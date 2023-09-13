<?php 

session_start();

$stars = $_GET['stars'];
$query = $_GET['query'];

$_SESSION['stars'] = $stars;

header('Location: search?query=' . $query . '&min=' . $min . '&max=' . $max . '&stars=' . $stars . '&noship=' . $noship .'&condition=' . $condition .'&condition2=' . $condition2);

?>