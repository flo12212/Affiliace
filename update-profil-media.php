<?php 

$user_id = $_GET['id'];

$instagram = $_POST['instagram'];
$tiktok = $_POST['tiktok'];
$twitter = $_POST['twitter'];
$facebook = $_POST['facebook'];
$youtube = $_POST['youtube'];
$whatsapp = $_POST['whatsapp'];
$linkedin = $_POST['linkedin'];
$snapchat = $_POST['snapchat'];
$reddit = $_POST['reddit'];

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$sql = "UPDATE userdata SET instagram = '$instagram', tiktok = '$tiktok', twitter = '$twitter', facebook = '$facebook', youtube = '$youtube', whatsapp = '$whatsapp', linkedin = '$linkedin', snapchat = '$snapchat', reddit = '$reddit' WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result) {
    header('Location: account');
    exit;
} else {
    echo "Error updating profile: " . mysqli_error($conn);
}

mysqli_close($conn);

?>