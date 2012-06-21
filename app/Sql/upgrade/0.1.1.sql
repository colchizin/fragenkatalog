/*
 *	0.1.1.sql
 *  
 *	Table exmsessions gets field 'correct' for count of correct answers
 *	Table exams gets field 'question_count' for count of assiciated questions
 *	Table exmsessions gets field 'examsessions_question_count' for count of answered questions
 */
ALTER TABLE  `examsessions` ADD  `correct` SMALLINT UNSIGNED NOT NULL
ALTER TABLE  `exams` ADD  `question_count` SMALLINT UNSIGNED NOT NULL
ALTER TABLE  `examsessions` ADD  `examsessions_question_count` SMALLINT UNSIGNED NOT NULL

