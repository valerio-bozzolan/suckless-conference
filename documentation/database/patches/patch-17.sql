ALTER TABLE `{$prefix}event_user` ADD `event_user_role` ENUM( 'speaker', 'moderator' ) DEFAULT 'speaker' NOT NULL;
