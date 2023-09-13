<?php 

session_start();

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["file"];
    $titel = $_POST['titel'];
    $old_titel = $_POST['old_titel'];
    $upid = $_POST['upid'];
    $description  = $_POST['description'];
    $price = $_POST['price'];
    $shipping = $_POST['shipping'];
    $currancy = $_POST['currancy'];
    $ship_days = $_POST['ship_days'];
    $ship_hours = $_POST['ship_hours'];
    $catigory = $_POST['catigory'];

    $targetDirectory = "videos/";
    $targetFile = $targetDirectory . basename($file["name"]);
    
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        $sql = "UPDATE uploads SET titel = '$titel', description = '$description', preview = '$targetFile', price = '$price', shipping = '$shipping', currancy = '$currancy', ship_days = '$ship_days', ship_hours = '$ship_hours', catigory = '$catigory' WHERE id = '$user_id' AND titel = '$old_titel' AND upid = '$upid'";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: product-view");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
    }
} else {
    $defaultfile = $_POST['defaultfile'];
    $titel = $_POST['titel'];
    $old_titel = $_POST['old_titel'];
    $upid = $_POST['upid'];
    $description  = $_POST['description'];
    $price = $_POST['price'];
    $shipping = $_POST['shipping'];
    $currancy = $_POST['currancy'];
    $ship_days = $_POST['ship_days'];
    $ship_hours = $_POST['ship_hours'];
    $catigory = $_POST['catigory'];
    
    $sql = "UPDATE uploads SET titel = '$titel', description = '$description', preview = '$defaultfile', price = '$price', shipping = '$shipping', currancy = '$currancy', ship_days = '$ship_days', ship_hours = '$ship_hours', catigory = '$catigory' WHERE id = '$user_id' AND titel = '$old_titel' AND upid = '$upid'";
        
    if ($conn->query($sql) === TRUE) {
        header("Location: product-view");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>