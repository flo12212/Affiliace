<?php 

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$firstLetter = $username[0];
$sql3 = "SELECT * FROM userdata WHERE username = '$username'";
$result3 = $conn->query($sql3);
$row7 = $result3->fetch_assoc(); 
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$firstLetter = $username[0];
$sql3 = "SELECT * FROM cart WHERE user_id = '$user_id'";     
$result3 = $conn->query($sql3);
$totalQuantity = 0;
while ($row3 = mysqli_fetch_assoc($result3)) {
    $totalQuantity += 1 * $row3['ammount'];
}






$currencyFormats = array(
    'en' => array('symbol' => '$', 'position' => 'before', 'equivalent' => 1.13),
    'eur' => array('symbol' => '€', 'position' => 'after', 'equivalent' => 1),
    'pt' => array('symbol' => 'R$', 'position' => 'before', 'equivalent' => 0.86),
    'jp' => array('symbol' => '¥', 'position' => 'before', 'equivalent' => 131.97),
    'cn' => array('symbol' => '¥', 'position' => 'before', 'equivalent' => 7.97),
    'ru' => array('symbol' => '₽', 'position' => 'after', 'equivalent' => 87.49),
    'kr' => array('symbol' => '₩', 'position' => 'before', 'equivalent' => 1331.13),
    'in' => array('symbol' => '₹', 'position' => 'before', 'equivalent' => 81.47),
    );


$sql = "SELECT * FROM uploads WHERE id = '$user_id'";
$sql2 = "SELECT * FROM userdata WHERE id = '$user_id'";
$sql3 = "SELECT * FROM orders WHERE seller_id = '$user_id'";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

$sql5 = "SELECT * FROM orders WHERE seller_id = '$user_id' AND `status` IN ('inprogress', 'preparation', 'shipment', 'traveling')";
$result5 = $conn->query($sql5);

$sql7 = "SELECT * FROM orders WHERE seller_id = '$user_id' AND `status` IN ('finished', 'delivered')";
$result7 = $conn->query($sql7);


$row2 = $result2->fetch_assoc();


      while($row3 = $result->fetch_assoc()) { 
        
          } 
          
          
 $total_price1 = 0;
 $total_price2 = 0;
 $total_price3 = 0;
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row2['company']; ?>: Orders</title>
    <link rel="stylesheet" href="orders.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
    .course-box {
      display: none;
    }

    .course-box.active {
      display: block;
    }
  </style>
</head>
<body>
  <div class="container">
  <div class="modal-bg" id="modal">
      <button id="closeButton" style="display: none;"><img src="arrow2.png" alt=""></button>
      <nav id="targetElement">
      <ul>
      <li>
      <?php 
          if (!empty($row2['website']) && strlen($row2['website']) > 0) {
            ?>
            <a href="<?php echo $row2['website']; ?>" target="_blank"> <?php
            } else { ?>
              <a href="index"> <?php 
            } ?>

          
            <div class="center2">
              <?php if (!empty($row2['profilpicture'])) {
                ?>
                <img src="profilpictures/<?php echo $row2['profilpicture']; ?>" alt=""  class="logo1">
                <?php
              } else { ?>
                  <img src="logo.png" class="logo1">
              <?php } ?>
              
            </div>
          </a></li>
          <li><a href="dashboard">
          <i class="fas fa-chart-line"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="account">
          <i class="fas fa-user"></i>
          <span class="nav-item">Profile</span>
        </a></li>
        <li><a href="orders" style="background-color: #c5d5fd;">
          <i class="fas fa-wallet"></i>
          <span class="nav-item">Orders</span>
        </a></li>
        <li><a href="sales">
          <i class="fas fa-tag"></i>
          <span class="nav-item">Sales</span>
        </a></li>
        <li><a href="upload1">
          <i class="fas fa-upload"></i>
          <span class="nav-item">Upload</span>
        </a></li>
        <li><a href="affiliate">
          <i class="fas fa-dollar-sign"></i>
          <span class="nav-item">Affiliate</span>
        </a></li>
        <li><a href="product-view">
          <i class="fas fa-shopping-cart"></i>
          <span class="nav-item">Products</span>
        </a></li>
        <li><a href="help" class="help" id="help">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Help</span>
        </a></li>
        <li><a href="logout" class="logout" id="logout">
        <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
  </div>

  <script>
  window.addEventListener('scroll', function() {
    const stickyDiv = document.getElementById('help');
    const myDiv = document.getElementById('main');
    const viewportHeight = window.innerHeight;

    if (window.scrollY >= myDiv.offsetTop + myDiv.offsetHeight - viewportHeight) {
      stickyDiv.style.position = 'absolute';
      stickyDiv.style.bottom = '340';
    } else {
      stickyDiv.style.position = 'fixed';
      stickyDiv.style.bottom = '40';
    }
  });
