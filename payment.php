<?php 
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

if (!isset($_SESSION['user_id'])) {
    $firstLetter = "?";
    } else {
      $user_id = $_SESSION['user_id'];
      $username = $_SESSION['username'];
      $firstLetter = $username[0];
      $sql3 = "SELECT * FROM userdata WHERE username = '$username'";
      $result3 = $conn->query($sql3);
      $row7 = $result3->fetch_assoc();
      if ($row7['paid'] == 1) {
        header("Location: dashboard");
      }
      $username = $_SESSION['username'];
      $user_id = $_SESSION['user_id'];
      $firstLetter = $username[0];
      $sql3 = "SELECT * FROM cart WHERE user_id = '$user_id'";     
      $result3 = $conn->query($sql3);
      $totalQuantity = 0;
      while ($row3 = mysqli_fetch_assoc($result3)) {
          $totalQuantity += 1 * $row3['ammount'];
      }  
    }


    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliace: Seller</title>
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="account.css">
    <link rel="stylesheet" href="payment.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
</head>
<body>
  <div class="container">
    <nav>
      <ul>
        <li><a href="index" class="logo">
          <img src="logo.png" alt="">
        </a></li>
        <?php if ($row7['paid'] == 1) { ?>
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
        <li><a href="sales">
          <i class="fas fa-tag"></i>
          <span class="nav-item">Sales</span>
        </a></li>
        <li><a href="upload1">
          <i class="fas fa-upload"></i>
          <span class="nav-item">Upload</span>
        </a></li>
       <?php } else { ?>
        <li><a href="payment">
          <i class="fas fa-home"></i>
          <span class="nav-item">Become a Seller</span>
        </a></li> 
        <li><a href="account">
          <i class="fas fa-user"></i>
          <span class="nav-item">Profile</span>
        </a></li><?php } ?>
        
        <li><a href="settings">
          <i class="fas fa-cog"></i>
          <span class="nav-item">Settings</span>
        </a></li>
        <li><a href="help" class="help">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Help</span>
        </a></li>
        <li><a href="logout" class="logout">
          <i class="fas fa-upload"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
    <section class="main">
        <div class="main-top">
            <h1 class="blue">Become a Seller</h1>
            <div><a href="index">back</a></div>
        </div>
          <div class="payment-info">
          <table>
            <tr>
              <th></th>
              <th>Basic</th>
              <th>Premium</th>
              <th>Unlimited</th>
            </tr>
            <tr>
              <td>Cost</td>
              <td>2€</td>
              <td>3€</td>
              <td>5€</td>
            </tr>
            <tr>
              <td>Uploads</td>
              <td>5 per month</td>
              <td>15 per month</td>
              <td>Unlimited</td>
            </tr>
          </table>
        </div>
        <div class="payment-container">
          <button onclick="updatePlan('P-0UG17664U3493201WMRPGAUY')">Basic</button>
          <button>Premium</button>
          <button onclick="updatePlan('P-79L948441C508754FMRPF42Y')">Unlimited</button>
          <div>Selected plan:
            <div id="Plan"></div>
          </div>
          <div id="paypal-button-container"></div>
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

  <script src="https://www.paypal.com/sdk/js?client-id=AQP_JIGKW6ixciG6YhiL-JNY_Nom4AgDlbJtdvFEE2zADGavd53N94nbtMw5iQmutk2ZdQIQ2Sqxi0_6&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>
  var paypalSubscriptionButton = paypal.Buttons({
    style: {
      shape: 'rect',
      color: 'gold',
      layout: 'vertical',
      label: 'subscribe'
    },
    createSubscription: function(data, actions) {
      return actions.subscription.create({
        /* Creates the subscription */
        plan_id: document.getElementById('Plan').innerHTML
      });
    },
    onApprove: function(data, actions) {
      window.location.replace("https://ithelppp.000webhostapp.com/succses-abo?id=<?php echo $_SESSION['user_id']; ?>")
    }
  });

  function updatePlan(plan_id) {
    document.getElementById('Plan').innerHTML = plan_id;
    paypalSubscriptionButton.update();
  }

  // Render the default subscription button
  paypalSubscriptionButton.render('#paypal-button-container');
</script>


</body>
</html>
