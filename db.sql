CREATE DATABASE IF NOT EXISTS `c2w2m2` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use `c2w2m2`;

CREATE TABLE IF NOT EXISTS `users`(
    `id` VARCHAR(32) NOT NULL PRIMARY KEY,
    `pw` VARCHAR(64) NOT NULL,
    `comment` VARCHAR(256),
    `created` DATETIME,
    `last_solves` INT(16)
);

CREATE TABLE IF NOT EXISTS `challs`(
    `no` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` TEXT NOT NULL,
    `description` TEXT NOT NULL,
    `category` VARCHAR(16),
    `author` VARCHAR(16),
    `point` INT(5),
    `flag` VARCHAR(256),
    `visable` TINYINT(1)
);

CREATE TABLE IF NOT EXISTS `uploads`(
    `no` INT(10) NOT NULL,
    `path` VARCHAR(128) NOT NULL,
    FOREIGN KEY (`no`) REFERENCES `challs` (`no`)
);

CREATE TABLE IF NOT EXISTS `submissions`(
    `idx` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id` VARCHAR(32) NOT NULL,
    `no` INT(10) NOT NULL,
    `ip` VARCHAR(16) NOT NULL,
    `flag` VARCHAR(256) NOT NULL,
    `date` DATETIME,
    `correct` TINYINT(1),
    FOREIGN KEY (`id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`no`) REFERENCES `challs` (`no`)
);

CREATE TABLE IF NOT EXISTS `solves`(
    `idx` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `id` VARCHAR(32) NOT NULL,
    `no` INT(10) NOT NULL,
    `flag` VARCHAR(256) NOT NULL,
    `date` DATETIME,
    FOREIGN KEY (`id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`no`) REFERENCES `challs` (`no`)
);