UPDATE `ecm_message` set `from_id` = 0 WHERE `from_id` = -1;
ALTER TABLE `ecm_member` ADD `feed_config` TEXT NOT NULL ;
ALTER TABLE `ecm_message` CHANGE `from_id` `from_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0';
ALTER TABLE `ecm_goods` ADD `tags` varchar(102) NOT NULL;
ALTER TABLE `ecm_goods` ADD INDEX ( `tags` );

