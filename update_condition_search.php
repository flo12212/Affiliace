<?php 

session_start();

$way = $_GET['way'];
$query = $_GET['query'];

$_SESSION['condition'] = $way;
$_SESSION['condition2'] = $way;

header('Location: search?query=' . $query);

?>