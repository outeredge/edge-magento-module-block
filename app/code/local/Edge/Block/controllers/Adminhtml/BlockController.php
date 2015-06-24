<?php

class Edge_Block_Adminhtml_BlockController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_title($this->__('outer/edge'))
            ->_title($this->__('Block'))
            ->_setActiveMenu('edge');

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()
             ->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Block'))
             ->_title($this->__('Block'))
             ->_title($this->__('Manage Content'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('block_id');
        $model = Mage::getModel('block/block');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('block')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Block'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('block', $model);

        // 5. Build edit form
        $this->_initAction()
             ->_addBreadcrumb(
                $id ? Mage::helper('block')->__('Edit Block')
                    : Mage::helper('block')->__('New Block'),
                $id ? Mage::helper('block')->__('Edit Block')
                    : Mage::helper('block')->__('New Block'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            if (!empty($_FILES)) {
                foreach ($_FILES as $name=>$fileData) {
                    if (isset($fileData['name']) && $fileData['name'] != '') {
                        try {
                            $uploader = new Mage_Core_Model_File_Uploader($name);
                            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','svg'));
                            $uploader->setAllowRenameFiles(true);
                            $uploader->setFilesDispersion(false);

                            $dirPath = Mage::getBaseDir('media') . DS . 'block' . DS;
                            $result = $uploader->save($dirPath, $fileData['name']);

                        } catch (Exception $e) {
                            Mage::log($e->getMessage());
                        }

                        $data[$name] = 'block/' . $result['file'];
                    }
                    elseif (isset($data[$name]) && is_array($data[$name])) {
                        $data[$name] = $data[$name]['value'];
                    }
                }
            }

            $data = $this->_filterDates($data, array('active_from', 'active_to'));

            //init model and set data
            $model = Mage::getModel('block/block');
            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('block')->__('The block has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('block_id' => $model->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('block')->__('An error occurred while saving the block.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('block_id' => $this->getRequest()->getParam('block_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('block_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('block/block');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('block')->__('The block has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('block_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('block')->__('Unable to find a block to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
}