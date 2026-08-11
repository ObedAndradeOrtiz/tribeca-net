ALTER TABLE `mantenimientos`
    ADD COLUMN `estado` VARCHAR(30) NOT NULL DEFAULT 'Activo' AFTER `user_id`,
    ADD COLUMN `fecha_baja` DATETIME NULL AFTER `estado`,
    ADD COLUMN `motivo_baja` VARCHAR(500) NULL AFTER `fecha_baja`;

CREATE INDEX `mantenimientos_estado_fecha_siguiente_index`
    ON `mantenimientos` (`estado`, `fecha_siguiente`);
