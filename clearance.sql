-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.21-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for clearance
CREATE DATABASE IF NOT EXISTS `clearance` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `clearance`;


-- Dumping structure for table clearance.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.admin: ~5 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
	(1, 'librarian', 'root', 'librarian'),
	(2, 'caretaker', 'root', 'caretaker'),
	(3, 'dean', 'root', 'dean'),
	(4, 'director', 'root', 'director'),
	(5, 'registrar', 'root', 'registrar'),
	(6, 'admin', 'root', 'admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;


-- Dumping structure for procedure clearance.clearTable
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `clearTable`(IN `user_id` INT)
BEGIN
   INSERT INTO `cleartable` SET `user_id`  = user_id, user = 'Registrar';
   INSERT INTO `cleartable` SET `user_id`  = user_id, user = 'Dean of Students';
   INSERT INTO `cleartable` SET `user_id`  = user_id, user = 'Director';
END//
DELIMITER ;


-- Dumping structure for table clearance.cleartable
CREATE TABLE IF NOT EXISTS `cleartable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `user` varchar(50) DEFAULT '',
  `status` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.cleartable: ~7 rows (approximately)
/*!40000 ALTER TABLE `cleartable` DISABLE KEYS */;
INSERT INTO `cleartable` (`id`, `user_id`, `user`, `status`) VALUES
	(1, 2, 'Registrar', 'Y'),
	(2, 2, 'Dean of Students', 'N'),
	(3, 2, 'Director', 'Y'),
	(4, 1, 'Registrar', 'Y'),
	(5, 1, 'Dean of Students', 'N'),
	(6, 1, 'Director', 'Y');
/*!40000 ALTER TABLE `cleartable` ENABLE KEYS */;


-- Dumping structure for table clearance.damages
CREATE TABLE IF NOT EXISTS `damages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `item` varchar(50) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.damages: ~2 rows (approximately)
/*!40000 ALTER TABLE `damages` DISABLE KEYS */;
INSERT INTO `damages` (`id`, `user_id`, `item`, `description`, `amount`, `time`) VALUES
	(1, 2, 'Window Pane', 'Destroyed hostel windows', 300, '2018-01-23 21:00:34'),
	(2, 1, 'School Pavement', 'Spilled lime', 1000, '2018-01-23 21:01:16');
/*!40000 ALTER TABLE `damages` ENABLE KEYS */;


-- Dumping structure for table clearance.finance
CREATE TABLE IF NOT EXISTS `finance` (
  `user_id` int(11) NOT NULL,
  `balance` double NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.finance: ~0 rows (approximately)
/*!40000 ALTER TABLE `finance` DISABLE KEYS */;
INSERT INTO `finance` (`user_id`, `balance`, `time`) VALUES
	(1, 12000, '2017-10-04 10:59:42');
/*!40000 ALTER TABLE `finance` ENABLE KEYS */;


-- Dumping structure for table clearance.hostel
CREATE TABLE IF NOT EXISTS `hostel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `space_no` varchar(50) NOT NULL DEFAULT '',
  `room_no` varchar(50) NOT NULL DEFAULT '',
  `amount` double NOT NULL DEFAULT '0',
  `academic_year` varchar(50) NOT NULL DEFAULT '',
  `sem` varchar(50) NOT NULL DEFAULT '',
  `cleared` enum('Y','N') NOT NULL DEFAULT 'N',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.hostel: ~1 rows (approximately)
/*!40000 ALTER TABLE `hostel` DISABLE KEYS */;
INSERT INTO `hostel` (`id`, `user_id`, `space_no`, `room_no`, `amount`, `academic_year`, `sem`, `cleared`, `time`) VALUES
	(1, 1, 'Mt Kenya', '5', 1200, '2017/2018', '2', 'N', '2017-12-05 17:39:42');
/*!40000 ALTER TABLE `hostel` ENABLE KEYS */;


-- Dumping structure for procedure clearance.insertReport
DELIMITER //
CREATE DEFINER=`root`@`localhost` PROCEDURE `insertReport`(IN `user_id` INT)
BEGIN
   INSERT INTO `report` SET `user_id`  = user_id, user = 'Finance';
   INSERT INTO `report` SET `user_id`  = user_id, user = 'Librarian';
   INSERT INTO `report` SET `user_id`  = user_id, user = 'Hostel Manager';
   INSERT INTO `report` SET `user_id`  = user_id, user = 'Sports Officer';
   INSERT INTO `report` SET `user_id`  = user_id, user = 'Damages';
END//
DELIMITER ;


-- Dumping structure for table clearance.library
CREATE TABLE IF NOT EXISTS `library` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `isbn` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '',
  `author` varchar(50) NOT NULL DEFAULT '',
  `amount_due` double NOT NULL DEFAULT '0',
  `time_borrowed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.library: ~2 rows (approximately)
/*!40000 ALTER TABLE `library` DISABLE KEYS */;
INSERT INTO `library` (`id`, `user_id`, `isbn`, `title`, `author`, `amount_due`, `time_borrowed`) VALUES
	(1, 2, 'GHHK', 'Verily', 'John', 0, '2018-01-24 10:10:13'),
	(2, 2, 'GHJ', 'vskd', 'bbb', 0, '2018-01-24 10:10:13');
/*!40000 ALTER TABLE `library` ENABLE KEYS */;


-- Dumping structure for table clearance.report
CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user` varchar(50) NOT NULL DEFAULT '',
  `transaction_id` varchar(50) NOT NULL DEFAULT '',
  `paid` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.report: ~5 rows (approximately)
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
INSERT INTO `report` (`id`, `user_id`, `user`, `transaction_id`, `paid`, `date`) VALUES
	(1, 2, 'Finance', '', 0, '2018-01-24 10:08:40'),
	(2, 2, 'Librarian', '', 1200, '2018-01-24 10:09:31'),
	(3, 2, 'Hostel Manager', '', 0, '2018-01-24 10:08:40'),
	(4, 2, 'Sports Officer', '', 0, '2018-01-24 10:08:40'),
	(5, 2, 'Damages', '', 300, '2018-01-24 10:08:40');
/*!40000 ALTER TABLE `report` ENABLE KEYS */;


-- Dumping structure for table clearance.sports
CREATE TABLE IF NOT EXISTS `sports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `item` varchar(50) NOT NULL DEFAULT '',
  `amount_due` double NOT NULL DEFAULT '0',
  `time_reported` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.sports: ~2 rows (approximately)
/*!40000 ALTER TABLE `sports` DISABLE KEYS */;
INSERT INTO `sports` (`id`, `user_id`, `item`, `amount_due`, `time_reported`) VALUES
	(1, 1, 'Football Adiddas', 2000, '2017-11-27 13:04:37'),
	(2, 1, 'Basketball Net', 1200, '2017-11-27 13:04:59');
/*!40000 ALTER TABLE `sports` ENABLE KEYS */;


-- Dumping structure for table clearance.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.user: ~1 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `reg_no`, `password`, `type`) VALUES
	(1, 'C026-01-0730/2012', 'pass123', 'student'),
	(2, 'C026-01-0632/2012', 'pass123', 'student');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table clearance.user_details
CREATE TABLE IF NOT EXISTS `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `names` varchar(100) NOT NULL DEFAULT '',
  `id_no` varchar(50) DEFAULT '',
  `gender` varchar(50) DEFAULT '',
  `dob` varchar(50) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table clearance.user_details: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` (`id`, `user_id`, `names`, `id_no`, `gender`, `dob`) VALUES
	(1, 1, 'ANTONY NGANGA WANJIRU', '29326831', 'male', '02/09/1992'),
	(2, 2, 'MONICA LANA', '3300973', 'female', '021/03/1990');
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
