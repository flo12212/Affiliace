<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();


$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$filteredQuantityArray = []; // Initialize as an empty array

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
$id = $_GET['id'];

if (!isset($_GET['affiliate'])) {
    $affiliate = 0;
} else {
    $affiliate = $_GET['affiliate'];
}




$sql = "SELECT * FROM uploads WHERE '$id' = upid";
$result = $conn->query($sql);

$rewiews = "SELECT * FROM rewievs WHERE '$id' = product_id";
$result_rewiews = $conn->query($rewiews);





if ($row = $result->fetch_assoc()) {

    $upuserid = $row['id'];
    $sql2 = "SELECT * FROM userdata WHERE id = $upuserid";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
    $upusername = $row2['username'];



    $views = $row['views'];
    $number = $views + 1;


    $sql3 = "UPDATE uploads SET views = '$number' WHERE upid = '$id'";


    $conn->query($sql3);

    
    $path = $row['preview'];
    $filename = basename($path);

    $path = $row['preview'];
    $filename = basename($path);

    $symbol = $_SESSION['currancy'];
    $equivalentRate = $_SESSION['equivalent'];
    $query = "SELECT COUNT(*) as total_reviews, AVG(stars) as average_rating FROM rewievs WHERE product_id = $id";
    $result8 = $conn->query($query);
    $row8 = $result8->fetch_assoc();

    $totalReviews = $row8["total_reviews"];
    $averageRating = $row8["average_rating"];
    if ($averageRating !== null && is_numeric($averageRating)) {
        $formattedRating = number_format($averageRating, 1, ',', '');
    } else {
        $formattedRating = $averageRating;
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
    <title><?php echo $row['titel']; ?></title>
    <link rel="stylesheet" href="product.css">
    <link rel="stylesheet" href="header.css">
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

    
    <style>
          .bottom {
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

    <div class="container">
        <div class="home">
            <a href="index"><button>Home</button></a>
            <button onclick="copyURL()">Copy Link</button>
        </div>

        <?php 
$fileNamesStr = $row['images'];
$fileNames = explode(",", $fileNamesStr);
$numberOfFiles = count($fileNames);
?>

        <div class="row" id="row1">
            <div class="button-container">
                    <?php
                    if ($numberOfFiles > 1) {
                        $i = 0;
                        while ($i < $numberOfFiles) {
                            $i++;
                            ?>
                            <button onclick="changeImage('<?php echo $fileNames[$i-1]; ?>')">
                                <img src="videos/<?php echo $fileNames[$i-1]; ?>" alt="<?php echo $fileNames[$i-1]; ?>">
                            </button>
                            <?php
                        }
                    }
                    ?>

                </div>
                <div class="col1" id="col1">
                    <img id="product-image" src="videos/<?php echo $filename; ?>" class="product-image" alt="Product Image">
                </div>
                <div class="col">
                    <h1><?php echo $row['titel']; ?></h1>
                    <p class="description"><?php echo $row['description']; ?></p>
                    <?php 
                    $taxRate = 0.19;
                    $tax = $row['price'] * $taxRate;
                    $totalPrice = $row['price'] + $row['shipping'] + $tax;
                    ?>
                    <div class="price"><?php echo number_format($totalPrice * $equivalentRate, 2, ',', '.').' '.$symbol; ?></div>
                    <div id="output1"></div>
                    <script>
                        const daysInput = <?php echo $row['ship_days']; ?>;
                        const hourSelect = <?php echo $row['ship_hours']; ?>;
                        const outputDiv = document.getElementById('output1');
                        // Call the function to calculate and display the date instantly
                        calculateDate();

function calculateDate() {
    const now = new Date(); // Current date and time
    const future = new Date(now.getTime()); // Create a copy of the current date and time

    future.setDate(future.getDate() + daysInput); // Add days
    future.setHours(future.getHours() + hourSelect); // Add hours

    const options = { weekday: 'long', month: 'long', day: 'numeric' };
    const formattedDate = future.toLocaleDateString(undefined, options); // Format the future date as a string

    const dayOfWeek = formattedDate.split(',')[0]; // Extract the day of the week from the formatted date
    const restOfDate = formattedDate.split(', ').slice(1).join(', '); // Extract the rest of the formatted date

    outputDiv.textContent = `Delivery for ${restOfDate}, ${dayOfWeek}`;
}

                    </script>
                    <p>
                    <?php
                    echo $formattedRating;
                    echo " ";
                    $roundedRating = round($averageRating * 2) / 2;
                    $hasHalfStar = false;

                    if ($averageRating - $roundedRating >= 0.25 && $averageRating - $roundedRating <= 0.75) {
                        $hasHalfStar = true;
                    }

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $roundedRating) {
                            echo "&#9733;"; // Full star
                        } elseif ($hasHalfStar && $i - 0.5 == $roundedRating) {
                            echo "&#189;"; // Half star (unicode for ½)
                        } else {
                            echo "&#9734;"; // Empty star
                        }
                    }
                    ?></p>
                    <p>Seller: <a href="seller?id=<?php echo $row['id']; ?>"><?php echo $upusername; ?></a></p>
                    
                    
                    <?php if (!($row['way'] == 'Affiliate')) { ?>
                        <form action="upload-card?id=<?php echo $id; ?>&source=product" method="post"><button class="cart-button">Add to card</button></form>
                        <?php 
                            if (!isset($_SESSION['user_id'])) { ?>
                                <a href="login?product_id=<?php echo $id; ?>&affiliate=<?php echo $affiliate; ?>"><button class="buy-button">Buy</button></a>
                        <?php } else { ?>
                            <a href="buy?id=<?php echo $id; ?>&affiliate=<?php echo $affiliate; ?>"><button class="buy-button">Buy</button></a> <?php 
                    } } else {
                        ?>
                        <a href="<?php echo $row['link']; ?>" target="_blank"><button class="buy-button">Buy</button></a>
                        <?php }?>
                    </div>
                </div>
                <div class="infos">

            </div>
        </div>

        <div id="row2">
                <h1><?php echo $row['titel']; ?></h1>
                <p class="star2">
                    <?php
                    echo $formattedRating;
                    echo " ";
                    $roundedRating = round($averageRating * 2) / 2;
                    $hasHalfStar = false;

                    if ($averageRating - $roundedRating >= 0.25 && $averageRating - $roundedRating <= 0.75) {
                        $hasHalfStar = true;
                    }

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $roundedRating) {
                            echo "&#9733;"; // Full star
                        } elseif ($hasHalfStar && $i - 0.5 == $roundedRating) {
                            echo "&#189;"; // Half star (unicode for ½)
                        } else {
                            echo "&#9734;"; // Empty stars
                        }
                    }
                    ?></p>
                <div class="col1">
                    <img id="product-image2" src="videos/<?php echo $filename; ?>" class="product-image" alt="Product Image">
                </div>
                <div class="button-container">
                    <?php
                    if ($numberOfFiles > 1) {
                        $i = 0;
                        while ($i < $numberOfFiles) {
                            $i++;
                            ?>
                            <button onclick="changeImage2('<?php echo $fileNames[$i-1]; ?>')">
                                <img src="videos/<?php echo $fileNames[$i-1]; ?>" alt="<?php echo $fileNames[$i-1]; ?>">
                            </button>
                            <?php
                        }
                    }
                    ?>

            </div>
                <div class="col">
                    
                    
                <?php 
                    $taxRate = 0.19;
                    $tax = $row['price'] * $taxRate;
                    $totalPrice = $row['price'] + $row['shipping'] + $tax;
                    ?>
                    <div class="price"><?php echo number_format($totalPrice * $equivalentRate, 2, ',', '.').' '.$symbol; ?></div>
                    <div id="output2"></div>
