<?php 

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();
$id = $_GET['id'];

if (!isset($_SESSION['user_id'])) {
        //back and error massege: you schoukld be logged in 
    }
$name = $_SESSION['username'];
$rewiew = $_POST["rewiew"];
$rating = $_POST["rating"];

$sql = "INSERT INTO rewievs (product_id, username, rewiev, stars, time) VALUES ('$id', '$name', '$rewiew', '$rating', NOW())";
$conn->query($sql);

if(mysqli_affected_rows($conn) > 0) {
    header('Location:product?id=' . $id);
} else {
    //error message
}

$conn->close();
?>
