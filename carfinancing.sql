-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 14, 2017 at 08:02 PM
-- Server version: 5.7.17-log
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carfinancing`
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
(1, 'Vikram', 'shahvikram24@gmail.com', 'e7f937da3989c33d0a31eb9eca14d66f', '67e600c7c6deadb91094d2a3c3c80368077739ac', 1);

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
(1, 'Vikram', 'Shah', 'shahvikram24@gmail.com', '7809200324', '7809200324', '14438578653b8fc50d869a72ff3cae4a', '102dd38d7a9df30c645432debcad0ee32621a624', 'vstudiozzz', 'vstudiozzz.com', '3624 119 Street NW', '201C', 'EDMONTON', 'T6J 2X6', 43, 2, '527f4abd08412', '5.00', '546545454', 'cheque', 'Hirva Shah', 'shahvikram24@gmail.com', 'TD Canda Trust', '1709', '004', 'Vikram Shah', '34534543', '127.0.0.1', 1, 1, '2013-11-10 02:24:25'),
(2, 'Hirva', 'Shah', 'ahah@gmail.com', '(782) 025-4545', '', '20e5134043ec1e77c4f8649077801946', 'b2eb969f505a129397ba48a9d17dab9f513c8a54', 'nsmgjkdghsjkd', '', 'gghf hfghfghf', 'SK', 'sdgdfgd', 't6t6t6', 43, 2, '58c5657537602', '5.00', '', '', 'sdfgdfgdf', '', '', '', '', '', '', '::1', 1, 1, '2017-03-12 09:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `affiliatetransaction`
--

CREATE TABLE `affiliatetransaction` (
  `affiliatetransactionid` int(11) NOT NULL,
  `affiliateid` int(11) NOT NULL,
  `contactinfoid` int(11) NOT NULL,
  `description` text NOT NULL COMMENT 'tbldealstatus',
  `amount` decimal(15,4) NOT NULL,
  `dateadded` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `affiliatetransaction`
--

INSERT INTO `affiliatetransaction` (`affiliatetransactionid`, `affiliateid`, `contactinfoid`, `description`, `amount`, `dateadded`, `status`) VALUES
(1, 1, 4, '1', '0.0000', '2017-03-10 21:53:59', 3),
(2, 1, 5, '2', '0.0000', '2017-03-12 09:15:53', 3),
(3, 1, 6, '3', '0.0000', '2017-03-14 11:35:53', 3),
(4, 1, 7, '4', '0.0000', '2017-03-14 11:59:22', 3),
(5, 1, 8, '5', '0.0000', '2017-03-14 11:59:45', 3),
(6, 1, 9, '6', '500.0000', '2017-03-14 12:00:10', 3),
(7, 1, 10, '6', '500.0000', '2017-03-14 12:00:41', 3);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `vehicle_type_id` int(11) NOT NULL DEFAULT '1',
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `month_of_birth` tinyint(2) DEFAULT NULL,
  `day_of_birth` tinyint(2) DEFAULT NULL,
  `year_of_birth` int(4) DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `rent_or_own` enum('rent','own') DEFAULT 'rent',
  `residence_years` tinyint(1) DEFAULT NULL,
  `monthly_payment` varchar(10) DEFAULT NULL,
  `company_name` varchar(20) DEFAULT NULL,
  `job_title` varchar(20) DEFAULT NULL,
  `work_phone` varchar(15) DEFAULT NULL,
  `monthly_income` varchar(10) DEFAULT NULL,
  `sin_number` varchar(40) DEFAULT NULL,
  `years_on_job` tinyint(2) DEFAULT NULL,
  `months_on_job` tinyint(2) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` text,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `vehicle_type_id`, `first_name`, `last_name`, `email`, `phone`, `month_of_birth`, `day_of_birth`, `year_of_birth`, `address`, `postal_code`, `province_id`, `city`, `rent_or_own`, `residence_years`, `monthly_payment`, `company_name`, `job_title`, `work_phone`, `monthly_income`, `sin_number`, `years_on_job`, `months_on_job`, `created`, `notes`, `status`) VALUES
