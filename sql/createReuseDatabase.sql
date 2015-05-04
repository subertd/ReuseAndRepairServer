DROP TABLE IF EXISTS `Organization_Item`;
DROP TABLE IF EXISTS `cs419-g15`.`Item`;
DROP TABLE IF EXISTS `cs419-g15`.`Category`;
DROP TABLE IF EXISTS `cs419-g15`.`Item`;

CREATE TABLE `cs419-g15`.`Organization` (
  `organization_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `phone_number` VARCHAR( 14 ) NULL,
  `website_url` VARCHAR( 255 ) NULL,
  `physical address` VARCHAR( 255 ) NULL
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Category` (
  `category_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_name` VARCHAR( 255 ) NOT NULL
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Item` (
  `item_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `item_name` VARCHAR( 255 ) NOT NULL,
  `category_id` INT NOT NULL,
  INDEX ( `category_id` )
) ENGINE = INNODB;

CREATE TABLE `cs419-g15`.`Organization_Item` (
  `organization_id` INT NOT NULL,
  `item_id` INT NOT NULL,
  FOREIGN KEY (`organization_id`) REFERENCES `cs419-g15.Organization`(`organization_id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `cs419-g15.Item`(`item_id`) ON DELETE CASCADE,
  UNIQUE KEY (`organization_id`, `item_id`)
) ENGINE = INNODB;