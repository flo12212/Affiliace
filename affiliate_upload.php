<?php 

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

if (!isset($_POST['product_id']) || !isset($_POST['commission'])) {
    header("Location: affiliate");
    exit;
}

$product_id = $_POST['product_id'];
$commission = $_POST['commission'];

$sql3 = "SELECT * FROM affiliate WHERE user_id = '$user_id' AND product_id = '$product_id'";
$result3 = $conn->query($sql3);
$row3 = $result3->fetch_assoc();

if (!empty($row3)) {
    header("Location: affiliate");
}

$sql2 = "INSERT INTO affiliate (product_id, user_id, commision) VALUES ('$product_id', '$user_id', '$commission')";
if ($conn->query($sql2) === TRUE) {
    header("Location: affiliate");
} else {
    echo "Error inserting record: " . mysqli_error($conn);
}
    ?>