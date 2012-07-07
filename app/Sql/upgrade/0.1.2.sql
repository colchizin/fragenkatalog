CREATE TABLE  IF NOT EXISTS `fragenkatalog`.`logins` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`user_id` INT NOT NULL ,
`created` DATETIME NOT NULL
) ENGINE = INNODB;

ALTER TABLE `fragenkatalog`.`questions` ADD `valid` BOOLEAN NOT NULL DEFAULT 1;
CREATE INDEX ix_answers_question_id ON answers(question_id);
