<?php
$servername = "localhost";
$username = 'root';
$password = '';
$dbname = 'mysqlday1';

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Kết nối CSDL thành công";
}catch(PDOException $e){
    echo "Kết nối CSDL khó tạo: " . $e->getMessage();
}

