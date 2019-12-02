DROP DATABASE IF EXISTS User_DB;
CREATE DATABASE User_DB;
USE User_DB;

DROP TABLE IF EXISTS `users`;
CREATE TABLE users (
`id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
`firstname` TINYTEXT NOT NULL,
`lastname` TINYTEXT NOT NULL,
`pwd` LONGTEXT NOT NULL,
`email` TINYTEXT NOT NULL,
`date_joined` DATE NOT NULL 
);

DROP TABLE IF EXISTS `issues`;
CREATE TABLE `issues` (
	`id`int(11) NOT NULL auto_increment,
	`title` char(65) NOT NULL ,
	`description` LONGTEXT NOT NULL ,
	`type` char(35) NOT NULL  ,
	`priority` char(12) NOT NULL  ,
	`statusOI` char(15) NOT NULL ,
	`assigned_to` int(11) NOT NULL  ,
	`created_by` int(11) NOT NULL  ,
	`created_D` DATE NOT NULL  ,
	`created_T` TIME NOT NULL,
	`updated_D` DATE NOT NULL  ,
	`updated_T` TIME NOT NULL  ,
	PRIMARY KEY  (`id`)
	);

INSERT INTO Users (firstname, lastname, pwd, email, date_joined)
VALUES ('Bro','Gad','$2y$10$oOAoHMO/b5/kGQGqzLvkS.g2FPSLZUukJjK4YAUcR8xBZP3rCqTfS','admin@bugme.com','0000-00-00');
