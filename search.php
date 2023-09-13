<?php 

$query = $_GET['query'];

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

$fullURL = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo $fullURL;

if(isset($_SESSION['stars'])) {
    $stars = $_SESSION['stars'];
} else {
    $stars = 6;
} 



if(isset($_SESSION['min']) && isset($_SESSION['max'])) {
    $min = $_SESSION['min'];
    $max = $_SESSION['max'];
} else {
    $min = 0;
    $max = 999999999;
}

if(isset($_SESSION['noship'])) {
    $noship = $_SESSION['noship'];
} else {
    $noship = 9999999;
}

$condition = $_SESSION['condition'];
$condition2 = $_SESSION['condition2'];

if(isset($_POST['clear'])) {
    $_SESSION['stars'] = 6;
    $_SESSION['min'] = 0;
    $_SESSION['max'] = 9999999;
    $_SESSION['noship'] = 9999999;
    unset($_SESSION['brand']);
    $_SESSION['condition'] = "new";
    $_SESSION['condition2'] = "used";
    header("Location: search?query=" . $query);
}



if(isset($_SESSION['brand'])) {
    $brand = $_SESSION['brand'];
    $sql = "SELECT * FROM uploads WHERE (titel LIKE '%$query%' OR catigory LIKE '%$query%') AND (conditionn = '$condition' OR conditionn = '$condition2') AND brand = '$brand' AND price > '$min' AND price < '$max' AND shipping <= '$noship'";
} else {
    $brand = "";
    $sql = "SELECT * FROM uploads WHERE (titel LIKE '%$query%' OR catigory LIKE '%$query%') AND (conditionn = '$condition' OR conditionn = '$condition2') AND price > '$min' AND price < '$max' AND shipping <= '$noship'";
   
}

