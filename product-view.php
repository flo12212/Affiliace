<?php 


$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$firstLetter = $username[0];


$sql = "SELECT * FROM uploads WHERE id = '$user_id'";
$sql2 = "SELECT * FROM userdata WHERE id = '$user_id'";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);

$row2 = $result2->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row2['company']; ?>: Products</title>
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="product-view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
  <div class="container">
  <div class="modal-bg2" id="modal">
    <button id="closeButton" style="display: none;"><img src="arrow2.png" alt=""></button>
    <nav id="targetElement">
      <ul>
      <li>
      <?php 
          if (!empty($row2['website']) && strlen($row2['website']) > 0) {
            ?>
            <a href="<?php echo $row2['website']; ?>" target="_blank"> <?php
            } else { ?>
              <a href="index"> <?php 
            } ?>

          
            <div class="center2">
              <?php if (!empty($row2['profilpicture'])) {
                ?>
                <img src="profilpictures/<?php echo $row2['profilpicture']; ?>" alt=""  class="logo1">
                <?php
              } else { ?>
                  <img src="logo.png" class="logo1">
              <?php } ?>
              
            </div>
          </a></li>
          <li><a href="dashboard">
          <i class="fas fa-chart-line"></i>
          <span class="nav-item">Dashboard</span>
        </a></li>
        <li><a href="account">
          <i class="fas fa-user"></i>
          <span class="nav-item">Profile</span>
        </a></li>
        <li><a href="orders">
          <i class="fas fa-wallet"></i>
          <span class="nav-item">Orders</span>
        </a></li>
        <li><a href="sales">
          <i class="fas fa-tag"></i>
          <span class="nav-item">Sales</span>
        </a></li>
        <li><a href="upload1">
          <i class="fas fa-upload"></i>
          <span class="nav-item">Upload</span>
        </a></li>
        <li><a href="affiliate">
          <i class="fas fa-dollar-sign"></i>
          <span class="nav-item">Affiliate</span>
        </a></li>
        <li><a href="product-view" style="background-color: #c5d5fd;">
          <i class="fas fa-shopping-cart"></i>
          <span class="nav-item">Products</span>
        </a></li>
        <li><a href="help" id="help">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Help</span>
        </a></li>
        <li><a href="logout" id="logout">
        <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
  </div>


 <script>
  window.addEventListener('scroll', function() {
    const stickyDiv = document.getElementById('help');
    const myDiv = document.getElementById('main');
    const viewportHeight = window.innerHeight;

    if (window.scrollY >= myDiv.offsetTop + myDiv.offsetHeight - viewportHeight) {
      stickyDiv.style.position = 'absolute';
      stickyDiv.style.bottom = '340';
    } else {
      stickyDiv.style.position = 'fixed';
      stickyDiv.style.bottom = '40';
    }
  });
</script>

<script>
  window.addEventListener('scroll', function() {
    const logoutDiv = document.getElementById('logout');
    const myDiv2 = document.getElementById('main');
    const viewportHeight2 = window.innerHeight;

    if (window.scrollY >= myDiv2.offsetTop + myDiv2.offsetHeight - viewportHeight2) {
      logoutDiv.style.position = 'absolute';
      logoutDiv.style.bottom = '340';
    } else {
      logoutDiv.style.position = 'fixed';
      logoutDiv.style.bottom = '0';
    }
  });