</script>

<script>
  window.addEventListener('scroll', function() {
    const logoutDiv = document.getElementById('logout');
    const myDiv2 = document.getElementById('main');
    const viewportHeight2 = window.innerHeight;

    if (window.scrollY >= myDiv2.offsetTop + myDiv2.offsetHeight - viewportHeight2) {
      logoutDiv.style.position = 'absolute';
      logoutDiv.style.bottom = '340';
    } else {
      logoutDiv.style.position = 'fixed';
      logoutDiv.style.bottom = '0';
    }
  });
</script>

    <section class="main" id="main">
      <div class="main-top">
        <h1 class="blue">Order Settings</h1>
        <div><a href="index" class="a">back</a></div>
      </div>
      <button id="changePositionButton"><img src="arrow.png"></button>
      <section class="main-course">
        <div class="course-box active" id="orders">
          <h1 class="blue">Orders</h1>
          <ul>
            <li class="active" onclick="showCourseBox(0)">orders</li>
            <li onclick="showCourseBox(1)">In progress</li>
            <li onclick="showCourseBox(2)">finished</li>
          </ul>
          <div class="orders">
            <?php if ($result3->num_rows > 0) { ?>
            <table>
              <thead>
                  <tr>
                      <th>Order ID</th>
                      <th>Customer</th>
                      <th>Order</th>
                      <th>Delivery Date</th>
                      <th>Price</th>
                      <th>Ammount</th>
                      <th>Delivery Status</th>
                      <th>Payment</th>
                      <th>Bill</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                    <?php 
                    
                      while($row3 = $result3->fetch_assoc()) {
                        $product_id = $row3['product_id'];
                        $sql4 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                        $result4 = mysqli_query($conn, $sql4);
                          while ($row4 = mysqli_fetch_assoc($result4)) {
                        ?>
                          <tr>
                      <?php   $total = $row3['total'];
                              $price = $row3['price'];
                              $ammount = $row3['ammount'];
                              $shipping = $row3['shipping'];
                              $tax = $row3['tax'];
                            
                              $tax_amount = $price * $ammount * $tax;
                              $total_price1 = $price * $ammount + $tax_amount + $shipping;
                              
                              $rounded_total_price = round($total_price1, 2);
                              $commission_price = $rounded_total_price * 0.2;
                              $user_price = round($rounded_total_price - $commission_price, 2);
                              
                              $formatted_commission_price = number_format(round($commission_price, 2), 2, ',', '.');
                              $formatted_user_price = number_format(round($user_price, 2), 2, ',', '.');
                              $formatted_total_price1 = number_format($total, 2, ',', '.'); ?>

                              <td><?php echo $row3['id']; ?></td>
                              <td><?php echo $row3['name']; ?></td>
                              <td><?php echo $row4['titel']; ?></td>
                              <td><?php echo $row3['time']; ?></td>
                              <td><?php echo $formatted_total_price1; ?> €</td>
                              <td><?php echo $row3['ammount']; ?></td>


                              <?php $buttonId = 'button_' . $row3['id']; 
                                    $overlayId = 'overlay_' . $row3['id'];
                                    $popupId = 'popup_' . $row3['id']; ?>
                              
                                <div id="<?php echo $overlayId; ?>" class="overlay"></div>
                                <div id="<?php echo $popupId; ?>" class="popup">
                                  <h1 class="blue"><?php echo $row4['titel'] . "|" . $row3['name'] ; ?></h1>
                                  <div>Current: <?php echo $row3['status']; ?></div>
                                  <div class="flex">
                                    <div class="block">
                                      <a href="update-order-status?status=delivered&id=<?php echo $row3['id']; ?>"><button class="green">Delivered</button></a>
                                      <a href="update-order-status?status=finished&id=<?php echo $row3['id']; ?>"><button class="green">Finished</button></a>
                                    </div>
                                    <div class="block">
                                      <a href="update-order-status?status=inprogress&id=<?php echo $row3['id']; ?>"><button class="yellow">In Progress</button></a>
                                      <a href="update-order-status?status=preparation&id=<?php echo $row3['id']; ?>"><button class="yellow">Shipping preparation</button></a>
                                      <a href="update-order-status?status=shipment&id=<?php echo $row3['id']; ?>"><button class="yellow">Shipment</button></a>
                                      <a href="update-order-status?status=traveling&id=<?php echo $row3['id']; ?>"><button class="yellow">Traveling</button></a>
                                    </div>
                                    <div class="block">
                                      <a href="update-order-status?status=failed&id=<?php echo $row3['id']; ?>"><button class="red">Failed</button></a>
                                    </div>
                                  </div>
                                </div>


                              <?php if ($row3['status'] == "finished" || $row3['status'] == "delivered") { ?>
                                <td><button style="font-size: 5px; border-radius: 10px; padding: 5px;" id="<?php echo $buttonId; ?>" class="green2"><?php echo $row3['status']; ?></button></td><?php
                              } if ($row3['status'] == "inprogress" || $row3['status'] == "shipment" || $row3['status'] == "traveling" || $row3['status'] == "preparation") { ?>
                                <td><button style="font-size: 5px; border-radius: 10px; padding: 5px;" id="<?php echo $buttonId; ?>" class="yellow2"><?php echo $row3['status']; ?></button></td><?php
                              } if ($row3['status'] == "failed") { ?>
                                <td><button style="font-size: 5px; border-radius: 10px; padding: 5px;" id="<?php echo $buttonId; ?>" class="red2"><?php echo $row3['status']; ?></button></td><?php
                              } ?>
                              <td>Paypal</td>
                              <td>
                                <form action="generate_pdf" method="post">
                                    <input type="hidden" name="name" value="<?php echo $row3['name']; ?>">
                                    <input type="hidden" name="titel"  value="<?php echo $row4['titel']; ?>">
                                    <input type="hidden" name="time" value="<?php echo $row3['time']; ?>">
                                    <input type="hidden" name="price" value="<?php echo $formatted_total_price1 . " €"; ?>">
                                    <input type="hidden" name="way" value="<?php echo "Paypal"; ?>">
                                    <button type="submit" style="font-size: 7px;" name="download_pdf">Download PDF</button>
                                </form>
                              </td>
                              <script>
                                    // JavaScript code for handling button click and overlay click for this specific button and pop-up div
                                    var button_<?php echo $buttonId; ?> = document.getElementById('<?php echo $buttonId; ?>');
                                    var overlay_<?php echo $overlayId; ?> = document.getElementById('<?php echo $overlayId; ?>');
                                    var popup_<?php echo $popupId; ?> = document.getElementById('<?php echo $popupId; ?>');

                                    button_<?php echo $buttonId; ?>.addEventListener('click', function() {
                                        overlay_<?php echo $overlayId; ?>.style.display = 'block';
                                        popup_<?php echo $popupId; ?>.style.display = 'block';
                                        document.body.style.overflow = 'hidden';
                                    });

                                    overlay_<?php echo $overlayId; ?>.addEventListener('click', function() {
                                        overlay_<?php echo $overlayId; ?>.style.display = 'none';
                                        popup_<?php echo $popupId; ?>.style.display = 'none';
                                        document.body.style.overflow = 'auto';
                                    });
                                </script>


                              
                              
                      <?php } } ?>
                      </tbody>
              </table> <?php
                      } else {
                        echo "no orders until now";
                      } ?>
                  
          </div>
        </div>

        <div class="course-box" id="inProgress">
          <h1 class="blue">Orders In progress</h1>
          <ul>
            <li onclick="showCourseBox(0)">orders</li>
            <li class="active" onclick="showCourseBox(1)">In progress</li>
            <li onclick="showCourseBox(2)">finished</li>
          </ul>
          <div class="orders">
            <?php if ($result5->num_rows > 0) { ?>
            <table>
              <thead>
                  <tr>
                      <th>Order ID</th>
                      <th>Customer</th>
                      <th>Order</th>
                      <th>Delivery Date</th>
                      <th>Price</th>
                      <th>Delivery Status</th>
                      <th>Payment</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php while($row5 = $result5->fetch_assoc()) {
                        $product_id = $row5['product_id'];
                        $sql6 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                        $result6= mysqli_query($conn, $sql6);
                        while ($row6 = mysqli_fetch_assoc($result6)) {
                        ?>

                          <tr>

                      <?php   $total2 = $row5['total'];
                              $price2 = $row5['price'];
                              $ammount2 = $row5['ammount'];
                              $shipping2 = $row5['shipping'];
                              $tax2 = $row5['tax'];
                            
                              $tax_amount2 = $price2 * $ammount2 * $tax2;
                              $total_price2 = $price2 * $ammount2 + $tax_amount2 + $shipping2;
                              
                              $rounded_total_price = round($total_price2, 2);
                              $commission_price = $rounded_total_price * 0.2;
                              $user_price = round($rounded_total_price - $commission_price, 2);
                              
                              $formatted_commission_price = number_format(round($commission_price, 2), 2, ',', '.');
                              $formatted_user_price = number_format(round($user_price, 2), 2, ',', '.');
                              $formatted_total_price2 = number_format($total2, 2, ',', '.'); ?>

                              <td><?php echo $row5['id']; ?></td>
                              <td><?php echo $row5['name']; ?></td>
                              <td><?php echo $row6['titel']; ?></td>
                              <td><?php echo $row5['time']; ?></td>
                              <td><?php echo $formatted_total_price2; ?> €</td>
                              <td class="yellow"><?php echo $row5['status']; ?></td>
                              <td>Paypal</td>
                              </tr>
                      <?php } } ?>
                  </tbody>
              </table>
              <?php } else {
                echo "no progress orders";
              } ?>
          </div>
        </div>



        <div class="course-box" id="finished">
          <h1 class="blue">finished Orders</h1>
          <ul>
            <li onclick="showCourseBox(0)">orders</li>
            <li onclick="showCourseBox(1)">In progress</li>
            <li class="active" onclick="showCourseBox(2)">finished</li>
          </ul>
          <div class="orders">
            <?php if ($result7->num_rows > 0) { ?>
          <table>
              <thead>
                  <tr>
                      <th>Order ID</th>
                      <th>Customer</th>
                      <th>Order</th>
                      <th>Delivery Date</th>
                      <th>Price</th>
                      <th>Delivery Status</th>
                      <th>Payment</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php while($row7 = $result7->fetch_assoc()) {
                        $product_id = $row7['product_id'];
                        $sql8 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                        $result8= mysqli_query($conn, $sql8);
                        while ($row8 = mysqli_fetch_assoc($result8)) {
                        ?>

                          <tr>

                      <?php   $total3 = $row7['total'];
                              $price3 = $row7['price'];
                              $ammount3 = $row7['ammount'];
                              $shipping3 = $row7['shipping'];
                              $tax3 = $row7['tax'];
                            
                              $tax_amount3 = $price3 * $ammount3 * $tax3;
                              $total_price3 = $price3 * $ammount3 + $tax_amount3 + $shipping3;
                              
                              $rounded_total_price = round($total_price3, 2);
                              $commission_price = $rounded_total_price * 0.2;
                              $user_price = round($rounded_total_price - $commission_price, 2);
                              
                              $formatted_commission_price = number_format(round($commission_price, 2), 2, ',', '.');
                              $formatted_user_price = number_format(round($user_price, 2), 2, ',', '.');
                              $formatted_total_price3 = number_format($total3, 2, ',', '.'); ?>

                              <td><?php echo $row7['id']; ?></td>
                              <td><?php echo $row7['name']; ?></td>
                              <td><?php echo $row8['titel']; ?></td>
                              <td><?php echo $row7['time']; ?></td>
                              <td><?php echo $formatted_total_price3; ?> €</td>
                              <td class="green"><?php echo $row7['status']; ?></td>
                              <td>Paypal</td>
                              </tr>
                      <?php } } ?>
                  </tbody>
              </table>
              <?php } else {
                echo "no finished orders";
              } ?>
          </div>
        </div>
      </section>
    </section>
  </div>


