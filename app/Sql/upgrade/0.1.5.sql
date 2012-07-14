CREATE TABLE  `fragenkatalog`.`news` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`title` TEXT NOT NULL ,
`description` TEXT NOT NULL ,
`user_id` INT NOT NULL ,
`created` DATETIME NOT NULL ,
`updated` DATETIME NOT NULL
) ENGINE = INNODB;

ALTER TABLE  `examsessions` ADD  `valid` SMALLINT UNSIGNED NOT NULL AFTER  `correct`;
