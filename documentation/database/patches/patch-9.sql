CREATE TABLE IF NOT EXISTS `{$prefix}option` (
	`option_name` varchar(32) NOT NULL,
	`option_value` text NOT NULL,
	`option_autoload` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 or 1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Associative informations';

ALTER TABLE `{$prefix}option`
	ADD PRIMARY KEY (`option_name`),
	ADD KEY `option_autoload` (`option_autoload`) COMMENT 'To speed up filtering by autoload';

