CREATE TABLE `tbl_users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`cognome` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`telefono` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`token` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`otp` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`stato` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
	`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`) USING BTREE
)
COMMENT='TABELLA UTENTI'
COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=3
;
