<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start(); // Start output buffering

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();
$id = $_SESSION['user_id'];

$way = $_GET['id'];
$loc = $_GET['loc'];
$count = $_POST['count'];
$product_id = $_POST['product_id'];

    $newamount = $count + 1;
    $sql = "UPDATE cart SET ammount = '$newamount' WHERE user_id = '$id' AND product_id = '$product_id'";
    $result = $conn->query($sql);

if ($loc == 'cart') {
    ?> 
<script>
    window.location.href='cart'
</script> 
<?php

} else {
?> 

<script>
    window.location.href='buy?id=cart'
</script> 
<?php
    }
    exit();
?>
