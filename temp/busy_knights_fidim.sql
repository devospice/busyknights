-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql.fidim.com
-- Generation Time: Sep 02, 2026 at 07:26 AM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `busy_knights_fidim`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_19`
--

CREATE TABLE `accounts_19` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_20`
--

CREATE TABLE `accounts_20` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_21`
--

CREATE TABLE `accounts_21` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_22`
--

CREATE TABLE `accounts_22` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_23`
--

CREATE TABLE `accounts_23` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `list_on_left` tinyint NOT NULL DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_24`
--

CREATE TABLE `accounts_24` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `list_on_left` tinyint(1) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_25`
--

CREATE TABLE `accounts_25` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `send_below_ten` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `list_on_left` tinyint(1) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_26`
--

CREATE TABLE `accounts_26` (
  `name` varchar(255) NOT NULL,
  `starting_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `contact` int NOT NULL DEFAULT '0',
  `company` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `send_below_ten` tinyint(1) NOT NULL DEFAULT '0',
  `notes` text NOT NULL,
  `list_on_left` tinyint(1) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `account_category`
--

CREATE TABLE `account_category` (
  `name` varchar(255) NOT NULL,
  `notes` tinytext NOT NULL,
  `applies_to` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `type` varchar(15) NOT NULL,
  `examples` text NOT NULL,
  `sort_order` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `web_site` varchar(255) NOT NULL,
  `contact` int NOT NULL,
  `notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(15) NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone_office` varchar(25) NOT NULL,
  `phone_alt` varchar(25) NOT NULL,
  `fax_office` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email2` varchar(255) NOT NULL,
  `web_site` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(15) NOT NULL,
  `country` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email2` varchar(255) NOT NULL,
  `email3` varchar(255) NOT NULL,
  `email4` varchar(255) NOT NULL,
  `phone_home` varchar(25) NOT NULL,
  `phone_office` varchar(25) NOT NULL,
  `phone_cell` varchar(25) NOT NULL,
  `phone_alt` varchar(25) NOT NULL,
  `fax_home` varchar(25) NOT NULL,
  `fax_office` varchar(25) NOT NULL,
  `company` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `entries_19`
--

CREATE TABLE `entries_19` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_20`
--

CREATE TABLE `entries_20` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_21`
--

CREATE TABLE `entries_21` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_22`
--

CREATE TABLE `entries_22` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_23`
--

CREATE TABLE `entries_23` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_24`
--

CREATE TABLE `entries_24` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_25`
--

CREATE TABLE `entries_25` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `entries_26`
--

CREATE TABLE `entries_26` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `type` varchar(255) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `sale_item` int NOT NULL,
  `quantity_in` int NOT NULL DEFAULT '0',
  `quantity_out` int NOT NULL,
  `transaction` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `instructions` text NOT NULL,
  `account` int NOT NULL COMMENT 'index into accounts',
  `method` int NOT NULL COMMENT '1=Paypal, 2=Check, 3=Web, 4=Venmo',
  `info` int NOT NULL COMMENT 'Index to entry in check, paypal, or web.',
  `is_preferred` tinyint NOT NULL DEFAULT '1',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info_check`
--

CREATE TABLE `payment_info_check` (
  `pay_to` varchar(255) NOT NULL,
  `mail_to` varchar(255) NOT NULL,
  `type` int DEFAULT '2' COMMENT '2=Check.  Do not change.',
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(25) NOT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info_paypal`
--

CREATE TABLE `payment_info_paypal` (
  `email` varchar(255) NOT NULL,
  `type` int NOT NULL DEFAULT '1' COMMENT '1=Paypal. Do not change.',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info_venmo`
--

CREATE TABLE `payment_info_venmo` (
  `handle` varchar(255) NOT NULL,
  `type` int NOT NULL DEFAULT '4' COMMENT '4=Venmo. Do not change.',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info_web`
--

CREATE TABLE `payment_info_web` (
  `url` varchar(255) NOT NULL,
  `type` int NOT NULL DEFAULT '3' COMMENT '3=Web. Do not change.',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `method` varchar(255) NOT NULL,
  `use_table` varchar(50) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `pre_allocations`
--

CREATE TABLE `pre_allocations` (
  `id` int NOT NULL,
  `account` int NOT NULL,
  `percent` decimal(5,2) NOT NULL,
  `artist` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `royalties`
--

CREATE TABLE `royalties` (
  `sale_item` int NOT NULL,
  `credit_account` int NOT NULL COMMENT 'The account the royalties are assigned to.',
  `debit_account` int NOT NULL COMMENT 'The expense account where the royalties are recorded.',
  `percent` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `use_percent` tinyint NOT NULL DEFAULT '1',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `name` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `catalog_number` varchar(255) NOT NULL,
  `artist` int NOT NULL,
  `bar_code` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `opening_stock` int NOT NULL,
  `cogs` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `template_entries`
--

CREATE TABLE `template_entries` (
  `account` int NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `transaction_template` int NOT NULL,
  `entry_num` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_19`
--

CREATE TABLE `transactions_19` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_20`
--

CREATE TABLE `transactions_20` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_21`
--

CREATE TABLE `transactions_21` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_22`
--

CREATE TABLE `transactions_22` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_23`
--

CREATE TABLE `transactions_23` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_24`
--

CREATE TABLE `transactions_24` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_25`
--

CREATE TABLE `transactions_25` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `cleared` tinyint(1) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transactions_26`
--

CREATE TABLE `transactions_26` (
  `date` date NOT NULL,
  `notes` text NOT NULL,
  `sale_item` int NOT NULL,
  `category` int NOT NULL,
  `subscription_payment` int NOT NULL DEFAULT '0',
  `cleared` tinyint(1) NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_templates`
--

CREATE TABLE `transaction_templates` (
  `name` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_19`
--
ALTER TABLE `accounts_19`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_20`
--
ALTER TABLE `accounts_20`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_21`
--
ALTER TABLE `accounts_21`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_22`
--
ALTER TABLE `accounts_22`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_23`
--
ALTER TABLE `accounts_23`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_24`
--
ALTER TABLE `accounts_24`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_25`
--
ALTER TABLE `accounts_25`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accounts_26`
--
ALTER TABLE `accounts_26`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_category`
--
ALTER TABLE `account_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_19`
--
ALTER TABLE `entries_19`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_20`
--
ALTER TABLE `entries_20`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_21`
--
ALTER TABLE `entries_21`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_22`
--
ALTER TABLE `entries_22`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_23`
--
ALTER TABLE `entries_23`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_24`
--
ALTER TABLE `entries_24`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_25`
--
ALTER TABLE `entries_25`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `entries_26`
--
ALTER TABLE `entries_26`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info_check`
--
ALTER TABLE `payment_info_check`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info_paypal`
--
ALTER TABLE `payment_info_paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info_venmo`
--
ALTER TABLE `payment_info_venmo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_info_web`
--
ALTER TABLE `payment_info_web`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pre_allocations`
--
ALTER TABLE `pre_allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `royalties`
--
ALTER TABLE `royalties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_entries`
--
ALTER TABLE `template_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_19`
--
ALTER TABLE `transactions_19`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_20`
--
ALTER TABLE `transactions_20`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_21`
--
ALTER TABLE `transactions_21`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_22`
--
ALTER TABLE `transactions_22`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_23`
--
ALTER TABLE `transactions_23`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_24`
--
ALTER TABLE `transactions_24`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_25`
--
ALTER TABLE `transactions_25`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions_26`
--
ALTER TABLE `transactions_26`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_templates`
--
ALTER TABLE `transaction_templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_19`
--
ALTER TABLE `accounts_19`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_20`
--
ALTER TABLE `accounts_20`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_21`
--
ALTER TABLE `accounts_21`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_22`
--
ALTER TABLE `accounts_22`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_23`
--
ALTER TABLE `accounts_23`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_24`
--
ALTER TABLE `accounts_24`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_25`
--
ALTER TABLE `accounts_25`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accounts_26`
--
ALTER TABLE `accounts_26`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_category`
--
ALTER TABLE `account_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_19`
--
ALTER TABLE `entries_19`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_20`
--
ALTER TABLE `entries_20`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_21`
--
ALTER TABLE `entries_21`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_22`
--
ALTER TABLE `entries_22`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_23`
--
ALTER TABLE `entries_23`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_24`
--
ALTER TABLE `entries_24`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_25`
--
ALTER TABLE `entries_25`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `entries_26`
--
ALTER TABLE `entries_26`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info_check`
--
ALTER TABLE `payment_info_check`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info_paypal`
--
ALTER TABLE `payment_info_paypal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info_venmo`
--
ALTER TABLE `payment_info_venmo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_info_web`
--
ALTER TABLE `payment_info_web`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_allocations`
--
ALTER TABLE `pre_allocations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `royalties`
--
ALTER TABLE `royalties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_entries`
--
ALTER TABLE `template_entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_19`
--
ALTER TABLE `transactions_19`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_20`
--
ALTER TABLE `transactions_20`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_21`
--
ALTER TABLE `transactions_21`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_22`
--
ALTER TABLE `transactions_22`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_23`
--
ALTER TABLE `transactions_23`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_24`
--
ALTER TABLE `transactions_24`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_25`
--
ALTER TABLE `transactions_25`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions_26`
--
ALTER TABLE `transactions_26`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_templates`
--
ALTER TABLE `transaction_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
