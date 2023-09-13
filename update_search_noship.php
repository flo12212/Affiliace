<?php 

session_start();

$query = $_GET['query'];
$noship = $_GET['noship'];

$_SESSION['noship'] = $noship;

header('Location: search?query=' . $query);

?>