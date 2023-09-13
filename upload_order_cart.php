<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$id = $_POST['id'];

$sql49 = "SELECT * FROM uploads WHERE upid = '$id'";
$result49 = $conn->query($sql49);
$row49 = $result49->fetch_assoc();

$titel = $row49['titel'];
$seller_id = $_POST['seller_id'];
$product_id = $_POST['product_id'];
$amount = $_POST['amount'];
$username = $_POST['username'];
$address = $_POST['address'];
$price = $_POST['price'];
$shipping = $_POST['shipping'];
$tax_rate = $_POST['tax_rate'];
$total_amount = $_POST['total_amount'];

// Convert single values to arrays
if (!is_array($seller_id)) {
    $seller_id = array($seller_id);
}

if (!is_array($product_id)) {
    $product_id = array($product_id);
}

if (!is_array($amount)) {
    $amount = array($amount);
}

if (!is_array($price)) {
    $price = array($price);
}

if (!is_array($shipping)) {
    $shipping = array($shipping);
}
$insertQueries = array(); // Array to store the queries

for ($i = 0; $i < count($product_id); $i++) {
  // Insert the order into the database for the current product
  // Replace this code with your actual database insertion logic
  $insertQueries[] = "INSERT INTO orders (order_id, user_id, seller_id, product_id, ammount, name, address, price, shipping, tax, total, time, status, titel)
                      VALUES (0,'$id', '$seller_id[$i]', '$product_id[$i]', '$amount[$i]', '$username', '$address', '$price[$i]', '$shipping[$i]', '$tax_rate', '$total_amount', NOW(), 0, $titel)";
}

// Execute the queries
foreach ($insertQueries as $insertQuery) {
  
}

?>