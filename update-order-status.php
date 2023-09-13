<?php 

$status = $_GET['status'];
$id = $_GET['id'];

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$sql = "UPDATE orders SET `status` = '$status' WHERE id = '$id'";
$result = $conn->query($sql);

if ($result) {
    header('Location: orders');
    exit;
} else {
    echo "Error updating profile: " . mysqli_error($conn);
}

mysqli_close($conn);

?>