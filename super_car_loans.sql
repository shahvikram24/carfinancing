-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2017 at 02:11 PM
-- Server version: 5.5.30
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `super_car_loans`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id` int(2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `SALT` varchar(100) NOT NULL,
  `HASH` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id`, `username`, `email`, `SALT`, `HASH`, `Status`) VALUES
(1, 'simonsays', 'simonsaysapproved@gmail.com', 'e7f937da3989c33d0a31eb9eca14d66f', '67e600c7c6deadb91094d2a3c3c80368077739ac', 1),
(2, 'Vikram', 'shahvikram24@gmail.com', 'e7f937da3989c33d0a31eb9eca14d66f', '67e600c7c6deadb91094d2a3c3c80368077739ac', 1);

-- --------------------------------------------------------

--
-- Table structure for table `affiliate`
--

CREATE TABLE `affiliate` (
  `affiliate_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `HASH` varchar(50) NOT NULL,
  `company` varchar(32) NOT NULL,
  `website` varchar(255) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '43',
  `zone_id` int(11) NOT NULL DEFAULT '2',
  `code` varchar(64) NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax` varchar(64) DEFAULT NULL,
  `payment` varchar(6) DEFAULT NULL,
  `cheque` varchar(100) DEFAULT NULL,
  `paypal` varchar(64) DEFAULT NULL,
  `bank_name` varchar(64) DEFAULT NULL,
  `bank_branch_number` varchar(64) DEFAULT NULL,
  `bank_swift_code` varchar(64) DEFAULT NULL,
  `bank_account_name` varchar(64) DEFAULT NULL,
  `bank_account_number` varchar(64) DEFAULT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affiliate`
--

INSERT INTO `affiliate` (`affiliate_id`, `firstname`, `lastname`, `email`, `telephone`, `fax`, `salt`, `HASH`, `company`, `website`, `address_1`, `address_2`, `city`, `postcode`, `country_id`, `zone_id`, `code`, `commission`, `tax`, `payment`, `cheque`, `paypal`, `bank_name`, `bank_branch_number`, `bank_swift_code`, `bank_account_name`, `bank_account_number`, `ip`, `status`, `approved`, `date_added`) VALUES
(1, 'Vikram', 'Shah', 'shahvikram24@gmail.com', '7809200324', '7809200324', '14438578653b8fc50d869a72ff3cae4a', '102dd38d7a9df30c645432debcad0ee32621a624', 'vstudiozzz', 'vstudiozzz.com', '201C - 3624 119 Street NW', '', 'EDMONTON', 'T6J 2X6', 43, 2, '527f4abd08412', '5.00', '546545454', 'cheque', 'Hirva Shah', 'shahvikram24@gmail.com', 'TD Canda Trust', '1709', '004', 'Vikram Shah', '34534543', '127.0.0.1', 1, 1, '2013-11-10 02:24:25'),
(15, 'PAMELA', 'DEADMAN', 'misspamelarobinson@gmail.com', '639-317-7453', '', '1252c3bb040cf3862cd5a5bad6b21797', '271c980b0457bc874e0d48c3e0df2bd6d62e8bfb', '', '', '45 701 BEACON HILL DRIVE', '', 'FORT MCMURRAY`', 'T9H3R4', 43, 2, '5709a65d2d20a', '5.00', '', 'cheque', 'PAMELA DEADMAN', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-04-09 18:03:25'),
(13, 'Desiree', 'Downey', 'd.desiree11@hotmail.com', '250 806 0273', '', '1a4e8432ca2f5410adea633cb7c0fadf', '0840869e62bc1ae380d9983e96e44f2b20fc5410', '', '', '11303 130st', '', 'Edmonton', 'T5M 1A3', 43, 2, '56fda2aa8bc0b', '5.00', '', 'cheque', 'Desiree Downey', '', '', '', '', '', '', '24.114.43.240', 1, 1, '2016-03-31 15:20:26'),
(14, 'Daine', 'Jennings', 'dainedj@yahoo.com', '3069992620', '', '8386ddb4b6bc464c76f4c0ae8fcefb78', '7e7410d88337799c3c7f4eb2f4bf0dad50236334', '', '', '2116 rose st apt 27', '', 'Regina', 'S4P2A4', 43, 2, '5709503261dc8', '5.00', '', 'cheque', 'Daine  jennings', '', '', '', '', '', '', '207.195.109.139', 1, 1, '2016-04-09 11:55:46'),
(12, 'Simon', 'Ferguson', 'simonsaysapproved@gmail.com', '7808874357', '', '96c3a6a2fca5bf71488c00734bf4d4f3', '621e23d81f1162fce5e13f6f92011f00161acc8b', 'DreamTeam Auto', 'www.dreamteamauto.ca', '10212 178 St NW', '', 'Edmonton', 'T5S 1H3', 43, 2, '56f9acfe69b4c', '5.00', '', 'cheque', 'Simon Ferguson', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-03-28 15:15:26'),
(6, 'April', 'Roberts', 'aprylroberts@outlook.com', '3067640495', '', '97552341cf946380e59f49ccd7a32ca4', '2f4f0a4cb5bfc101c80e064473c06865be2036a8', '', '', '589-16 street west', '', 'prince albert ', 's6v3v8', 43, 2, '56f2c5c5d6c7e', '5.00', '', 'cheque', 'April Eva Roberts', '', '', '', '', '', '', '174.2.128.222', 1, 1, '2016-03-23 09:35:17'),
(7, 'Raylene', 'Degenhardt', 'rayleneliesl@hotmail.com', '780-499-0052', '', '467cab1b4df3b520c7b1220ca6bf6038', '774cf26b04886393347f8211f299d4055c07832e', '', '', '3908 Gallinger Loop NW', '', 'Edmonton', 't5t 4g6', 43, 2, '56f2c9ee00cd7', '5.00', '', 'cheque', 'Raylene Degenhardt', '', '', '', '', '', '', '75.159.160.181', 1, 1, '2016-03-23 09:53:02'),
(11, 'Hyde', 'Spence', 'bruckupspence@gmail.com', '780-616-1516', '7804990052', '2728784af4d24b0386415537f017f1bd', '1c95224d0f692f31d8899dc59a3da901ac796ca6', '', '', '3908 Gallinger Loop NW', '', 'Edmonton', 'T5T 4G6', 43, 2, '56f6ba857e45f', '5.00', '', 'cheque', 'Hyde Spence', '', '', '', '', '', '', '70.74.99.201', 1, 1, '2016-03-26 09:36:21'),
(10, 'Donovan', 'Waterhen', 'donz101@hotmail.com', '3069812988', '', 'df0caebbc2073e959df80e4c45c96c89', '9947894991e4e386ce335cff91202859f4c88092', '', '', '890 17 St W', 'Sask', 'Prince Albert ', 'S6V 3Y4', 43, 2, '56f5a82f94f63', '5.00', '', 'cheque', 'Donovan Waterhen', '', '', '', '', '', '', '207.195.95.74', 1, 1, '2016-03-25 14:05:51'),
(16, 'Bryant', 'lawrence', 'bryant.lawrence21@gmail.com', '5879373882', '', 'a75a83cfe410dac823a5310928c462e1', 'ac97b8a15d9335fe1dd7803c96c5b18ce1a03336', '', '', '10129-163 street apt.202', '', 'Edmonton', 'T5P 3N6', 43, 2, '5709c62c9c9c9', '5.00', '', 'cheque', 'Bryant Lawrence', '', '', '', '', '', '', '104.205.48.241', 1, 1, '2016-04-09 20:19:08'),
(17, 'SAHARLA', 'ADEN', 'sah.aden@gmail.com', '780-8637723', '', '2e7e91d6b47a47d9c2f540f9f8590bd9', '02c05e9fb00ceb31da8d044f1225b65972c4e959', '', '', '15709 139 STREET APT 321', '', 'EDMONTON', 'T6V 0C6', 43, 2, '570f171d94ea0', '5.00', '', 'cheque', 'SAHARLA ADEN', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-04-13 21:05:49'),
(18, 'Tyree', 'Malcolm', 'runninback33@hotmail.com', '780-530-4264', '', '47a1baec32604ce4a30bafd5b0d39460', '9bbbf653658cef7a1f23a984b07b353cb5b6e2fd', '', '', '8620 184 Street', '', 'Edmonton', 'AB', 43, 2, '5711943f19c05', '5.00', '', 'cheque', 'Tyree Malcolm', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-04-15 18:24:15'),
(21, 'Samuel', 'Staffe', 'bodyguard@live.ca', '780-257-2962', '', '35da6e7819004783373c4b32270ec759', 'c4611a0bb6f666354b306fdf11e0354a1a825f8a', '', '', '4520 26 AVE', '', 'EDMONTON', 'T6L 5J1', 43, 2, '572a4da7bb817', '5.00', '', 'cheque', 'SAMUEL STAFFE', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-05-04 12:29:43'),
(20, 'Russ', 'Zaltsmenov', 'buzzzrus@gmail.com', '780-707-0459', '', '715747e7eea7877ad5515d3ff864c84b', 'bc988796ba393a292cba953553fbf20711a01c37', 'Russ', 'Zaltsmenov', 'PO BOX 780 54 RPO Callinwood', '', 'Edmonton', 'T6K1Y4', 43, 2, '571ad1ad47ffb', '5.00', '', 'cheque', 'Russ Zaltsmenov', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-04-22 18:36:45'),
(22, 'Colin', 'Snowball', 'csnowball@gmail.com', '7809649989', '7809649989', '78343ed9f40ed5ecc309d706ec83f6f1', '68196d33b716fd4bc00f5b37452b7c3bccaf1e75', 'Snowball Media & Advertising', '', '8733 53 Ave', '', 'Edmonton', 'T6E5E9', 43, 2, '572aa1a1d1211', '5.00', '', 'cheque', 'Colin Snowball', '', '', '', '', '', '', '70.74.177.91', 1, 1, '2016-05-04 18:28:01'),
(23, 'Cornelia', 'Cousins', 'cornelia_cousins@yahoo.ca', '780-901-4781', '', '235811d7e4ef1ea22698e2cfb6b6beee', '87799542105ae5bc3e15cbf906f22ea8d5cc561d', '', '', '10227 137 Ave', 'AB', 'Edmonton', 'T5E 1Y9', 43, 2, '5737e896d7f3f', '5.00', '', 'cheque', 'CORNELIA COUSINS', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-05-14 20:10:14'),
(24, 'Kevon', 'Wallace', 'kevonwallace@gmail.com', '780-838-9542', '', 'e5dc3cf7ab61aaca2298cc072a587017', '2d065c97ffc0a417ade9a34b1100da1b2b87d865', '', '', '13635 34 street', 'ab', 'edmonton', 't5a0c4', 43, 2, '5740c49db2fa5', '5.00', '', 'cheque', 'Kevon Wallace', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-05-21 13:27:09'),
(25, 'Bradly', 'Wack', 'bradly_wack@hotmail.com', '780-807-5336', '', '978495ca4eb2bfa1bbef0fa2e38564db', '6ebc76d33b794985a0e7d69fca2fc8f6e132ebea', '', '', '1628 150 Ave', 'AB', 'EDMONTON', 'T5Y 3J1', 43, 2, '5744fc4c3a22e', '5.00', '', 'cheque', 'BRADLY WACK', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-05-24 18:13:48'),
(26, 'Darren ', 'Swerda', 'dss539@ymail.com', '17809338054', '', 'ce972d30b343890f05ff540abc7129d9', '0b57f98195e3af791feb46814b23b37eb458cccf', '', '', '515 Halton St.', 'Alberta', 'Thunder Bay Ont.', 'P7A7R9', 43, 2, '57617e375d6c8', '5.00', '', 'cheque', 'Darren Swerda', '', '', '', '', '', '', '207.148.173.164', 1, 1, '2016-06-15 09:11:35'),
(27, 'Devon', 'Williams', 'devon@dreamteamauto.ca', '587-873-3347', '', 'e598d81b6b1b75d2b8a866c21da1016d', '81e282f8e4fb1b395803529a9f02d63e534e8b25', '', '', '12251 167 B Ave', 'AB', 'EDMONTON', 'T5X0G7', 43, 2, '5765a4cad08f0', '5.00', '', 'cheque', 'Devon Williams', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-06-18 12:45:14'),
(28, 'Nhat', 'Nguyen', 'nnguyen1976@yahoo.ca', '780-267-9575', '', 'd2b658bcb2c24ce0b6754d5619c265e2', 'd1ca8743c1c063646b4643dcd796a394de2c4dde', 'Can Auto Finance', '', '111222', 'AB', 'Edmonton', 'T5T 4M2', 43, 2, '57698edde0f71', '5.00', '', 'cheque', 'Can Auto Finance', '', '', '', '', '', '', '209.89.100.67', 1, 1, '2016-06-21 12:00:45'),
(29, 'Christina', 'McDougall', 'chris1503jade@gmail.com', '3067697205', '', 'b678567197fe4cb5b0be727da9a7f3f2', '7af9069b8dc856d06f224830423afd7f08a9cd42', '', '', 'Nw115115 west of 2nd', 'Saskatchewan ', 'whitefox', 'S0j3b0', 43, 2, '576ac710e94ff', '5.00', '', 'cheque', 'Christina McDougall ', '', '', '', '', '', '', '207.195.86.68', 1, 1, '2016-06-22 10:12:48'),
(31, 'Lester', 'George', 'sagaboy71@gmail.com', '587.930.6499', '', 'be462454299888b4d3633dc5aceba7da', '9830ecae79745873e96d99fa82020856d7017c46', 'Legacy Group INC ', '', '3552 33 ave se', 'Alberta ', 'Calgary ', 'T0G2K0', 43, 2, '576d75ce5855b', '5.00', '', 'cheque', 'Lester George', '', '', '', '', '', '', '68.179.68.105', 1, 1, '2016-06-24 11:02:54'),
(32, 'Omar', 'Salah', 'ewavegroupinc@gmail.com', '905-921-1084', '', 'f153c9dde6211e2605b8d0c9ad9c651e', '58c51b8194ccec65160c8fdf9707c0909ab23f5b', 'EWAVE GROUP INC', 'http://techno-logy.com', '345 VALRIDGE DRIVE', 'ONTARIO', 'ANCASTER', 'L9G 0B1', 43, 2, '5770ea7360f78', '5.00', '', 'cheque', 'EWAVE GROUP INC', '', '', '', '', '', '', '13.93.149.84', 1, 1, '2016-06-27 01:57:23'),
(33, 'Dennis', 'Davison', 'ddavison@telus.net', '7809071648', '587-759-2504', '924960ede60c41ea435a8dc7fa007a34', '05ccb1ed6279138a78ba06bed68ae5cb6f1869e5', '', '', '7232 Armour Crescent SW', 'Alberta', 'Edmonton', 'T6W2P1', 43, 2, '5772c3b39eecf', '5.00', '', 'cheque', 'Dennis Davison', '', '', '', '', '', '', '75.159.87.10', 1, 1, '2016-06-28 11:36:35'),
(34, 'Floyd', 'Patrick', 'floyd_patrick2000@yahoo.ca', '(416) 402-7186', '4164027186', '834de5ef8ef8cc9db6dfe1baad881768', '47d41b649e77ec458590c3ace5c40530ca042258', '', '', '19-2585 Jane street', 'Ontario', 'Toronto', 'M3L-1R8', 43, 2, '57f1a4ea7c1c1', '5.00', '', 'cheque', 'Floyd Patrick', '', '', '', '', '', '', '173.206.17.73', 1, 1, '2016-10-02 17:23:06'),
(39, 'Bryant', 'Lawrence', 'bryant.lawrence21@gmail.com', '5879373882', '', '58106090f6085265914ac076a6252482', 'df00d208b3d96cd348e54d8268efbba465d128eb', '', '', 'Apt. 202 10129 163 Street', 'Alberta', 'Edmonton', 'T5P 3N6', 43, 2, '584ee123e734c', '5.00', '', 'cheque', 'Bryant Lawrence', '', '', '', '', '', '', '24.114.42.181', 1, 1, '2016-12-12 09:40:51'),
(37, 'Simon', 'Ferguson', 'simonsaysapproved@gmail.com', '780-887-4357', '', 'db8da2366b2dc0d973acf3c193b2fb37', '1fe482c6c3c7b1a417a8e23024ade4e6b3c1af2f', '', '', '111', 'ab', 'edmotnobn', 't5t567', 43, 2, '57feefc8ec086', '5.00', '', 'cheque', 'simon ferguson', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-10-12 19:22:00'),
(38, 'SIMON', 'FERGUSON', 'internetceo@hotmail.com', '780-887-4357', '', '31f6205149a3bcd857e0fddbfefc18aa', '555ef24448b96126a848307650685b901a90fa4d', '', '', '111', 'ab', 'edmotnon', 't5t4g6', 43, 2, '57fef1220ea98', '5.00', '', 'cheque', 'simon ferguson', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-10-12 19:27:46');

-- --------------------------------------------------------

--
-- Table structure for table `affiliatetransaction`
--

CREATE TABLE `affiliatetransaction` (
  `affiliatetransactionid` int(11) NOT NULL,
  `affiliateid` int(11) NOT NULL,
  `contactinfoid` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `dateadded` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affiliatetransaction`
--

INSERT INTO `affiliatetransaction` (`affiliatetransactionid`, `affiliateid`, `contactinfoid`, `description`, `amount`, `dateadded`, `status`) VALUES
(2, 6, 3, '5', '0.0000', '2016-03-25 05:45:06', 1),
(5, 10, 5, '4', '0.0000', '2016-04-06 13:03:46', 3),
(6, 10, 6, '5', '0.0000', '2016-04-12 15:31:16', 1),
(7, 10, 9, '2', '0.0000', '2016-04-23 20:59:03', 1),
(8, 0, 10, '5', '0.0000', '2016-04-29 05:40:49', 1),
(9, 0, 13, '1', '0.0000', '2016-05-09 14:38:56', 3),
(10, 0, 14, '1', '0.0000', '2016-05-11 22:01:31', 3),
(11, 0, 15, '2', '0.0000', '2016-05-15 13:54:20', 1),
(14, 24, 18, '1', '0.0000', '2016-05-21 13:29:09', 3),
(15, 0, 19, '1', '0.0000', '2016-05-24 07:27:46', 3),
(16, 25, 20, '1', '0.0000', '2016-05-24 18:16:37', 1),
(17, 0, 21, '1', '0.0000', '2016-05-26 14:53:39', 3),
(18, 0, 22, '1', '0.0000', '2016-05-26 21:43:13', 3),
(19, 0, 23, '1', '0.0000', '2016-05-26 22:43:32', 3),
(20, 0, 24, '1', '0.0000', '2016-05-27 02:06:56', 3),
(21, 0, 25, '1', '0.0000', '2016-05-28 00:40:20', 3),
(22, 0, 26, '1', '0.0000', '2016-05-28 00:41:26', 3),
(23, 0, 27, '1', '0.0000', '2016-05-29 22:15:10', 3),
(24, 0, 28, '1', '0.0000', '2016-05-29 23:34:00', 3),
(25, 0, 29, '1', '0.0000', '2016-05-30 21:17:55', 3),
(26, 0, 30, '1', '0.0000', '2016-06-01 07:28:16', 3),
(27, 0, 31, '1', '0.0000', '2016-06-02 19:30:40', 3),
(28, 0, 32, '1', '0.0000', '2016-06-06 13:14:19', 3),
(29, 0, 33, '1', '0.0000', '2016-06-10 15:37:34', 3),
(30, 0, 34, '1', '0.0000', '2016-06-15 17:45:19', 3),
(31, 0, 35, '1', '0.0000', '2016-06-15 17:45:19', 3),
(32, 0, 36, '1', '0.0000', '2016-06-15 17:45:21', 3),
(34, 0, 38, '2', '0.0000', '2016-06-20 17:19:52', 1),
(35, 0, 39, '1', '0.0000', '2016-06-21 23:27:58', 3),
(36, 0, 40, '1', '0.0000', '2016-06-22 11:01:31', 3),
(37, 0, 41, '2', '0.0000', '2016-06-23 08:42:22', 1),
(38, 29, 42, '2', '0.0000', '2016-06-23 17:43:19', 1),
(39, 22, 43, '7', '500.0000', '2016-04-29 10:40:09', 1),
(40, 1, 44, '1', '0.0000', '2016-06-24 13:15:22', 3),
(41, 0, 45, '1', '0.0000', '2016-06-26 09:49:24', 3),
(42, 0, 46, '1', '0.0000', '2016-06-27 15:21:50', 3),
(43, 0, 47, '2', '0.0000', '2016-06-28 12:52:56', 1),
(44, 1, 53, '2', '0.0000', '2016-07-15 11:34:09', 1),
(45, 26, 54, '2', '0.0000', '2016-10-12 20:27:28', 1),
(46, 26, 55, '4', '0.0000', '2016-10-12 20:33:05', 1),
(47, 26, 56, '4', '0.0000', '2016-10-13 09:07:13', 1),
(48, 26, 57, '7', '0.0000', '2016-10-13 09:14:11', 1),
(49, 26, 58, '4', '0.0000', '2016-10-13 13:17:05', 1),
(50, 26, 59, '1', '0.0000', '2016-10-13 16:33:19', 3),
(51, 26, 61, '2', '0.0000', '2016-10-13 17:29:03', 1),
(52, 26, 62, '2', '0.0000', '2016-10-14 08:00:55', 1),
(53, 26, 66, '5', '0.0000', '2016-10-14 16:01:08', 1),
(54, 26, 67, '4', '0.0000', '2016-10-14 16:26:46', 1),
(55, 26, 69, '2', '0.0000', '2016-10-16 13:50:59', 1),
(56, 26, 70, '1', '0.0000', '2016-10-16 15:52:00', 3),
(57, 26, 71, '4', '0.0000', '2016-10-16 15:55:32', 1),
(58, 1, 72, '1', '0.0000', '2016-10-17 11:38:17', 3),
(59, 1, 73, '1', '0.0000', '2016-10-17 11:39:05', 3),
(60, 1, 74, '1', '0.0000', '2016-10-17 11:41:16', 3),
(61, 26, 75, '1', '0.0000', '2016-10-18 10:57:00', 3),
(62, 26, 76, '2', '0.0000', '2016-10-18 19:24:42', 1),
(63, 26, 77, '7', '500.0000', '2016-10-18 19:50:33', 1),
(64, 26, 78, '1', '0.0000', '2016-10-18 21:11:04', 3),
(65, 26, 79, '4', '0.0000', '2016-10-23 14:53:13', 1),
(66, 1, 80, '1', '0.0000', '2016-10-24 08:29:22', 3),
(67, 26, 81, '1', '0.0000', '2016-10-24 11:05:40', 3),
(68, 26, 82, '1', '0.0000', '2016-10-24 16:14:58', 3),
(69, 26, 83, '5', '0.0000', '2016-10-27 10:38:20', 1),
(70, 26, 84, '1', '0.0000', '2016-10-27 20:39:43', 3),
(71, 26, 85, '2', '0.0000', '2016-10-28 19:22:49', 1),
(72, 26, 86, '2', '0.0000', '2016-10-28 19:28:12', 1),
(73, 26, 88, '1', '0.0000', '2016-10-30 08:16:31', 3),
(74, 26, 90, '1', '0.0000', '2016-11-07 19:22:11', 3),
(75, 26, 92, '5', '0.0000', '2016-12-13 00:00:00', 1),
(76, 26, 93, '1', '0.0000', '2016-12-13 00:00:00', 1),
(77, 26, 94, '1', '0.0000', '2016-12-15 18:54:14', 3),
(78, 26, 95, '1', '0.0000', '2016-12-16 18:27:44', 3),
(79, 26, 96, '1', '0.0000', '2016-12-17 13:28:19', 3),
(81, 0, 89, '1', '0.0000', '2016-12-05 00:00:00', 1),
(82, 26, 97, '1', '0.0000', '2016-12-26 11:49:17', 3);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inventoryaccess`
--

CREATE TABLE `inventoryaccess` (
  `Id` int(11) NOT NULL,
  `SALT` varchar(100) NOT NULL,
  `HASH` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventoryaccess`
--

INSERT INTO `inventoryaccess` (`Id`, `SALT`, `HASH`) VALUES
(1, 'e7f937da3989c33d0a31eb9eca14d66f', '8897815c761f699571b4f16e05bcdcdd571f8d21');

-- --------------------------------------------------------

--
-- Table structure for table `superaffiliate`
--

CREATE TABLE `superaffiliate` (
  `superaffiliate_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `HASH` varchar(50) NOT NULL,
  `company` varchar(32) NOT NULL,
  `website` varchar(255) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '43',
  `zone_id` int(11) NOT NULL DEFAULT '2',
  `code` varchar(64) NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax` varchar(64) DEFAULT NULL,
  `payment` varchar(6) DEFAULT NULL,
  `cheque` varchar(100) DEFAULT NULL,
  `paypal` varchar(64) DEFAULT NULL,
  `bank_name` varchar(64) DEFAULT NULL,
  `bank_branch_number` varchar(64) DEFAULT NULL,
  `bank_swift_code` varchar(64) DEFAULT NULL,
  `bank_account_name` varchar(64) DEFAULT NULL,
  `bank_account_number` varchar(64) DEFAULT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `superaffiliate`
--

INSERT INTO `superaffiliate` (`superaffiliate_id`, `firstname`, `lastname`, `email`, `telephone`, `fax`, `salt`, `HASH`, `company`, `website`, `address_1`, `address_2`, `city`, `postcode`, `country_id`, `zone_id`, `code`, `commission`, `tax`, `payment`, `cheque`, `paypal`, `bank_name`, `bank_branch_number`, `bank_swift_code`, `bank_account_name`, `bank_account_number`, `ip`, `status`, `approved`, `date_added`) VALUES
(1, 'SEAN', 'DONALDS', 'sadonalds@hotmail.com', '7809774874', '', 'a8f56c1eb9cbd3a6661e3eccc69375cf', 'd8448368b4d1c2ca6f93585175a4866731a163c5', 'AFFINITY BUSINESS SOLUTIONS', '', '6050 SOUTH TERWILLEGAR BOULEVARD', '', 'EDMONTON', 'T6R 0K6', 43, 2, '57052e7390e43', '5.00', '', 'cheque', 'SEAN DONALDS', '', '', '', '', '', '', '173.212.145.57', 1, 1, '2016-04-06 08:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `superaffiliatetransaction`
--

CREATE TABLE `superaffiliatetransaction` (
  `superaffiliatetransactionid` int(11) NOT NULL,
  `superaffiliateid` int(11) NOT NULL,
  `affiliateid` int(11) NOT NULL,
  `description` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `dateadded` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblcoapplicant`
--

CREATE TABLE `tblcoapplicant` (
  `Id` int(11) NOT NULL,
  `ContactInfoId` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key tblcontactinfo',
  `EmploymentId` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key tblemployment',
  `PreviousEmpId` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key tblpreviousemployment',
  `RelationContactId` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key tblcontact',
  `Relation` varchar(100) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcoapplicant`
--

INSERT INTO `tblcoapplicant` (`Id`, `ContactInfoId`, `EmploymentId`, `PreviousEmpId`, `RelationContactId`, `Relation`, `Timestamp`, `Status`) VALUES
(1, 49, 14, 0, 13, 'Spouse', '2016-07-12 17:48:51', 0),
(2, 68, 28, 0, 26, 'Spouse', '2016-10-15 22:53:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `Id` int(11) NOT NULL,
  `ContactInfoId` int(11) DEFAULT NULL COMMENT 'foreign key tblcontactinfo',
  `MortgageId` int(11) DEFAULT NULL COMMENT 'foreign key tblmortgage',
  `EmploymentId` int(11) DEFAULT NULL COMMENT 'foreign key tblemployment',
  `PreviousEmpId` int(11) DEFAULT NULL COMMENT 'foreign key tblpreviousemployment',
  `CreateDate` datetime NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`Id`, `ContactInfoId`, `MortgageId`, `EmploymentId`, `PreviousEmpId`, `CreateDate`, `Timestamp`, `Status`) VALUES
(1, 3, 3, 1, 0, '2016-03-25 05:45:07', '2016-03-25 05:45:07', 0),
(2, 6, 4, 2, 0, '2016-04-12 22:39:19', '2016-04-12 22:39:19', 1),
(3, 10, 5, 3, 1, '2016-04-29 05:40:49', '2016-04-29 05:40:49', 1),
(6, 15, 8, 6, 0, '2016-05-20 22:41:31', '2016-05-20 22:41:31', 1),
(5, 9, 7, 5, 3, '2016-05-16 20:32:06', '2016-05-16 20:32:06', 1),
(7, 38, 11, 7, 4, '2016-06-21 00:24:35', '2016-06-21 00:24:35', 1),
(8, 41, 12, 8, 0, '2016-06-23 15:44:35', '2016-06-23 15:44:35', 1),
(9, 20, 13, 9, 0, '2016-06-23 19:01:10', '2016-06-23 19:01:10', 1),
(10, 42, 14, 10, 0, '2016-06-24 17:23:14', '2016-06-24 17:23:14', 1),
(11, 43, 15, 11, 5, '2016-04-29 10:40:09', '2016-06-24 17:44:57', 1),
(12, 47, 17, 12, 6, '2016-06-28 19:53:59', '2016-06-28 19:53:59', 0),
(13, 48, 18, 13, 7, '2016-07-12 17:48:18', '2016-07-12 17:48:18', 0),
(14, 51, 19, 15, 0, '2016-07-15 15:01:02', '2016-07-15 15:01:02', 1),
(15, 52, 20, 16, 0, '2016-07-15 17:58:32', '2016-07-15 17:58:32', 0),
(16, 53, 21, 17, 8, '2016-07-15 18:35:04', '2016-07-15 18:35:04', 0),
(24, 61, 29, 25, 0, '2016-10-14 23:16:25', '2016-10-14 23:16:25', 1),
(23, 57, 28, 24, 0, '2016-10-14 21:44:43', '2016-10-14 21:44:43', 1),
(22, 56, 27, 23, 0, '2016-10-14 21:41:25', '2016-10-14 21:41:25', 1),
(21, 55, 26, 22, 0, '2016-10-14 21:35:07', '2016-10-14 21:35:07', 1),
(25, 54, 35, 26, 9, '2016-10-14 23:37:13', '2016-10-14 23:37:13', 1),
(26, 67, 36, 27, 0, '2016-10-15 22:48:15', '2016-10-15 22:48:15', 0),
(27, 62, 37, 29, 0, '2016-10-16 00:17:34', '2016-10-16 00:17:34', 1),
(28, 71, 38, 30, 10, '2016-10-17 15:32:37', '2016-10-17 15:32:37', 1),
(29, 69, 39, 31, 0, '2016-10-17 15:37:02', '2016-10-17 15:37:02', 1),
(30, 66, 40, 32, 0, '2016-10-17 15:42:02', '2016-10-17 15:42:02', 0),
(31, 58, 41, 33, 11, '2016-10-18 15:32:57', '2016-10-18 15:32:57', 1),
(32, 76, 42, 34, 0, '2016-10-19 19:26:18', '2016-10-19 19:26:18', 1),
(33, 77, 43, 35, 12, '2016-10-24 17:57:04', '2016-10-24 17:57:04', 1),
(34, 79, 44, 36, 0, '2016-10-25 02:57:20', '2016-10-25 02:57:20', 0),
(35, 83, 45, 37, 13, '2016-10-28 16:26:20', '2016-10-28 16:26:20', 0),
(36, 85, 46, 38, 14, '2016-11-01 16:08:59', '2016-11-01 16:08:59', 1),
(37, 86, 47, 39, 15, '2016-11-04 00:57:42', '2016-11-04 00:57:42', 1),
(38, 89, 48, 40, 0, '2016-11-05 22:13:03', '2016-11-05 22:13:03', 1),
(40, 92, 50, 42, 16, '2016-12-15 17:27:14', '2016-12-15 17:27:14', 0),
(41, 98, 51, 43, 0, '2017-01-13 19:24:40', '2017-01-13 19:24:40', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcontactinfo`
--

CREATE TABLE `tblcontactinfo` (
  `Id` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Address1` text,
  `Address2` text,
  `Postal` text,
  `City` varchar(50) DEFAULT 'Edmonton',
  `Province` text,
  `Country` varchar(50) DEFAULT 'Canada',
  `Phone1` text,
  `Email` text,
  `SIN` varchar(9) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `MaritalStatus` varchar(25) DEFAULT NULL,
  `Gender` varchar(25) DEFAULT NULL,
  `ResidenceYears` int(11) DEFAULT '0',
  `ResidenceMonths` int(11) DEFAULT '0',
  `CreditScore` varchar(25) DEFAULT '0',
  `Notes` text,
  `ArchiveNotes` text,
  `ArchiveNotification` date DEFAULT NULL,
  `Created` datetime NOT NULL,
  `Notification` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblcontactinfo`
--

INSERT INTO `tblcontactinfo` (`Id`, `FirstName`, `LastName`, `Address1`, `Address2`, `Postal`, `City`, `Province`, `Country`, `Phone1`, `Email`, `SIN`, `DOB`, `MaritalStatus`, `Gender`, `ResidenceYears`, `ResidenceMonths`, `CreditScore`, `Notes`, `ArchiveNotes`, `ArchiveNotification`, `Created`, `Notification`, `Status`) VALUES
(10, 'Joey', 'Crookedneck', 'Box 375', '', 'S0M1L0', 'Loon lake', 'SASKATCHEWAN', 'Canada', '6398401401', 'jcrookedneck@yahoo.ca', '', '1979-04-25', 'Common Law', 'Male', 1, 0, '493', '', NULL, NULL, '2016-04-29 05:40:49', NULL, 1),
(9, 'Joey', 'McCallum', 'Po Box 14 - lot 9 block 2 Canoe Rd ', '', 'S0M 0M0', 'Cole Bay', 'SK', 'Canada', '306-829-4256', 'rough_riders_14@outlook.com', '660132473', '1987-05-29', 'Single', 'Male', 25, 0, '0', '', NULL, NULL, '2016-05-16 20:32:06', NULL, 1),
(5, 'Jordana', 'Badger', '', '', '', '', '', 'Canada', '3069411469', 'JordanaBadger@outlook.com', '', '0000-00-00', '', '', 0, 0, '0', '', 'quit job, out of the market. call back in 6 months. Dec 2016', NULL, '2016-04-06 20:03:46', NULL, 0),
(3, 'Christopher', 'Gallerneault', '1898-13 west', '', 'S6v3k3', 'Prince albert', 'Sk', 'Canada', '3069221571', 'chrisgallerneault', '', '1981-01-01', 'Single', 'Male', 2, 4, '0', '', NULL, NULL, '2016-03-25 05:45:06', NULL, 1),
(6, 'Allison', 'Rabbitskin  ', 'Box 624', '', 'S0J0E0', 'Big River', 'Saskatchewan  ', 'Canada', '13064699124', 'aaliyah_love2015@outlook.com', '664255239', '1993-04-20', 'Common Law', 'Female', 4, 4, '514', '', NULL, NULL, '2016-04-12 22:39:19', NULL, 1),
(11, 'Stella', 'Supernault', '', '', '', '', '', 'Canada', '780-513-1228', 'ssupernault@northernalberta.ymca.ca', '', '0000-00-00', '', '', 0, 0, '0', '', 'currently in bankruptcy.  1 yr follow up - MAY 2017', NULL, '2016-05-03 17:04:50', NULL, 0),
(15, 'joseph ', 'harry', '4984 River Road', '', 'V8A0B7', 'Powell River', 'British Columbia', 'Canada', '6042234417', 'derekjgalligos@gmail.com', '', '1959-09-07', 'Divorced', 'Male', 50, 0, '544', '', '', NULL, '2016-05-20 22:41:31', 0, 1),
(19, 'James', 'Staunton', '1380 Hwy 8', '', 'N1R 5S2', 'RR 1 Cambridge', 'Ontario', 'Canada', '226-808-8565', 'staunton22@gmail.com', '473 447 5', '1962-11-08', 'Separated', 'Male', 4, 5, '0', '', '', NULL, '2016-05-24 14:36:53', 1, 1),
(20, 'Daniel', 'Mccartney', '64 Kendall Crescent', '', 'T8N 7A9', 'St. Albert', 'AB', 'Canada', '780-3945344', '', '672938842', '1997-03-04', 'Single', 'Male', 8, 0, '0', 'truck or suv', '', NULL, '2016-06-23 19:01:10', 0, 1),
(39, 'Mike ', 'Short', '', '', '', '', '', 'Canada', '7809743286 ', 'short2013@hotmail.com', '', '0000-00-00', '', '', 0, 0, '0', '', 'jdhsgfdhjsgf dhjsgfdhjsgfhjds jdsgfdhjsgf', '2016-08-16', '2016-06-22 06:27:58', 0, 0),
(36, 'Carl', 'Chico', '1585 West 115th Avenue', '', '80234', 'Westminster', 'CO', 'Canada', '7295793929', 'Carlchico720@gmail.com', '', '1987-03-07', 'Single', 'Male', 1, 5, '0', '', '', NULL, '2016-06-16 00:56:35', 1, 1),
(38, 'Meagan', 'Ivanco', '311A 5580 35th street', '', 'T7S0G1', 'whitecourt', 'AB', 'Canada', '4036051555', 'ivancomeagan@gmail.com', '655876365', '1985-02-24', 'Common Law', 'Female', 0, 1, '0', '', '', NULL, '2016-06-21 00:24:35', 1, 1),
(42, 'Karnel', 'Michell', '3666 11th Street Ambassador Trailer Court', '', 'VOJ 1Z2', 'Houston', 'BC', 'Canada', '250-844-1154', 'karnel421@hotmail.com', '', '1972-10-28', 'Divorced', 'Male', 6, 0, '0', '', '', NULL, '2016-06-24 17:23:14', 1, 1),
(40, 'Thaney', 'Lupichuk', 'Box 242', '', 'T0H1C0', 'Hythe', 'AB', 'Canada', '780-978-2560', 'tlupichuk@gmail.com', '', '1987-07-02', 'Single', 'Female', 1, 4, '0', '', '', NULL, '2016-06-22 18:04:11', 1, 1),
(41, 'keith', 'morrison', '13910 stony plain rd', '', 't5n3r2', 'edmonton ', 'alberta', 'Canada', '7786548316', 'keithmorrison3@gmail.com', '', '1988-09-10', 'Single', 'Male', 5, 0, '0', '', '', NULL, '2016-06-23 15:44:35', 1, 1),
(43, 'Nordia', 'Hunt', '8310 Jasper Avenue NW', '', 'T5H 3S3', 'Edmonton', 'AB', 'Canada', '7805667574', '', '651629933', '1981-02-02', 'Common Law', 'Female', 2, 0, '0', '', '', NULL, '2016-04-29 10:40:09', 1, 1),
(45, 'Mario', 'St aubin', '20401 simcoe rd', '', 'L0C1G0', 'Seagrave', 'Ont', 'Canada', '9059858403', 'staubmr@aol.com', '479440950', '1965-07-24', 'Common Law', 'Male', 16, 8, '0', '', '', NULL, '2016-06-26 16:55:07', 1, 1),
(46, 'Ernest', 'Sanregret', '', '', '', '', '', 'Canada', '7805459965', 'esanregret@hotmail.com', '', '0000-00-00', '', '', 0, 0, '0', '', 'This is just testing', '2016-08-08', '2016-06-27 22:21:50', 0, 0),
(47, 'vikram', 'demo', 'sdgsdg', '', 'sdgsdgsd', 'sdgsdgsdg', 'sdgsdg', 'Canada', '346346346', 'vipvicks71@gmail.com', '', '1991-01-01', 'Common Law', 'Male', 2, 4, '0', '', '', NULL, '2016-06-28 19:53:59', 1, 1),
(48, 'Vikram', 'Shah', '201C - 3624 119 Street NW', '', 'T6E5E9', 'Edmonton', 'AB', 'Canada', '7806602477', 'shahvikram24@hotmail.com', '', '1998-01-01', 'Single', 'Male', 3, 3, '0', '', '', NULL, '2016-07-12 17:48:18', 1, 1),
(49, 'Hirva', 'Shah', '201C - 3624 119 Street NW', '', 'T6J2X6', 'Edmonton', 'AB - Alberta', 'Canada', '7806602427', 's_hirva@yahoo.in', '', '1998-01-01', 'Married', 'Female', 0, 0, '0', '', '', NULL, '0000-00-00 00:00:00', 0, 1),
(52, 'vikram', 'shah', 'skjdfhksdjhfsh', '', 'y6y6y6', 'hglgsdhgsdlkhg', 'AB', 'Canada', '4636364366', 'kjsdjfjsj@gmail.com', '', '1998-01-01', 'Married', 'Male', 4, 4, '0', '', '', NULL, '2016-07-15 17:58:32', 0, 1),
(51, 'Ryan ', 'Hartmann', '105 foxboro twrrace', '', 'T8a6c8', 'Sherwood park ', 'Alberta', 'Canada', '7802895289', 'hartmann_ryan@hotmail.com', '650368814', '1980-07-02', 'Separated', 'Male', 5, 0, '0', '', '', NULL, '2016-07-15 15:01:02', 1, 1),
(53, 'vikram', 'shah', 'khlhlh', '', 'hlhlhlhlh', 'hlkhlkhlkh', 'hhlhlhl', 'Canada', '4636364366', 'vipvicks71@gmail.com', '', '1998-01-01', 'Married', 'Female', 3, 6, '780', '', '', '0000-00-00', '2016-07-15 18:35:04', 0, 1),
(54, 'Markus', 'Goodhope', '11313 101 ST', '', 'T8V2P7', 'GRANDE PRAIRIE', 'AB', 'Canada', '4034360310', 'mcgoodhope1@gmail.com', '728085929', '1998-05-09', 'Single', 'Male', 2, 1, '484', 'looking for a 2500 to pull his  toy hauler trailer. works for the county of Grande Prairie.', '', '0000-00-00', '2016-10-14 23:37:13', 1, 1),
(55, 'Lila', 'Logan', 'P.O. BOX 165 / 6020 EAST CENTENNIAL ROAD', '', 'V0C 1X0', 'MOBERLY LAKE', 'BC', 'Canada', '2504017336', '', '', '1965-06-14', 'Single', 'Female', 50, 0, '595', '6020 E Centennial Rd. Moberly Lake BC. P.O.Box 165 V0C1X0\r\nHas lived there for 50 years and owns her home. no mortgage. \r\nBorn June 14,1965  drivers # 4092473\r\ntrade a 2015 Honda Civic for a Tahoe \r\nDoes not like the car in the winter as lots of snow and also mountains, hills.', '', '0000-00-00', '2016-10-14 21:35:07', 1, 1),
(56, 'Roseanne', 'Taypotat', '424 TORONTO STREET', '', 'S4R 1M4', 'REGINAK', 'SK', 'Canada', '306-450-2721', 'rtaypotat73@gmail.com', '', '1961-08-14', '', 'Female', 0, 2, '422', 'Born August 14, 1961\r\nLives at A424 Toronto St. Regina Sask S4R1M4  $750.00 per month  There a couple of months now\r\nOld address is 170 Cannon St. Regina Sask.S4N4E3  was there for 1.5 years\r\n\r\nWorks at Thomas Circle of Care Network  Regina Sask  $17.00 per hour\r\nHas a 2015  Dodge Caravan now i believe, not sure if she wants to trade it in or add another vehicle.\r\nShe is looking for a 7  passenger van  I believe to transport kids where she works.\r\n\r\n', '', '0000-00-00', '2016-10-14 21:41:25', 1, 1),
(57, 'Justine', 'Severight', 'P.O. BOX 1343', '', 'S0A 1S0', 'KAMSACK', 'SK', 'Canada', '306-542-0408', 'miss_severight15@hotmail.com', '', '1998-04-25', 'Single', 'Male', 5, 0, '535', 'Looking for a small Suv or van. Has three children and one plays hockey. Need the room for the kids and hockey equipment \r\nAround $400.00 to $500.00 per month payments would be great as she explained.\r\nNever had a vehicle loan, but was a cosigner at one point. Does not believe she has much for credit, not bad just not much.\r\n', '', '0000-00-00', '2016-10-14 21:44:43', 1, 1),
(58, 'Michael', 'Hibbs', '10210 87 Street', '', 'T8X 0M5', 'GRANDE PRAIRIE', 'ab', 'Canada', '780-882-1203', 'mhibbs312@gmail.com', '', '1964-11-08', 'Married', 'Male', 2, 0, '0', 'Looking to trade a 2014 truck and get into a car. Something like a Hyundia  or a Kia, something good on gas.\r\nLives in Grande Prairie Ab', '', '0000-00-00', '2016-10-18 15:32:57', 1, 1),
(59, 'Robbie David', 'Kearley', '', '', '', '', '', 'Canada', '4035222600', 'bait4bears@gmail.com', '', '0000-00-00', '', '', 0, 0, '0', 'Date of birth is 06/14/72\r\nLives at 200 Sentinel Rd. Lake Louise Ab T0L1E0 $400.00 monthly for rent.\r\nLooking for an F150 or Silverado Full size truck either an extended cab or Crew Cab.\r\nNo Trade in.\r\nHas no credit. Has no loans.\r\n Has not had to finance anything before as his parents usually bought what he needed.\r\nWorks for Station Partnership LTD as a cook at one of the restaurants they own.\r\nPhone number is his work number as his phone was destroyed recently and he needs to replace it.\r\nContact by email to start', '', '0000-00-00', '2016-10-13 23:33:19', 1, 3),
(67, 'Ernie', 'Noskiye', 'PO BOX 2664, 9 WABIHILL TRAILOR COURT', '', 'VOC1J0', 'CHETWYND', 'BC', 'Canada', '306-441-6646', 'Ernienoskiye@hotmail.ca', '', '1959-07-06', 'Married', 'Male', 8, 1, '564', 'P.O. Box 2667 Chetwynd BC V0C1J0\r\n\r\nlooking for half ton F150 ext cab lariat\r\nCurrently has a 2012 Challenger SRT and cannot drive it in the winter and needs a truck\r\nWorks at Site C Dam in Ft. ST. John BC Has work for 10 years works 21 on 7 off\r\nPeace River Hydro Partners 250-263-9920\r\n', 'DNP. Too Heavy in  Trade.  Poor Auto Repayment History.', '0000-00-00', '2016-10-15 22:48:15', 1, 1),
(61, 'Gabriel', 'John', 'PO BOX 57', '', 'S0M2V0', 'SPEERS', 'AB', 'Canada', '306-441-7878', 'gabjohn58@gmail.com', '', '1998-01-01', 'Married', 'Male', 20, 0, '0', 'Lives in Speers Sask.  P.O. Box 57 S0M2V0\r\nHas a 2013 Dodge Journey to trade  looking for another newer Journey or something like it.', '', '0000-00-00', '2016-10-14 23:16:25', 1, 1),
(62, 'Harry', 'Fisowich', 'APT 19 425 RAE STREET', '', 'S4R3M3', 'REGINA', 'SK', 'Canada', '306-501-8423', 'harry_fisowich@hotmail.com', '622-739-3', '1953-09-20', 'Single', 'Male', 5, 6, '555', 'Looking for an inexpensive 4 door smaller car. Automatic transmission. \r\nOn some kind of permanent disability... ', '', '0000-00-00', '2016-10-16 00:17:34', 1, 1),
(66, 'Roy', 'Jacknife', 'P.O. BOX 520, COLD LAKE FIRTS NATIONS ROUTE', '', 'T9M 1P4', 'COLD LAKE', 'AB', 'Canada', '780-573-3604', 'royjacknife48@hotmail.com', '', '1948-03-03', 'Married', 'Male', 60, 0, '506', 'Looking to get a truck', '	Awaiting T1 General or Income change.', '2017-02-01', '2016-10-17 15:42:02', 1, 1),
(68, 'CAROL ANN', 'NOSKIYE', 'SAME', '', 'VOC1J0', 'CHETWYND', 'BC', 'Canada', '306-937-3772', 'NO@EMAIL.COM', '608-087-8', '1998-01-01', 'Married', 'Female', 0, 0, '0', '', '', '0000-00-00', '0000-00-00 00:00:00', 0, 1),
(69, 'Lanny', 'O Rafferty', '1037 MCCORMACK ROAD', '', 'S7M 5C2', 'SASKATOON', 'sk', 'Canada', '306-881-2263', 'lanny_39@hotmail.com', '', '1974-06-03', 'Married', 'Male', 0, 2, '432', 'Has a 2013 Dodge Journey R/T that he would like to trade in.\r\nWants a truck as it would be more useful to him at this time.\r\nLooking to get payments around the $250.00-$300.00 Bi-weekly range\r\nWorking full time.', '', '0000-00-00', '2016-10-17 15:37:02', 1, 1),
(70, 'Heather ', 'McColl', '', '', '', '', '', 'Canada', '705-761-6571', 'heather.mccoll@yahoo.com', '', '0000-00-00', '', '', 0, 0, '0', 'Looking for a Jeep Wrangler.\r\nLives at 635 Bellaire St. Peterborough Ontario K9J3Y5\r\nHas a vehicle that is in her ex spouses name, She is going to see if he will sign it over or not. If so she will trade it if not no trade.\r\n', '', '0000-00-00', '2016-10-16 22:52:00', 1, 3),
(71, 'Keith', 'Esperance', 'P.O. BOX 2621', '', 'T0C 1N0', 'MASKWACIS', 'AB', 'Canada', '780-352-1529', 'keeper_00@hotmail.com', '', '1963-08-08', 'Single', 'Male', 27, 0, '445', 'Looking for a Jeep or an SUV of some type.', '', '0000-00-00', '2016-10-17 15:32:37', 1, 1),
(72, 'Nizarali', 'Moloo', '', '', '', '', '', 'Canada', '5878035825', 'nizaralimoloo@outlook.com', '', '0000-00-00', '', '', 0, 0, '0', '', '', '0000-00-00', '2016-10-17 18:38:17', 1, 3),
(73, 'Shaylynn', 'Papequash', '', '', '', '', '', 'Canada', '', 'papequash.shay@yahoo.ca', '', '0000-00-00', '', '', 0, 0, '0', 'I dont have the phone number.  But you can contact them through email.', '', '0000-00-00', '2016-10-17 18:39:05', 1, 3),
(74, 'Dylan', 'Deiter', '', '', '', '', '', 'Canada', '7802246960', 'fox_ridre@hotmail.com', '', '0000-00-00', '', '', 0, 0, '0', '', '', '0000-00-00', '2016-10-17 18:41:16', 1, 3),
(75, 'Stanley', 'Sanguez', '', '', '', '', '', 'Canada', '867-875-2914', 'sanguez58@gmail.com', '', '0000-00-00', '', '', 0, 0, '0', 'Currently has a 2015 Dodge Ram 1500  Laramie Longhorn with about 93,000 km, payments of $1468.00 per month\r\nLooking to trade down and lower his monthly payments. Will take an SUV or another truck that is a bit older with some mileage to lower payments.\r\nLives in the NWT\r\nWife may co sign if required. Ask about this when you speak with him.', 'He says its too much Hassell and wants to withdraw application', '0000-00-00', '2016-10-18 17:57:00', 1, 0),
(76, 'Ramona', 'Hobden', 'BOX 404 PEGUIS ', '', 'R0C3J0', 'PEGUIS', 'MB', 'Canada', '204-308-1148', 'rhobden@hotmail.com', '644-261-5', '1970-02-23', 'Married', 'Female', 20, 0, '0', 'Currently has a 2012 Ford Escape that she has had for 5 years now and needs something bigger to transport children and hockey equipment\r\nSome type of SUV or van would be great. \r\n', '', '0000-00-00', '2016-10-19 19:26:18', 1, 1),
(77, 'Dale', 'Partridge', '61 CLARK CRES', '', 'S9X1C3', 'MEADOWLAKE', 'SK', 'Canada', '306-240-0459', 'dale.p_1975@hotmail.com', '646200568', '1975-02-24', 'Single', 'Male', 2, 0, '515', 'Says he has no credit at this time.\r\nis working full time.', '', '0000-00-00', '2016-10-24 17:57:04', 1, 1),
(78, 'Wayne', 'Janvier', '', '', '', '', '', 'Canada', '306-304-2841', 'haroldwayne@hotmail.ca', '', '0000-00-00', '', '', 0, 0, '0', 'Phone number will be in service on this coming  Friday October 21,2016\r\nPlease contact by email to start file.\r\nLooking to obtain a Compact  SUV of some kind.\r\nWorking full time.', '', '0000-00-00', '2016-10-19 04:11:04', 1, 3),
(79, 'Rahama', 'Umar', '6141 172 STREET NW', '', 'T5T3R6', 'EDMONTON', 'AB', 'Canada', '587-710-3068', 'rahmaumar13@gmail.com', '', '1982-07-19', 'Widow/Widower', 'Female', 2, 0, '566', 'Currently has a 2016 Hyundai Elantra GT with about 6oookm Financed with TD $277.56 bi weekly\r\nwants something bigger like an SUV of some kind. Finds the Elantra is too small for the needs.\r\nLives in Edmonton.\r\n', '', '0000-00-00', '2016-10-25 02:57:20', 1, 1),
(80, 'Laporsha', 'Haggins', '', '', '', '', '', 'Canada', '7737038168', '', '', '0000-00-00', '', '', 0, 0, '0', 'lead from website. its Chicago number, but try to contact.', 'invalid contact #', '0000-00-00', '2016-10-24 15:29:22', 1, 0),
(81, 'Justine ', 'Layden ', '40 Churchill Place ', '', 'T4M 0B6', 'blackfalds ', 'Alberta ', 'Canada', '5874478870', 'layden_576@hotmail.com', '', '1996-01-02', 'Common Law', 'Female', 0, 9, '0', '', '', '0000-00-00', '2016-10-24 18:07:48', 0, 1),
(82, 'Sandy', 'Wedawin', '', '', '', '', '', 'Canada', '780-978-4572', 'sandywedawin@hotmail.com', '', '0000-00-00', '', '', 0, 0, '0', 'Currently has a Hyundai Accent to trade in and is looking for a 13/14/15 Explorer. \r\nLives in Grande Prairie Ab.\r\nHis little son has been battling cancer and Sandy has had to travel to Edmonton quite often.\r\nJust finished with Chemo. Has one more trip to make next month to have the IVAD removed from his son.\r\nHope you can help him out.\r\nHe has a sister that he may be able to ask to co-sign if absolutely required, but would obviously like to get financed on own if he can.\r\n\r\n', '', '0000-00-00', '2016-10-24 23:14:58', 1, 3),
(83, 'Gerald ', 'Page', '1306 Nanaimo Street', '', 'V2B 2W1', 'Kamloops', 'BC', 'Canada', '587-377-8695', 'jerrypagemusic@gmail.com', '123855181', '1971-09-05', 'Common Law', 'Male', 0, 6, '0', 'Gerald Sin # 123 855 181\r\nGerald works for Complete Flooring in Kamloops BC\r\nHe is in  common law relationship with Tammy Leanne\r\nHe is looking for a truck or extended van that he can use for work as well.', 'Need to get Birth Cert etc to open Bank account to show deposits going in. Call back in March 1st.', '2017-03-01', '2016-10-28 16:26:20', 1, 1),
(84, 'Robbie', 'Corfe', '10818 98th ', '', 'TOE0y0', 'Gande Cache ', 'AB', 'Canada', '7805010948', 'robbiecorfe@gmail.com', '', '1998-11-01', 'Common Law', 'Male', 8, 0, '0', '', '', '0000-00-00', '2016-10-28 03:45:45', 0, 1),
(85, 'Marshal', 'Fink', '221 Melvin Ave Apt 1605', '', 'L8H 2K1', 'Hamilton', 'ON', 'Canada', '2896899811', 'seagoer2005@gmail.com', '', '1962-03-27', 'Single', 'Male', 3, 6, '526', '', '', '0000-00-00', '2016-11-01 16:08:59', 0, 1),
(86, 'Chasity', 'Chamakese', 'BOX 457, #154 PELICAN LAKE', '', 'S0A1N0', 'LEOVILLE ', 'SK', 'Canada', '306-984-4485', 'chasitychamakese08@gmail.com', '671566347', '1993-08-06', 'Single', 'Female', 23, 0, 'no credit', 'Lives in Saskatchewan and is available after 3:30pm local time or on weekends.\r\nLooking for a car or SUV.', '', '0000-00-00', '2016-11-04 00:57:42', 1, 1),
(88, 'Marshal', 'Fink', '1605-221 Melvin Ave.', '', 'L8H 2K1', 'Hamilton', 'ON', 'Canada', '2896899811', 'seagoer2005@gmail.com', '', '1962-03-27', 'Single', 'Male', 3, 5, '0', '', '', '0000-00-00', '2016-10-30 15:27:23', 0, 1),
(89, 'Sheldon', 'Daigneault', 'Box 248', '', 'S0m1c0', 'Ile a la crosse', 'Saskatchewan ', 'Canada', '3068330131', 'sheldaig@gmail.com', '652787326', '1982-04-05', 'Single', 'Male', 34, 5, '444', '', '', '0000-00-00', '2016-11-05 22:13:04', 0, 1),
(90, 'Gerald', 'Deltress', '', '', '', '', '', 'Canada', '780-881-5529', 'gdeltress@gmail.com', '', '0000-00-00', '', '', 0, 0, '0', 'looking for a Jeep Cherokee or something like it.', 'Work is slow.   Call back in a few months when he had job tenure', '2017-04-04', '2016-11-08 03:22:11', 1, 0),
(92, 'Annie', 'Obrien', '51 CHURCH STREET', '', 'N3T3R2', 'BRANTFORD', 'ON', 'Canada', '226-583-5250', 'wolseanne@gmail.com', '493247795', '1972-12-20', 'Common Law', 'Female', 2, 0, '0', 'Says she has bad credit but would like to get to rebuilding it. Is working full time. Available anytime after 4 pm or weekends.', 'Call for  Hubby co-app info', '2017-03-01', '2016-12-15 17:27:14', 0, 1),
(93, 'Betty', 'Moar', '', '', '', '', '', 'Canada', '204 732 2171', 'betty.moar@wrcfs.org', '', '0000-00-00', '', '', 0, 0, '0', 'Has a 2015 Silverado and is wanting to trade it off for a smaller truck like Colorado or canyon.', '', '0000-00-00', '2016-12-13 17:45:32', 0, 3),
(94, 'Kurtis', 'Lavoie', '', '', '', '', '', 'Canada', '2048696326', 'reticlythons@gmail.com', '', '0000-00-00', '', '', 0, 0, '0', '', '', '0000-00-00', '2016-12-16 02:54:14', 0, 3),
(95, 'Carla', 'Duquette', '', '', '', '', '', 'Canada', '306-941-1781', 'carladuquette@hotmail.com', '', '0000-00-00', '', '', 0, 0, '0', 'I believe that Carla is a student, but I am not sure whether she is working, married or how she has an income.\r\nyou will need to contact her to find out. She is looking to get a car of some kind.', 'BOUGHT ELSEWHERE.  CALL BACK AND SEE IF SHE REEDS REFINANCING.  ', '2017-07-04', '2016-12-17 02:27:44', 1, 0),
(96, 'Muhammed Usman', 'Munir', '', '', '', '', '', 'Canada', '403-560-8726', 'tahirnadeem01@gmail.com', '', '0000-00-00', '', '', 0, 0, '0', 'Ling Haul Truck driver with HKM Transport $6000.00 monthly\r\nBorn April 01 1986\r\nMortgage of $1800.00 monthly', '', '0000-00-00', '2016-12-17 21:28:19', 1, 3),
(97, 'leland ', 'schneider', '', '', '', '', '', 'Canada', '7808712585', 'peemtout2dgg@hotmail.com', '', '0000-00-00', '', '', 0, 0, '0', '', '', '0000-00-00', '2016-12-26 19:49:17', 0, 3),
(98, 'vikram', 'shah', 'sdgsdg', '', 'sdgsdgsdg', 'sdgsdgsdg', 'sdgsdg', 'Canada', '36346346', 'vipvicks71@gmail.com', '', '1984-01-01', 'Single', 'Male', 4, 0, '0', '', 'fake test', '2017-08-25', '2017-01-13 19:24:40', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcountry`
--

CREATE TABLE `tblcountry` (
  `Id` int(10) UNSIGNED NOT NULL,
  `CountryName` varchar(100) NOT NULL DEFAULT '',
  `CountryCode` varchar(2) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbldealercredits`
--

CREATE TABLE `tbldealercredits` (
  `Id` int(11) NOT NULL,
  `DealerId` int(11) NOT NULL COMMENT 'tbldealership',
  `DealerPackageId` int(11) NOT NULL COMMENT 'tbldealerpackages',
  `Quantity` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `IsQuantityPositive` int(11) NOT NULL DEFAULT '1',
  `Timestamp` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbldealerpackagefeatures`
--

CREATE TABLE `tbldealerpackagefeatures` (
  `Id` int(11) NOT NULL,
  `DealerId` int(11) NOT NULL COMMENT 'tbldealership',
  `DealerPackageId` int(11) NOT NULL COMMENT 'tbldealerpackages',
  `ContactId` int(11) NOT NULL COMMENT 'tblcontact',
  `Timestamp` datetime NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbldealerpackagefeatures`
--

INSERT INTO `tbldealerpackagefeatures` (`Id`, `DealerId`, `DealerPackageId`, `ContactId`, `Timestamp`, `Status`) VALUES
(1, 1, 1, 1, '2016-05-05 17:01:24', 1),
(2, 1, 1, 2, '2016-05-05 17:01:37', 1),
(3, 1, 1, 3, '2016-05-05 17:01:43', 1),
(4, 1, 1, 5, '2016-05-16 20:35:11', 1),
(5, 1, 1, 6, '2016-05-20 22:42:09', 1),
(6, 1, 1, 9, '2016-06-23 19:41:28', 1),
(7, 1, 1, 8, '2016-06-23 19:41:35', 1),
(8, 1, 1, 7, '2016-06-23 19:41:40', 1),
(9, 1, 1, 11, '2016-06-24 17:45:25', 1),
(10, 1, 1, 10, '2016-06-24 17:45:30', 1),
(11, 1, 1, 21, '2016-10-14 21:35:37', 1),
(12, 1, 1, 22, '2016-10-14 21:41:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbldealerpackages`
--

CREATE TABLE `tbldealerpackages` (
  `Id` int(10) UNSIGNED NOT NULL,
  `AddDate` datetime NOT NULL,
  `ExpireDate` datetime NOT NULL,
  `PlanId` int(11) NOT NULL,
  `Term` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `DealerId` int(11) NOT NULL COMMENT 'fk_tbldealership',
  `Timestamp` datetime DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbldealerpackages`
--

INSERT INTO `tbldealerpackages` (`Id`, `AddDate`, `ExpireDate`, `PlanId`, `Term`, `DealerId`, `Timestamp`, `Status`) VALUES
(1, '2016-05-05 16:58:06', '2016-06-04 16:58:06', 5, 0, 1, '2016-05-05 16:58:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbldealership`
--

CREATE TABLE `tbldealership` (
  `Id` int(11) NOT NULL,
  `DealershipName` varchar(100) NOT NULL,
  `DealershipPlan` int(11) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Fax` varchar(100) DEFAULT NULL,
  `ContactName` varchar(100) NOT NULL,
  `LicenceNo` varchar(100) DEFAULT '0',
  `Remarks` text,
  `CreatedDate` datetime NOT NULL,
  `Approve` int(11) NOT NULL DEFAULT '2',
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbldealership`
--

INSERT INTO `tbldealership` (`Id`, `DealershipName`, `DealershipPlan`, `Address`, `Phone`, `Email`, `Fax`, `ContactName`, `LicenceNo`, `Remarks`, `CreatedDate`, `Approve`, `Status`) VALUES
(1, 'Simon Dream Team Auto', 5, '4404 - 66 Street, Edmonton AB T6K 4E7', '1.866.220.6166', 'simon@dreamteamauto.ca', '', 'Simon Ferguson', '0', '', '2016-05-05 16:44:36', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbldealstatus`
--

CREATE TABLE `tbldealstatus` (
  `Id` int(11) NOT NULL,
  `StatusText` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbldealstatus`
--

INSERT INTO `tbldealstatus` (`Id`, `StatusText`, `Status`) VALUES
(1, 'Application Received', 1),
(2, 'Processing Application', 1),
(3, 'Deal Completed', 1),
(4, 'Application Withdrawn', 1),
(5, 'Deal Not Completed', 1),
(6, 'Deal Booked', 1),
(7, 'Deal Funded', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblemployment`
--

CREATE TABLE `tblemployment` (
  `Id` int(11) NOT NULL,
  `EmpStatusId` int(11) NOT NULL COMMENT 'foreign key tblempstatus',
  `EmpTypeId` int(11) NOT NULL COMMENT 'foreign key tblemptype',
  `OrganizationName` text NOT NULL,
  `JobTitle` varchar(50) NOT NULL,
  `Address1` text NOT NULL,
  `Address2` text,
  `City` varchar(100) NOT NULL DEFAULT 'Edmonton',
  `Province` text NOT NULL,
  `Country` varchar(100) NOT NULL DEFAULT 'Canada',
  `Postal` text NOT NULL,
  `Phone1` text NOT NULL,
  `EmpYears` varchar(10) NOT NULL DEFAULT '0',
  `EmpMonths` varchar(10) NOT NULL DEFAULT '0',
  `GrossIncome` decimal(10,2) NOT NULL DEFAULT '0.00',
  `OtherIncome` decimal(10,2) NOT NULL DEFAULT '0.00',
  `FrequencyId` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key tblfrequency',
  `OtherIncomeTypeId` int(11) NOT NULL DEFAULT '0' COMMENT 'foreign key tblotherincometype',
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblemployment`
--

INSERT INTO `tblemployment` (`Id`, `EmpStatusId`, `EmpTypeId`, `OrganizationName`, `JobTitle`, `Address1`, `Address2`, `City`, `Province`, `Country`, `Postal`, `Phone1`, `EmpYears`, `EmpMonths`, `GrossIncome`, `OtherIncome`, `FrequencyId`, `OtherIncomeTypeId`, `Timestamp`, `Status`) VALUES
(1, 6, 3, 'Angies', 'Construction ', '', '', 'Prince albert', 'Sk', 'Canada', '', '3064001505', '3', '5', '1900.00', '0.00', 5, 9, '2016-03-25 05:45:07', 1),
(2, 6, 13, 'North West Regional College ', 'Student ', '', '', 'Big River', 'Saskatchewan  ', 'Canada', '', '', '3', '0', '0.00', '2100.00', 2, 5, '2016-04-12 22:39:19', 1),
(3, 1, 7, 'Bouchier Contracting', 'Operator Level 2', 'PO Box 6607 Stn Main', '', 'Ft. McMurray', 'AB', 'Canada', '', '17807901682', '1', '8', '6500.00', '0.00', 5, 9, '2016-04-29 05:40:49', 1),
(4, 1, 14, 'Fire Suppresioon Group', 'Fire Fight', 'Cole GD Cole Bay SK ', '', 'Cale Bay', 'SK', 'Canada', '', '306-829-4232', '0', '2', '2000.00', '0.00', 5, 9, '2016-05-16 20:30:43', 1),
(5, 1, 14, 'Fire Suppresioon Group', 'Fire Fight', 'Cole GD Cole Bay SK ', '', 'Cale Bay', 'SK', 'Canada', '', '306-829-4232', '0', '2', '2000.00', '0.00', 5, 9, '2016-05-16 20:32:06', 1),
(6, 1, 8, 'West Coast Fishclutu', 'Labourer', '1106 Morton Road', '', 'Powell River', 'British Columbia', 'Canada', '', '604487920', '5', '0', '2500.00', '0.00', 5, 9, '2016-05-20 22:41:31', 1),
(7, 1, 8, 'IPS', 'EMT', '1803 8th street', '', 'Nisku', 'AB', 'Canada', '', '7809559535', '1', '5', '3500.00', '0.00', 5, 9, '2016-06-21 00:24:35', 1),
(8, 1, 14, 'ftn contracting', 'shingler', '', '', 'edmonton', 'alberta', 'Canada', '', '5879750608', '5', '0', '5500.00', '0.00', 5, 9, '2016-06-23 15:44:35', 1),
(9, 1, 14, 'MR LUBE', 'TECH', '460 St. Albert Trail', '', 'St. Albert', 'AB', 'Canada', '', '7804607300', '2', '0', '2200.00', '0.00', 5, 9, '2016-06-23 19:01:10', 1),
(10, 1, 3, 'Canfor Forest Products', 'Labourer', 'Houston', '', 'Houston', 'BC', 'Canada', '', '250-845-5200', '6', '0', '5000.00', '0.00', 5, 9, '2016-06-24 17:23:14', 1),
(11, 1, 14, 'Alberta Honda', 'Driver', '9526 127 Avenue', '', 'Edmonton', 'AB', 'Canada', '', '7804748595', '0', '6', '2600.00', '0.00', 5, 9, '2016-04-29 17:40:09', 1),
(12, 3, 4, 'sdgsdg', 'sdgsdg', 'sdgsdgsdg', '', 'sdgsdg', 'sdgsdg', 'Canada', '', '54745754754754457', '0', '0', '99999999.99', '0.00', 5, 9, '2016-06-28 19:53:59', 1),
(13, 3, 4, 'fsdghsfhs', 'sdhsdhsdsh', '201C - 3624 119 Street NW', '', 'Edmonton', 'Canada', 'Canada', '', '7806602488', '0', '4', '75684.00', '0.00', 5, 9, '2016-07-12 17:48:18', 1),
(14, 6, 1, 'fsghsdh', '', '201C - 3624 119 Street NW', '', 'Edmonton', 'AB - Alberta', 'Canada', '', '7806602488', '3', '0', '457547.00', '0.00', 0, 0, '2016-07-12 17:48:51', 1),
(15, 1, 14, 'Strathcona county ', 'Certified technician ', '370 stream bank ave ', '', 'Sherwood park ', 'Alberta', 'Canada', '', '7804675869', '06', '07', '6750.00', '0.00', 5, 9, '2016-07-15 15:01:02', 1),
(16, 3, 12, 'sdgsdgsd', 'hjgjhfhjfjhf', 'kgkgkgkg', '', 'kjgkgkg', 'kjgkjg', 'Canada', '', '5785857858758', '7', '6', '86585.00', '0.00', 5, 9, '2016-07-15 17:58:32', 1),
(17, 5, 4, 'sdgsdgsd', 'hjgjhfhjfjhf', 'kgkgkgkg', '', 'kjgkgkg', 'kjgkjg', 'Canada', '', '3466346346', '0', '3', '86585.00', '0.00', 5, 9, '2016-07-15 18:35:04', 1),
(18, 1, 2, 'jhghjg', 'jhghjg', 'jhgjhgjhgjh', '', 'jhgjhg', 'jhgjhg', 'Canada', '', '578779897', '4', '2', '76786.00', '0.00', 5, 9, '2016-10-14 15:44:32', 1),
(19, 3, 3, 'jhghjg', 'jhghjg', 'jhgjhgjhgjh', '', 'jhgjhg', 'jhgjhg', 'Canada', '', '878979', '5', '5', '76786.00', '0.00', 5, 9, '2016-10-14 16:04:00', 1),
(20, 3, 3, 'jhghjg', 'jhghjg', 'jhgjhgjhgjh', '', 'jhgjhg', 'jhgjhg', 'Canada', '', '878979', '5', '5', '76786.00', '0.00', 5, 9, '2016-10-14 16:04:54', 1),
(21, 2, 2, 'jhghjg', 'jhghjg', 'jhgjhgjhgjh', '', 'jhgjhg', 'jhgjhg', 'Canada', '', '878979', '3', '3', '76786.00', '0.00', 5, 9, '2016-10-14 16:33:00', 1),
(22, 5, 9, ' ', ' ', '', '', 'MOBERLY LAKE', 'BC', 'Canada', '', '', '50', '0', '0.00', '0.00', 5, 9, '2016-10-14 21:35:07', 1),
(23, 1, 8, 'THOMAS CIRCLE OF CARE NETWORK', 'CARE WORKER', '', '', 'REGINA', 'SK', 'Canada', '', '', '2', '0', '0.00', '0.00', 5, 9, '2016-10-14 21:41:25', 1),
(24, 1, 3, 'DUCK MOUNTAIN LODGE', 'HOUSEKEEPING', '57 HIGHWAY', '', 'KAMSACK', 'SK', 'Canada', '', '(306)542-3466', '2', '0', '3400.00', '0.00', 5, 9, '2016-10-14 21:44:43', 1),
(25, 6, 3, 'S SCAN FARMS', 'FARM HAND', 'GD ', '', 'VAUXHALL', 'AB', 'Canada', '', '', '10', '1', '5000.00', '0.00', 5, 9, '2016-10-14 23:16:25', 1),
(26, 1, 14, 'COUNTY OF GRANDE PRAIRIE', 'EQUIPMENT OPERATOR', 'GRANDE PRAIRIE', '', 'GRANDE PRAIRIE', 'AB', 'Canada', '', '', '0', '2', '5000.00', '0.00', 1, 5, '2016-10-14 23:37:13', 1),
(27, 1, 14, 'PEACE RIVER HYDRO SITE C DAM', 'ROCK TRUCK DRIVER', '9948 100 AVE', '', 'FORT ST. JOHN', 'BC', 'Canada', '', '778-256-0337', '8', '1', '9000.00', '0.00', 5, 9, '2016-10-15 22:48:15', 1),
(28, 5, 8, 'CANADA PENSION', '', 'N/A', '', 'CHETWYND', 'BC', 'Canada', '', 'N/A', '4', '1', '1000.00', '0.00', 0, 0, '2016-10-15 22:53:06', 1),
(29, 1, 6, 'DISABILITY', 'DISABILITY', 'SAME', '', 'REGINA', 'SK', 'Canada', '', '', '5', '0', '1822.00', '0.00', 5, 9, '2016-10-16 00:17:34', 1),
(30, 1, 14, 'ERMINESKIN ASETS', 'DRIVER', '100 ERMINESKIN SUBDIVISION', '', 'MASKWACIS', 'ab', 'Canada', '', '780)585-0191', '0', '7', '2700.00', '0.00', 5, 9, '2016-10-17 15:32:37', 1),
(31, 1, 14, 'AARONS SALES AND LEASE', 'ACCOUNTS MNGR', '2305 22 STREET', '', 'SASKATOON', 'sk', 'Canada', '', '306)668-0100', '3', '0', '3000.00', '0.00', 5, 9, '2016-10-17 15:37:02', 1),
(32, 5, 9, 'retired', 'retired', '', '', 'COLD LAKE', 'AB', 'Canada', '', '', '3', '0', '0.00', '0.00', 5, 9, '2016-10-17 15:42:02', 1),
(33, 1, 14, 'VIRTUS', 'VAC TRUCK DRIVER', '16102 102 St #102, Grande Prairie, AB T8X 0K7', '', 'Grande Prairie', 'AB', 'Canada', '', '1 844-259-2168', '0', '3', '6500.00', '0.00', 5, 9, '2016-10-18 15:32:57', 1),
(34, 1, 1, 'PUGUIS CHILD FOSTER SERVICES', 'FOSTER PARENT', 'SAME', '', 'R0C', 'MB', 'Canada', '', '', '15', '0', '4800.00', '0.00', 5, 9, '2016-10-19 19:26:18', 1),
(35, 1, 8, 'GUARDAWORLD', 'SECURITY OFFICER', 'MEADOWLAKE SK', '', 'MEADOWLAKE', 'SK', 'Canada', '', '', '1', '0', '2600.00', '0.00', 5, 9, '2016-10-24 17:57:04', 1),
(36, 1, 8, 'ALBERTA HEALTH SERVICE', 'NURSING ASSISTANT ', '', '', 'EDMONTON', 'AB', 'Canada', '', '780-436-8484', '2', '0', '3500.00', '0.00', 5, 9, '2016-10-25 02:57:20', 1),
(37, 1, 14, 'COMPLETE FLOORING SOLUTIONS', 'INSTALLER', '427 MOUNT PAUL WAY', '', 'KAMLOOPS', 'BC', 'Canada', '', '250-828-2666', '0', '5', '4000.00', '0.00', 5, 9, '2016-10-28 16:26:20', 1),
(38, 3, 14, 'ATTRIDGE BUS LINES', 'DRIVER', '', '', 'HAMILTON', 'ON', 'Canada', '', '', '0', '4', '1200.00', '1200.00', 2, 3, '2016-11-01 16:08:59', 1),
(39, 1, 13, 'STUDENT', 'STUDENT', 'SASK', '', 'SASK', 'SK', 'Canada', '', '', '1', '1', '2012.00', '1516.00', 2, 2, '2016-11-04 00:57:42', 1),
(40, 7, 3, 'Ile a la crosse fish company', 'Fish scaler', '194', '', 'Ile a la crosse', 'Saskatchewan ', 'Canada', '', '3068332011', '2', '0', '2800.00', '0.00', 3, 9, '2016-11-05 22:13:03', 1),
(41, 7, 3, 'Ile a la crosse fish company', 'Fish scaler', '194', '', 'Ile a la crosse', 'Saskatchewan ', 'Canada', '', '3068332011', '2', '0', '2800.00', '0.00', 3, 9, '2016-11-05 22:13:04', 1),
(42, 1, 14, 'NORMERICA', 'MACHINE OPERATOR', '1599 Hurontario St', '', 'MISSISSAUGA', 'ON', 'Canada', '', '877-646-8621', '0', '1', '3000.00', '313.00', 4, 5, '2016-12-15 17:27:14', 1),
(43, 1, 3, 'xdgsdfhg', 'dfhdfhdfh', '', '', 'sdgsdg', 'afsadf', 'Canada', '', '', '4', '0', '346346.00', '0.00', 5, 9, '2017-01-13 19:24:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblempstatus`
--

CREATE TABLE `tblempstatus` (
  `Id` int(11) NOT NULL,
  `StatusText` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblempstatus`
--

INSERT INTO `tblempstatus` (`Id`, `StatusText`, `Status`) VALUES
(1, 'Full time', 1),
(2, 'Full Time (Probation)', 1),
(3, 'Part Time (Casual)', 1),
(4, 'Part Time (Regular)', 1),
(5, 'Retired', 1),
(6, 'Seasonal Summer', 1),
(7, 'Seasonal Winter', 1),
(8, 'Self Employed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblemptype`
--

CREATE TABLE `tblemptype` (
  `Id` int(11) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblemptype`
--

INSERT INTO `tblemptype` (`Id`, `Type`, `Status`) VALUES
(1, 'At home', 1),
(2, 'Executive', 1),
(3, 'Labourer', 1),
(4, 'Management', 1),
(5, 'Office Staff', 1),
(6, 'Other', 1),
(7, 'Production', 1),
(8, 'Professional', 1),
(9, 'Retired', 1),
(10, 'Sales', 1),
(11, 'Self-Employed', 1),
(12, 'Service', 1),
(13, 'Student', 1),
(14, 'Trades', 1),
(15, 'Unemployed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfile`
--

CREATE TABLE `tblfile` (
  `Id` int(10) UNSIGNED NOT NULL,
  `FileName` text NOT NULL,
  `FileDescription` text NOT NULL,
  `FileSize` mediumint(9) NOT NULL DEFAULT '0',
  `FileMIME` text NOT NULL,
  `FileLocation` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `FileVersion` int(11) UNSIGNED DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DownloadCount` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfile`
--

INSERT INTO `tblfile` (`Id`, `FileName`, `FileDescription`, `FileSize`, `FileMIME`, `FileLocation`, `Status`, `FileVersion`, `Timestamp`, `DownloadCount`) VALUES
(1, '20160323200438.jpg', '', 752707, 'image/jpeg', '20160323200438.jpg', 1, 1, '2016-03-23 20:04:38', 0),
(2, 'Credit Report', '', 672145, 'application/pdf', '20160503232725.PDF', 1, 1, '2016-05-03 23:27:25', 0),
(3, 'Credit Report', '', 786555, 'application/pdf', '20160503233811.PDF', 1, 1, '2016-05-03 23:38:11', 0),
(4, 'Credit Report', '', 537640, 'application/pdf', '20160623202623.PDF', 1, 1, '2016-06-23 20:26:23', 0),
(5, 'Credit Report', '', 194204, 'application/pdf', '20161014213617.pdf', 1, 1, '2016-10-14 21:36:17', 0),
(6, 'Credit Report', '', 192093, 'application/pdf', '20161014214532.pdf', 1, 1, '2016-10-14 21:45:32', 0),
(7, 'Credit Report', '', 194340, 'application/pdf', '20161017154430.pdf', 1, 1, '2016-10-17 15:44:30', 0),
(8, 'Credit Report', '', 198524, 'application/pdf', '20161017154543.pdf', 1, 1, '2016-10-17 15:45:43', 0),
(9, 'Credit Report', '', 345117, 'application/pdf', '20161025153043.pdf', 1, 1, '2016-10-25 15:30:43', 0),
(10, 'Credit Report', '', 344509, 'application/pdf', '20161028152421.pdf', 1, 1, '2016-10-28 15:24:21', 0),
(11, 'Credit Report', '', 339229, 'application/pdf', '20161028164819.pdf', 1, 1, '2016-10-28 16:48:19', 0),
(12, 'Credit Report', '', 347348, 'application/pdf', '20161101162814.pdf', 1, 1, '2016-11-01 16:28:14', 0),
(13, 'Credit Report', '', 284333, 'application/pdf', '20161104153636.pdf', 1, 1, '2016-11-04 15:36:36', 0),
(14, 'Credit Report', '', 350627, 'application/pdf', '20161215173340.pdf', 1, 1, '2016-12-15 17:33:40', 0),
(15, 'Credit Report', '', 1028643, 'application/pdf', '20161216170145.PDF', 1, 1, '2016-12-16 17:01:45', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblfilerelations`
--

CREATE TABLE `tblfilerelations` (
  `Id` int(11) UNSIGNED NOT NULL,
  `FileId` int(10) UNSIGNED NOT NULL,
  `ContactId` int(11) UNSIGNED DEFAULT NULL,
  `AffiliateId` int(11) DEFAULT NULL,
  `DealId` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfilerelations`
--

INSERT INTO `tblfilerelations` (`Id`, `FileId`, `ContactId`, `AffiliateId`, `DealId`, `Status`) VALUES
(1, 1, NULL, 6, NULL, 1),
(2, 2, 2, NULL, NULL, 1),
(3, 3, 3, NULL, NULL, 1),
(4, 4, 9, NULL, NULL, 1),
(5, 5, 21, NULL, NULL, 1),
(6, 6, 23, NULL, NULL, 1),
(7, 7, 29, NULL, NULL, 1),
(8, 8, 28, NULL, NULL, 1),
(9, 9, 34, NULL, NULL, 1),
(10, 10, 30, NULL, NULL, 1),
(11, 11, 35, NULL, NULL, 1),
(12, 12, 36, NULL, NULL, 1),
(13, 13, 37, NULL, NULL, 1),
(14, 14, 40, NULL, NULL, 1),
(15, 15, 25, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfrequency`
--

CREATE TABLE `tblfrequency` (
  `Id` int(11) NOT NULL,
  `Frequency` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblfrequency`
--

INSERT INTO `tblfrequency` (`Id`, `Frequency`, `Status`) VALUES
(1, 'Yearly', 1),
(2, 'Monthly', 1),
(3, 'Bi-Weekly', 1),
(4, 'Weekly', 1),
(5, 'None', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblmail`
--

CREATE TABLE `tblmail` (
  `Id` int(11) NOT NULL,
  `ContactInfoId` int(11) NOT NULL COMMENT 'tblcontactinfo',
  `TemplateId` int(11) NOT NULL COMMENT 'tbltemplate',
  `DateSent` datetime NOT NULL COMMENT 'date and time the email is sent',
  `Status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmail`
--

INSERT INTO `tblmail` (`Id`, `ContactInfoId`, `TemplateId`, `DateSent`, `Status`) VALUES
(1, 5, 1, '2016-05-02 15:25:22', 1),
(2, 9, 1, '2016-05-02 15:25:22', 1),
(3, 11, 1, '2016-05-02 15:25:22', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblmortgage`
--

CREATE TABLE `tblmortgage` (
  `Id` int(11) NOT NULL,
  `MortgageType` varchar(100) NOT NULL,
  `MortgagePayment` decimal(10,2) NOT NULL,
  `MortgageAmount` decimal(10,2) NOT NULL,
  `MortgageHolder` varchar(100) NOT NULL,
  `MarketValue` decimal(10,2) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblmortgage`
--

INSERT INTO `tblmortgage` (`Id`, `MortgageType`, `MortgagePayment`, `MortgageAmount`, `MortgageHolder`, `MarketValue`, `Timestamp`, `Status`) VALUES
(1, 'Rent', '1200.00', '0.00', '', '0.00', '2016-03-11 18:54:20', 1),
(2, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-03-11 21:16:36', 1),
(3, 'Rent', '450.00', '0.00', '', '0.00', '2016-03-25 05:45:07', 1),
(4, 'Rent', '538.00', '0.00', '', '0.00', '2016-04-12 22:39:19', 1),
(5, 'Reserve Housing', '0.00', '0.00', '', '0.00', '2016-04-29 05:40:49', 1),
(6, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-05-16 20:30:43', 1),
(7, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-05-16 20:32:06', 1),
(8, 'Rent', '300.00', '0.00', '', '0.00', '2016-05-20 22:41:31', 1),
(9, 'Rent', '500.00', '0.00', '', '0.00', '2016-05-24 14:36:53', 1),
(10, 'Rent', '1049.00', '0.00', '', '0.00', '2016-06-16 00:56:35', 1),
(11, 'Rent', '725.00', '0.00', '', '0.00', '2016-06-21 00:24:35', 1),
(12, 'Rent', '550.00', '0.00', '', '0.00', '2016-06-23 15:44:35', 1),
(13, 'With Parents', '0.00', '0.00', '', '0.00', '2016-06-23 19:01:10', 1),
(14, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-06-24 17:23:14', 1),
(15, 'Rent', '350.00', '0.00', '', '0.00', '2016-06-24 17:44:57', 1),
(16, 'Rent', '800.00', '0.00', '', '0.00', '2016-06-26 16:55:07', 1),
(17, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-06-28 19:53:59', 1),
(18, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-07-12 17:48:18', 1),
(19, 'Own with Mortgage', '1800.00', '353000.00', 'Genworth ', '430000.00', '2016-07-15 15:01:02', 1),
(20, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-07-15 17:58:32', 1),
(21, 'Own Free Clear', '0.00', '0.00', '', '0.00', '2016-07-15 18:35:04', 1),
(29, 'Own Free Clear', '0.00', '0.00', '', '200000.00', '2016-10-14 23:16:25', 1),
(28, 'Own Free Clear', '0.00', '0.00', '', '15000.00', '2016-10-14 21:44:43', 1),
(27, 'Rent', '0.00', '0.00', '', '0.00', '2016-10-14 21:41:25', 1),
(26, 'Own Free Clear', '0.00', '0.00', '', '250000.00', '2016-10-14 21:35:07', 1),
(30, 'With Parents', '0.00', '0.00', '', '0.00', '2016-10-14 23:34:01', 1),
(31, 'With Parents', '0.00', '0.00', '', '0.00', '2016-10-14 23:34:25', 1),
(32, 'With Parents', '0.00', '0.00', '', '0.00', '2016-10-14 23:34:54', 1),
(33, 'With Parents', '0.00', '0.00', '', '0.00', '2016-10-14 23:35:37', 1),
(34, 'Rent', '0.00', '0.00', '', '0.00', '2016-10-14 23:36:15', 1),
(35, 'Rent', '0.00', '0.00', '', '0.00', '2016-10-14 23:37:13', 1),
(36, 'Rent', '500.00', '0.00', '', '0.00', '2016-10-15 22:48:15', 1),
(37, 'Rent', '900.00', '0.00', '', '0.00', '2016-10-16 00:17:34', 1),
(38, 'Own Free Clear', '0.00', '0.00', '', '200000.00', '2016-10-17 15:32:37', 1),
(39, 'Rent', '450.00', '0.00', '', '0.00', '2016-10-17 15:37:02', 1),
(40, 'Reserve Housing', '0.00', '0.00', '', '0.00', '2016-10-17 15:42:02', 1),
(41, 'Own with Mortgage', '1700.00', '325000.00', 'mcap', '400000.00', '2016-10-18 15:32:57', 1),
(42, 'Own Free Clear', '0.00', '0.00', '', '200000.00', '2016-10-19 19:26:18', 1),
(43, 'Own Free Clear', '0.00', '0.00', '', '45000.00', '2016-10-24 17:57:04', 1),
(44, 'Rent', '1299.00', '0.00', '', '0.00', '2016-10-25 02:57:20', 1),
(45, 'Rent', '600.00', '0.00', '', '0.00', '2016-10-28 16:26:20', 1),
(46, 'Rent', '350.00', '0.00', '', '0.00', '2016-11-01 16:08:59', 1),
(47, 'Own Free Clear', '0.00', '0.00', '', '150000.00', '2016-11-04 00:57:42', 1),
(48, 'With Parents', '100.00', '0.00', '', '0.00', '2016-11-05 22:13:03', 1),
(49, 'With Parents', '100.00', '0.00', '', '0.00', '2016-11-05 22:13:04', 1),
(50, 'Rent', '500.00', '0.00', '', '0.00', '2016-12-15 17:27:14', 1),
(51, 'Rent', '500.00', '0.00', '', '0.00', '2017-01-13 19:24:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblnotes`
--

CREATE TABLE `tblnotes` (
  `Id` int(11) NOT NULL,
  `Notes` text NOT NULL,
  `DatePosted` datetime NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblnotes`
--

INSERT INTO `tblnotes` (`Id`, `Notes`, `DatePosted`, `Status`) VALUES
(1, ' Says he has no credit at this time. is working full time. ', '2016-10-28 16:04:51', 1),
(2, 'Tammy his gf, supposed to send in paystub and a LOE. Might consider a minivan as well', '2016-10-28 16:30:23', 1),
(3, '2002 envoy 250 k 44 month lease $320.97 pmt', '2016-11-01 16:57:02', 1),
(4, 'Credit Score: 526', '2016-11-02 19:49:56', 1),
(5, 'Asked her to send me 3 months Bank Statements', '2016-11-04 01:00:11', 1),
(6, 'waiting to hear form current car lender to see if they will let him return envoy', '2016-11-04 01:01:51', 1),
(7, 'Docs sent via email.  Awaiting signatures.  $200 deposit so far. will need another $1300', '2016-11-04 01:03:05', 1),
(8, 'Deal Not Completed', '2016-11-07 17:01:14', 1),
(9, 'Called and Spoke with Tammy.  Said she will call back when she has better reception.', '2016-11-08 16:26:40', 1),
(10, 'This is te\'st', '2016-11-08 16:52:03', 1),
(11, 'Will call back when he starts job. Seasonal.', '2016-11-08 20:02:38', 1),
(12, 'Called and left message with some guy.  She wasnt home form school yet', '2016-11-09 22:05:55', 1),
(13, 'Need to get Birth Cert etc to open Bank account to show deposits going in.  Call back in March 1st.', '2016-12-14 20:34:58', 1),
(14, 'Called.  Some guy answered. she wasn\'t home', '2016-12-14 20:50:28', 1),
(15, 'Awaiting T1 General on Income change. ', '2016-12-14 21:01:30', 1),
(16, 'Struggling with current TD Car Payment . Multiple lates.  DNP.', '2016-12-14 21:06:23', 1),
(17, 'Need to call her today. Date: Dec. 15, 2016', '2016-12-15 16:50:54', 1),
(18, 'Deal Booked and Funded', '2016-12-15 16:52:21', 1),
(19, 'left message with her step-dad for her to call back.', '2016-12-15 21:30:12', 1),
(20, 'Will ask her common law to cosign.', '2016-12-16 16:12:15', 1),
(21, 'Called and he was at Doctors office. wasnt able to find a cosignor yet. said he\'d call back after.', '2016-12-16 16:42:09', 1),
(22, 'Call her back on Sunday Dec 18th at 4pm. Will ask her husband to cosign by then.', '2016-12-17 21:31:40', 1),
(23, 'He wasn\'t willing to cosign till Feb/March 2017.  Call back March 1, 2017', '2016-12-18 23:41:00', 1),
(24, 'Call for  Hubby co-app info', '2016-12-19 22:18:38', 1),
(25, 'Need to get Birth Cert etc to open Bank account to show deposits going in. Call back in March 1st.', '2016-12-20 18:02:26', 1),
(26, '	Awaiting T1 General or Income change.', '2016-12-20 18:04:24', 1),
(27, 'DNP. Too Heavy in  Trade.  Poor Auto Repayment History.', '2016-12-20 18:18:34', 1),
(28, 'fake test', '2017-01-13 19:25:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblnotesrelation`
--

CREATE TABLE `tblnotesrelation` (
  `Id` int(11) NOT NULL,
  `NotesId` int(11) NOT NULL,
  `ContactId` int(11) DEFAULT NULL,
  `ContactInfoId` int(11) DEFAULT NULL,
  `AffiliateId` int(11) DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblnotesrelation`
--

INSERT INTO `tblnotesrelation` (`Id`, `NotesId`, `ContactId`, `ContactInfoId`, `AffiliateId`, `Status`) VALUES
(1, 1, 33, NULL, NULL, 1),
(2, 2, 35, NULL, NULL, 1),
(3, 3, 36, NULL, NULL, 1),
(4, 4, 36, NULL, NULL, 1),
(5, 5, 37, NULL, NULL, 1),
(6, 6, 36, NULL, NULL, 1),
(7, 7, 33, NULL, NULL, 1),
(8, 8, 1, NULL, NULL, 1),
(9, 9, 35, NULL, NULL, 1),
(10, 10, 38, NULL, NULL, 1),
(11, 11, 38, NULL, NULL, 1),
(12, 12, 37, NULL, NULL, 1),
(13, 13, 35, NULL, NULL, 1),
(14, 14, 37, NULL, NULL, 1),
(15, 15, 30, NULL, NULL, 1),
(16, 16, 28, NULL, NULL, 1),
(17, 17, NULL, 92, NULL, 1),
(18, 18, 33, NULL, NULL, 1),
(19, 19, 2, NULL, NULL, 1),
(20, 20, 40, NULL, NULL, 1),
(21, 21, 29, NULL, NULL, 1),
(22, 22, 40, NULL, NULL, 1),
(23, 23, 40, NULL, NULL, 1),
(24, 24, 40, NULL, NULL, 1),
(25, 25, 35, NULL, NULL, 1),
(26, 26, 30, NULL, NULL, 1),
(27, 27, 26, NULL, NULL, 1),
(28, 28, 41, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblotherincometype`
--

CREATE TABLE `tblotherincometype` (
  `Id` int(11) NOT NULL,
  `IncomeType` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblotherincometype`
--

INSERT INTO `tblotherincometype` (`Id`, `IncomeType`, `Status`) VALUES
(1, 'Car Allowance', 1),
(2, 'Child Support/Alimony', 1),
(3, 'Disability Payments', 1),
(4, 'Investment Income', 1),
(5, 'Other', 1),
(6, 'Pensions', 1),
(7, 'Rental Income', 1),
(8, 'Workers Compensation', 1),
(9, 'None', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblpackage`
--

CREATE TABLE `tblpackage` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Description` text NOT NULL,
  `Price` decimal(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `Apps` int(11) NOT NULL DEFAULT '0',
  `RecurringId` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `Rank` int(11) NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpackage`
--

INSERT INTO `tblpackage` (`Id`, `Name`, `Description`, `Price`, `Apps`, `RecurringId`, `Rank`, `Status`) VALUES
(1, 'Trial', 'This is just a trial plan', '5.95', 5, 5, 1, 1),
(2, 'Bronze', 'Bronze plan', '9.95', 10, 2, 2, 1),
(3, 'Silver', 'Silver Plan', '15.95', 15, 2, 3, 1),
(4, 'Gold', 'Gold Plan', '19.95', 19, 2, 4, 1),
(5, 'Platinum', 'Platinum Plan', '25.95', 25, 2, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblpreviousemployment`
--

CREATE TABLE `tblpreviousemployment` (
  `Id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `PrevEmpYears` varchar(10) NOT NULL,
  `PrevEmpMonths` varchar(10) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblpreviousemployment`
--

INSERT INTO `tblpreviousemployment` (`Id`, `Name`, `PrevEmpYears`, `PrevEmpMonths`, `Timestamp`, `Status`) VALUES
(1, '', '', '', '2016-04-29 05:40:49', 1),
(2, 'N/A', '0', '0', '2016-05-16 20:30:43', 1),
(3, 'N/A', '0', '0', '2016-05-16 20:32:06', 1),
(4, '', '', '', '2016-06-21 00:24:35', 1),
(5, 'Western Drug Distribution Center', '1', '0', '2016-06-24 17:44:57', 1),
(6, 'dfhdfhdfh', '4', '4', '2016-06-28 19:53:59', 1),
(7, 'dfhfdh', '4', '3', '2016-07-12 17:48:18', 1),
(8, ',bkjgkgkgkjgkj', '4', '4', '2016-07-15 18:35:04', 1),
(9, 'COUNTY OF DRUMHELLER', '7', '1', '2016-10-14 23:37:13', 1),
(10, ' ', '0', '0', '2016-10-17 15:32:37', 1),
(11, ' ', '0', '0', '2016-10-18 15:32:57', 1),
(12, '', '0', '0', '2016-10-24 17:57:04', 1),
(13, 'HARMONY FLOORING RED DEER ', '3', '0', '2016-10-28 16:26:20', 1),
(14, 'SHARP BUS LINE', '1', '0', '2016-11-01 16:08:59', 1),
(15, '', '0', '0', '2016-11-04 00:57:42', 1),
(16, 'MASSILLY ', '2', '1', '2016-12-15 17:27:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblrecurring`
--

CREATE TABLE `tblrecurring` (
  `Id` int(10) UNSIGNED NOT NULL,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Status` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblrecurring`
--

INSERT INTO `tblrecurring` (`Id`, `Name`, `Status`) VALUES
(1, 'Yearly', 1),
(2, 'Monthly', 1),
(3, 'Weekly', 1),
(4, 'Daily', 1),
(5, 'Indefinitely', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblsubscribers`
--

CREATE TABLE `tblsubscribers` (
  `id` tinyint(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `status` tinyint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblsubscribers`
--

INSERT INTO `tblsubscribers` (`id`, `name`, `email`, `status`) VALUES
(1, 'Vikram Shah', 'shahvikram24@gmail.com', 1),
(2, 'PAMELA DEADMAN', 'misspamelarobinson@gmail.com', 1),
(3, 'Desiree Downey', 'd.desiree11@hotmail.com', 1),
(4, 'Daine Jennings', 'dainedj@yahoo.com', 1),
(5, 'Simon Ferguson', 'simonsaysapproved@gmail.com', 1),
(6, 'April Roberts', 'aprylroberts@outlook.com', 1),
(7, 'Raylene Degenhardt', 'rayleneliesl@hotmail.com', 1),
(8, 'Hyde Spence', 'bruckupspence@gmail.com', 1),
(9, 'Donovan Waterhen', 'donz101@hotmail.com', 1),
(10, 'Bryant lawrence', 'bryant.lawrence21@gmail.com', 1),
(11, 'SAHARLA ADEN', 'sah.aden@gmail.com', 1),
(12, 'Tyree Malcolm', 'runninback33@hotmail.com', 1),
(14, 'Russ Zaltsmenov', 'buzzzzrus@gmail.com', 1),
(15, 'Samuel Staffe', 'bodyguard@live.ca', 1),
(16, 'Colin Snowball', 'csnowball@gmail.com', 1),
(17, 'Cornelia Cousins', 'cornelia_cousins@yahoo.ca', 1),
(18, 'Kevon Wallace', 'kevonwallace@gmail.com', 1),
(19, 'Bradly Wack', 'bradly_wack@hotmail.com', 1),
(20, 'Darren  Swerda', 'Dss539@ymail.com', 1),
(21, 'Devon Williams', 'devon@dreamteamauto.ca', 1),
(22, 'Nhat Nguyen', 'nnguyen1976@yahoo.ca', 1),
(23, 'Christina McDougall', 'chris1503jade@gmail.com', 1),
(24, 'Christina McDougall', 'chris1503jade@gmail.com', 1),
(25, 'Leste George', 'sagaboy71@gmail.com', 1),
(26, 'OMAR SALAH', 'ewavegroupinc@gmail.com', 1),
(27, 'Dennis Davison', 'ddavison@telus.net', 1),
(28, 'Floyd Patrick', 'floyd_patrick2000@yahoo.ca', 1),
(29, 'Darren Swerda', 'Dss539@ymail.com', 1),
(30, 'Darren Swerda', 'Dss539@ymail.com', 1),
(31, 'Simon Ferguson', 'simonsaysapproved@gmail.com', 1),
(32, 'SIMON FERGUSON', 'internetceo@hotmail.com', 1),
(33, 'Bryant Lawrence', 'bryant.lawrence21@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbltemplate`
--

CREATE TABLE `tbltemplate` (
  `Id` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Filename` text NOT NULL,
  `Type` int(11) NOT NULL,
  `Color` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbltemplate`
--

INSERT INTO `tbltemplate` (`Id`, `Title`, `Filename`, `Type`, `Color`, `Status`) VALUES
(1, 'INCOMPLETE CREDIT APP -1', 'contact.html', 2, '#FF3636', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zone`
--

CREATE TABLE `zone` (
  `zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `affiliate`
--
ALTER TABLE `affiliate`
  ADD PRIMARY KEY (`affiliate_id`);

--
-- Indexes for table `affiliatetransaction`
--
ALTER TABLE `affiliatetransaction`
  ADD PRIMARY KEY (`affiliatetransactionid`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `superaffiliate`
--
ALTER TABLE `superaffiliate`
  ADD PRIMARY KEY (`superaffiliate_id`);

--
-- Indexes for table `superaffiliatetransaction`
--
ALTER TABLE `superaffiliatetransaction`
  ADD PRIMARY KEY (`superaffiliatetransactionid`);

--
-- Indexes for table `tblcoapplicant`
--
ALTER TABLE `tblcoapplicant`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ContactInfoId` (`ContactInfoId`),
  ADD KEY `EmploymentId` (`EmploymentId`),
  ADD KEY `PreviousEmploymentId` (`PreviousEmpId`),
  ADD KEY `RelationContactId` (`RelationContactId`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ContactInfoId` (`ContactInfoId`),
  ADD KEY `MortgageId` (`MortgageId`),
  ADD KEY `EmploymentId` (`EmploymentId`),
  ADD KEY `PreviousEmpId` (`PreviousEmpId`);

--
-- Indexes for table `tblcontactinfo`
--
ALTER TABLE `tblcontactinfo`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IX_tblcontactinfo_CountryId` (`Country`);

--
-- Indexes for table `tblcountry`
--
ALTER TABLE `tblcountry`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbldealercredits`
--
ALTER TABLE `tbldealercredits`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbldealerpackagefeatures`
--
ALTER TABLE `tbldealerpackagefeatures`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbldealerpackages`
--
ALTER TABLE `tbldealerpackages`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbldealership`
--
ALTER TABLE `tbldealership`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbldealstatus`
--
ALTER TABLE `tbldealstatus`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblemployment`
--
ALTER TABLE `tblemployment`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `EmpStatusId` (`EmpStatusId`),
  ADD KEY `EmpTypeId` (`EmpTypeId`),
  ADD KEY `FrequencyId` (`FrequencyId`),
  ADD KEY `OtherIncomeTypeId` (`OtherIncomeTypeId`);

--
-- Indexes for table `tblempstatus`
--
ALTER TABLE `tblempstatus`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblemptype`
--
ALTER TABLE `tblemptype`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblfile`
--
ALTER TABLE `tblfile`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblfilerelations`
--
ALTER TABLE `tblfilerelations`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_tblfilerelations_fileid_tblfile_id` (`FileId`);

--
-- Indexes for table `tblfrequency`
--
ALTER TABLE `tblfrequency`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblmail`
--
ALTER TABLE `tblmail`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblmortgage`
--
ALTER TABLE `tblmortgage`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblnotes`
--
ALTER TABLE `tblnotes`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblnotesrelation`
--
ALTER TABLE `tblnotesrelation`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblotherincometype`
--
ALTER TABLE `tblotherincometype`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblpackage`
--
ALTER TABLE `tblpackage`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_tblpackage_recurringid_tblrecurring_id` (`RecurringId`);

--
-- Indexes for table `tblpreviousemployment`
--
ALTER TABLE `tblpreviousemployment`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblrecurring`
--
ALTER TABLE `tblrecurring`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbltemplate`
--
ALTER TABLE `tbltemplate`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`zone_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `affiliate`
--
ALTER TABLE `affiliate`
  MODIFY `affiliate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `affiliatetransaction`
--
ALTER TABLE `affiliatetransaction`
  MODIFY `affiliatetransactionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `superaffiliate`
--
ALTER TABLE `superaffiliate`
  MODIFY `superaffiliate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `superaffiliatetransaction`
--
ALTER TABLE `superaffiliatetransaction`
  MODIFY `superaffiliatetransactionid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblcoapplicant`
--
ALTER TABLE `tblcoapplicant`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `tblcontactinfo`
--
ALTER TABLE `tblcontactinfo`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `tblcountry`
--
ALTER TABLE `tblcountry`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbldealercredits`
--
ALTER TABLE `tbldealercredits`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbldealerpackagefeatures`
--
ALTER TABLE `tbldealerpackagefeatures`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tbldealerpackages`
--
ALTER TABLE `tbldealerpackages`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbldealership`
--
ALTER TABLE `tbldealership`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbldealstatus`
--
ALTER TABLE `tbldealstatus`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tblemployment`
--
ALTER TABLE `tblemployment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `tblempstatus`
--
ALTER TABLE `tblempstatus`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tblemptype`
--
ALTER TABLE `tblemptype`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tblfile`
--
ALTER TABLE `tblfile`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tblfilerelations`
--
ALTER TABLE `tblfilerelations`
  MODIFY `Id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tblfrequency`
--
ALTER TABLE `tblfrequency`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tblmail`
--
ALTER TABLE `tblmail`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblmortgage`
--
ALTER TABLE `tblmortgage`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `tblnotes`
--
ALTER TABLE `tblnotes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tblnotesrelation`
--
ALTER TABLE `tblnotesrelation`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `tblotherincometype`
--
ALTER TABLE `tblotherincometype`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tblpackage`
--
ALTER TABLE `tblpackage`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tblpreviousemployment`
--
ALTER TABLE `tblpreviousemployment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tblrecurring`
--
ALTER TABLE `tblrecurring`
  MODIFY `Id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tblsubscribers`
--
ALTER TABLE `tblsubscribers`
  MODIFY `id` tinyint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `zone`
--
ALTER TABLE `zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
