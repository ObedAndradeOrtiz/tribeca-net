ALTER TABLE `users`
    ADD COLUMN `google_id` varchar(255) NULL AFTER `email`,
    ADD COLUMN `provider` varchar(50) NULL AFTER `google_id`,
    ADD COLUMN `resident_profile_completed` tinyint(1) NOT NULL DEFAULT 0 AFTER `key`,
    ADD INDEX `users_google_id_index` (`google_id`),
    ADD INDEX `users_rol_index` (`rol`);

CREATE TABLE IF NOT EXISTS `resident_access_codes` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `code` varchar(40) NOT NULL,
    `user_id` bigint(20) unsigned NULL,
    `name` varchar(255) NULL,
    `ci` varchar(255) NULL,
    `status` varchar(40) NOT NULL DEFAULT 'Activo',
    `expires_at` datetime NULL,
    `created_by` bigint(20) unsigned NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `resident_access_codes_code_unique` (`code`),
    KEY `resident_access_codes_user_id_index` (`user_id`),
    KEY `resident_access_codes_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `resident_department_access` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `user_id` bigint(20) unsigned NULL,
    `access_code_id` bigint(20) unsigned NULL,
    `tratamiento_id` bigint(20) unsigned NOT NULL,
    `departamento_nombre` varchar(255) NOT NULL,
    `status` varchar(40) NOT NULL DEFAULT 'Solicitado',
    `requested_at` datetime NULL,
    `approved_at` datetime NULL,
    `approved_by` bigint(20) unsigned NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `resident_department_access_user_id_index` (`user_id`),
    KEY `resident_department_access_code_id_index` (`access_code_id`),
    KEY `resident_department_access_tratamiento_id_index` (`tratamiento_id`),
    KEY `resident_department_access_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
