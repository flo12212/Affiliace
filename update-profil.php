<?php 

$user_id = $_GET['id'];

// Retrieve the form data
$name = $_POST['name'];
$email = $_POST['email'];
$company = $_POST['company'];
$address = $_POST['address'];
$zip = $_POST['zip'];
$city = $_POST['city'];
$country = $_POST['country'];
$website = $_POST['website'];
$no_file_upload = $_POST['no_file_upload'];

$fileName = $_FILES["file-upload"]["name"];
$tmpLocation = $_FILES["file-upload"]["tmp_name"];

if (empty($fileName)) {
    $fileName = $no_file_upload;
  }

// Specify the target location to move the file
$targetLocation = "C:/xampp/htdocs/Affilate Marketing Website - Online2/profilpictures/" . $fileName;
move_uploaded_file($tmpLocation, $targetLocation);

// Perform the database update
$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$sql = "UPDATE userdata SET username = '$name', email = '$email', company = '$company', address = '$address', zip = '$zip', city = '$city', country = '$country', profilpicture	= '$fileName', website = '$website' WHERE id = '$user_id'";
$result = $conn->query($sql);

// Check if the update was successful
if ($result) {
    // Redirect the user back to the account page
    header('Location: account');
    exit;
} else {
    // Handle the update error
    echo "Error updating profile: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);

?>