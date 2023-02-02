-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2023 at 09:01 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `employee monthly expense`
-- (See below for the actual view)
--
CREATE TABLE `employee monthly expense` (
`expSubcategory` varchar(50)
,`expCategory` varchar(50)
,`amount` int(7)
,`dateTrans` date
,`receiptNumber` varchar(100)
,`note` varchar(200)
,`submittedBy` varchar(50)
,`dateClosed` date
,`validatedBy` varchar(50)
,`cash_float` int(7)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `man monthly expense`
-- (See below for the actual view)
--
CREATE TABLE `man monthly expense` (
`expCategory` varchar(100)
,`amount` int(7)
,`receiptNumber` varchar(100)
,`date` date
,`consumption` int(11)
,`note` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `employee monthly expense`
--
DROP TABLE IF EXISTS `employee monthly expense`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employee monthly expense`  AS SELECT `emp_expense_subcategory`.`expSubcategory` AS `expSubcategory`, `emp_expense_category`.`expCategory` AS `expCategory`, `emp_expense`.`amount` AS `amount`, `emp_expense`.`dateTrans` AS `dateTrans`, `emp_expense`.`receiptNumber` AS `receiptNumber`, `emp_expense`.`note` AS `note`, `emp_expense`.`submittedBy` AS `submittedBy`, `emp_expense`.`dateClosed` AS `dateClosed`, `emp_expense`.`validatedBy` AS `validatedBy`, `emp_expense`.`cash_float` AS `cash_float` FROM (((`emp_expense` join `cash_advance` on(`emp_expense`.`cashAdvance_id` = `cash_advance`.`id`)) join `emp_expense_category` on(`cash_advance`.`expCategory_id` = `emp_expense_category`.`id`)) join `emp_expense_subcategory` on(`cash_advance`.`expSubcategory_id` = `emp_expense_subcategory`.`id`)) WHERE month(`emp_expense`.`dateTrans`) = month(current_timestamp()) AND year(`emp_expense`.`dateTrans`) = year(current_timestamp())  ;

-- --------------------------------------------------------

--
-- Structure for view `man monthly expense`
--
DROP TABLE IF EXISTS `man monthly expense`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `man monthly expense`  AS SELECT `man_expense_category`.`expCategory` AS `expCategory`, `man_expense`.`amount` AS `amount`, `man_expense`.`receiptNumber` AS `receiptNumber`, `man_expense`.`date` AS `date`, `man_expense`.`consumption` AS `consumption`, `man_expense`.`note` AS `note` FROM (`man_expense` join `man_expense_category` on(`man_expense`.`expCategory` = `man_expense_category`.`id`)) WHERE month(`man_expense`.`date`) = month(current_timestamp()) AND year(`man_expense`.`date`) = year(current_timestamp())  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