<script>
    const daysInput2 = <?php echo $row['ship_days']; ?>;
    const hourSelect2 = <?php echo $row['ship_hours']; ?>;
    const outputDiv2 = document.getElementById('output2');
    // Call the function to calculate and display the date instantly
    calculateDate();

    function calculateDate() {
        const now2 = new Date(); // Current date and time
        const future2 = new Date(now2.getTime()); // Create a copy of the current date and time

        future2.setDate(future2.getDate() + daysInput2); // Add days
        future2.setHours(future2.getHours() + hourSelect2); // Add hours

        const options2 = { month: 'long', day: 'numeric'};
        const formattedDate2 = future2.toLocaleDateString(undefined, options2); // Format the future date as a string

        outputDiv2.textContent = `Delivery for ${formattedDate2}`;
    }
</script>

                    <p class="description"><?php echo $row['description']; ?></p>
                    <p>Seller: <a href="seller?id=<?php echo $row['id']; ?>" class="seller"><?php echo $upusername; ?></a></p>
                    
                    
                    <?php if (!($row['way'] == 'Affiliate')) { ?>
                        <form action="upload-card?id=<?php echo $id; ?>&source=product" method="post"><button>Add to card</button></form>
                        <?php 
                            if (!isset($_SESSION['user_id'])) { ?>
                                <a href="login?product_id=<?php echo $id; ?>&affiliate=<?php echo $affiliate; ?>"><button class="buy-button">Buy</button></a>
                        <?php } else { ?>
                            <a href="buy?id=<?php echo $id; ?>&affiliate=<?php echo $affiliate; ?>"><button class="buy-button">Buy</button></a> <?php 
                    } } else {
                        ?>
                        <a href="<?php echo $row['link']; ?>" target="_blank"><button class="buy-button">Buy</button></a>
                        <?php }?>
                    </div>
                </div>
                <div class="infos">

            </div>
        </div>
    
        <div class="rewievs">
            <form method="POST" action="rewiev?id=<?php echo $id; ?>">
                <label for="rating">Rewievs:</label>
                <select name="rating" id="rating">
                    <option value="1">1 Star</option>
                    <option value="2">2 Star</option>
                    <option value="3">3 Star</option>
                    <option value="4">4 Star</option>
                    <option value="5">5 Star</option>
                </select>
                <br>
                <label for="rewiew">Rewiew:</label>
                <textarea name="rewiew" id="rewiew" maxlength="250" placeholder="maxlenght: 250" required></textarea>
                <div id="counter">0</div>
                <br>
                <input type="submit" value="send" class="send"> 
            </form>
            <div class="display-rewievs">
                <h3>Rewievs:</h3>
                <div class="rew-container">
                <?php while($row = $result_rewiews->fetch_assoc()) {
                        $name = $row['username'];
                        $rewiev = $row['rewiev'];
                        $stars = $row['stars'];
                        $time = $row['time'];
                        $formattedTime = date("d.m.y", strtotime($time));
                        $firstLetter2 = $name[0];
                        $sql4 = "SELECT * FROM userdata WHERE username = '$name'";
                        $result4 = $conn->query($sql4);
                        while($row4 = $result4->fetch_assoc()) {
                            $id = $row4['id'];
                             ?>

                    
                    
                   <div class="rewiev-container">
                        <div>
                            <div class="flex">
                                <div class="circle">
                                    <div><?php echo $firstLetter2; ?></div>
                                </div>
                                <div class="flexbox1">
                                    <a href="seller?id=<?php echo $id; ?>"><?php echo $name; ?></a>
                                    
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
    <div class="under-images">
        <?php 
            $i = 0;
            while ($i < count($fileNames)) { ?>
            <img src="videos/<?php echo $fileNames[$i]; ?>" class="product-image"> 
        <?php $i++; } ?>
    </div>
</div> 
    <script>
    function copyURL() {
      var url = window.location.href;
      navigator.clipboard.writeText(url)
        .then(function() {
          alert("Product Link copied to clipboard!");
        })
        .catch(function(error) {
          console.error("Error copying URL to clipboard:", error);
        });
    }
    function changeImage(imageSrc) {
        var imageElement = document.getElementById("product-image");
        imageElement.src = "videos/" + imageSrc;
        }

    function changeImage2(imageSrc2) {
    var imageElement2 = document.getElementById("product-image2");
    imageElement2.src = "videos/" + imageSrc2;
    }

  </script>
<script>
  const textarea = document.getElementById('rewiew');
  const counter = document.getElementById('counter');

  textarea.addEventListener('input', updateCharacterCount);
  textarea.addEventListener('keyup', updateCharacterCount);
  textarea.addEventListener('paste', () => setTimeout(updateCharacterCount, 0));

  function updateCharacterCount() {
    const textLength = textarea.value.length;
    counter.textContent = textLength;
  }
</script>



  <div id="bottom" class="bottom">
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





<script>
        function updateVisibility() {
            const row1 = document.getElementById("row1");
            const row2 = document.getElementById("row2");

            if (window.innerWidth < 767) {
                row1.style.display = "none"; // Hide row1
                row2.style.display = "block"; // Show row2
            } else {
                row1.style.display = "flex"; // Show row1
                row2.style.display = "none";
            }
        }

        // Call the function initially to set the correct visibility based on the screen width
        updateVisibility();

        // Listen for window resize events and update visibility accordingly
        window.addEventListener("resize", updateVisibility);
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
<script>
    $(document).ready(function() {
     $('[title="Hosted on free web hosting 000webhost.com. Host your own website for FREE."]').hide();
 });
</script>
</body>
</html>
<?php }?>