(1, 2, 'Alex', 'Lesan', 'alex.lesan@gmail.com', '069630914', 2, 2, 1988, 'Chisinau, Moldova', 'MD2051', 11, 'Chisinau', 'own', 5, '150', 'Artsintez', 'PHP developer', '123456789', '1000', '9874561234567', 7, 10, '2017-03-11 04:41:48', NULL, 1),
(2, 1, 'asdfasd', 'asdfasdf', 'asdfasdf@asdfas.com', 'asdfasdf', 3, 5, 2003, 'asdf', 'asdf', 4, 'asdf', 'rent', 2, 'asdfasdf', 'asdfadsf', 'asdfasdf', 'asdfasdf', 'asdfasdf', 'asdfasdf', 16, 10, '2017-03-11 04:41:48', NULL, 1),
(3, 2, 'Vikram', 'Shah', 'vip_vicks@sify.com', '896789696', 5, 22, 1984, 'dfghdfhdfh dfhdfhdfhdf dfhdfhdf ', 't6t6t6', 3, 'dfghdfhdf dfhdfhdfh', 'rent', 5, '500', 'dfh dfhdfhdfh ', 'jkhjkh', '089789789', '897897.00', '', 3, 2, '2017-03-11 04:41:48', NULL, 1),
(4, 1, 'Dhaval', 'Patel', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-11 11:53:58', 'dfdfmng dghjkdfgh djkfghjkdf ghdfjkg \r\n                        ', 1),
(5, 1, 'snehal', 'panchal', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-12 21:15:53', 'jhfghfgh ghfgh fghf  \r\n                        ', 1),
(6, 1, 'Hardik', 'Amin', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-14 23:35:53', 'Looking for Honda CR-V \r\n                        ', 1),
(7, 1, 'Hardik', 'Patel', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-14 23:59:22', 'jksdhgfjk jhfdsjk fhjsdkhfjsdkhf sdjhf \r\n                        ', 1),
(8, 1, 'hjgdshjfgdshgf', 'hjgdsrfhgds', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-14 23:59:45', 'kjsdh hsdjk hkjdshg skjdhgskjd h \r\n                        ', 1),
(9, 1, 'dflkgjdkfljg', 'utioerutioeru', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-15 00:00:10', 'lkzjfhksdla lkjdsafklsdj fklsdjf klsjdfkl dsj \r\n                        ', 1),
(10, 1, 'iyuiwyruiwey', 'uiyruiweyrui', '', '', 0, 0, 0, '', '', 1, '', 'rent', 0, '', '', '', '', '', '', 0, 0, '2017-03-15 00:00:41', 'k ksdajf kasjfklas kalsjfklasjf \r\n                        ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `keyword` varchar(15) NOT NULL,
  `slug_url` varchar(80) NOT NULL,
  `title` varchar(40) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `keyword`, `slug_url`, `title`, `description`, `is_active`) VALUES
(1, 'tems', 'terms-and-conditions', 'Terms and Conditions', '<p> Terms and Conditions</p>', 1),
(2, 'privacy', 'privacy-policy', 'Privacy Policy', '<p>Privacy Policy</p>', 1),
(3, 'index', '', 'Index page', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p><span class=\"example1\">GET THE CAR YOU WANT</span><br /><br /><span class=\"example1\">We understand you have a budget in mind and want the best deal possible</span></p>\r\n</body>\r\n</html>', 1),
(4, 'step_c_inf', 'contact-information', 'Step1: Contact Information', '<p>Now we need to ask you for some personal information to verify your identity.</p> \r\n<p>This info is kept private and secure.</p>', 1),
(5, 'step_r_inf', 'residential-information', 'Step2: Residential Information', '<p>Confirming your housing info shows lenders that you have stability and might therefore qualify for lower rates.\r\n</p>', 1),
(6, 'step_e_inf', 'employement-information', 'Step3: Employment Information', '<p>Your employment and income helps lenders determine the exact loan amount you could qualify for.\r\n</p>', 1),
(7, 'step_f_inf', 'finish', 'Step4: Finish', '<p>Your inquiry has been received . No further action is required .</p>\r\n	<p>To help save time, it may be a good idea to have the following documents ready:</p>\r\n	<ol style=\"text-align: left;display: inline-block;margin: 10px;padding: 10px;font-style: italic;text-decoration: underline;\">\r\n		<li style=\"padding: 5px;\">Your two most recent pay stubs or equivalent </li>\r\n		<li style=\"padding: 5px;\">A valid and current driver\'s license / Identification or equivalent </li>\r\n	</ol>\r\n	<p class=\"clearfix\"></p>\r\n	<p style=\"font-weight: bold;margin-top: 20px;border-top: 1px solid #444444;text-transform: none;\">Please ensure you are available by your primary contact phone number as a credit specialist\r\n	will be contacting you to go over the details of your individual options.\r\n	If you have not received a call within (48) hours please contact our Processing Centre</p>', 1),
(8, 'step_c_footer', 'contact-information-footer', 'Step3: footer information', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n<p>By submitting this form I agree with&nbsp;<span style=\"color: #0000ff;\">Terms and Conditions</span> and <span style=\"color: #0000ff;\">Privacy Policy</span>. I also agree to receive <span style=\"color: #0000ff;\">Carloans311.ca</span> and their partners\' electronic communications.</p>\r\n</body>\r\n</html>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `is_active` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `is_active`) VALUES
(1, 'Alberta', 'yes'),
(2, 'British Columbia', 'yes'),
(3, 'Manitoba', 'yes'),
(4, 'New Brunswick', 'yes'),
(5, 'Newfoundland And Labrador', 'yes'),
(6, 'Nova Scotia', 'yes'),
(7, 'Ontario', 'yes'),
(8, 'Prince Edward Island', 'yes'),
(9, 'Québec', 'yes'),
(10, 'Saskatchewan', 'yes'),
(11, 'Northwest Territories', 'yes'),
(12, 'Yukon', 'yes'),
(13, 'Nunavut', 'yes');

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

-- --------------------------------------------------------

--
-- Table structure for table `tbllogin`
--

CREATE TABLE `tbllogin` (
  `Id` int(11) NOT NULL,
  `CustomerId` int(11) NOT NULL,
  `EmailId` varchar(50) NOT NULL,
  `SALT` varchar(50) NOT NULL,
  `HASH` varchar(50) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tblsupport`
--

CREATE TABLE `tblsupport` (
  `Id` int(11) NOT NULL,
  `AffiliateId` int(11) NOT NULL COMMENT 'affiliate',
  `Subject` text NOT NULL,
  `Message` text NOT NULL,
  `DateAdded` datetime NOT NULL,
  `SupportStatus` int(1) NOT NULL DEFAULT '1',
  `Status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tblsupport`
--

INSERT INTO `tblsupport` (`Id`, `AffiliateId`, `Subject`, `Message`, `DateAdded`, `SupportStatus`, `Status`) VALUES
(1, 1, 'jkdfjkghjkdfhgdf', 'djkfghjkdf dfjkghdfjkghjdfkhgjkdf dfjkghdfjkghkdfjghdf ', '2017-03-11 05:54:43', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'ofOiFks2m_zq5OOqem-x9QSqwwRAhYmf', '$2y$13$BubCgggvqLa1FlcyTzB3x.6qA3/eyjbkV4ePCjevH/.LbFLBO4TIe', NULL, 'admin@admin.com', 10, 1480946923, 1488538041);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_types`
--

CREATE TABLE `vehicle_types` (
  `id` int(11) NOT NULL,
  `keyword` varchar(12) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(12) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vehicle_types`
--

INSERT INTO `vehicle_types` (`id`, `keyword`, `is_default`, `name`, `photo`) VALUES
(1, 'sedan', 0, 'Sedan', 'sedan.png'),
(2, 'suv', 0, 'Suv', 'suv.png'),
(3, 'truck', 1, 'Truck', 'truck.png'),
(4, 'minivan', 0, 'MiniVan', 'minivan.png');

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
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_type_id` (`vehicle_type_id`),
  ADD KEY `provinces` (`province_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tbllogin`
--
ALTER TABLE `tbllogin`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tblsupport`
--
ALTER TABLE `tblsupport`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Indexes for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliatetransaction`
--
ALTER TABLE `affiliatetransaction`
  MODIFY `affiliatetransactionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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
-- AUTO_INCREMENT for table `tbllogin`
--
ALTER TABLE `tbllogin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tblsupport`
--
ALTER TABLE `tblsupport`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `vehicle_types`
--
ALTER TABLE `vehicle_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `provinces` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`),
  ADD CONSTRAINT `vehicles` FOREIGN KEY (`vehicle_type_id`) REFERENCES `vehicle_types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
