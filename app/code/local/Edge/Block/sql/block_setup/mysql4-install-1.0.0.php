<?php

$this->startSetup();

$this->run("
    CREATE TABLE `{$this->getTable('block/type')}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` text,
        `identifier` varchar(255) NOT NULL,
        `status` int(1) NOT NULL DEFAULT '1',
        `sort_order` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE `{$this->getTable('block/block')}` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` text,
        `image` text,
        `content` text,
        `link` text,
        `type` int(11) DEFAULT NULL,
        `active_from` timestamp NULL DEFAULT NULL,
        `active_to` timestamp NULL DEFAULT NULL,
        `status` int(1) NOT NULL DEFAULT '1',
        `sort_order` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `type` (`type`),
        CONSTRAINT `FK_BLOCK_TYPE` FOREIGN KEY (`type`) REFERENCES `block_type` (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$this->endSetup();