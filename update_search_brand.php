<?php 

session_start();

$brand = $_GET['brand'];
$query = $_GET['query'];

$_SESSION['brand'] = $brand;

header('Location: search?query=' . $query);

?>