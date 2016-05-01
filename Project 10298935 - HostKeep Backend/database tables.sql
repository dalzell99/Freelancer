-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2016 at 03:37 PM
-- Server version: 5.6.29
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ccrsc638_10298935`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customer`
--

CREATE TABLE IF NOT EXISTS `Customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `salutation` text NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `company` text NOT NULL,
  `propertyIDs` text NOT NULL,
  `phoneNumber` text NOT NULL,
  `mobileNumber` text NOT NULL,
  `bankName` text NOT NULL,
  `bsb` text NOT NULL,
  `accountNumber` text NOT NULL,
  `postalAddress` text NOT NULL,
  `suburb` text NOT NULL,
  `state` text NOT NULL,
  `postcode` text NOT NULL,
  `country` text NOT NULL,
  `lastModified` text NOT NULL,
  `lastLogin` text NOT NULL,
  `lastLoginIP` text NOT NULL,
  PRIMARY KEY (`customerID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `Documents`
--

CREATE TABLE IF NOT EXISTS `Documents` (
  `documentID` int(11) NOT NULL,
  `date` text NOT NULL,
  `matter` text NOT NULL,
  `title` text NOT NULL,
  `view` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Properties`
--

CREATE TABLE IF NOT EXISTS `Properties` (
  `propertyID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `address` text NOT NULL,
  `minimumNightlyPrice` text NOT NULL,
  PRIMARY KEY (`propertyID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
