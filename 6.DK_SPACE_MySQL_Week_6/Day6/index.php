//Procedure 

// DELIMITER $$

// CREATE PROCEDURE TransferMoney(
//     IN p_from_account INT,
//     IN p_to_account INT,
//     IN p_amount DECIMAL(15,2)
// )
// BEGIN
//     DECLARE v_from_balance DECIMAL(15,2);
//     DECLARE v_from_status VARCHAR(20);
//     DECLARE v_to_status VARCHAR(20);

//     DECLARE EXIT HANDLER FOR SQLEXCEPTION 
//     BEGIN
//         ROLLBACK;
//         INSERT INTO TxnAuditLogs(from_account, to_account, amount, message)
//         VALUES (p_from_account, p_to_account, p_amount, 'Transfer failed - Rolled back');
//     END;

//     START TRANSACTION;

//     IF p_from_account < p_to_account THEN
//         SELECT balance, status INTO v_from_balance, v_from_status
//         FROM Accounts WHERE account_id = p_from_account FOR UPDATE;

//         SELECT status INTO v_to_status
//         FROM Accounts WHERE account_id = p_to_account FOR UPDATE;
//     ELSE
//         SELECT status INTO v_to_status
//         FROM Accounts WHERE account_id = p_to_account FOR UPDATE;

//         SELECT balance, status INTO v_from_balance, v_from_status
//         FROM Accounts WHERE account_id = p_from_account FOR UPDATE;
//     END IF;

//     IF v_from_status != 'Active' THEN
//         SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Sender account is not active';
//     END IF;

//     IF v_to_status != 'Active' THEN
//         SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Receiver account is not active';
//     END IF;

//     IF v_from_balance < p_amount THEN
//         SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Insufficient balance';
//     END IF;

//     UPDATE Accounts
//     SET balance = balance - p_amount
//     WHERE account_id = p_from_account;

//     UPDATE Accounts
//     SET balance = balance + p_amount
//     WHERE account_id = p_to_account;

//     INSERT INTO Transactions(from_account, to_account, amount, status)
//     VALUES (p_from_account, p_to_account, p_amount, 'Success');

//     INSERT INTO TxnAuditLogs(from_account, to_account, amount, message)
//     VALUES (p_from_account, p_to_account, p_amount, 'Transfer completed successfully');

//     COMMIT;
// END $$

// DELIMITER ;




";
///MVCC – Multi-Version Concurrency Control:

// -- 1. Đặt mức cách ly REPEATABLE READ (mặc định InnoDB)
// SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ;

// -- 2. Bắt đầu giao dịch
// START TRANSACTION;

// SELECT balance FROM Accounts WHERE account_id = 1;


//Tạo tab mới và cập nhật dữ liệu

START TRANSACTION;


UPDATE Accounts SET balance = balance - 100 WHERE account_id = 1;


UPDATE Accounts SET balance = balance + 100 WHERE account_id = 2;

COMMIT;

