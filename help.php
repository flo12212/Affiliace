<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$sql = "SELECT * FROM uploads";


$sql2 = "SELECT *, COUNT(*) AS num_bought
        FROM uploads
        GROUP BY buyed
        ORDER BY num_bought DESC
        LIMIT 5";

$result = $conn->query($sql);
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
    <title>Affiliace: Help</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="help.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    <div class="header">
        <div class="navbar">
            <a href="index"><img src="logo.png" class="logo"></a>
            <nav>
                <ul>
                    <li class="exception">
                        <form class="search-form" action="search" method="get">
                            <input class="search-input" type="text" name="query" placeholder="Search...">
                            <input type="submit" value="Search" class="search-btn">
                        </form>
                    </li>
                    <li>
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
                    <li>
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
                    <li class="exception">
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

    <div class="help-container">
        <div class="help-input">
            <h1>Enter your Question and we will respond in seconds!</h1>
            <h1>You will recevie a Email after the Quesdtion is uploaded</h1>
            <form>
                <input class="question" type="text" id="textbox" name="question" placeholder="Type your question here">
                <input type="submit" value="Submit">
                <img src="logo2.png" alt="">
            </form>
        </div>
        <div class="faq">
           
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

  <?php
if (isset($_SESSION['success']) && $_SESSION['success'] == 1) { ?>
    <div class="success-message" id="messageDiv" style="display: block;">Login successful!</div> <?php
    echo '<script>setTimeout(function() { document.getElementById("messageDiv").style.display = "none"; }, 2500);</script>';
    unset($_SESSION['success']);
} ?>

  <?php
if (isset($_SESSION['created']) && $_SESSION['created'] == 1) {
    echo '<div class="success-message" id="messageDiv2" style="display: block;">Account created successfully!</div>';
        echo '<script>setTimeout(function() { document.getElementById("messageDiv2").style.display = "none"; }, 2500);</script>';
    unset($_SESSION['created']);
} ?>


</body>
</html>