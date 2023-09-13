<?php

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

$id = $_POST['id'];

$sql2 = "DELETE FROM uploads WHERE upid = '$id'";
mysqli_query($conn, $sql2);
header("Location: product-view");


?>