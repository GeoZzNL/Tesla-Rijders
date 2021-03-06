CREATE TABLE users(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(50) NOT NULL,
    `rank`  int(10) DEFAULT '0',
    `active` int(10) DEFAULT '1',    
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB;

CREATE TABLE pages(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `ptitle` varchar(50) NOT NULL,
    `pname` varchar(50) NOT NULL,
    `pcontent` LONGTEXT NOT NULL,
    `phidden` varchar(50) NOT NULL,
    `htitle` varchar(2500) NOT NULL,
    `puseridadd` varchar(255) NOT NULL,
    `postdate` DATETIME,
    `puseridedit` varchar(255),
    `editdate` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`ptitle`),
    UNIQUE KEY (`pname`)
) ENGINE=InnoDB;

CREATE TABLE settings(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `sname` varchar(100) DEFAULT 'Site name',
    `galleryn` varchar(100) DEFAULT 'Default gallery',
    `gallery` varchar(10) DEFAULT 'false',
    `email` varchar(50) DEFAULT 'example@example.com',
    `footer` varchar(500) DEFAULT 'This website is using 1P5 CMS',
    `description` TEXT,
    `keywords` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `loginattempts` (
  `id` INT NOT NULL auto_increment,
  `u_id` INT NULL,
  `date` DATETIME DEFAULT current_timestamp,
  `ip` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `u_id`
    FOREIGN KEY (`u_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;

INSERT INTO `settings` (`id`, `sname`, `galleryn`, `gallery`, `email`, `footer`, `description`, `keywords`)
VALUES (NULL, 'Site name', 'Default gallery', 'false', 'example@example.com', 'This website is using Goat CMS.', 'A short description of your site', 'Some keywords for your website seperated by a comma');

CREATE TABLE images(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `imagen` varchar(50) NOT NULL,
    `imagedesc` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE hiddenimages(
    `id` int(10) NOT NULL AUTO_INCREMENT,
    `imagen` varchar(50) NOT NULL,
    `imagedesc` TEXT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE newsletter(
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` varchar(255) NOT NULL,
    `ip` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`email`)
) ENGINE=InnoDB;