$result = mysqli_query($conn, $sql);



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


        $watchformats = array(
            "Watch", "watch", "Analog", "Digital", "Smartwatches", "Automatic", "Quartz", "Mechanical",
            "Chronograph", "Diver's", "Pilot", "Luxury", "Sports", "Casual", "Dress",
            "Skeleton", "Vintage", "Limited Edition", "Fashion", "Aviator", "Dive",
            "Watch Bands", "Watch Straps", "Watch Bracelets", "Leather", "Metal", "NATO",
            "Rubber", "Mesh",
            "Watch Movements", "Automatic", "Quartz", "Mechanical", "Swiss", "Japanese",
            "Watch Crystals", "Sapphire", "Mineral", "Acrylic",
            "Bezel", "Rotating", "Fixed", "Ceramic",
            "Watch Dial", "Sunburst", "Guilloché", "Mother-of-Pearl",
            "Luminous Markers",
            "Watch Hands", "Sword", "Baton", "Skeleton",
            "Watch Case", "Stainless Steel", "Titanium", "Gold Plated", "Carbon Fiber",
            "Water Resistance", "30m", "50m", "100m", "200m",
            "Swiss", "Rolex", "TAG Heuer", "Omega", "Patek Philippe", "Audemars Piguet",
            "Casio", "Seiko", "Fossil", "Timex", "Citizen", "Michael Kors",
            "Bulova", "Movado", "Tissot", "Hamilton", "G-Shock", "Skagen",
            "Invicta", "Daniel Wellington", "Luminox", "Swatch", "Breitling",
            "Panerai", "Hugo Boss", "Armani Exchange", "Diesel", "Montblanc",
            "Hermès", "Cartier", "Vacheron Constantin", "Zenith", "Breguet", "Longines"
        );
        
        

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliace: <?php echo $query; ?></title>
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="header.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="footer.css">
</head>
<body>
<div class="header">
        <div class="navbar">
            <a href="index"><img src="logo.png" class="logo"></a>
            <nav>
                <ul>
                    <li class="exception">
                        <form class="search-form" action="search" method="get">
                            <input class="search-input" type="text" name="query" placeholder="Search..." value="<?php echo $query; ?>">
                            <input type="submit" value="Search" class="search-btn">
                        </form>
                    </li>
                    <li>
                    <form id="languageForm">
                        <select id="language" name="language">
                            <?php
                            if (!isset($_SESSION['language'])) {
                                $_SESSION['language'] = 'eur';
                            } ?>
                            <option value="eur">Europa | €</option>
                            <option value="en">English | $</option>
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
                        document.getElementById('languageForm').addEventListener('submit', function(event) {
                            event.preventDefault();

                            var languageSelect = document.getElementById('language');
                            var selectedLanguage = languageSelect.value;

                            // Update the URL with the selected language code
                            var newURL = 'https://translate.google.com/translate?sl=auto&tl=' + selectedLanguage + '&u=' + encodeURIComponent(window.location.href);
                            window.location.href = newURL;
                        });
                    </script>
                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
                                $selectedLanguage = $_POST['language'];
                                $_SESSION['language'] = $selectedLanguage; }

                            if (!isset($_SESSION['language'])) {
                                $userLanguage = "de";
                            } else {
                                $userLanguage = $_SESSION['language'];
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


<div class="sort">
    <a href="index"><button>Back</button></a>
</div>

<div class="flex">
    <div class="filter-container">
        <div class="block">
        <form method="post" action="">
            <button type="submit" name="clear">clear</button>
        </form>
        </div>
        <div class="block">
            <a href="update_search?min=0&max=20&query=<?php echo $query; ?>">0-20 EUR</a>
            <a href="update_search?min=20&max=50&query=<?php echo $query; ?>">20-50 EUR</a>
            <a href="update_search?min=50&max=100&query=<?php echo $query; ?>">50-100 EUR</a>
            <a href="update_search?min=100&max=200&query=<?php echo $query; ?>">100-200 EUR</a>
            <a href="update_search?min=200&max=9999999999&query=<?php echo $query; ?>">200 EUR and more</a>
            <form action="update_search">
                <input type="text" name="min" value="100" placeholder="min">
                <input type="text" name="max" value="200" placeholder="max">
                <input type="hidden" name="query" value="<?php echo $query; ?>">
                <input type="submit" value="start">
            </form>
        </div>
        <div class="block">
            <?php $starValue = "&stars=5";

            if (strpos($fullURL, "stars=") !== false) {
                // URL already contains stars parameter, keep stars as they are
                $modifiedURL = $fullURL;
            } else {
                // URL doesn't have stars parameter, add the star value to the end
                $modifiedURL = $fullURL . $starValue;
            }
            ?>

            <a href="<?php echo $modifiedURL; ?>">&#9733;&#9733;&#9733;&#9733;&#9733;</a>
            <a href="<?php echo "search?query=' . $query . '&min=' . $min . '&max=' . $max . '&stars=4&noship=' . $noship .'&condition=' . $condition .'&condition2=' . $condition2"?>">&#9733;&#9733;&#9733;&#9733;</a>
            <a href="<?php echo "search?query=' . $query . '&min=' . $min . '&max=' . $max . '&stars=3&noship=' . $noship .'&condition=' . $condition .'&condition2=' . $condition2"?>">&#9733;&#9733;&#9733;</a>
            <a href="<?php echo "search?query=' . $query . '&min=' . $min . '&max=' . $max . '&stars=2&noship=' . $noship .'&condition=' . $condition .'&condition2=' . $condition2"?>">&#9733;&#9733;</a>
            <a href="<?php echo "search?query=' . $query . '&min=' . $min . '&max=' . $max . '&stars=1&noship=' . $noship .'&condition=' . $condition .'&condition2=' . $condition2"?>">&#9733;</a>
        </div>
        <div class="block">
            <?php if ($noship == 0) { ?>
                <input type="checkbox" id="myCheckbox"> Free delivery
                <script>
                    var checkbox = document.getElementById("myCheckbox");
                    checkbox.checked = true;

                    checkbox.addEventListener("change", function() {
                        if (checkbox.checked) {
                            window.location.href = "update_search_noship?query=<?php echo $query; ?>&noship=99999";
                        } else {
                            window.location.href = "update_search_noship?query=<?php echo $query; ?>&noship=99999";
                        }
                    });
                </script>

            <?php } else { ?>
                <input type="checkbox" id="myCheckbox2">Free delivery
                <script>
                    var checkbox2 = document.getElementById("myCheckbox2");

                    checkbox2.addEventListener("change", function() {
                        if (checkbox2.checked) {
                            window.location.href = "update_search_noship?query=<?php echo $query; ?>&noship=0";
                        } else {
                            window.location.href = "update_search_noship?query=<?php echo $query; ?>&noship=0";
                        }
                    });
                </script>
            <?php } ?>
        </div>
        <?php
        if (in_array($query, $watchformats)) { ?>
            <div class="block" id="watch">
                <h1>Brand</h1>
                <a href="update_search_brand?brand=Casio&query=<?php echo $query; ?>">Casio</a>
                <a href="update_search_brand?brand=Citizen&query=<?php echo $query; ?>">Citizen</a>
                <a href="update_search_brand?brand=Tommyhilfigger&query=<?php echo $query; ?>">Tommy Hilfiger</a>
                <a href="update_search_brand?brand=Timex&query=<?php echo $query; ?>">Timex</a>
                <a href="update_search_brand?brand=Rolex&query=<?php echo $query; ?>">Rolex</a>
                <a href="update_search_brand?brand=Omega&query=<?php echo $query; ?>">Omega</a>
            </div> 
            <div class="block" id="watch">
                <h1>Watchband</h1>
                <a href="">Ceramic</a>
                <a href="">Gold Plated</a>
                <a href="">Leather</a>
                <a href="">Nylon</a>
                <a href="">Resin</a>
            </div>
            
            <?php
        } else {
            echo "$query is not in the array.";
        } ?>
            <div class="block">
                <h1>Condition</h1>
                <a href="update_condition_search?way=used&query=<?php echo $query; ?>">used</a>
                <a href="update_condition_search?way=new&query=<?php echo $query; ?>">new</a>
            </div>
       
    </div>                      

<div class="container" style="min-height: 780px;">
        <h2>Results</h2>
        <?php 
        if (mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()) {
                $product_id = $row['upid'];
                $sql2 = "SELECT AVG(stars) AS average_star_count FROM rewievs WHERE product_id = $product_id";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $average_star_count = $row2['average_star_count'];
                if ($average_star_count <= $stars) {
                $path = $row['preview'];
                $filename = basename($path);
            ?>
                <a href="product?id=<?php echo $row['upid']; ?>" class="product-container">
                    <img src="videos/<?php echo $filename; ?>" class="thumbnail">
                    <div class="product-titel"><?php echo $row['titel']; ?></div>
                    <div><?php echo $row['price'] * $equivalentRate . $symbol;?></div>
                    <div><?php echo $average_star_count; ?></div>
                </a>
            <?php }
            }
        } else { ?>
            <div>Nothing Found for <?php echo $query; ?></div>
        <?php } ?>
            
        
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
<script>

document.addEventListener("DOMContentLoaded", function() {
    const script1Checkbox = document.getElementById("script1Checkbox");
    const script2Checkbox = document.getElementById("script2Checkbox");
    
    script1Checkbox.addEventListener("change", function() {
        if (script1Checkbox.checked) {
            // Execute script 1
            window.location.href = "update_search_noship?query=<?php echo $query; ?>";
        }
    });
    
    script2Checkbox.addEventListener("change", function() {
        if (script2Checkbox.checked) {
            window.location.href = "update_search_noship?query=<?php echo $query; ?>";
        }
    });
});












</script>


</body>
</html>