<?php
// Start a session
session_start();

$totalQuantity = 0;

$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM userdata WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            
            if (isset($_GET['product_id'], $_GET['affiliate'])) {
                $product_id = $_GET['product_id'];
                $affiliate = $_GET['affiliate'];
        
                if ($affiliate == 0) {
                    header("Location: product?id=$product_id&affiliate=$affiliate");
                } else {
                    header("Location: product?id=$product_id");
                }
            } else {
                $_SESSION['success'] = 1;
                ?>
                <script>
                // Get the last visited URL using document.referrer
                var lastVisited = document.referrer;

                // Check if the last visited URL is not empty and not the current page
                if (lastVisited !== '' && lastVisited !== window.location.href) {
                    // Redirect to the last visited URL
                    window.location.href = lastVisited;
                } else {
                    // Redirect to a default page if no valid last visited URL is found
                    window.location.href = 'index';
                } 
                </script>
<?php 
            }
            
            
            exit();
        } else {
            echo '<div class="error" id="messageDiv" style="display: block; background-color: rgb(214, 163, 163);">Incorrect password!</div>';
            echo '<script>setTimeout(function() { document.getElementById("messageDiv").style.display = "none"; }, 2500);</script>';
        }
    } else {
        echo '<div class="error" id="messageDiv2" style="display: block; background-color: rgb(214, 163, 163);">Email not found!</div>';
        echo '<script>setTimeout(function() { document.getElementById("messageDiv2").style.display = "none"; }, 2500);</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliace: Login</title>
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="header.css">
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
                            <input class="search-input2" type="text" name="query" placeholder="Search...">
                            <button class="search-btn" type="submit">Search</button>
                        </form>
                    </li>
                    <li class="hide">
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
            <h1>Login</h1><br>
            <a href="register">Dont have a Account yet?  Register</a>
            <form action="" method="post" class="form">
                <input type="text" id="email" name="email" placeholder="Email" pattern="^[^#]*$" required>
                <input type="password" name="password" autocomplete="current-password" required="" id="id_password" placeholder="Password">
                 <div class="cart-content">
                    <span class="cart-count cart-count-small"><i class="far fa-eye" id="togglePassword"></i></span>
                </div>
                <input type="submit" value="login" name="login">
            </form>
        </div>
    </div>

    <script>
   const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#id_password');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
  </script>
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