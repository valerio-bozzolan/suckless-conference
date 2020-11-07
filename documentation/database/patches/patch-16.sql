ALTER TABLE `{$prefix}sharable`
	ADD COLUMN `sharable_parent` INT(10) UNSIGNED AFTER `sharable_license`,
	ADD CONSTRAINT `{$prefix}fk_sharable_parent` FOREIGN KEY (`sharable_parent`) REFERENCES `{$prefix}sharable` (`sharable_ID`);

