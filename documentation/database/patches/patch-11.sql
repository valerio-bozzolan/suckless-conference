-- allow NULL on these Location columns to support online Room(s) that has not an address
ALTER TABLE `{$prefix}location` MODIFY COLUMN `location_address` VARCHAR(100);
ALTER TABLE `{$prefix}location` MODIFY COLUMN `location_lat`     FLOAT;
ALTER TABLE `{$prefix}location` MODIFY COLUMN `location_lng`     FLOAT;