</script>


    <section class="main" id="main">
        <div class="main-top">
            <h1 class="blue">Products Settings</h1>
            <div><a href="index" class="a">back</a></div>
        </div> 
        <button id="changePositionButton"><img src="arrow.png"></button>
        <section class="main-course">
            <div class="pro-container">
              <h1 class="blue">Products</h1>
              <?php if ($result->num_rows > 0) { ?>
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
                <div class="product-container">
                    <img src="videos/<?php echo $filename; ?>" class="thumbnail">
                    <div class="product-titel"><?php echo $row['titel']; ?></div>
                    <div><?php echo number_format($row['price'], 2, ',', '.').' €'; ?></div>
                    <div class="stars" style="color: rgb(255, 199, 43); font-size: 22px;">
                        <?php 
                        $roundedRating = round($averageRating);
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $roundedRating) {
                                echo "&#9733;";
                            } else {
                                echo "&#9734;";
                            }
                        }
                        ?>
                    </div>
                    <div class="flex" style="justify-content: center;">
                      
                      <?php if ($row['way'] == 'Affiliate') { ?>
                        <button class="button" onclick="toggleBox('<?php echo $upid; ?>')">Change</button>
                    <?php } else { ?>
                      <button class="button" onclick="toggleBox('<?php echo $upid; ?>')">Change</button>
                    <?php } ?>
                      <a  style="padding: 0; width: 100px;"href="product?id=<?php echo $row['upid']; ?>"><button class="button">View</button></a>
                    </div>
                  </div>
        <!-- Modal for each product -->
            <div class="modal-bg" id="modal_<?php echo $upid; ?>">
              <div class="modal-content">
                <button class="button"><a href="product-view" style="color: white;font-size: 17px;display: flex;width: auto;padding: 0px;">Close</a></button>
                <h1><?php echo $row['titel']; ?></h1>
                      <form action="update-products" method="post" enctype="multipart/form-data">
                        <div class="flex2">
                            <div>
                              <div class="block">
                                <div class="blue">Titel</div>
                                <input type="text" name="titel" value="<?php echo $row['titel']; ?>">
                                <input type="hidden" name="old_titel" value="<?php echo $row['titel']; ?>">
                                <input type="hidden" name="upid" value="<?php echo $row['upid']; ?>">
                                <div class="blue">Description</div>
                                <input type="text" name="description" value="<?php echo $row['description']; ?>">
                                <div class="blue">Price</div>
                                <input type="text" name="price" value="<?php echo $row['price']; ?>">
                            </div>
                            <div class="block">
                                <div class="blue">Shipping</div>
                                <input type="text" name="shipping" value="<?php echo $row['shipping']; ?>">
                                <?php if ($row['way'] == "Affiliate") { ?>
                                  <input type="text" value="<?php echo $row['link']; ?>" placeholder="Link">
                                <?php
                                } ?>
                                <div class="blue">Currancy | Shipping Duration</div>
                                <div class="flex">
                                  <select name="currancy" class="selection2">
                                    <option value="<?php echo $row['currancy']; ?>"><?php echo $row['currancy']; ?></option>
                                    <option value="€">€</option>
                                    <option value="$">$</option>
                                    <option value="¥">¥</option>
                                    <option value="£">£</option>
                                    <option value="Fr">Fr</option>
                                  </select>
                                  <input style="width: 33%;" type="text" name="ship_days" value="<?php echo $row['ship_days']; ?>">
                                  <select name="ship_hours" class="selection2">
                                    <option value="<?php echo $row['ship_hours']; ?>"><?php echo $row['ship_hours']; ?></option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                  </select>
                                </div>
                                <div class="blue">Catigory</div>
                                <select id="catigory" class="selection" name="catigory" style="widht: 300px;">
                                  <option value="<?php echo $row['catigory']; ?>"><?php echo $row['catigory']; ?></option>
                                  <option value="Haushalt">Haushalt</option>
                                  <option value="Sport">Sport</option>
                                  <option value="Spielzeug">Spielzeug</option>
                                  <option value="Angebote">Angebote</option>
                                  <option value="Körperpflege">Körperpflege</option>
                                  <option value="Online Produkte">Online Produkte</option>
                                </select>
                            </div>   
                          </div>
                          <div>
                            <div class="blue">Image</div>
                            <?php
                              $path2 = $row['preview'];
                              $filename2 = basename($path2); ?>
                              <input type="file" id="imageInput_<?php echo $upid; ?>" value="videos/<?php echo $filename2 ?>" name="file" accept=".jpg, .jpeg, .png" style="display: none;" />
                              <input type="hidden" name="defaultfile" value="videos/<?php echo $filename2 ?>">
                              <label for="imageInput_<?php echo $upid; ?>" >
                                <div for="imageInput_<?php echo $upid; ?>" id="imageContainer_<?php echo $upid; ?>" class="uploadhide" style="display: none;"> 
                                  <img id="uploadedImage_<?php echo $upid; ?>" src="#" style="display: none;">
                                </div>
                                <div id="hideMe_<?php echo $upid; ?>" class="uploadhide" >
                                  <img src="videos/<?php echo $filename2 ?>" class="imgg">
                                </div>
                              </label>
                            </div>
                          </div>
                          <div class="block">
                          <input class="save" type="submit" value="Save">
                        </div>   
                    </form>
                    <form action="delete-product" method="post">
                      <input type="hidden" name="id" value="<?php echo $upid; ?>">
                      <input class="delete" type="submit" value="Delete">
                    </form>
        </div>
    </div>
    <script>
const imageInput = document.getElementById('imageInput_<?php echo $upid; ?>');
const uploadedImage = document.getElementById('uploadedImage_<?php echo $upid; ?>');
const hideMeDiv = document.getElementById('hideMe_<?php echo $upid; ?>');
const imageContainer = document.getElementById('imageContainer_<?php echo $upid; ?>');

imageInput.addEventListener('change', function(event) {
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = function() {
      uploadedImage.src = reader.result;
      uploadedImage.style.display = 'block';
      hideMeDiv.style.display = 'none';
      imageContainer.style.display = 'block';
    }

    reader.readAsDataURL(file);
  }
});
</script>
<?php } } else {
  echo "no products uploaded yet.";
}
 ?>
<script>
    function toggleBox(upid) {
        var modal = document.getElementById('modal_' + upid);
        modal.style.display = 'block';
    }

    function closeModal(upid) {
        var modal = document.getElementById('modal_' + upid);
        modal.style.display = 'none';
    }
</script>
        </section>
    </section>
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
        // JavaScript to handle the button click event
        const element = document.getElementById("targetElement");
        const button = document.getElementById("changePositionButton");
        const closeButton = document.getElementById("closeButton");
        const modal = document.getElementById("modal");
        

        changePositionButton.addEventListener("click", function () {
            element.classList.toggle("absolute");
            closeButton.style.display = "block";
            button.style.display = "none";
            modal.style.display = 'block';
        });

        closeButton.addEventListener("click", function () {
            element.classList.remove("absolute");
            closeButton.style.display = "none";
            button.style.display = "block";
            modal.style.display = 'none';
        });
    </script>
  </body>
</html>