<footer class="footer">
  	 <div class="footer-container">
  	 	<div class="footer-row">
  	 		<div class="footer-col">
  	 			<h4>company</h4>
  	 			<ul>
  	 				<li><a href="#">about us</a></li>
  	 				<li><a href="#">our services</a></li>
  	 				<li><a href="#">privacy policy</a></li>
  	 				<li><a href="footer/affiliate.html">affiliate program</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>get help</h4>
  	 			<ul>
  	 				<li><a href="#">FAQ</a></li>
  	 				<li><a href="#">shipping</a></li>
  	 				<li><a href="#">returns</a></li>
  	 				<li><a href="#">order status</a></li>
  	 				<li><a href="#">payment options</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>online shop</h4>
  	 			<ul>
  	 				<li><a href="search?query=watch">watch</a></li>
  	 				<li><a href="search?query=bag">bag</a></li>
  	 				<li><a href="search?query=shoes">shoes</a></li>
  	 				<li><a href="search?query=dress">dress</a></li>
  	 			</ul>
  	 		</div>
  	 		<div class="footer-col">
  	 			<h4>follow us</h4>
  	 			<div class="social-links">
  	 				<a href="#"><i class="fab fa-facebook-f"></i></a>
  	 				<a href="#"><i class="fab fa-twitter"></i></a>
  	 				<a href="https://www.instagram.com/affiliace.marketplace/" target="_blank"><i class="fab fa-instagram"></i></a>
  	 				<a href="https://www.tiktok.com/@affiliace" target="_blank"><i class="fab fa-tiktok"></i></a>
  	 			</div>
  	 		</div>
  	 	</div>
  	 </div>
  </footer>
  <script>
    function showCourseBox(index) {
      // Hide all course boxes
      const courseBoxes = document.getElementsByClassName('course-box');
      for (let i = 0; i < courseBoxes.length; i++) {
        courseBoxes[i].classList.remove('active');
      }

      // Show the selected course box
      courseBoxes[index].classList.add('active');
    }
  </script>
  <script>
        // JavaScript to handle the button click event
        const element = document.getElementById("targetElement");
        const button = document.getElementById("changePositionButton");
        const closeButton = document.getElementById("closeButton");
        const modal = document.getElementById("modal");
        

        changePositionButton.addEventListener("click", function () {
            element.classList.toggle("absolute");
            closeButton.style.display = "block";
            button.style.display = "none";
            modal.style.display = 'block';
        });

        closeButton.addEventListener("click", function () {
            element.classList.remove("absolute");
            closeButton.style.display = "none"; // Hide the close button when closing
            button.style.display = "block";
            modal.style.display = 'none';
        });
    </script>



  </body>
</html>