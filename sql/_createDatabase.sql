# It doesnt seem safe to globally disable foreign key checks
# implementing another solution
#SET FOREIGN_KEY_CHECKS = 0;

#DROP TABLE IF EXISTS `cs419-g15`.`Item_Category`;
#DROP TABLE IF EXISTS `cs419-g15`.`Organization_Reuse_Item`;
#DROP TABLE IF EXISTS `cs419-g15`.`Organization_Repair_Item`;
#DROP TABLE IF EXISTS `cs419-g15`.`Organization`;
#DROP TABLE IF EXISTS `cs419-g15`.`Category`;
#DROP TABLE IF EXISTS `cs419-g15`.`Item`;

DROP DATABASE IF EXISTS `cs419-g15`;
CREATE DATABASE `cs419-g15`;

CREATE TABLE `cs419-g15`.`admin_account` (
	id INT(3) AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(10) NOT NULL UNIQUE,
	password VARCHAR(10) NOT NULL,
	first_name VARCHAR(20) NOT NULL,
	last_name VARCHAR(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

CREATE TABLE `cs419-g15`.`Organization` (
  `organization_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `organization_name` VARCHAR ( 255 ) NOT NULL,
  `phone_number` VARCHAR( 14 ) NULL,
  `website_url` VARCHAR( 255 ) NULL,
  `physical_address` VARCHAR( 255 ) NULL
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Category` (
  `category_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR( 255 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Item` (
  `item_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `item_name` VARCHAR( 255 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Item_Category` (
  `category_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  FOREIGN KEY (`category_id`) REFERENCES `cs419-g15`.`Category`(`category_id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `cs419-g15`.`Item`(`item_id`) ON DELETE CASCADE,
  UNIQUE KEY (`category_id`, `item_id`)
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Organization_Repair_Item` (
  `organization_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  `additional_repair_info` TEXT,
  FOREIGN KEY (`organization_id`) REFERENCES `cs419-g15`.`Organization`(`organization_id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `cs419-g15`.`Item`(`item_id`) ON DELETE CASCADE,
  UNIQUE KEY (`organization_id`, `item_id`)
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Organization_Reuse_Item` (
  `organization_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  FOREIGN KEY (`organization_id`) REFERENCES `cs419-g15`.`Organization`(`organization_id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `cs419-g15`.`Item`(`item_id`) ON DELETE CASCADE,
  UNIQUE KEY (`organization_id`, `item_id`)
) ENGINE = INNODB;


#SET FOREIGN_KEY_CHECKS = 1;