<?php 

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$user_id = $_GET['id'];

$sql = "UPDATE userdata SET paid = 1 WHERE id = '$user_id'";
mysqli_query($conn, $sql);
header("Location: index");

?>