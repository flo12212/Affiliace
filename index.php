<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$sql = "SELECT * FROM uploads";


$result = $conn->query($sql);

session_start();

$_SESSION['stars'] = 6;

$_SESSION['min'] = 0;
$_SESSION['max'] = 9999999;

$_SESSION['noship'] = 9999999;

unset($_SESSION['brand']);
$_SESSION['condition'] = "new";
$_SESSION['condition2'] = "used";


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
    <title>Affiliace</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="slider.css">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
                                    <span class="cart-count-small"><?php echo $totalQuantity;?></span>
                                <?php else: ?>
                                    <span class="cart-count"><?php echo $totalQuantity;?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                    <li class="exception" id="box">
                        <div class="circle">
                            <?php echo $firstLetter;?>
                            <div class="dropdown-menu">
                                <?php if (!isset($_SESSION['user_id'])) { ?>
                                    <a href="login">Log in</a>
                                    <a href="register">Register</a>
                                <?php } else { ?>
                                    <a href="dashboard">Dashboard</a>
                                    <a href="account">Account</a> 
                                    <a href="orders">Orders</a> 
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

<div class="scrollable-container">
  <div class="sort">
    <a href="sort?id=Clothing"><button>Clothing</button></a>
    <a href="sort?id=Home"><button>Home</button></a>
    <a href="sort?id=Electronics"><button>Electronics</button></a>
    <a href="sort?id=Sport"><button>Sport</button></a>
    <a href="sort?id=Toys"><button>Toys</button></a>
    <a href="sort?id=Books"><button>Books</button></a>
    <a href="sort?id=Health"><button>Health</button></a>
    <a href="sort?id=Pets"><button>Pets</button></a>
  </div>
</div>

<script>
   const sortableContainer = document.querySelector('.sortable-section');

new Sortable(sortableContainer, {
  animation: 150, // Animation speed in milliseconds (optional)
  ghostClass: 'sortable-ghost', // Class name for the dragging item (optional)
}); 
</script>









    <div class="container">
    <!--
        <div class="slider">
                <div class="slider-wrapper">
                    <div id="slider">
                        <h1>E-Books</h1>
                        <figure>
                            <a href="sort?id=Online Produkte"><img src="videos/file5c41cbd59b17497403bdbcaa366540b4.jpg"></a>
                            <a href="sort?id=Online Produkte"><img src="videos/645bd7a2000ee3.75232361.jpg"></a>
                            <a href="sort?id=Online Produkte"><img src="videos/645bd7a2000ee3.75232361.jpg"></a>
                        </figure>
                    </div>

                    <div class="slider-nav">
                        <a href="#slide-1"></a>
                        <a href="#slide-2"></a>
                        <a href="#slide-3"></a>
                    </div>
                </div>
            </div> 
    -->


    </div>
    <div class="pro-container">
        <h1>Producs</h1>
        <?php while($row = $result->fetch_assoc()) {
            $path = $row['preview'];
            $filename = basename($path);
            $upid = $row['upid'];
            $query = "SELECT COUNT(*) as total_reviews, AVG(stars) as average_rating FROM rewievs WHERE product_id = $upid";
            $result8 = $conn->query($query);
            $row8 = $result8->fetch_assoc();

            $totalReviews = $row8["total_reviews"];
            $averageRating = $row8["average_rating"];
        ?>
            <a href="product?id=<?php echo $row['upid']; ?>" class="product-container">
                <img src="videos/<?php echo $filename; ?>" class="thumbnail">
                <div class="product-titel"><?php echo $row['titel']; ?></div>
                <div><?php echo number_format($row['price'] * $equivalentRate, 2, ',', '.').' '.$symbol; ?></div>
                <div class="stars" id="box">
                    <?php
                    if ($averageRating !== null) {
                        $roundedRating = round($averageRating);
                    } else {
                        $roundedRating = $averageRating;
                    }
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $roundedRating) {
                            echo "&#9733;";
                        } else {
                            echo "&#9734;";
                        }
                    }
                    ?>
                </div>
            </a>
        <?php } ?>
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
