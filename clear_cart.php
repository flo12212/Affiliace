<?php 

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

$id = $_SESSION['user_id'];


if (isset($_POST['clear_cart'])) {
    $result1 = mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$id'"); 
    header("Location: cart");
    exit;
}

?>