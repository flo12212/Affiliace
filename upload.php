<?php 

session_start();

$id = $_SESSION['user_id'];

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
        $previewFile = $_FILES['preview'];
        $previewFileName = $previewFile['name'];
        $previewFileTmpName = $previewFile['tmp_name'];
        $previewFileSize = $previewFile['size'];
        $previewFileError = $previewFile['error'];
        $previewFileType = $previewFile['type'];

        $previewFileExt = explode('.', $previewFileName);
        $previewFileActualExt = strtolower(end($previewFileExt));

        $allowed = array('jpg', 'png');

        $name = $_POST['name'];
        $description = str_replace("'", "''", $_POST['description']);
        $price = $_POST['price'];
        $link = $_POST['link'];
        $way = $_POST['way'];
        $catigory = $_POST['catigory'];
        $days = $_POST['days'];
        $hour = $_POST['hour'];
        $shipping = $_POST['shipping'];
        $currancy = $_POST['currancy'];

        $fileNames = array(); // initialize an empty array for file names
        foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['image']['name'][$key];
            $fileTmpName = $_FILES['image']['tmp_name'][$key];
            $fileSize = $_FILES['image']['size'][$key];
            $fileError = $_FILES['image']['error'][$key];
            $fileType = $_FILES['image']['type'][$key];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = 'videos/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $fileNames[] = $fileNameNew; // add file name to the array
                } 
            } 
        } 
        $fileNamesStr = implode(',', $fileNames); // concatenate the file names with comma

        if (in_array($previewFileActualExt, $allowed)) {
            if ($previewFileError === 0) {
                $previewFileNameNew = uniqid('', true) . "." . $previewFileActualExt;
                $previewFileDestination = 'videos/' . $previewFileNameNew;
                move_uploaded_file($previewFileTmpName, $previewFileDestination);
                $null = 0;
                $sql = "INSERT INTO uploads (id, titel, price, description, preview, images, link, way, catigory, views, bought, shipping, currancy, ship_days, ship_hours, brand, conditionn)
                VALUES ('$id', '$name', '$price', '$description', '$previewFileDestination', '$fileNamesStr', '$link', '$way', '$catigory', '$null', '$null', '$shipping', '$currancy', '$days', '$hour', '$null', '$null')";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Query failed: " . mysqli_error($conn) . $sql);
                }else {
                    header("Location: index");
                }
            } else {
                echo "Error1";
            }
        } else {
            echo "Not allowd format of file!";
        }
    } else {
        echo "Error3";
    }
?>