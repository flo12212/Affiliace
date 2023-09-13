<?php

session_start();

$totalQuantity = 0;
$password_hashed = 0;
$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

if ($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $passwd = $_POST['password'];
    $name = $_POST['name'];
    $password_hashed = password_hash($passwd, PASSWORD_DEFAULT);
    $result = mysqli_query($conn, "SELECT * FROM userdata WHERE email='$email'");
    $result2 = mysqli_query($conn, "SELECT * FROM userdata WHERE username='$name'");
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="error" id="messageDiv" style="display: block;">Email address already exists!</div>';
        echo '<script>setTimeout(function() { document.getElementById("messageDiv").style.display = "none"; }, 2500);</script>';
    } if (mysqli_num_rows($result2) > 0) {
        echo '<div class="error" id="messageDiv2" style="display: block;">Username address already exists!</div>';
        echo '<script>setTimeout(function() { document.getElementById("messageDiv2").style.display = "none"; }, 2500);</script>';
    } 

    else {
        $null = "";
        $sql = "INSERT INTO userdata (email, password, username, paid, cart, address, zip, country, city, company, profilpicture, website, description, instagram, tiktok, twitter, facebook, youtube, whatsapp, linkedin, snapchat, reddit) VALUES ( '$email', '$password_hashed', '$name', '1', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null', '$null')";

        if (mysqli_query($conn, $sql)) {
            $sql2 = "SELECT * FROM userdata WHERE username = '$name'";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $_SESSION['created'] = 1;
            $_SESSION['user_id'] = $row2['id'];
            $_SESSION['username'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password_hashed;
            $_SESSION['success'] = 1;
            header('Location: index');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } 
}




$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="user.css">
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
                            <input class="search-input" type="text" name="query" placeholder="Search...">
                            <button class="search-btn" type="submit">Search</button>
                        </form>
                    </li>
                    <li  class="hide">
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
                    <li class="hide"><a href="cart" class="cart-link">
                            <div class="cart-content">
                                <img src="cart_logo.png" alt="Cart" class="cart-logo">
                                <?php if ($totalQuantity < 10): ?>
                                    <span class="cart-count cart-count-small"><?php echo $totalQuantity;?></span>
                                <?php else: ?>
                                    <span class="cart-count"><?php echo $totalQuantity;?></span>
                                <?php endif; ?>
                            </div>
                        </a></li>
                    <li class="exception" style="display: none;">
                        <div class="circle">
                            <div>?</div>
                            <div class="dropdown-menu">
                                <a href="login">Log in</a>
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
    <br><br><br><br><br>
    <div class="big">
        <div class="main">
            <h1>Register</h1><br>
            <a href="login">Already have an Account? Login</a>
            <form action="" method="post" enctype="multipart/form-data"  class="form">
                <input type="text" id="email" name="email" placeholder="Email" class="email" required>
                <input type="text" id="password" name="password" placeholder="Password" class="password" required>
                <input type="text" id="name" name="name" placeholder="Name" required>
                <div>
                    <input type="checkbox" name="terms" value="accepted" required>
                    <a href="contitions.html">I accept the terms and conditions.</a>
                </div>
                <input type="submit" value="Register" class="submit">
            </form>
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
</body>
</html>