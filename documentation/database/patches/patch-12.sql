ALTER TABLE {$prefix}event ADD COLUMN event_url VARCHAR(256) AFTER event_uid;
ALTER TABLE {$prefix}ldto_event MODIFY COLUMN event_uid varchar(256);
