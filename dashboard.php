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

    $text = "finished";
    $text3 = "delivered";


    $text2 = "inprogress";
    $text4 = "preparation";
    $text5 = "shipment";
    $text6 = "traveling";


$sql = "SELECT * FROM uploads WHERE id = '$user_id'";
$sql2 = "SELECT * FROM userdata WHERE id = '$user_id'";
$sql3 = "SELECT * FROM orders WHERE user_id = '$user_id' AND `status` = '$text2' OR `status` = '$text4'OR `status` = '$text5'OR `status` = '$text6'";
$sql4 = "SELECT * FROM orders WHERE status = '$text' OR `status` = '$text3' AND user_id = '$user_id'";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
$result5 = $conn->query($sql4);

$row2 = $result2->fetch_assoc();


$total_price = 0;



$sql6 = "SELECT * FROM orders WHERE seller_id = '$user_id'";
$result6 = $conn->query($sql6);

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
    <title><?php echo $row2['company']; ?>: Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
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
            <li><a href="dashboard" style="background-color: #c5d5fd;">
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
          <li><a href="affiliate">
            <i class="fas fa-dollar-sign"></i>
            <span class="nav-item">Affiliate</span>
          </a></li>
          <li><a href="product-view">
            <i class="fas fa-shopping-cart"></i>
            <span class="nav-item">Products</span>
          </a></li>
          <li><a href="help" class="help">
            <i class="fas fa-question-circle"></i>
            <span class="nav-item">Help</span>
          </a></li>
          <li><a href="logout" class="logout">
          <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Log out</span>
          </a></li>
        </ul>
      </nav>
    </div>

    <section class="main">
      <div class="main-top">
        <h1 class="blue">Dashboard</h1>
        <div><a class="a" href="index">back</a></div>
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
            <h1 class="blue">Sales</h1>
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

      <section class="main-course">
        <div class="course-box" id="orders">
          <h1 class="blue">Orders</h1>
          <div class="content" id="content0">
            <ul>
              <li class="active" onclick="toggleContent(0)">In progress</li>
              <li onclick="toggleContent(1)">finished</li><ul>
              </ul>
            </ul>
            <div class="orders">
              <?php  if ($result3->num_rows > 0) { ?>
              <table>
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Address</th>
                          <th>Time</th>
                          <th>Product</th>
                      </tr>
                      </thead>
                      <tbody>
                        
                          <?php $counter1 = 0;
                          while($row3 = $result3->fetch_assoc()) { 
                            if ($counter1 < 2) {?>
                              <tr>
                                  <td><?php echo $row3['name']; ?></td>
                                  <td><?php echo $row3['address']; ?></td>
                                  <td><?php echo $row3['time']; ?></td>
                                  <td><?php echo $row3['product_id']; ?><a href="product?id=<?php echo $row3['product_id']; ?>">view</a></td>
                                  </tr>
                          <?php $counter1++; } else {
                            break;
                        } }?>
                      </tbody>
                  </table>
                  <a class="blue" href="orders">Orders</a>
                  <?php } else {
                    echo "no orders availiavle for processing.";
                  } ?>
            </div>
          </div>
          <div class="content" id="content1">
            <ul>
              <li onclick="toggleContent(0)">In progress</li>
              <li class="active" onclick="toggleContent(1)">finished</li>
            </ul>
            <div class="orders">
              <?php  if ($result5->num_rows > 0) { ?>
                <table>
                  <thead>
                    <tr>
                      <th>Bestellnummer</th>
                      <th>Artikel</th>
                      <th>Preis</th>
                      <th>Lieferadresse</th>
                      <th>Lieferdatum</th>
                      <th>Bestellstatus</th>
                      <th>Problems</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                    $counter = 0;

                    while ($row5 = $result5->fetch_assoc()) {
                      $product_id = $row5['product_id'];
                      $sql9 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                      $result9 = $conn->query($sql9);
                      while ($row9 = $result9->fetch_assoc()) {
                        if ($counter < 3) {
                            ?>
                            <tr>
                                  <td><?php echo $row5['id']; ?></td>
                                  <td><?php echo $row9['titel']; ?></td>
                                  <td><?php echo $row9['price']; ?> €</td>
                                  <td><?php echo $row5['address']; ?></td>
                                  <td>20.06.2023</td>
                                  <td><?php echo $row5['status']; ?></td>
                                  <td><a href="product?id=<?php echo $row3['product_id']; ?>">Problem</a></td>
                              </tr>
                            <?php
                            $counter++;
                        } else {
                            break;
                        }
                    } } } else {
                      echo "no finished orders.";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <a class="blue" href="sales">Sales</a>
          </div>
          
        </div>
        
        <div class="course-box">
        <h1 class="blue">Earnings (6 months)</h1>
            <div class="chart">
                <canvas id="lineChart" height="48"></canvas>
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

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <?php 
$sql8 = "SELECT * FROM orders WHERE seller_id = '$user_id'";
$result8 = mysqli_query($conn, $sql8);
$earningsTotal = 0;
$earningsByMonth = [];

while ($row8 = mysqli_fetch_assoc($result8)) {
  $total_price = $row8['total'];

  $earningsTotal += $total_price;

  $commision_price = $total_price * 0.2;
  $user_price = $total_price - $commision_price;

  $earnings = $user_price;
  $timestamp = $row8['time'];

  $month = date('m', strtotime($timestamp));
  $year = date('Y', strtotime($timestamp));

  if (!isset($earningsByMonth[$year])) {
    $earningsByMonth[$year] = [];
  }

  if (!isset($earningsByMonth[$year][$month])) {
    $earningsByMonth[$year][$month] = 0;
  }

  $earningsByMonth[$year][$month] += $earnings;
}

$monthsList = [];
$earningsList = [];

// Check if $earningsByMonth array is defined and not empty
if (isset($earningsByMonth) && !empty($earningsByMonth)) {
  // Loop through the earnings by month and populate the arrays
  foreach ($earningsByMonth as $year => $months) {
    foreach ($months as $month => $earnings) {
      // Get the month name
      $monthName = date('F', strtotime("$year-$month-01"));

      $monthsList[] = $monthName;
      $earningsList[] = round($earnings, 2);
    }
  }
}

// Get the index of the last earning
$lastEarningIndex = count($earningsList) - 1;

// Replace the next 5 months from the last earning
for ($i = 1; $i <= 5; $i++) {
  // Get the month name
  $nextMonth = date('F', strtotime("+$i month", strtotime($monthsList[$lastEarningIndex])));

  // Replace the month name in the array
  $monthsList[$lastEarningIndex + $i] = $nextMonth;
}
?>

<script>
  const ctx = document.getElementById('lineChart');

  const earningsData = <?php echo json_encode($earningsByMonth); ?>;

  const monthlyEarnings = Object.keys(earningsData).sort().map(year => {
    return Object.values(earningsData[year]).reduce((total, earnings) => total + earnings, 0);
  });

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($monthsList); ?>,
      datasets: [{
        label: 'Earnings in €',
        data: <?php echo json_encode($earningsList); ?>,
        backgroundColor: ['#225AEA'],
        borderColor: ['#225AEA'],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>


            
<script>
    function toggleContent(index) {
        var listItems = document.querySelectorAll("ul li");
        var contentDivs = document.getElementsByClassName("content");

        for (var i = 0; i < listItems.length; i++) {
            if (i === index) {
                listItems[i].classList.add("active");
                listItems[i].style.color = "#000";
                contentDivs[i].style.display = "block";
            } else {
                listItems[i].classList.remove("active");
                listItems[i].style.color = "";
                contentDivs[i].style.display = "none";
            }
        }
    }

    // Add this code to display only the first div on page load
    window.onload = function() {
        toggleContent(0); // Index 0 corresponds to the first div
    };
</script>
<script>
        // JavaScript to handle the button click event
        const element = document.getElementById("targetElement");
        const button = document.getElementById("changePositionButton");
        const closeButton = document.getElementById("closeButton");
        const modal = document.getElementById("modal");

        function handleResize() {
        if (window.innerWidth > 767) {
            element.classList.remove("absolute");
            closeButton.style.display = "none";
            button.style.display = "none";
            modal.style.display = 'none';
        }
      }

        changePositionButton.addEventListener("click", function () {
            element.classList.toggle("absolute");
            closeButton.style.display = "block";
            button.style.display = "none";
            modal.style.display = 'block';
        });

        closeButton.addEventListener("click", function () {
            element.classList.remove("absolute");
            closeButton.style.display = "none";
            button.style.display = "block";
            modal.style.display = 'none';
        });
    </script>
  </body>
</html>