-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2025 at 02:32 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysqlday6`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `TransferMoney` (IN `p_from_account` INT, IN `p_to_account` INT, IN `p_amount` DECIMAL(15,2))   BEGIN
    DECLARE v_from_balance DECIMAL(15,2);
    DECLARE v_from_status VARCHAR(20);
    DECLARE v_to_status VARCHAR(20);
    DECLARE EXIT HANDLER FOR SQLEXCEPTION 
    BEGIN
        ROLLBACK;
        INSERT INTO TxnAuditLogs(from_account, to_account, amount, message)
        VALUES (p_from_account, p_to_account, p_amount, 'Transfer failed - Rolled back due to error');
    END;

    START TRANSACTION;

    -- LOCK hàng tránh deadlock bằng cách luôn lock theo thứ tự account_id tăng dần
    IF p_from_account < p_to_account THEN
        SELECT balance, status INTO v_from_balance, v_from_status
        FROM Accounts WHERE account_id = p_from_account FOR UPDATE;

        SELECT status INTO v_to_status
        FROM Accounts WHERE account_id = p_to_account FOR UPDATE;
    ELSE
        SELECT status INTO v_to_status
        FROM Accounts WHERE account_id = p_to_account FOR UPDATE;

        SELECT balance, status INTO v_from_balance, v_from_status
        FROM Accounts WHERE account_id = p_from_account FOR UPDATE;
    END IF;

    -- Kiểm tra trạng thái
    IF v_from_status != 'Active' OR v_to_status != 'Active' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'One or both accounts are not active';
    END IF;

    -- Kiểm tra số dư
    IF v_from_balance < p_amount THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insufficient balance';
    END IF;

    -- Trừ tiền người gửi
    UPDATE Accounts
    SET balance = balance - p_amount
    WHERE account_id = p_from_account;

    -- Cộng tiền người nhận
    UPDATE Accounts
    SET balance = balance + p_amount
    WHERE account_id = p_to_account;

    -- Ghi log transaction
    INSERT INTO Transactions(from_account, to_account, amount, status)
    VALUES (p_from_account, p_to_account, p_amount, 'Success');

    -- Ghi vào audit log
    INSERT INTO TxnAuditLogs(from_account, to_account, amount, message)
    VALUES (p_from_account, p_to_account, p_amount, 'Transfer completed successfully');

    COMMIT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `full_name`, `balance`, `status`) VALUES
(1, 'Nguyen Van A', '700.00', 'Active'),
(2, 'Tran Thi B', '800.00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `txn_id` int NOT NULL,
  `from_account` int DEFAULT NULL,
  `to_account` int DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `txn_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT NULL
) ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`txn_id`, `from_account`, `to_account`, `amount`, `txn_date`, `status`) VALUES
(2, 1, 2, '100.00', '2025-06-12 10:17:01', 'Success'),
(3, 1, 2, '100.00', '2025-06-12 10:17:28', 'Success');

-- --------------------------------------------------------

--
-- Table structure for table `txnauditlogs`
--

CREATE TABLE `txnauditlogs` (
  `log_id` int NOT NULL,
  `from_account` int DEFAULT NULL,
  `to_account` int DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `txnauditlogs`
--

INSERT INTO `txnauditlogs` (`log_id`, `from_account`, `to_account`, `amount`, `log_time`, `message`) VALUES
(1, 1, 2, '100.00', '2025-06-12 10:11:10', 'Transfer failed - Rolled back due to error'),
(2, 1, 2, '100.00', '2025-06-12 10:17:01', 'Transfer completed successfully'),
(3, 1, 2, '100.00', '2025-06-12 10:17:28', 'Transfer completed successfully');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`txn_id`),
  ADD KEY `from_account` (`from_account`),
  ADD KEY `to_account` (`to_account`);

--
-- Indexes for table `txnauditlogs`
--
ALTER TABLE `txnauditlogs`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `txn_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `txnauditlogs`
--
ALTER TABLE `txnauditlogs`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`from_account`) REFERENCES `accounts` (`account_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`to_account`) REFERENCES `accounts` (`account_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
