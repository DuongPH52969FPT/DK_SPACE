<!-- DELIMITER $$

CREATE PROCEDURE MakeBooking(
    IN p_guest_id INT,
    IN p_room_id INT,
    IN p_check_in DATE,
    IN p_check_out DATE
)
BEGIN
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

DELIMITER ; -->

<!-- Trigger Booking -->

DELIMITER $$

<!-- CREATE TRIGGER after_booking_cancel
AFTER UPDATE ON Bookings
FOR EACH ROW
BEGIN
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
END$$

DELIMITER ; -->
