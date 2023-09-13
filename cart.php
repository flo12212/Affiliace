<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();


$_SESSION['stars'] = 6;

$_SESSION['min'] = 0;
$_SESSION['max'] = 9999999;

$_SESSION['noship'] = 9999999;

unset($_SESSION['brand']);
$_SESSION['condition'] = "new";
$_SESSION['condition2'] = "used";


if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

$symbol = $_SESSION['currancy'];
$equivalentRate = $_SESSION['equivalent'];

$id = $_SESSION['user_id'];
$username = $_SESSION['username'];





if (!isset($id)) {
    $firstLetter = "?";
} else {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    $firstLetter = $username[0];
    $sql1 = "SELECT * FROM userdata WHERE id = '$user_id'";
    $result1 = $conn->query($sql1);
    $row1 = mysqli_fetch_assoc($result1);
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


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


  $sql = "SELECT * FROM cart WHERE user_id = '$id'";
  $result = $conn->query($sql);

  $temp_price = 0;
  $total_price = 0;
  $shipment = 0;
  $many = 0;



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="card.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="footer.css">
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
                            <a id="row2"><i class="fas fa-arrow-left" id="icon"></i></a>
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

    <div id="bottom2" class="bottom2">
        <div class="block"><a href="index">
          <i class="fas fa-home"></i>
        </a></div>
        <div class="block"><a href="dashboard">
          <i class="fas fa-chart-line"></i>
        </a></div>
        <div class="block" style="border-top: 3px solid #225AEA;"><a href="cart">
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
            const myDiv = document.getElementById('bottom2');
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
    <style>
.bottom2 {
    display: none;
    position: fixed;
    bottom: 0;
    height: 50px;
    width: 100%;
    justify-content: space-evenly;
    border-top: 1px solid gray;
    background-color: white;
  }
  
  .fas {
    margin-top: 28px;
    margin-right: 10px;
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    font-size: 30px;
    text-align: center;
    color: black;
  }
    </style>
    <script>
    $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
</script>

    <div class="cart" id="cart">
        <div class="top">
            <a class="back-button" id="hideDiv" href="index"><button>Back</button></a>
            <h1>Shopping Cart</h1>
        </div>
        <div class="bottom">
            <div class="left">
                <h1 class="blue">Product's</h1>
                        <?php if ($result->num_rows > 0) {
                             $price = 0;
                             $taxAmount = 0;
                             $sum = 0;
                            while ($row = $result->fetch_assoc()) {
                                $productID = $row['product_id'];
                                $sqlProduct = "SELECT * FROM uploads WHERE upid = '$productID'";
                                $resultProduct = $conn->query($sqlProduct);

                                if ($resultProduct->num_rows > 0) {
                                    while ($product = $resultProduct->fetch_assoc()) {
                                        $many += 1;
                                        $path = $product['preview'];
                                        $filename = basename($path);
                                        $count = $row['ammount'];
                                        ?>
                                        <table>
                                            <tr>
                                                <td class="thumbnail">
                                                    <img src="videos/<?php echo $filename; ?>">
                                                </td>
                                                <td><?php echo $product['titel']; ?></td>
                                                <td><?php echo number_format($product['price'] * $equivalentRate, 2, ',', '.') . $symbol; ?></td>
                                                <td class="ammount">
                                                    <div class="flex">
                                                        <form action="upload_minus?id=cart&loc=cart" method="post">
                                                            <input type="hidden" name="count" value="<?php echo $count; ?>">
                                                            <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
                                                            <button type="submit" value="-" class="minus-btn">-</button>
                                                        </form>
                                                        <div><?php echo $count; ?></div>
                                                        <form action="upload_plus?id=cart&loc=cart" method="post">
                                                            <input type="hidden"name="count" value="<?php echo $count; ?>">
                                                            <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
                                                            <button type="submit" value="+" class="plus-btn">+</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="view">
                                                    <a href="product?id=<?php echo $product['upid']; ?>" class="view-product">View Product</a>
                                                </td>
                                            </tr>
                                        </table>
                                        <?php
                                       
                                        if (isset($_POST['submit2_' . $product['upid']])) {
                                            $newAmount = $_POST['new_amount_' . $product['upid']];
                                            $upid = $_POST['upid_' . $product['upid']];
                                            $sql4 = "UPDATE cart SET ammount = '$newAmount' WHERE product_id = '$upid'";
                                            $result4 = mysqli_query($conn, $sql4);
                                        }
                                            $price += $product['price'] * $count;
                                            $shipment += $product['shipping'];
                                            $taxRate = 0.19;   
                                    }
                                }
                            }
                        $taxAmount += $price * $taxRate;
                        $sum += $price + $shipment;
                        $totalAmount = ($price + $shipment + $taxAmount);

                    } else { 
                        $taxAmount = 0;
                        $tempprice = 0;
                        $totalAmount = 0;
                        $price = 0;
                        $sum = 0;
                        ?>

                        <div>Your Cart is emty.</div>
                    <?php } ?>
            </div>
            <div class="right">
            <div class="priceDiv" id="priceDiv">
                <h1 >Price: </h1>
                <div><?php echo " " ?></div>
                <h1><?php echo number_format($totalAmount * $equivalentRate, 2, ',', '.').' '.$symbol; ?></h1>
            </div>
                <?php if ($result->num_rows > 0) { ?>
                <a href="buy?id=cart"  class="pay-button2" id="fixedHeader"><button>Pay</button></a>
                <?php } else { ?>
                <a href="cart" class="pay-button2" id="fixedHeader><button">Pay</button></a>
                <?php } ?>
                </div>
                </div>
               
                        <div class="pricing" id="pricing">
                            <div class="part">
                                <h1 class="blue">Total: <?php echo number_format($totalAmount * $equivalentRate, 2, ',', '.').' '.$symbol; ?></h1>
                                <div>Total amount of the order includes VAT.</div>
                                <a href="">Details anzeigen</a>
                            </div>
                            <div class="part">
                                <h1>Cart Summary</h1>
                                <div class="block">
                                    <div>Item: <?php echo number_format($price * $equivalentRate, 2, ',', '.') . " " . $symbol; ?></div>
                                    <div>Packing & Shipping: <?php echo number_format($shipment * $equivalentRate, 2, ',', '.') . " " . $symbol; ?></div>
                                </div>
                                <div class="block">
                                    <div style="padding-bottom: 25px;">Summe: <?php echo number_format($sum * $equivalentRate, 2, ',', '.') . " " . $symbol; ?></div>
                                    <div>Tax: <?php echo number_format($taxAmount * $equivalentRate, 2, ',', '.') . " " . $symbol; ?></div>
                                </div>
                                <div>Total: <?php echo number_format($totalAmount * $equivalentRate, 2, ',', '.') . " " . $symbol; ?></div>
                            </div>
                            <div class="last-part">
                                <?php if ($result->num_rows > 0) { ?>
                                    <a href="buy?id=cart" class="pay-button"><button>Pay</button></a>
                                    <?php } else { ?>
                                    <a href="cart" class="pay-button"><button>Pay</button></a><?php
                                    } ?>
                            </div>
                            
                        </div>
                        
            </div>
        </div>
    </div>
    
<footer class="footer">
  	 
  </footer>

 <script>
        function checkScreenWidth() {
            const screenWidth = window.innerWidth;
            const priceDiv = document.getElementById('priceDiv');
            if (screenWidth < 767) {
                window.addEventListener('scroll', function() {
                    const stickyDiv = document.getElementById('pricing');
                    const myDiv = document.getElementById('cart');
                    const viewportHeight = window.innerHeight;

                    if (window.scrollY >= myDiv.offsetTop + myDiv.offsetHeight - viewportHeight + 150) {
                    stickyDiv.style.position = 'absolute';
                    } else {
                    stickyDiv.style.position = 'fixed';
                    }
                });
            } else {
                priceDiv.style.display = 'flex';
            }
        }
</script>

<script>
    const header = document.getElementById('fixedHeader');

// Get the initial offset of the header from the top of the document
const headerOffsetTop = header.offsetTop;

// Function to check whether the header should be fixed or not
function checkHeaderPosition() {
  if (window.pageYOffset >= headerOffsetTop) {
    // If the scroll position is greater than or equal to the initial offset of the header,
    // make the header fixed at the top
    header.style.position = 'fixed';
    header.style.top = '10px';
    header.style.width = '95.75%';
  } else {
    header.style.position = 'relative';
    header.style.width = '100%';
  }
}

// Add an event listener to the 'scroll' event
window.addEventListener('scroll', checkHeaderPosition);
</script>


<script>
  // Function to go back to the previous page
  function goBack() {
    window.history.back();
  }

  // Add a click event listener to the button
  const goBackButton = document.getElementById('row2');
  goBackButton.addEventListener('click', goBack);
</script>


</body>
</html>