<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');


// over everything here a credit card thing!!


$user_id = $_POST['user_id'];
$seller_id = $_POST['seller_id'];
$product_id = $_POST['product_id'];

$sql49 = "SELECT * FROM uploads WHERE upid = '$product_id'";
$result49 = $conn->query($sql49);
$row49 = $result49->fetch_assoc();

$titel = $row49['titel'];
$ammount = $_POST['ammount'];
$name = $_POST['name'];
$address = $_POST['address'];
$price = $_POST['price'];
$shipping = $_POST['shipping'];
$tax_rate = $_POST['tax_rate'];
$total_amount = $_POST['total_amount'];
$affiliate = $_POST['affiliate'];

if ($affiliate != '0') {
    echo $product_id;
    echo $seller_id; 
    $sql3 = "SELECT * FROM affliate_accept WHERE product_id = '$product_id' AND seller = '$seller_id'";
    $result3 = $conn->query($sql3);
    while ($row3 = mysqli_fetch_assoc($result3)) {
        $url = $row3['link'];
        $sql4 = "SELECT * FROM affliate_accept WHERE product_id = '$product_id' AND seller = '$seller_id' AND link = '$url'";
        $result4 = $conn->query($sql4);
        if ($result4) {
            
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        while ($row4 = mysqli_fetch_assoc($result4)) {
            $commission_id = $row4['user'];
            $commission = $row4['commission'];
            $affiliate_id = $row4['id'];
            $seller_id = $row4['seller'];
            $user_id = $row4['user'];
            $price2 = $price - (($price / 100) * $commission);
            $shipping2 = $shipping - (($shipping / 100) * $commission);
            $tax_rate2 = $tax_rate - (($tax_rate / 100) * $commission);
            $total_amount2 = $total_amount - (($total_amount / 100) * $commission);

            $sql = "INSERT INTO affiliate_orders (affiliate_id, total_price, commission_price, seller_id, user_id, 	commission)
            VALUES ('$affiliate_id', '$total_amount', '$total_amount2', '$seller_id', '$user_id', '$commission')";

            $sql2 = "INSERT INTO orders (order_id, user_id, seller_id, product_id, ammount, name, address, price, shipping, tax, total, time, status, way, titel) 
            VALUES ('0', '$user_id', '$seller_id', '$product_id', '$ammount', '$name', '$address', '$price2', '$shipping2', '$tax_rate2', '$total_amount2', NOW(), 'inprogress', 'affiliate', '$titel')";
            $result2 = $conn->query($sql2);

            $result = $conn->query($sql);
            if ($result) {
                header("Location: succses");
                exit();
            } else {
                // Query failed
                echo "Error: " . mysqli_error($conn);
            }
        }
    }    
} else {
    $sql = "INSERT INTO orders (order_id, user_id, seller_id, product_id, ammount, name, address, price, shipping, tax, total, time, status, way, titel)
    VALUES ('0', '$user_id', '$seller_id', '$product_id', '$ammount', '$name', '$address', '$price', '$shipping', '$tax_rate', '$total_amount', NOW(), 'inprogress', 'noaffiliate','$titel')";
    
    $result = $conn->query($sql);

    if ($result) {
        header("Location: succses");
        exit();
    } else {
        // Query failed
        echo "Error: " . mysqli_error($conn);
    }
}


?>