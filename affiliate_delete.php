<?php 

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$id = $_GET['id'];

$sql3 = "DELETE FROM affiliate WHERE id = $id";

if ($conn->query($sql3) === TRUE) {
    header("Location: affiliate");
} else {
    echo "Error deleting: " . $conn->error;
}

$conn->close();

?>