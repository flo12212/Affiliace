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
$sql3 = "SELECT * FROM orders WHERE user_id = '$user_id'";
$sql4 = "SELECT * FROM uploads WHERE bought > 0";
$sql6 = "SELECT * FROM affiliate";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
$result5 = $conn->query($sql4);
$result6 = $conn->query($sql6);
$row2 = $result2->fetch_assoc();

 $total_price = 0; //use this in the  paycheck!!


    while($row4 = $result4->fetch_assoc()) { 
      $price = $row4['price'];
      $ammount = $row4['bought'];
      
      $total_price += $ammount * $price;
      } 
      ;
    $commission_price = $total_price * 0.2;
    $user_price = round($total_price - $commission_price, 2);
    $formatted_commission_price = number_format(round($commission_price, 2), 2, ',', '.');
    $formatted_user_price = number_format(round($user_price, 2), 2, ',', '.');
    $formatted_total_price = number_format(round($total_price, 2), 2, ',', '.');
  
            
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row2['company']; ?>: Affiliate</title>
    <link rel="stylesheet" href="affliate.css">
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
        <li><a href="sales">
          <i class="fas fa-tag"></i>
          <span class="nav-item">Sales</span>
        </a></li>
        <li><a href="upload1">
          <i class="fas fa-upload"></i>
          <span class="nav-item">Upload</span>
        </a></li>
        <li><a href="affiliate" style="background-color: #c5d5fd;">
          <i class="fas fa-dollar-sign"></i>
          <span class="nav-item">Affiliate</span>
        </a></li>
        <li><a href="product-view">
          <i class="fas fa-shopping-cart"></i>
          <span class="nav-item">Products</span>
        </a></li>
        <li><a href="help" id="help">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Help</span>
        </a></li>
        <li><a href="logout" id="logout">
        <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
  </div>


 <script>
  window.addEventListener('scroll', function() {
    const stickyDiv = document.getElementById('help');
    const logoutDiv = document.getElementById('logout');
    const myDiv = document.getElementById('main');
    const viewportHeight = window.innerHeight;

    if (window.scrollY >= myDiv.offsetTop + myDiv.offsetHeight - viewportHeight) {
      stickyDiv.style.position = 'absolute';
      stickyDiv.style.bottom = '367';
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
        <h1 class="blue">Create Affiliate Link</h1>
        <div><a href="index" class="a">back</a></div>
      </div>
      <button id="changePositionButton"><img src="arrow.png"></button>
      <div class="course-box" style="min-height: 850px;">
      <h1>All Products</h1>
      <input type="text" id="searchInput" placeholder="Enter text to search">
      <button id="searchButton">Search</button>
          <div class="content active" id="content0">
            <ul>
              <li class="active" onclick="toggleContent(0)">Products</li>
              <li  onclick="toggleContent(1)">Requests</li>
              <li  onclick="toggleContent(2)">Marketplace</li>
              <li  onclick="toggleContent(3)">Promote</li>
            </ul>
            <div class="product_contianer">
              <?php
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                  $product_id = $row['upid'];
                  $sql8 = "SELECT * FROM affiliate WHERE user_id = '$user_id' AND product_id = '$product_id'";
                  $result8 = $conn->query($sql8);
                  $row8 = $result8->fetch_assoc();
                  if (!empty($row8)) {
                    $path = $row['preview'];
                  $filename = basename($path);?>
                  <div class="product">
                    <div class="flex">
                      <img src="videos/<?php echo $filename; ?>">
                      <div class="flexbox2">
                        <div><?php echo $row['titel']; ?></div>
                        <div><?php echo $row['price'] . " €"; ?></div>
                        <div><?php echo $row8['commision'] . " %"; ?></div>
                      </div>
                    </div>
                      <div>Product is Already on the Affiliate Marketplace </div>
                      <a href="affiliate_delete?id=<?php echo $row8['id']; ?>">Delete from Marketplace</a>
                  </div>
                    <?php 
                  } else {
                    $path = $row['preview'];
                  $filename = basename($path);?>
                  <div class="product">
                    <div class="flex">
                      <img src="videos/<?php echo $filename; ?>">
                      <div class="flexbox2">
                        <div><?php echo $row['titel']; ?></div>
                        <div><?php echo $row['price'] . " €"; ?></div>
                      </div>
                    </div>
                    <form action="affiliate_upload" method="post">
                        <div class="flex" style="padding-bottom: 20px;">
                            <div class="blue" style="font-size: 20px; padding-right: 20px; padding-left: 100px;">Create:</div>
                            <div class="center-input">
                              <input type="hidden" name="product_id" value="<?php echo $row['upid']; ?>">
                            <input style="text-align: center;" type="text" name="commission" id="commission" maxlength="2" placeholder="Commission" required>
                            <div>%</div>
                          </div>
                        </div>
                        <input type="submit" value="Promote">
                    </form>
                  </div> 
          <?php } }
            } else {
                ?> <div>No Products Uploaded yet!</div>
                <a href="upload1">Click here to Upload your first Product</a> <?php
            } ?>
                  
            </div>
          </div>
          <div class="content" id="content1">
              <ul>
                <li onclick="toggleContent(0)">Products</li>
                <li class="active" onclick="toggleContent(1)">Requests</li>
                <li  onclick="toggleContent(2)">Marketplace</li>
                <li  onclick="toggleContent(3)">Promote</li>
              </ul>
              
              <?php $sql8 = "SELECT * FROM requests WHERE seller_id = '" . $user_id . "'";
              $result8 = $conn->query($sql8);
              if ($result8->num_rows > 0) { ?>
                <table class="table-style">
                    <tr>
                      <th>Product</th>
                      <th>User</th>
                      <th>Accept</th>
                    </tr> <?php 
                while($row8 = $result8->fetch_assoc()) {
                  $sql9 = "SELECT * FROM uploads WHERE upid = '" . $row8['product_id'] . "'";
                  $result9 = $conn->query($sql9);
                    while($row9 = $result9->fetch_assoc()) { 
                      $sql16 = "SELECT * FROM affiliate WHERE product_id = '" . $row8['product_id'] . "' AND '" . $row8['user_id'] . "'";
                      $result16 = $conn->query($sql16);
                      while($row16 = $result16->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><a class="exept" target="_blank" href="product?id=<?php echo $row9['upid'];?>"><?php echo $row9['titel']; ?></a></td>
                        <td>
                          <a class="exept" target="_blank" href="seller?id=<?php echo $row8['user_id']; ?>"><?php echo $row8['username']; ?></a>
                        </td>
                        <td>
                          <form action="affiliate_accept" method="POST">
                            <input type="hidden" name="seller" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="user" value="<?php echo $row8['user_id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row8['product_id']; ?>">
                            <input type="hidden" name="commission" value="<?php echo $row16['commision']; ?>">
                            <input type="submit" value="Accept">
                          </form>
                        </td>
                    
                    <?php
                    } }
                }
              ?>
              </tr>
              </table>
                  <?php 
              } else {
                echo "no Requests";
              }
                  ?>
          </div>
          <div class="content" id="content2">
            <ul>
                <li onclick="toggleContent(0)">Products</li>
                <li onclick="toggleContent(1)">Requests</li>
                <li  class="active" onclick="toggleContent(2)">Marketplace</li>
                <li  onclick="toggleContent(3)">Promote</li>
              </ul>
              <div class="product_contianer">
            <?php 
            if ($result6 && mysqli_num_rows($result6) > 0) {

              while($row6 = $result6->fetch_assoc()) {
                $product_id2 = $row6['product_id'];
                $sql7 = "SELECT * FROM uploads WHERE upid = '$product_id2'";
                $result7 = $conn->query($sql7);
                $sellerid = $row6['user_id'];
                
                $sql12 = "SELECT * FROM affiliate WHERE product_id = '$product_id2' AND user_id = '$sellerid'";
                $result12 = $conn->query($sql12);
                $sql13 = "SELECT * FROM requests WHERE product_id = '$product_id2' AND user_id = '$user_id'";
                $result13 = $conn->query($sql13);
                $sql14 = "SELECT * FROM affliate_accept WHERE product_id = '$product_id2' AND user = '$user_id'";
                $result14 = $conn->query($sql14);
                while($row7 = $result7->fetch_assoc()) {
                  while($row12 = $result12->fetch_assoc()) {
                  $row13 = $result13->fetch_assoc();
                  $row14 = $result14->fetch_assoc();
                  $path7 = $row7['preview'];
                  $filename7 = basename($path7);
                  $commission = $row7['price'] / 100;
                  $commission_€ = $row12['commision'] * $commission?>
                  <div class="product">
                    <div class="flex">
                      <img src="videos/<?php echo $filename7; ?>" class="">
                      <div class="flexbox2">
                        <div><?php echo $row7['titel']; ?></div>
                        <div><?php echo $row7['price'] . " €"; ?></div>
                        <div>Commission: <?php echo $row12['commision'] . " %"; ?></div>
                        <div>Every Sale: <?php echo $commission_€ . " €"; ?></div>
                      </div>
                    </div>
                    <?php 

                    if (!empty($row14)) { ?>
                      <div>Already ready to Promote</div><?php
                    } else {
                      if (!empty($row13)) {?>
                        <div>Already Requested</div> <?php 
                      } else {
                        if ($row7['id'] == $user_id) { ?>
                          <div>Your own</div><?php
                        } else { ?>
                          <form action="upload_request" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $row7['upid']; ?>">
                            <input type="hidden" name="seller_id" value="<?php echo $row7['id']; ?>">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="username" value="<?php echo $username; ?>">
                            <input type="submit" value="Request">
                          </form> <?php
                        }
                      } 
                    }
                    
                    ?>
                  </div>
                  <?php
                } 
              } 
            } 
          } else {
            echo "There are no Product uploaded yet!";
          }
            ?>
            </div>
          </div>
          <div class="content" id="content3">
            <ul>
                <li onclick="toggleContent(0)">Products</li>
                <li onclick="toggleContent(1)">Requests</li>
                <li onclick="toggleContent(2)">Marketplace</li>
                <li class="active" onclick="toggleContent(3)">Promote</li>
            </ul>
            <div>
            <div class="product_contianer">
            <?php
                $counter = 0;
                $sql10 = "SELECT * FROM affliate_accept WHERE user = '$user_id'";
                $result10 = $conn->query($sql10);
                 if ($result10 && mysqli_num_rows($result10) > 0) {
                  while ($row10 = $result10->fetch_assoc()) {
                      $product_id = $row10['product_id'];
                      $sql11 = "SELECT * FROM affiliate WHERE product_id = '$product_id'";
                      $result11 = $conn->query($sql11);
                      while ($row11 = $result11->fetch_assoc()) {
                        $sql13 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                        $result13 = $conn->query($sql13);
                          while ($row13 = $result13->fetch_assoc()) {
                            $path13 = $row13['preview'];
                            $filename13 = basename($path13);
                            $counter += 1;?>
                            
                              <div class="product">
                                <img src="videos/<?php echo $filename13; ?>">
                                <div><?php echo $row13['titel']; ?></div>
                                <div><?php echo $row13['price'] . " €"; ?></div>
                                <div id="myLink<?php echo $counter; ?>"><?php echo $row10['link'] ?></div>
                                <button onclick="copyLink(<?php echo $counter; ?>)">Copy Link</button>
                              </div>
                            </div>
                          <?php
                        }
                      }
                  }
                } else {
                  echo "Nothing here!";?>
                  <ul>
                    <li class="active" onclick="toggleContent(2)">Request here</li>
                  </ul>
                 
               <?php }
                ?>
                 </div>
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

  <div id="messageDiv">Link copied!</div>


  <script>
function copyLink(counter) {
    var linkElement = document.getElementById("myLink" + counter);
    var linkText = linkElement.innerText;

    var tempInput = document.createElement("input");
    tempInput.value = linkText;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    
    var messageDiv = document.getElementById("messageDiv");
    messageDiv.style.display = "block";
    
    setTimeout(function() {
        messageDiv.style.display = "none";
    }, 2500);
}
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
        // Get the input and button elements
      const searchInput = document.getElementById('searchInput');
      const searchButton = document.getElementById('searchButton');

      // Add click event listener to the button
      searchButton.addEventListener('click', function() {
        // Get the text to search for
        const searchText = searchInput.value;

        // Search for the text on the webpage
        const textFound = window.find(searchText);

      });

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
            closeButton.style.display = "none";
            button.style.display = "block";
            modal.style.display = 'none';
        });
    </script>

  </body>
</html>