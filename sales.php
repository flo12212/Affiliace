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
while ($row6 = mysqli_fetch_assoc($result3)) {
    $totalQuantity += 1 * $row6['ammount'];
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



$sql2 = "SELECT * FROM userdata WHERE id = '$user_id'";

$result2 = $conn->query($sql2);


$row2 = $result2->fetch_assoc();

 $total_price = 0; //use this in the  paycheck!!

 
$sql6 = "SELECT * FROM orders WHERE seller_id = '$user_id'";
$result6 = $conn->query($sql6);

$sql5 = "SELECT * FROM orders WHERE seller_id = '$user_id'";
$result5 = $conn->query($sql5);

if (!$result6) {
  die("Query failed: " . $conn->error);
}

$sql12 = "SELECT * FROM affiliate_orders WHERE user_id = '$user_id'";
$result12 = $conn->query($sql12);
$affilaite_commission_price = 0;

while ($row6 = $result6->fetch_assoc()) {
  $total_price += $row6['total'];
}
$commision_price = $total_price * 0.2;
$user_price = $total_price - $commision_price;
$formatted_commission_price = number_format($commision_price, 2);
$formatted_user_price = number_format($user_price, 2);
$formatted_total_price = number_format($total_price, 2);
  
            
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row2['company']; ?>: Sales</title>
    <link rel="stylesheet" href="sales.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
        <li><a href="orders">
          <i class="fas fa-wallet"></i>
          <span class="nav-item">Orders</span>
        </a></li>
        <li><a href="sales" style="background-color: #c5d5fd;">
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
        <h1 class="blue">Sales</h1>
        <div><a href="index" class="a">back</a></div>
      </div>
      <button id="changePositionButton"><img src="arrow.png"></button>
      <div class="main-skills">
        <div class="card">
          <h1 class="blue">Total Sales</h1>
          <div class="div"><?php echo $formatted_user_price . " €"; ?></div>
          <from>
            <button>Paycheck from 10€</button>
          </from>
        </div>
        <div class="card">
          <div class="font">
            <h1  class="blue">Sales</h1>
            <div class="bottom-border">
              <div>Sales: <?php echo $formatted_total_price . " €"; ?></div>
              <div>Commission: <?php echo $formatted_commission_price . " €"; ?></div>
            </div>
            <div>
              <div>Total: <?php echo $formatted_user_price . " €"; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="course-box">
        <div class="orders">
            <h1 class="blue">Total Sales</h1>
            <?php if ($result5->num_rows > 0) { ?>
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
                    </tr>
                </thead>
                <tbody>
                    <?php while($row5 = $result5->fetch_assoc()) {
                        $product_id = $row5['product_id'];
                        $total = $row5['total'];
                        $price = $row5['price'];
                        $ammount = $row5['ammount'];
                        $shipping = $row5['shipping'];
                        $tax = $row5['tax'];

                        $tax_amount = $price * $ammount * $tax;
                        $total_price1 = $price * $ammount + $tax_amount + $shipping;

                        $rounded_total_price = round($total_price1, 2);
                        $commission_price = $rounded_total_price * 0.2;
                        $user_price = round($rounded_total_price - $commission_price, 2);

                        $formatted_commission_price = number_format(round($commission_price, 2), 2, ',', '.');
                        $formatted_user_price = number_format(round($user_price, 2), 2, ',', '.');
                        $formatted_total_price1 = number_format($total_price1, 2, ',', '.');

                        // Fetch product details outside the loop
                        $sql49 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                        $result49 = $conn->query($sql49);
                        $row49 = $result49->fetch_assoc();
                    ?>
                    <tr>
                        <td><?php echo $row5['id']; ?></td>
                        <td><?php echo $row5['name']; ?></td>
                        <td><?php echo $row5['titel']; ?></td>
                        <td><?php echo $row5['time']; ?></td>
                        <td><?php echo $formatted_total_price1; ?> €</td>
                        <td><?php echo $row5['ammount']; ?></td>
                        <td class="green"><?php echo $row5['status']; ?></td>
                        <td>Paypal</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } else { 
              echo "No Sales Yet."; ?>
              <a href="upload"></a>
              <?php
              }
              ?>
        </div>
    </div>
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