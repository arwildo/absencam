<?php
$conn = mysqli_connect("localhost", "root", "", "webcam");

if (isset($_GET['name']) && isset($_GET['unit']) && isset($_GET['email'])) {
    $name = $_GET['name'];
    $unit = $_GET['unit'];
    $email = $_GET['email'];

    if (isset($_FILES["webcam"])) {
        $tmpName = $_FILES["webcam"]["tmp_name"];
        $imageName = date("Ymd") . "-" . date("His") . '.jpeg';
        move_uploaded_file($tmpName, 'img/' . $imageName);

        $date = date("Y/m/d") . "-" . date("H:i:s");
        $query = "INSERT INTO tb_image (date, image, name, unit, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss", $date, $imageName, $name, $unit, $email);
            mysqli_stmt_execute($stmt);
        }
    }
}
?>