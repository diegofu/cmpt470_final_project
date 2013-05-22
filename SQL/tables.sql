 
--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
`session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
`ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
`user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
`last_activity` int(10) unsigned NOT NULL DEFAULT '0',
`user_data` text COLLATE utf8_bin NOT NULL,
PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
 
-- --------------------------------------------------------
 
--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
`login` varchar(50) COLLATE utf8_bin NOT NULL,
`time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
 
-- --------------------------------------------------------
 
--
-- Table structure for table `user_autologin`
--
 
CREATE TABLE IF NOT EXISTS `user_autologin` (
`key_id` char(32) COLLATE utf8_bin NOT NULL,
`user_id` int(11) NOT NULL DEFAULT '0',
`user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
`last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
`last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
 
-- --------------------------------------------------------
 
--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
	`id` int(3) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------
 
--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(50) COLLATE utf8_bin NOT NULL,
`password` varchar(255) COLLATE utf8_bin NOT NULL,
`email` varchar(100) COLLATE utf8_bin NOT NULL,
`activated` tinyint(1) NOT NULL DEFAULT '1',
`banned` tinyint(1) NOT NULL DEFAULT '0',
`ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
`new_password_requested` datetime DEFAULT NULL,
`new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
`new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
`last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
`last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Table structure for table `user_profiles`
--
 
CREATE TABLE IF NOT EXISTS `user_profiles` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`user_id` int(11) NOT NULL,
`role` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`background` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`avatar` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`phone` varchar(11) COLLATE utf8_bin DEFAULT NULL,
`email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`address` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`company` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`firstname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
`lastname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
PRIMARY KEY (`id`),
FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
 
-- --------------------------------------------------------






-- ---------------------------------------------------------
-- appanded upon the default config for user login table settings
-- implement for exercise and solutions
-- 11-02-2012
-- --------------------------------------------------------

--
-- Table structure for table `programming_language`
--

CREATE TABLE IF NOT EXISTS`programming_language` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------- -----------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE IF NOT EXISTS `exercise` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) COLLATE utf8_bin NOT NULL,
	`expected_output` text COLLATE utf8_bin NOT NULL,
	`solution` text COLLATE utf8_bin NOT NULL,
	`instruction` text COLLATE utf8_bin NOT NULL,
	`template` text COLLATE utf8_bin NOT NULL,
	`author_id` int(11) NOT NULL,
	`plang_id` int(11) NOT NULL,
	`created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`author_id`) REFERENCES users(`id`),
	FOREIGN KEY (`plang_id`) REFERENCES programming_language(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE IF NOT EXISTS `submission` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`exercise_id` int(11) NOT NULL,
	`body` text COLLATE utf8_bin DEFAULT NULL,
	`correctness` tinyint(2) COLLATE utf8_bin DEFAULT NULL,
    `author_id` int(11) NOT NULL,
	`created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`),
	FOREIGN KEY (`author_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------
 
--
-- Table structure for table `discussion`
--

CREATE TABLE IF NOT EXISTS `discussion` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`author_id` int(11) NOT NULL,
	`exercise_id` int(11) NOT NULL,
	`created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`content` text,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`),
	FOREIGN KEY (`author_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------
 
--
-- Table structure for table `completed_exercise`
--

CREATE TABLE IF NOT EXISTS `completed_exercise` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`exercise_id` int(11) NOT NULL,
	`completed_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE IF NOT EXISTS `follow` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`follow_id` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`id`),
	FOREIGN KEY (`follow_id`) REFERENCES users(`id`)	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------




-- -------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------

-- -------------------------------------------------------

--
-- Table structure for table `tag_ref`
--

CREATE TABLE IF NOT EXISTS `tag_ref` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`tag_id` int(11) NOT NULL,
	`exercise_id` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`tag_id`) REFERENCES tag(`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`)	
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- -------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`subject` varchar(255) COLLATE utf8_bin NOT NULL,
	`content` text COLLATE utf8_bin NOT NULL,
	`from` int(11) NOT NULL,
	`to` int(11) NOT NULL,
	`send_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`read` bool NOT NULL DEFAULT false,
	`deleted_by_from` bool NOT NULL DEFAULT false,
	`deleted_by_to` bool NOT NULL DEFAULT false,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`from`) REFERENCES users(`id`),
	FOREIGN KEY (`to`) REFERENCES users(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE IF NOT EXISTS `collection` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`description` text COLLATE utf8_bin NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------


--
-- Table structure for table `collection_exercise`
--

CREATE TABLE IF NOT EXISTS `collection_exercise` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`collection_id` int(11) NOT NULL,
	`exercise_id` int(11) NOT NULL,
	PRIMARY KEY (`id`),
	FOREIGN KEY (`collection_id`) REFERENCES collection(`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `view`
--

CREATE TABLE IF NOT EXISTS `view` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`exercise_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	`created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `exercise_vote`
--

CREATE TABLE IF NOT EXISTS `exercise_vote` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`exercise_id` int(11) NOT NULL,
	`user_id` int(11) NOT NULL,
	`vote` int(4) DEFAULT '0',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`user_id`) REFERENCES users(`id`),
	FOREIGN KEY (`exercise_id`) REFERENCES exercise(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;



-- ------------------------------------------------------------


INSERT INTO tag (name) VALUES ('For Loops');
INSERT INTO tag (name) VALUES ('Function');
INSERT INTO tag (name) VALUES ('Calculation');
INSERT INTO tag (name) VALUES ('Numbers');
INSERT INTO tag (name) VALUES ('Basic I/O');
INSERT INTO tag (name) VALUES ('While Loops');
INSERT INTO programming_language (name)
VALUES ('C');

INSERT INTO programming_language (name)
VALUES ('C++');

INSERT INTO programming_language (name)
VALUES ('Python');

INSERT INTO programming_language (name)
VALUES ('Java');

INSERT INTO country (name)
VALUES ('Canada');