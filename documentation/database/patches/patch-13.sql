ALTER TABLE `{$prefix}user` ADD COLUMN       `user_metawiki` VARCHAR(64);
ALTER TABLE `{$prefix}user` ADD UNIQUE INDEX `user_metawiki`(`user_metawiki`);
