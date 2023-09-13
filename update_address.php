<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

$id = $_SESSION['user_id'];

$country = $_POST['country'];
$name = $_POST['name'];
$address = $_POST['address'];
$zip = $_POST['zip'];
$city = $_POST['city'];
$product_id = $_GET['id'];


$sql = "UPDATE userdata SET country = '$country', username = '$name', address = '$address', zip = '$zip', city = '$city' WHERE id = '$id'";

$result = mysqli_query($conn, $sql);

header("Location: buy?id=" . $product_id);

mysqli_close($conn);

?>
