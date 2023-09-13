<?php 
if (isset($_POST['count'])) {
  $count = $_POST['count']; // Get the updated count value

  // Update the count in the database
  // Adapt the code to fit your database structure
  $sql = "UPDATE cart SET ammount = '$count'";
  $result = $conn->query($sql);

  header("Location: buy") }

?>