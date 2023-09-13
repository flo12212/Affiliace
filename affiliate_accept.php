<?php

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['seller']) && isset($_POST['user']) && isset($_POST['product_id']) && isset($_POST['commission'])) {
  $seller = $_POST['seller'];
  $user = $_POST['user'];
  $product_id = $_POST['product_id'];
  $commission = $_POST['commission'];

  $sql = "SELECT * FROM affliate_accept WHERE seller = '$seller' AND user = '$user' AND product_id = '$product_id'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    header("Location: affiliate");
  } else {
    // Move the function definition outside the else block
    function generateRandomCode() {
      $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $codeLength = 8;
      $randomCode = '';

      for ($i = 0; $i < $codeLength; $i++) {
        $randomCode .= $characters[rand(0, strlen($characters) - 1)];
      }

      return $randomCode;
    }

    $sql4 = "SELECT * FROM affliate_accept";
    $result4 = $conn->query($sql4);

    while ($row = $result4->fetch_assoc()) {
      $url = $row['link'];

      // Extract the query string from the URL
      $queryString = parse_url($url, PHP_URL_QUERY);

      // Parse the query string into an associative array
      parse_str($queryString, $params);

      // Get the value of the 'affiliate' parameter
      $affiliate = isset($params['affiliate']) ? $params['affiliate'] : null;

      // Remove any surrounding quotes from the affiliate value
      $affiliate = trim($affiliate, '"');
      $existingCodes[] = $affiliate;
    }

    do {
      $randomCode = generateRandomCode();
      $link = 'https://ithelppp.000webhostapp.com/product?id=' . $product_id . '&affiliate=' . $randomCode;

      $sql2 = "INSERT INTO affliate_accept (product_id, user, seller, link, commission) VALUES ('$product_id', '$user', '$seller', '$link', '$commission')";
      if ($conn->query($sql2)) {
        $sql3 = "DELETE FROM requests WHERE product_id = '$product_id' AND user_id = '$user' AND seller_id = '$seller'";
        if ($conn->query($sql3)) {
          header("Location: affiliate");
        } else {
          echo "Error executing SQL query: " . $conn->error;
        }
      } else {
        echo "Error executing SQL query: " . $conn->error;
      }
    } while (in_array($randomCode, $existingCodes));
  }
} else {
  echo "Missing user, seller, or product_id.";
}
?>
