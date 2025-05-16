

<?php

include "header.php";
include "logger.php";


if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_FILES['file'])) {
    $uploadDir  =  '../uploads/';



    $file = $_FILES['file'];
    $currentName = $file['name'];
    $tmpPath = $file['tmp_name'];
    $error = $file['error'];

    if($error === UPLOAD_ERR_OK){
        $newName = 'upload_'.time() . '_' . basename($currentName);
        $destination = $uploadDir . $newName;
        
        if(move_uploaded_file($tmpPath, $destination)) {
             writeLog('Upload File', "File '$currentName' đã được upload thành công với tên '$newName'.");
            echo "<p>File đã được upload thành công!</p>";
        } else {
            writeLog('Upload File', "Lỗi khi upload file '$currentName'.");
          echo "<p>Không thể upload file.</p>";
        }
        
    }
}
?>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="file">Chọn file để upload:</label>
    <input type="file" name="file" id="file" required>
    <button type="submit">Upload</button>
</form>