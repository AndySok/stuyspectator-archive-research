CREATE TABLE  `users` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
 `name` VARCHAR( 200 ) NOT NULL,
 `email` VARCHAR( 200 ) NOT NULL,
 `password` VARCHAR( 200 ) NOT NULL,
 `access_level` INT NOT NULL,
 `active` INT NOT NULL,
 `contact` INT NOT NULL,
 `comments` VARCHAR ( 200 ) NOT NULL,
 `cat` VARCHAR( 200 ) NOT NULL,
 `date` DATE NOT NULL
);

CREATE TABLE `pasteup` (
  `id` int NOT NULL auto_increment PRIMARY KEY,
  `cat` varchar(200) NOT NULL,
  `article` varchar(200) NOT NULL,
  `word_count` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `art` varchar(200) NOT NULL,
  `lede` varchar(200) NOT NULL,
  `comments` varchar(200) NOT NULL,
  `date` DATE NOT NULL
);

CREATE TABLE `log` (
    `id` int NOT NULL auto_increment PRIMARY KEY,
    `user_id` int NOT NULL
);

CREATE TABLE `messages` (
   `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `name` varchar(200) NOT NULL,
   `regarding` varchar(200) NOT NULL,
   `email` varchar(200) NOT NULL,
   `subject` varchar(200) NOT NULL,
   `body` varchar(200) NOT NULL,
   `to_cat` varchar(200) NOT NULL,
   `date` DATE NOT NULL
);

CREATE TABLE `departments` (
	`id` int NOT NULL auto_increment PRIMARY KEY,
	`user_id` INT NOT NULL,
	`department` varchar (200) NOT NULL
);