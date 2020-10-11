ALTER TABLE `{$prefix}user` MODIFY COLUMN `user_role` ENUM('admin','user','translator','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user';
