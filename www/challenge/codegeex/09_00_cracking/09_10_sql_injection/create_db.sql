CREATE DATABASE sqlfirst;
CREATE USER sqlfirst@localhost IDENTIFIED BY 'sqlfirst';
GRANT SELECT ON sqlfirst.* TO sqlfirst@localhost;
USE sqlfirst;
CREATE TABLE `users` (
	`id` INT(10) NOT NULL,
	`username` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_general_ci',
	`password` VARCHAR(32) NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=MyISAM
;

 -- Oh noe, the password is scrambled!
INSERT INTO users VALUES (0, 'admin', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');
