<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

$totalQuantity = 0;
$temp_price = 0;
$total_price = 0;
$price = 0;

$symbol = $_SESSION['currancy'];
$equivalentRate = $_SESSION['equivalent'];

$id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$firstLetter = $username[0];

$sql3 = "SELECT * FROM userdata WHERE id = '$id'";
$result3 = $conn->query($sql3);
$row3 = mysqli_fetch_assoc($result3);


    $sql = "SELECT * FROM cart WHERE user_id = '$id'";
    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $totalQuantity += 1 * $row['ammount'];
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


    if (!isset($_GET['affiliate'])) { 
        $affiliate = 0;
    } else {
        $affiliate = $_GET['affiliate'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Payment Accepted</title>
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="footer.css">
	<link rel="stylesheet" href="header.css">
		<style>
body {
    margin: 0;
    padding: 0;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f0f0f0;
    font-family: Arial, sans-serif;
}

.container {

    text-align: center;
	margin-left: 40%;
	margin-top: 200px;
	margin-bottom: 200px;
    background-color: #fff;
    padding: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    max-width: 400px;
}

.success-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    background-color: #4caf50;
}

.success-icon svg {
    width: 50px;
    height: 50px;
    fill: #fff;
}

h1 {
    color: #4caf50;
}

p {
    color: #333;
    margin: 15px 0;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4caf50;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.2s;
}

.btn:hover {
    background-color: #45a049;
}

	</style>
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
                        <form id="languageForm" onsubmit="return appendLanguageParam()">
                            <input type="hidden" id="existingId" name="id" value="<?php echo $way; ?>">
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

                        <script>
                        function appendLanguageParam() {
                            var form = document.getElementById('languageForm');
                            var selectedLanguage = document.getElementById('language').value;
                            var existingId = document.getElementById('existingId').value;
                            var currentURL = window.location.href;
                            var separator = currentURL.includes('?') ? '&' : '?';
                            var newURL = currentURL + separator + 'id=' + existingId + '&language=' + selectedLanguage;

                            form.action = newURL;
                            return true;
                        }
                        </script>

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
                                    <?php if ($row3['paid'] == 1) {?>
                                        <a href="dashboard">Sallary Dashboard</a>
                                    <?php } else { ?>
                                        <a href="payment">Become a Seller</a>
                                        <?php } ?>
                                    <a href="settings">Settings</a>
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







	<div class="container">
		<div class="success-icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
				<path d="M0 0h24v24H0z" fill="none"/>
				<path d="M0 0h24v24H0z" fill="none"/>
				<path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z" fill="#4caf50"/>
				<path d="M17.296 8.296L11 14.586l-2.296-2.292-1.414 1.414L11 17.414l6.71-6.708z" fill="#fff"/>
			</svg>
		</div>
		<h1>Success!</h1>
		<p>Thank you very much.</p>
		<p>Your request has been processed successfully.</p>
		<a href="index" class="btn">Back to Home</a>
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
</body>
</html>