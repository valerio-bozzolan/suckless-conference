ALTER TABLE `{$prefix}event` ADD COLUMN `event_aborted` TINYINT(1) DEFAULT 0 AFTER `event_img`;
