-- noinspection SqlNoDataSourceInspectionForFile
-- noinspection SqlDialectInspectionForFile

SET SQL_MODE = "TRADITIONAL,NO_ENGINE_SUBSTITUTION";
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE `crests` (
    `userId` INT unsigned NOT NULL DEFAULT 0,
    `userHash` BINARY(10) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0',
    `crest` VARCHAR(255) NOT NULL DEFAULT '[]',
    `lastUpdate` INT unsigned NOT NULL DEFAULT 0,
    `lastFetch` INT unsigned NOT NULL DEFAULT 0,
        PRIMARY KEY (`userId`)
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;