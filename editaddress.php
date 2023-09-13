<?php

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

$editlink = $_GET['id'];


$username = $_SESSION['username'];
    $firstLetter = $username[0];
    $user_id = $_SESSION['user_id'];
$sql2 = "UPDATE userdata SET address = '' WHERE id = '$user_id'";
mysqli_query($conn, $sql2);
header("Location: buy?id=$editlink");


?>