<?php

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

// Retrieve the number from the POST data
$id = $_POST['number'];

$sql1 = "SELECT views FROM uploads WHERE upid = '$id' ";
mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
$views = $row['views'];

$number = $views + 1;

$sql2 = mysqli_query($conn, "UPDATE uploads SET views = '' WHERE upid = '$id'");

$sql3 = "UPDATE uploads SET views = ('$number') WHERE upid = '$id'";

if (mysqli_query($conn, $sql)) {
  echo "Number inserted successfully";
} else {
  echo "Error inserting number: " . mysqli_error($conn);
}
mysqli_close($conn);
?>
