-- News can be commented
CREATE TABLE  `fragenkatalog`.`news_comments` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`news_id` INT NOT NULL ,
`comment_id` INT NOT NULL
) ENGINE = INNODB;

-- Comments can be a reply to a previous comment
ALTER TABLE  `comments` ADD  `reply_to` INT NOT NULL AFTER  `user_id`
