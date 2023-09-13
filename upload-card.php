<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('html_errors', 1);

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

$id = $_SESSION['user_id'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$product_id = $_GET['id'];

$sql = "SELECT * FROM cart WHERE user_id = '$id' AND product_id = '$product_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row !== null) {
    $ammount = $row['ammount'];

    // Update the existing row
    $newammount = $ammount + 1;
    $updateSql = "UPDATE cart SET ammount = '$newammount' WHERE user_id = '$id' AND product_id = '$product_id'";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect based on source
        if (isset($_GET['source'])) {
            $source = $_GET['source'];
            if ($source === 'home') {
                header('Location: index');
                exit();
            } else {
                header('Location: product?id=' . $product_id);
                exit();
            }
        }
    } else {
        echo "Error updating data: " . $conn->error;
    }
} else {
    // Insert a new row
    $insertSql = "INSERT INTO cart (user_id, product_id, ammount) VALUES ('$id', '$product_id', 1)";

    if ($conn->query($insertSql) === TRUE) {
        // Redirect based on source
        if (isset($_GET['source'])) {
            $source = $_GET['source'];
            if ($source === 'home') {
                header('Location: index');
                exit();
            } else {
                header('Location: product?id=' . $product_id);
                exit();
            }
        }
    } else {
        echo "Error inserting data: " . $conn->error;
    }
}

$conn->close();

?>