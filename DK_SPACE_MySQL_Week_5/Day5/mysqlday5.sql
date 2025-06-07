-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2025 at 01:11 PM
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
-- Database: `mysqlday5`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `MakeBooking` (IN `p_guest_id` INT, IN `p_room_id` INT, IN `p_check_in` DATE, IN `p_check_out` DATE)   BEGIN
    DECLARE room_available INT;
    DECLARE overlapping_bookings INT;

    -- 1. Kiểm tra phòng có status = 'Available'
    SELECT COUNT(*) INTO room_available
    FROM Rooms
    WHERE room_id = p_room_id AND status = 'Available';

    IF room_available = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Phòng không có sẵn hoặc đang được sử dụng.';
    END IF;

    -- 2. Kiểm tra phòng không bị đặt trùng lịch
    SELECT COUNT(*) INTO overlapping_bookings
    FROM Bookings
    WHERE room_id = p_room_id
      AND status = 'Confirmed'
      AND (
        (p_check_in < check_out) AND (p_check_out > check_in)
      );

    IF overlapping_bookings > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Phòng đã được đặt trong khoảng thời gian này.';
    END IF;

    -- 3. Tạo booking mới
    INSERT INTO Bookings (guest_id, room_id, check_in, check_out, status)
    VALUES (p_guest_id, p_room_id, p_check_in, p_check_out, 'Confirmed');

    -- 4. Cập nhật trạng thái phòng
    UPDATE Rooms
    SET status = 'Occupied'
    WHERE room_id = p_room_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int NOT NULL,
  `guest_id` int NOT NULL,
  `room_id` int NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `guest_id`, `room_id`, `check_in`, `check_out`, `status`) VALUES
(1, 1, 1, '2025-06-10', '2025-06-12', 'Cancelled'),
(2, 2, 1, '2025-06-15', '2025-06-17', 'Pending'),
(3, 3, 1, '2025-06-18', '2025-06-20', 'Cancelled');

--
-- Triggers `bookings`
--
DELIMITER $$
CREATE TRIGGER `after_booking_cancel` AFTER UPDATE ON `bookings` FOR EACH ROW BEGIN
    DECLARE future_confirmed_count INT;

    -- Chỉ xử lý khi status bị đổi thành 'Cancelled'
    IF OLD.status != 'Cancelled' AND NEW.status = 'Cancelled' THEN
        SELECT COUNT(*) INTO future_confirmed_count
        FROM Bookings
        WHERE room_id = NEW.room_id
          AND status = 'Confirmed'
          AND check_in > CURDATE();

        IF future_confirmed_count = 0 THEN
            UPDATE Rooms
            SET status = 'Available'
            WHERE room_id = NEW.room_id;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `guest_id` int NOT NULL,
  `full_name` varchar(200) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`guest_id`, `full_name`, `phone`) VALUES
(1, 'Nguyễn Văn A', '0909123456'),
(2, 'Trần Thị B', '0912345678'),
(3, 'Lê Văn C', '0987654321');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `type`, `status`, `price`) VALUES
(1, '101', 'Standard', 'Available', 500),
(2, '102', 'Standard', 'Available', 500),
(3, '201', 'VIP', 'Available', 1000),
(4, '202', 'Suite', 'Maintenance', 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
