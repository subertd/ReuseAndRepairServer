-- SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `cs419-g15`.`admin_account`;
CREATE TABLE `cs419-g15`.`admin_account` (
	id INT(3) AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(10) NOT NULL UNIQUE,
	password VARCHAR(10) NOT NULL,
	first_name VARCHAR(20) NOT NULL,
	last_name VARCHAR(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

INSERT INTO `cs419-g15`.`admin_account` (id,username,password,first_name,last_name) VALUES 
('101','admin','AAaa12345','Admin1','Admin1'),
('102','admin2','ZZzz67890','Admin2','Admin2');


-- SET FOREIGN_KEY_CHECKS = 1;