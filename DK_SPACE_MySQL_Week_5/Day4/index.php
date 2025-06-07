<?php
include 'sql/connect.php';

// Tạo một cơ sở dữ liệu tên là OnlineLearning.

// "CREATE DATABASE OnlineLearning";

// Xóa cơ sở dữ liệu OnlineLearning nếu không còn dùng nữa.
// "DROP DATABASE OnlineLearning";

// Thêm cột status vào bảng Enrollments với giá trị mặc định là 'active'.

// "ALTER TABLE Enrollments ADD COLUMN status VARCHAR(20) DEFAULT 'active'";

// Xóa bảng Enrollments nếu không còn cần nữa.

// "DROP TABLE Enrollments";

// Tạo một VIEW tên là StudentCourseView hiển thị danh sách sinh viên và tên khóa học họ đã đăng ký.

// "CREATE VIEW StudentCourseView AS
// SELECT 
//     s.student_id,
//     s.full_name,
//     c.course_id,
//     c.title AS course_title
// FROM Students s
// JOIN Enrollments e ON s.student_id = e.student_id
// JOIN Courses c ON e.course_id = c.course_id;

// CREATE INDEX idx_course_title ON Courses(title);
