<?php 

$id = $_GET['id'];

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');


$sql = "SELECT * FROM userdata WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sql2 = "SELECT * FROM uploads WHERE id = '$id'";
$result2 = $conn->query($sql2);


session_start();

$filteredQuantityArray = []; 
if (!isset($_SESSION['user_id'])) {
    $firstLetter = "?";
    $totalQuantity = 0;
    } else {
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
    }
    $username = $row['username'];
    $rewiews = "SELECT * FROM rewievs WHERE '$username' = username";
    $result_rewiews = $conn->query($rewiews);
    






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

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliace Seller: <?php echo $row['username']; ?></title>
    <link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="header.css">
	<link rel="stylesheet" href="seller.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
	<div class="header">
        <div class="navbar">
            <a href="index"><img src="logo.png" class="logo"></a>
            <nav>
                <ul>
                    <li class="exception">
                        <form class="search-form" action="search" method="get">
                            <a id="row2"><i style=" transform: translateY(-50%);margin-top: 28px;margin-right: 10px;width: 30px;height: 30px;font-size: 30px;text-align: center;color: black;"class="fas fa-arrow-left" id="icon"></i></a>
                            <input class="search-input" type="text" name="query" placeholder="Search...">
                            <input type="submit" value="Search" class="search-btn">
                        </form>
                    </li>
                    <li id="box">
                    <form id="languageForm">
                        <select id="language" name="language">
                            <option value="eur">Europa | €</option>
                            <option value="en">US | $</option>
                            <option value="en">Britain | £</option>
                            <option value="pt">Portuguese | R$</option>
                            <option value="jp">Japanese | ¥</option>
                            <option value="cn">Chinese | ¥</option>
                            <option value="ru">Russian | ₽</option>
                            <option value="kr">Korean | ₩</option>
                            <option value="in">Hindi | ₹</option>
                        </select>
                        <input type="submit" value="Submit">
                    </form>

                        <?php

                            if (!isset($_GET['language'])) {
                                $userLanguage = "eur";
                            } else {
                                $userLanguage = $_GET['language'];
                            }
                            $currencyFormat = $currencyFormats[$userLanguage];
                            $symbol = $currencyFormat['symbol'];
                            $_SESSION['currancy'] = $symbol;
                            $equivalentRate = $currencyFormat['equivalent'];
                            $_SESSION['equivalent'] = $equivalentRate; 
                        ?>
                        
                    </li>
                    <li id="box">
                        <a href="cart" class="cart-link">
                            <div class="cart-content">
                                <img src="cart_logo.png" alt="Cart" class="cart-logo">
                                <?php if ($totalQuantity < 10): ?>
                                    <span class="cart-count cart-count-small"><?php echo $totalQuantity;?></span>
                                <?php else: ?>
                                    <span class="cart-count"><?php echo $totalQuantity;?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                    <li  id="box" class="exception">
                        <div class="circle">
                            <?php echo $firstLetter;?>
                            <div class="dropdown-menu">
                                <?php if (!isset($_SESSION['user_id'])) { ?>
                                    <a href="login">Log in</a>
                                    <a href="register">Register</a>
                                <?php } else { ?>
                                    <a href="account">Account</a> 
                                    <?php if ($row7['paid'] == 1) {?>
                                        <a href="dashboard">Dashboard</a>
                                        <a href="affiliate">Affiliace</a>
                                    <?php } else { ?>
                                        <a href="payment">Become a Seller</a>
                                        <?php } ?>
                                    <a href="logout">Log out</a>
                                <?php } ?>
                            </div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                            $('.circle').click(function() {
                                $(this).find('.dropdown-menu').toggle();
                            });
                            });
                        </script>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


	<div>
        <div class="top">
            <a href="index" class="a"><button>Back</button></a>
        </div>
		
        <div class="bottom2">
            <div class="flex">
                <div class="left">
                    <div class="flex3">
                    <div class="user-container">
                        <div class="bottom-border">
                            <img src="profilpictures/<?php echo $row['profilpicture']; ?>" alt=""  class="logo1">
                            <div><?php echo $row['username']; ?></div>
                            <div class="flex3">
                                <p class="star">&#9733</p>
                                <p class="star">&#9733</p>
                                <p class="star">&#9733</p>
                                <p class="star">&#9733</p>
                                <p class="star">&#9733</p>
                            </div>
                        </div>
                        <div class="user-info">
                            <div class="div">From: <?php echo $row['country']; ?></div>
                            <div class="div">Company: <?php echo $row['company']; ?></div>
                            <div class="div">Website: <a href="<?php echo $row['website']; ?>">Website</a></div>
                        </div>
                    </div>
                    <div class="user-container2" style="margin-top: 10px;">
                        <div class="margin">
                            <h1>Social Media</h1>
                            <div class="div">Instagram: <a href="https://www.instagram.com/<?php echo $row['instagram']; ?>/" target="_blank"><i class="fab fa-instagram"></i></a></div>
                            <div class="div">Tiktok: <a href="https://www.tiktok.com/@<?php echo $row['tiktok']; ?> " target="_blank"><i class="fab fa-tiktok"></i></a></div>
                            <div class="div">Twitter: <a href="https://twitter.com/<?php echo $row['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a></div>
                            <div class="div">Facebook: <a href="" target="_blank"><i class="fab fa-facebook" target="_blank"></i></a></div>
                            <div class="div">Youtube: <a href=""><i class="fab fa-youtube" target="_blank"></i></a></div>
                            <div class="div">Whatsapp: <a href=""><i class="fab fa-whatsapp" target="_blank"></i></a></div><div class="div">Instagram: <a href="https://www.instagram.com/<?php echo $row['instagram']; ?>/" target="_blank"><i class="fab fa-instagram"></i></a></div>
                            <div class="div">Linkedin: <a href=""><i class="fab fa-linkedin" target="_blank"></i></a></div>
                            <div class="div">Snapchat: <a href=""><i class="fab fa-snapchat" target="_blank"></i></a></div>
                            <div class="div">Reddit: <a href=""><i class="fab fa-reddit" target="_blank"></i></a></div>
                        </div>
                    </div>
                </div>
                </div>
                    <div class="user-container" style="margin-top: 1 0px;">
                        <div class="margin">
                            <h1>Description</h1>
                            <div class="div"><?php  echo $row['description']; ?></div>
                        </div>
                    </div>
                </div>

                <div class="right">
                    <div class="product-container">
                        <h1><?php echo $row['username']; ?>'s Products</h1>
                        <?php
                            if ($result2->num_rows > 0) {
                                while($row2 = $result2->fetch_assoc()) { 
                                    $product_id = $row2['upid'];
                                    $path = $row2['preview'];
                                    $filename = basename($path);?>
                                    <div class="product">
                                        <img src="videos/<?php echo $filename; ?>">
                                        <div><?php echo $row2['titel']; ?></div>
                                        <div><?php echo $row2['price'] . " €"; ?></div>
                                        <a href="buy?id=<?php echo $row2['upid']; ?>"><button class="buy-button">Buy</button></a>
                                    </div>
                                <?php
                                } 
                            } else {
                                ?> <div>No Products Uploaded yet!</div>
                            <?php } ?>
                    </div>       

                    <div class="rewievs">
                        <div class="display-rewievs">
                            <h3>Rewievs:</h3>
                            <div class="rew-container">
                                <?php while($row5 = $result_rewiews->fetch_assoc()) {
                                    $name = $row5['username'];
                                    $rewiev = $row5['rewiev'];
                                    $stars = $row5['stars'];
                                    $time = $row5['time'];
                                    $product_id = $row5['product_id'];
                                    $formattedTime = date("d.m.y", strtotime($time));
                                    $firstLetter2 = $name[0];
                                    $sql6 = "SELECT * FROM userdata WHERE username = '$name'";
                                    $result6 = $conn->query($sql6);
                                    while($row6 = $result6->fetch_assoc()) {
                                        $id = $row6['id']; ?>  
                                <div class="rewiev-container">
                                    <div>
                                        <div class="flex">
                                            <div class="circle">
                                                <div><?php echo $firstLetter2; ?></div>
                                            </div>
                                            <div class="flexbox1">
                                                <a href="seller?id=<?php echo $id; ?>"><?php echo $name; ?> | </a>
                                                <a href="product?id=<?php echo $product_id; ?>"><?php echo $product_id; ?></a>
                                                <?php 
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $stars) {
                                                        echo '<span class="star">&#9733;</span>';
                                                    } else {
                                                        echo '<span>&#9734;</span>';
                                                    }
                                                } ?>
                                                    <div><?php echo $formattedTime; ?></div>
                                            </div>
                                        </div>
                                        <div class="rewiev"><?php echo $rewiev; ?></div>
                                    </div>
                                </div>
                                    <?php } }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
  	 		<div class="footer-scol">
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
    $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
</script>

    <div id="bottom" class="bottom">
        <div class="block" style="border-top: 3px solid #225AEA;"><a href="index">
          <i class="fas fa-home"></i>
        </a></div>
        <div class="block"><a href="dashboard">
          <i class="fas fa-chart-line"></i>
        </a></div>
        <div class="block"><a href="cart">
            <i class="fas fa-shopping-cart"></i>
        </a></div>
        <div class="block"><a href="upload1">
          <i class="fas fa-upload"></i>
        </a></div>
        <div class="block"><a href="account">
          <i class="fas fa-user"></i>
        </a></div>  
    </div>
    <script>
        // Function to check the screen width and toggle the div visibility
        function checkScreenWidth() {
            const myDiv = document.getElementById('bottom');
            const screenWidth = window.innerWidth;

            if (screenWidth < 767) {
                myDiv.style.display = 'flex';
            } else {
                myDiv.style.display = 'none';
            }
        }

        // Initial check when the page loads
        checkScreenWidth();

        // Add event listener to recheck when the screen is resized
        window.addEventListener('resize', checkScreenWidth);
    </script>
</body>
</html>