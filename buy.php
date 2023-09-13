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
$way = $_GET['id'];

$sql3 = "SELECT * FROM userdata WHERE id = '$id'";
$result3 = $conn->query($sql3);
$row3 = mysqli_fetch_assoc($result3);

if ($way == "cart") {
    $sql = "SELECT * FROM cart WHERE user_id = '$id'";
    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $totalQuantity += 1 * $row['ammount'];
    }
} 

else {
    $sql = "SELECT * FROM cart WHERE user_id = '$id'";
    $result = $conn->query($sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $totalQuantity += 1 * $row['ammount'];
    }
    $product_id = $_GET['id'];
    $sql1 = "SELECT * FROM uploads WHERE upid = '$product_id'";
    $result1 = $conn->query($sql1);
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
    <title>Affliace: Payment</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="buy.css">
    <link rel="stylesheet" href="credit-cart.css">
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
                            <a href="index" id="bottom2"><i class="fas fa-arrow-left" id="icon"></i></a>
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
  
  .block {
    padding-top: 25px;
  }
  
  .fas {
    transform: translateY(-50%);
    width: 30px;
    height: 30px;
    font-size: 23px;
    text-align: center;
    color: black;
  }

    </style>

    <div class="cart">
        <div class="top">
        </div>
        <div class="bottom">
            <div class="left">
                <div class="details">
                    <h1 class="blue">Details</h1>
                    <button class="open-button" onclick="openModal()">Change</button>
                    <div><?php echo $row3['username']; ?></div>
                    <div><?php echo $row3['country']; ?></div>
                    <div><?php echo $row3['address']; ?></div>
                    <div><?php echo $row3['city'] . ", " . $row3['zip']; ?></div>
                </div>
                <div id="modal-overlay" class="modal-overlay">
                    <div class="modal-content">
                        <div class="close-button">
                            <span onclick="closeModal()" class="x-symbol">X</span>
                        </div>
                        <h2 class="blue">Change Details</h2>
                        <form action="update_address?id=<?php echo $product_id; ?>" method="post">
                            <div class="input-box">
                                <span>Country</span>
                                <select name="country" id="country" require>
                                    <option value="<?php echo $row3['country']; ?>"><?php echo $row3['country']; ?></option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Albania">Albania</option>
                                    <option value="Algeria">Algeria</option>
                                    <option value="Andorra">Andorra</option>
                                    <option value="Angola">Angola</option>
                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                    <option value="Argentina">Argentina</option>
                                    <option value="Armenia">Armenia</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Austria">Austria</option>
                                    <option value="Azerbaijan">Azerbaijan</option>
                                    <option value="Bahamas">Bahamas</option>
                                    <option value="Bahrain">Bahrain</option>
                                    <option value="Bangladesh">Bangladesh</option>
                                    <option value="Barbados">Barbados</option>
                                    <option value="Belarus">Belarus</option>
                                    <option value="Belgium">Belgium</option>
                                    <option value="Belize">Belize</option>
                                    <option value="Benin">Benin</option>
                                    <option value="Bhutan">Bhutan</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                    <option value="Botswana">Botswana</option>
                                    <option value="Brazil">Brazil</option>
                                    <option value="Brunei">Brunei</option>
                                    <option value="Bulgaria">Bulgaria</option>
                                    <option value="Burkina Faso">Burkina Faso</option>
                                    <option value="Burundi">Burundi</option>
                                    <option value="Cabo Verde">Cabo Verde</option>
                                    <option value="Cambodia">Cambodia</option>
                                    <option value="Cameroon">Cameroon</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Central African Republic">Central African Republic</option>
                                    <option value="Chad">Chad</option>
                                    <option value="Chile">Chile</option>
                                    <option value="China">China</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Comoros">Comoros</option>
                                    <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                                    <option value="Congo, Republic of the">Congo, Republic of the</option>
                                    <option value="Costa Rica">Costa Rica</option>
                                    <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                    <option value="Croatia">Croatia</option>
                                    <option value="Cuba">Cuba</option>
                                    <option value="Cyprus">Cyprus</option>
                                    <option value="Czech Republic">Czech Republic</option>
                                    <option value="Denmark">Denmark</option>
                                    <option value="Djibouti">Djibouti</option>
                                    <option value="Dominica">Dominica</option>
                                    <option value="Dominican Republic">Dominican Republic</option>
                                    <option value="East Timor (Timor-Leste)">East Timor (Timor-Leste)</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="Egypt">Egypt</option>
                                    <option value="El Salvador">El Salvador</option>
                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                    <option value="Eritrea">Eritrea</option>
                                    <option value="Estonia">Estonia</option>
                                    <option value="Eswatini">Eswatini</option>
                                    <option value="Ethiopia">Ethiopia</option>
                                    <option value="Fiji">Fiji</option>
                                    <option value="Finland">Finland</option>
                                    <option value="France">France</option>
                                    <option value="Gabon">Gabon</option>
                                    <option value="Gambia">Gambia</option>
                                    <option value="Georgia">Georgia</option>
                                    <option value="Germany">Germany</option>
                                    <option value="Ghana">Ghana</option>
                                    <option value="Greece">Greece</option>
                                    <option value="Grenada">Grenada</option>
                                    <option value="Guatemala">Guatemala</option>
                                    <option value="Guinea">Guinea</option>
                                    <option value="Guinea-Bissau">Guinea-Bissau</option>
                                    <option value="Guyana">Guyana</option>
                                    <option value="Haiti">Haiti</option>
                                    <option value="Honduras">Honduras</option>
                                    <option value="Hungary">Hungary</option>
                                    <option value="Iceland">Iceland</option>
                                    <option value="India">India</option>
                                    <option value="Indonesia">Indonesia</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Iraq">Iraq</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Israel">Israel</option>
                                    <option value="Italy">Italy</option>
                                    <option value="Jamaica">Jamaica</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Jordan">Jordan</option>
                                    <option value="Kazakhstan">Kazakhstan</option>
                                    <option value="Kenya">Kenya</option>
                                    <option value="Kiribati">Kiribati</option>
                                    <option value="Korea, North">Korea, North</option>
                                    <option value="Korea, South">Korea, South</option>
                                    <option value="Kosovo">Kosovo</option>
                                    <option value="Kuwait">Kuwait</option>
                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                    <option value="Laos">Laos</option>
                                    <option value="Latvia">Latvia</option>
                                    <option value="Lebanon">Lebanon</option>
                                    <option value="Lesotho">Lesotho</option>
                                    <option value="Liberia">Liberia</option>
                                    <option value="Libya">Libya</option>
                                    <option value="Liechtenstein">Liechtenstein</option>
                                    <option value="Lithuania">Lithuania</option>
                                    <option value="Luxembourg">Luxembourg</option>
                                    <option value="Madagascar">Madagascar</option>
                                    <option value="Malawi">Malawi</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Maldives">Maldives</option>
                                    <option value="Mali">Mali</option>
                                    <option value="Malta">Malta</option>
                                    <option value="Marshall Islands">Marshall Islands</option>
                                    <option value="Mauritania">Mauritania</option>
                                    <option value="Mauritius">Mauritius</option>
                                    <option value="Mexico">Mexico</option>
                                    <option value="Micronesia">Micronesia</option>
                                    <option value="Moldova">Moldova</option>
                                    <option value="Monaco">Monaco</option>
                                    <option value="Mongolia">Mongolia</option>
                                    <option value="Montenegro">Montenegro</option>
                                    <option value="Morocco">Morocco</option>
                                    <option value="Mozambique">Mozambique</option>
                                    <option value="Myanmar (Burma)">Myanmar (Burma)</option>
                                    <option value="Namibia">Namibia</option>
                                    <option value="Nauru">Nauru</option>
                                    <option value="Nepal">Nepal</option>
                                    <option value="Netherlands">Netherlands</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Nicaragua">Nicaragua</option>
                                    <option value="Niger">Niger</option>
                                    <option value="Nigeria">Nigeria</option>
                                    <option value="North Macedonia (Macedonia)">North Macedonia (Macedonia)</option>
                                    <option value="Norway">Norway</option>
                                    <option value="Oman">Oman</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palau">Palau</option>
                                    <option value="Panama">Panama</option>
                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                    <option value="Paraguay">Paraguay</option>
                                    <option value="Peru">Peru</option>
                                    <option value="Philippines">Philippines</option>
                                    <option value="Poland">Poland</option>
                                    <option value="Portugal">Portugal</option>
                                    <option value="Qatar">Qatar</option>
                                    <option value="Romania">Romania</option>
                                    <option value="Russia">Russia</option>
                                    <option value="Rwanda">Rwanda</option>
                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                    <option value="Saint Lucia">Saint Lucia</option>
                                    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                    <option value="Samoa">Samoa</option>
                                    <option value="San Marino">San Marino</option>
                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                    <option value="Senegal">Senegal</option>
                                    <option value="Serbia">Serbia</option>
                                    <option value="Seychelles">Seychelles</option>
                                    <option value="Sierra Leone">Sierra Leone</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Slovakia">Slovakia</option>
                                    <option value="Slovenia">Slovenia</option>
                                    <option value="Solomon Islands">Solomon Islands</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="South Africa">South Africa</option>
                                    <option value="South Sudan">South Sudan</option>
                                    <option value="Spain">Spain</option>
                                    <option value="Sri Lanka">Sri Lanka</option>
                                    <option value="Sudan">Sudan</option>
                                    <option value="Suriname">Suriname</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Syria">Syria</option>
                                    <option value="Taiwan">Taiwan</option>
                                    <option value="Tajikistan">Tajikistan</option>
                                    <option value="Tanzania">Tanzania</option>
                                    <option value="Thailand">Thailand</option>
                                    <option value="Togo">Togo</option>
                                    <option value="Tonga">Tonga</option>
                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                    <option value="Tunisia">Tunisia</option>
                                    <option value="Turkey">Turkey</option>
                                    <option value="Turkmenistan">Turkmenistan</option>
                                    <option value="Tuvalu">Tuvalu</option>
                                    <option value="Uganda">Uganda</option>
                                    <option value="Ukraine">Ukraine</option>
                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                    <option value="United Kingdom">United Kingdom</option>
                                    <option value="United States of America">United States of America</option>
                                    <option value="Uruguay">Uruguay</option>
                                    <option value="Uzbekistan">Uzbekistan</option>
                                    <option value="Vanuatu">Vanuatu</option>
                                    <option value="Vatican City">Vatican City</option>
                                    <option value="Venezuela">Venezuela</option>
                                    <option value="Vietnam">Vietnam</option>
                                    <option value="Yemen">Yemen</option>
                                    <option value="Zambia">Zambia</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>
                            <div class="input-box">
                                <span>Name (Pre- and Lastname)</span>
                                <input id="name" type="text" name="name" value="<?php echo $row3['username']; ?>" placeholder="Name" require>
                            </div>
                            <div class="input-box">
                                <span>Address</span>
                                <input id="address" type="text" name="address" value="<?php echo $row3['address']; ?>" placeholder="Address" require>
                            </div>
                            <div class="input-box">
                                <span>Zip</span>
                                <input id="zip" type="text" name="zip" value="<?php echo $row3['zip']; ?>" placeholder="Zip" require>
                            </div>
                            <div class="input-box">
                                <span>City</span>
                                <input id="city" type="text" name="city" value="<?php echo $row3['city']; ?>" placeholder="City" require>
                            </div>
                            <?php 
                            $address = $row3['address'];
                            $zip = $row3['zip'];
                            $city = $row3['city'];
                            $combinedaddress = $address . " " .  $zip . " " . $city; ?>
                            <input type="submit" value="Change">
                        </form>

                    </div>
                </div>
                <div class="product-container">
                    <h1 class="blue">Products</h1>
                    <?php
                    $shipment = 0;
                    if ($way == "cart") {
                        $totalPrice = 0;
                        $totalAmount = 0;
                        $sql = "SELECT * FROM cart WHERE user_id = '$id'";
                        $result = $conn->query($sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $productID = $row['product_id'];
                            $sqlProduct = "SELECT * FROM uploads WHERE upid = '$productID'";
                            $resultProduct = $conn->query($sqlProduct);
                            $productIDs[] = $productID;
                            if ($resultProduct->num_rows > 0) {
                                while ($product = $resultProduct->fetch_assoc()) {
                                    $path = $product['preview'];
                                    $filename = basename($path);
                                    $count = $row['ammount'];
                                    $raw_price = $product['price'];
                                    $price += $product['price'] * $count;
                                    $shipment += $product['shipping'];
                                    $product_shipment = $product['shipping'];
                                    $seller_id = $product['id'];
                                    $product_id = $product['upid'];

                                    $taxRate = 0.19;
                                    $sum = $price;
                                    $taxAmount = $sum * $taxRate;
                                    $totalAmount = ($sum + $shipment + $taxAmount);

                                    if (isset($_POST['submit'])) {
                                        $sql9 = "INSERT INTO orders (order_id, user_id, seller_id, product_id, ammount, name, address, price, shipping, tax, total, time, status)
                                        VALUES (0,'$id', '$seller_id', '$product_id', '$count', '$username', '$combinedaddress', '$raw_price', '$product_shipment', '$taxRate', '$totalAmount', NOW(), 0)";
                                        if ($result9 = $conn->query($sql9) === true) { ?>
                                            <script>
                                                window.location.href='succses'
                                            </script>  <?php 
                                            } else {
                                            //error messege
                                            }
                                    }

                                    ?>
                                    <table class="product-table">
                                        <tr>
                                            <td class="thumbnail"><img src="videos/<?php echo $filename; ?>"></td>
                                            <td class="titel"><div><?php echo $product['titel']; ?></div></td>
                                            <td class="price"><?php echo number_format($product['price'] * $equivalentRate, 2, ',', '.') . "" . $symbol; ?></td>
                                            <td class="ammount">
                                                <div class="flex">
                                                    <form action="upload_minus?id=cart&loc=buy" method="post">
                                                        <input type="hidden" name="count" value="<?php echo $count; ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
                                                        <button type="submit" value="-" class="minus-btn">-</button>
                                                    </form>
                                                    <div><?php echo $count; ?></div>
                                                    <form action="upload_plus?id=cart&loc=buy" method="post">
                                                        <input type="hidden"name="count" value="<?php echo $count; ?>">
                                                        <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
                                                        <button type="submit" value="+" class="plus-btn">+</button>
                                                    </form>
                                                    
                                                </div>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                            }
                        }
                    } else {
                        $product_id = $_GET['id'];
                        $sql1 = "SELECT * FROM uploads WHERE upid = '$product_id'";
                        $result1 = $conn->query($sql1);
                        while ($product = $result1->fetch_assoc()) {
                            $path = $product['preview'];
                            $filename = basename($path);
                            $shipment += $product['shipping'];
                            if (!isset($_SESSION['ammount'])) {
                                $count = 1;
                            } else {
                                $count  = $_SESSION['ammount'];
                            }
                            $price += $product['price'] * $count;
                            $seller_id = $product['id'];
                            $product_id = $product['upid'];
                            ?>

                            <table class="product-table">
                                <tr>
                                    <td class="thumbnail"><img src="videos/<?php echo $filename; ?>"></td>
                                    <td><?php echo $product['titel']; ?></td>
                                    <td><?php echo number_format($product['price'] * $equivalentRate, 2, ',', '.').' '.$symbol; ?></td>
                                    <td class="amount">
                                        <form action="change_count?id=<?php echo $product_id; ?>&affiliate=<?php echo $affiliate; ?>" method="post">
                                            <input type="text"  maxlength="2" class="ammount-input" name="ammount" value="<?php echo $count; ?>">
                                            <input type="submit" value="send" class="submit">
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <?php
                        }
                        $totalAmount = 0;
                        $taxRate = 0.19;
                        $sum = $price;
                        $taxAmount = $sum * $taxRate;
                        $totalAmount += ($sum + $shipment + $taxAmount);
                    }
                    

                    
                    ?>
                </div>
                </div>
            <div class="flex22">
                <div class="payment">
                    <h1 class="blue">Payment</h1>
                    <div class="circle-selector">
                        <input type="radio" name="option" id="radio1" onclick="showDiv(1)" checked>
                        <label for="radio1">Credit Card</label>

                        <input type="radio" name="option" id="radio2" onclick="showDiv(2)">
                        <label for="radio2">Paypal</label>

                        <input type="radio" name="option" id="radio3" onclick="showDiv(3)">
                        <label for="radio3">Div 3</label>
                    </div>  
                    <div id="div1" class="content active">
                        <div class="container">
                        <div class="card-container" id="div1">
                            <div class="front">
                                <div class="image">
                                    <h1>Credit Card</h1>
                                    <img src="card_chip.png" alt="">
                                </div>
                                <div class="card-number-box">****************</div>
                                <div class="flexbox">
                                    <div class="box">
                                        <div class="card-holder-name">Name</div>
                                    </div>
                                    <div class="box">
                                        <div class="expiration">
                                            <span class="exp-month">mm</span>
                                            <span>/</span>
                                            <span class="exp-year">yy</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="back">
                                <div class="stripe"></div>
                                <div class="box">
                                    <span>cvv</span>
                                    <div class="cvv-box"></div>
                                    <h1>Credit Card</h1>
                                </div>
                            </div>

                            </div>
                    <?php if ($way == "cart") { ?>
                        <form action="upload_order_cart" method="post">
                        <?php } else { 
                            ?>
                        <form action="upload_order_product" method="post">
                        <?php } ?>
                            <div class="inputBox">
                                <span>Card Number</span>
                                <input type="text" maxlength="16" class="card-number-input" required>
                            </div>
                            <div class="inputBox">
                                <span>Card Holder</span>
                                <input type="text" class="card-holder-input" required>
                            </div>
                            <div class="flexbox">
                                <div class="inputBox">
                                    <span>Expiration mm</span>
                                    <select name="" id="" class="month-input" required>
                                        <option value="month" selected disabled>month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="inputBox">
                                    <span>Expiration yy</span>
                                    <select name="" id="" class="year-input" required>
                                        <option value="year" selected disabled>year</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2031</option>
                                        <option value="2030">2032</option>
                                        <option value="2030">2033</option>
                                        <option value="2030">2034</option>
                                    </select>
                                </div>
                                <div class="inputBox">
                                    <span>CVC</span>
                                    <input type="text" maxlength="4" class="cvv-input" require>
                                </div>
                            </div>
                            <div class="submit-btn-container">
                                <?php 
                               if (!empty($row3['username']) && !empty($row3['country']) && !empty($row3['address']) && !empty($row3['city']) && !empty($row3['zip'])) {
                                    if ($way == "cart") {
                                         ?>
                                    <form action="upload_order_cart" method="post">
                                        <input type="submit" name="submit" value="Buy Now" class="submit-btn">
                                    </form>
                                <?php } else {  ?>
                                    <form action="upload_order_product" method="post">
                                        <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                                        <input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="hidden" name="ammount" value="<?php echo $count; ?>">
                                        <input type="hidden" name="name" value="<?php echo $username; ?>">
                                        <input type="hidden" name="address" value="<?php echo $combinedaddress ?>">
                                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                                        <input type="hidden" name="shipping" value="<?php echo $shipment; ?>">
                                        <input type="hidden" name="tax_rate" value="<?php echo $taxRate; ?>">
                                        <input type="hidden" name="total_amount" value="<?php echo $totalAmount; ?>">
                                        <input type="hidden" name="affiliate" value="<?php echo $affiliate; ?>">
                                        <input type="submit" value="Buy Now" class="submit-btn">
                                    </form>
                            <?php } } else { ?>
                                    <input type="button" onclick="openModal()" value="Change Deteils" class="detail-btn">
                               <?php } ?>
                            </div>
                        </div>
                        
                    </div>
                    <div id="div2" class="content" style="display: none;">
                        <div id="paypal-button-container" class="paypal"></div>
                    </div>
                    <div id="div3" class="content" style="display: none;">Content for Div 3</div>
                </div>
            <div class="right">
                <div class="pricing">
                    <div class="part">
                        <?php $formattedAmount = number_format($totalAmount, 2, ',', '.'); ?>
                        <h1 class="blue">Total: <?php echo number_format(round($totalAmount * $equivalentRate, 2), 2, ',', '.') . " " . $symbol; ?></h1>
                        <div>Total amount of the order includes VAT.</div>
                        <a href="">Details anzeigen</a>
                    </div>
                    <div class="last-part">
                        <h1>Order Summary</h1>
                        <div class="block">
                            <div>Item: <?php echo number_format(($price * $equivalentRate), 2, ',', '.') . " " . $symbol; ?></div>
                            <div>Packing & Shipping: <?php echo number_format(($shipment * $equivalentRate), 2, ',', '.') . " " . $symbol; ?></div>
                        </div>
                        <div class="block">
                            <div style="padding-bottom: 25px;">Summe: <?php echo number_format(($sum + $shipment), 2, ',', '.') . " " . $symbol; ?></div>
                            <div>Tax: <?php echo number_format(round($taxAmount * $equivalentRate, 2), 2, ',', '.') . " " . $symbol; ?></div>
                        </div>
                        <div>Total: <?php echo number_format(round($totalAmount * $equivalentRate, 2), 2, ',', '.') . " " . $symbol; ?></div>
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>
</div>
 
<footer>

  </footer>

  <script>
               const radio1 = document.getElementById('radio1');
                    const radio2 = document.getElementById('radio2');
                    const radio3 = document.getElementById('radio3');
                    const div1 = document.getElementById('div1');
                    const div2 = document.getElementById('div2');
                    const div3 = document.getElementById('div3');
                    
                    radio1.addEventListener('click', function() {
                    div1.style.display = 'block';
                    div2.style.display = 'none';
                    div3.style.display = 'none';
                    });
                    
                    radio2.addEventListener('click', function() {
                    div1.style.display = 'none';
                    div2.style.display = 'block';
                    div3.style.display = 'none';
                    });
                    
                    radio3.addEventListener('click', function() {
                    div1.style.display = 'none';
                    div2.style.display = 'none';
                    div3.style.display = 'block';
                    });
                </script>
                <script src="https://www.paypal.com/sdk/js?client-id=AZ7lb29SySUaF0gB_hqSzRAYR0fpn4EwldkwLVYDdtJM6jvuNQWQN6ObfQ0nXo5KFgK4Mozl0VS9_Wdf&components=buttons"></script>
                <script>
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units:[{
                                    amount:{
                                        value:"<?php echo $totalPrice; ?>"
                                    }
                                }]
                            })
                        },
                        onApprove:function(data,actions) {
                            return actions.order.capture().then(function(details) {
                                console.log(details);
                                <?php      
                                if (isset($_POST['approve_payment'])) {
                                    if ($way == "cart") {
                                        while ($row = mysqli_fetch_assoc($result)) 
                                        $product_id = $row['product_id'];

                                        //order insert
                                        $address = $row3['address'];
                                        $sql3 = "INSERT INTO orders (user_id, product_id, ammount, name, address, time) VALUES ('$user_id', '$product_id', '$count', '$name', '$address', NOW())";
                                        mysqli_query($conn, $sql3);

                                        //buyed add 1 update in uploads
                                        $sql4 = "SELECT buyed FROM uploads WHERE upid = '$product_id'";
                                        $result4 = mysqli_query($conn, $sql4);
                                        $row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
                                        $number = $row4['buyed'] + 1;

                                        $sql7 = "UPDATE uploads SET buyed = '$number' WHERE upid = '$product_id'";
                                        mysqli_query($conn, $sql7);
                                        
                                        //cart delete
                                        $sql8 = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
                                        mysqli_query($conn, $sql8);
                                    } else {

                                        //order insert
                                        $address = $row3['address'];
                                        $sql3 = "INSERT INTO orders (user_id, product_id, ammount, name, address, time) VALUES ('$user_id', '$product_id', '$count', '$name', '$address', NOW())";
                                        mysqli_query($conn, $sql3);

                                        //buyed add 1 update in uploads
                                        $sql4 = "SELECT buyed FROM uploads WHERE upid = '$product_id'";
                                        $result4 = mysqli_query($conn, $sql4);
                                        $row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
                                        $number = $row4['buyed'] + 1;

                                        $sql7 = "UPDATE uploads SET buyed = '$number' WHERE upid = '$product_id'";
                                        mysqli_query($conn, $sql7);
                                        
                                        //cart delete
                                        $sql8 = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
                                        mysqli_query($conn, $sql8);
                                    }
                                }
                                ?>
                                window.location.replace("https://ithelppp.000webhostapp.com/success");
                            })
                        },
                        onCancel:function(data) {
                            window.location.replace("https://ithelppp.000webhostapp.com/oncancel?loc=<?php echo $way; ?>");
                        }
                    }).render('#paypal-button-container');
                </script>
                                        <script>
                            const scrollContainer = document.getElementById("scrollContainer");
                            const scrollContent = document.getElementById("scrollContent");
                            const scrollbar = document.createElement("div");
                            scrollbar.id = "scrollbar";
                            scrollContainer.appendChild(scrollbar);

                            scrollContent.addEventListener("scroll", () => {
                            const scrollPercentage = (scrollContent.scrollTop / (scrollContent.scrollHeight - scrollContent.clientHeight)) * 100;
                            const scrollbarPosition = (scrollContainer.clientHeight - scrollbar.offsetHeight) * (scrollPercentage / 100);
                            scrollbar.style.top = `${scrollbarPosition}px`;
                            });

                            scrollbar.addEventListener("mousedown", (event) => {
                            event.preventDefault();
                            const startY = event.clientY;
                            const scrollbarPosition = scrollbar.offsetTop;

                            document.addEventListener("mousemove", moveScrollbar);

                            document.addEventListener("mouseup", () => {
                                document.removeEventListener("mousemove", moveScrollbar);
                            });

                            function moveScrollbar(event) {
                                const deltaY = event.clientY - startY;
                                const maxScrollbarPosition = scrollContainer.clientHeight - scrollbar.offsetHeight;

                                const newScrollbarPosition = Math.min(Math.max(scrollbarPosition + deltaY, 0), maxScrollbarPosition);
                                const scrollPercentage = (newScrollbarPosition / (scrollContainer.clientHeight - scrollbar.offsetHeight)) * 100;
                                const scrollTop = (scrollContent.scrollHeight - scrollContent.clientHeight) * (scrollPercentage / 100);

                                scrollContent.scrollTop = scrollTop;
                            }
                            });

                            scrollContainer.addEventListener("mouseenter", () => {
                            scrollbar.style.opacity = "1";
                            });

                            scrollContainer.addEventListener("mouseleave", () => {
                            scrollbar.style.opacity = "0";
                            });
                        </script>
                        <script>
                            function openModal() {
                                document.getElementById("modal-overlay").style.display = "flex";
                            }

                            function closeModal() {
                                document.getElementById("modal-overlay").style.display = "none";
                            }
                        </script>
                        <script>

                        document.querySelector('.card-number-input').oninput = () =>{
                        document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
                        }

                        document.querySelector('.card-holder-input').oninput = () =>{
                        document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
                        }

                        document.querySelector('.month-input').oninput = () =>{
                        document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
                        }

                        document.querySelector('.year-input').oninput = () =>{
                        document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
                        }

                        document.querySelector('.cvv-input').onmouseenter = () =>{
                        document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
                        document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
                        }

                        document.querySelector('.cvv-input').onmouseleave = () =>{
                        document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
                        document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
                        }

                        document.querySelector('.cvv-input').oninput = () =>{
                        document.querySelector('.cvv-box').innerText = document.querySelector('.cvv-input').value;
                        }

                    </script>
                    <script>
                        window.onbeforeunload = function() {
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'notify', true);
                            xhr.send();
                        };
</script>
    <div id="bottom2" class="bottom2">
        <div class="block"><a href="index">
          <i class="fas fa-home"></i>
        </a></div>
        <div class="block"><a href="orders">
          <i class="fas fa-chart-line"></i>
        </a></div>
        <div class="block"><a href="cart">
            <i class="fas fa-shopping-cart"></i>
        </a></div>
        <div class="block"><a href="orders">
          <i class="fas fa-upload"></i>
        </a></div>
        <div class="block"><a href="orders">
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



</body>
</html>

