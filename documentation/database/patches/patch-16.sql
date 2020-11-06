ALTER TABLE `{$prefix}sharable`
	ADD COLUMN        `parent_sharable_ID` INT(10) UNSIGNED AFTER `sharable_license`,
        ADD CONSTRAINT `fk_parent_sharable_ID` FOREIGN KEY (`parent_sharable_ID`) REFERENCES `{$prefix}sharable` (`sharable_ID`);
