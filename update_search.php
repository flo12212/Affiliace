<?php 

session_start();

$min = isset($_GET['min']) ? $_GET['min'] : '';
$max = isset($_GET['max']) ? $_GET['max'] : '';
$query = isset($_GET['query']) ? $_GET['query'] : '';

if (empty($min) && empty($max) && empty($query)) {
    $min = isset($_POST['min']) ? $_POST['min'] : '';
    $max = isset($_POST['max']) ? $_POST['max'] : '';
    $query = isset($_POST['query']) ? $_POST['query'] : '';
}

$_SESSION['min'] = $min;
$_SESSION['max'] = $max;

header('Location: search?query=' . $query);

?>