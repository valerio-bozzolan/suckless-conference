ALTER TABLE `{$prefix}room`       ADD COLUMN `room_playerurl`       VARCHAR(254) AFTER `room_name`;
ALTER TABLE `{$prefix}room`       ADD COLUMN `room_meetingurl`      VARCHAR(254) AFTER `room_playerurl`;
ALTER TABLE `{$prefix}conference` ADD COLUMN `conference_langs`     VARCHAR(64)  AFTER `conference_events_url`;
ALTER TABLE `{$prefix}conference` ADD COLUMN `conference_rooms_url` VARCHAR(512) AFTER `conference_events_url`;
