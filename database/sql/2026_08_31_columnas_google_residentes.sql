ALTER TABLE `users`
    ADD COLUMN `google_id` VARCHAR(191) NULL AFTER `email`,
    ADD COLUMN `provider` VARCHAR(50) NULL AFTER `google_id`;
