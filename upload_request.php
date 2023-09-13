<?php
$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

if (isset($_POST['user_id']) && isset($_POST['product_id'])) {
  $user_id = $_POST['user_id'];
  $product_id = $_POST['product_id'];
  $seller_id = $_POST['seller_id'];
  $username = $_POST['username'];

  $sql = "SELECT * FROM requests WHERE product_id = '$product_id' AND user_id = '$user_id' AND seller_id = '$seller_id' AND username = '$username'";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    header("Location: affiliate");
  } else {
      



      $sql2 = "INSERT INTO requests (product_id, user_id, seller_id, username) VALUES ('$product_id', '$user_id', '$seller_id', '$username')";
  
    if ($conn->query($sql2)) {
      header("Location: affiliate");
    } else {
      echo "Error executing SQL query: " . $conn->error;
    }
  }




} else {
  echo "Missing user_id or product_id.";
}
?>