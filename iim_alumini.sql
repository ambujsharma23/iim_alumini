-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 03, 2017 at 11:43 AM
-- Server version: 5.7.20-0ubuntu0.17.10.1
-- PHP Version: 5.6.31-6+ubuntu17.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bytelogi_iim_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `iim_alumini`
--

CREATE TABLE `iim_alumini4` (
  `id` int(11) NOT NULL,
  `nominated0` text,
  `award_category` varchar(5) DEFAULT NULL,
  `verticals_plan` varchar(5) DEFAULT NULL,
  `mention_year` varchar(5) DEFAULT NULL,
  `stage_startup` text,
  `FY2017` text,
  `FY2016` text,
  `FY2015` text,
  `FY2014` text,
  `FY2013` text,
  `FY2012` text,
  `r_address` text,
  `f_contact` text,
  `p_contact` text,
  `brf_description` text,
  `brf_achievements` text,
  `mntion_key` text,
  `mntion_solving` text,
  `innovation_cat` varchar(5) DEFAULT NULL,
  `technology_cat` varchar(5) DEFAULT NULL,
  `investment_made` varchar(5) DEFAULT NULL,
  `mnpwr_resources` varchar(5) DEFAULT NULL,
  `mnt_nominated` text,
  `bmodel_market` varchar(5) DEFAULT NULL,
  `bmodel_management` varchar(5) DEFAULT NULL,
  `bmodel_financial` varchar(5) DEFAULT NULL,
  `enumerate_bmodel` text,
  `diff_skillsets` varchar(5) DEFAULT NULL,
  `different_types` text,
  `impact_customers` varchar(5) DEFAULT NULL,
  `stage_society` varchar(5) DEFAULT NULL,
  `impact_nominated` varchar(5) DEFAULT NULL,
  `describe_nominated` text,
  `future_plan` text,
  `photo_img` text,
  `dtlweb_address` text,
  `attach_award` text,
  `additional_information` text,
  `user_agent` text,
  `ip` text,
  `device` text,
  `created_date` text,
  `error` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `iim_alumini`
--
ALTER TABLE `iim_alumini4`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `iim_alumini`
--
ALTER TABLE `iim_alumini4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
