<?php 


session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}

$id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$_SESSION['username'];
$password = $_SESSION['password'];
$email = $_SESSION['email'];


$conn = mysqli_connect('localhost', 'root', '', 'afiiliatedata');

$sql2 = "SELECT * FROM userdata WHERE id = '$id'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();


if ($row2['paid'] == 0) {
    header("Location: payment"); 
} 

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header('Location: payment');  }

$firstLetter = $username[0];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Affiliace: Upload</title>
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
  <div class="container">
  <div class="modal-bg" id="modal">
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
        <li><a href="upload1" style="background-color: #c5d5fd;">
          <i class="fas fa-upload"></i>
          <span class="nav-item">Upload</span>
        </a></li>
        <li><a href="affiliate">
          <i class="fas fa-dollar-sign"></i>
          <span class="nav-item">Affiliate</span>
        </a></li>
        <li><a href="product-view">
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
            <h1 class="blue">Upload a Product</h1>
            <div><a href="index" class="a">back</a></div>
        </div>
        <button id="changePositionButton"><img src="arrow.png"></button>
        <section class="main-course">
          <div class="circle-selector">
              <input class="exept" type="radio" name="option" id="radio1" onclick="showDiv(1)" checked>
              <label for="radio1">Product</label>

              <input class="exept" type="radio" name="option" id="radio2" onclick="showDiv(2)">
              <label for="radio2">Affiliace</label>

              <input class="exept" type="radio" name="option" id="radio3" onclick="showDiv(3)">
              <label for="radio3">other</label>
          </div>  
              <div id="div1" class="content active">
                  <div class="course-box" style="min-height: 850px;">
                  <h1>Product</h1>
                  <div>no -> '</div>
                  <div class="flex">
                    <div class="flexbox">
                      <form method="POST" action="upload" enctype="multipart/form-data" onsubmit="return validateFileCount();">
                        <h1 class="blue">Product Name </h1>
                        <input type="text" class="name" id="name" name="name" placeholder="Product Name" pattern="[^']*">
                        <h1 class="blue">Description</h1>
                        <textarea pattern="[^']*" class="description" id="description" name="description" placeholder="Description" maxlength="249" ></textarea><div id="charCount"></div>
                        <h1 class="blue">Price | Shipping | Currancy</h1>
                        <input type="text" class="price" id="price" name="price" placeholder="Price" pattern="[^']*">
                        <input type="text" class="shipping" id="shipping" name="shipping" placeholder="Shipping" pattern="[^']*">
                        <select name="currancy" id="options" class="selection" onchange="displaySelectedOption()" >
                          <option value="€">€</option>
                          <option value="$">$</option>
                          <option value="¥">¥</option>
                          <option value="£">£</option>
                          <option value="Fr">Fr</option>
                        </select>
                        <h1 class="blue">Catigory</h1>
                        <select id="catigory" class="catigory" name="catigory">
                            <option value="">Select a Catigory</option>
                            <option value="Haushalt">Haushalt</option>
                            <option value="Sport">Sport</option>
                            <option value="Spielzeug">Spielzeug</option>
                            <option value="Angebote">Angebote</option>
                            <option value="Körperpflege">Körperpflege</option>
                            <option value="Online Produkte">Online Produkte</option>
                        </select>
                        <h1 class="blue">Shipping duration</h1>
                        <input type="text" class="days" id="days" name="days" placeholder="Days" pattern="[^']*">
                        <select name="hour" id="hour" class="selection">
                          <option disabled selected>hours</option>
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

                      <div class="right">
                        <div class="flex">
                          <label for="preview" class="label-upload">
                            <h1 class="blue">Prewiev Image</h1>
                            <div class="center">
                              <div id="hideDiv"  class="hide">
                                <i class="fas fa-upload"></i>
                                <div>Click to</div>
                                <div>Upload Picture here!</div>
                              </div>
                              <div id="fileDisplay" class="img1"></div>
                            </div>
                          </label>
                          <div id="uploadForm">
                            <input type="file" id="preview" name="preview" accept=".jpg, .jpeg, .png" style="display: none;" />
                          </div>

                          <label for="file-input" class="label-upload">
                            <h1 class="blue">Product Images</h1>
                              <div id="hideDiv2" class="hide">
                                <i class="fas fa-upload"></i>
                                <div>Click to</div>
                                <div>Upload Pictures here!</div>
                                <div>Only 8 pics are allowed!</div>
                              </div>
                              <div class="container1">
                                <div class="slider-wrapper">
                                  <div id="file-display" class="slider">

                                  </div>
                                </div>
                              </div>
                          </label>
                        </div>
                        <div id="upload-form">
                          <input type="file" id="file-input" name="image[]" multiple style="display: none;" >
                        </div>
                        <input type="hidden" name="link" id="link">
                        <input type="hidden" name="way" id="way" value="Product">
                        <input type="submit" class="buy" name="submit" value="Upload" onclick="checkFileCount()">
                      </form>
                  </div>

                </div>
              </div>
              <div class="course-box" style="min-height: 850px;, align-items: center;" id="course2">
                    <h1 class="blue">Product Prewiev</h1>
                  <div class="row">
                      <div class="button-container">
                          <div id="file-display2" class="img2">
                            <div class="border"></div>
                          </div>
                      </div>
                      <div class="col1">
                        <div id="fileDisplay2" class="img3">
                          <div class="border2"></div>
                        </div>
                      </div>
                      <div class="col">
                          <h1 id="nameOutput">Product Name</h1>
                          <p id="descriptionOutput">Description</p>
                          <div class="flex">
                            <div id="result">Price</div>
                            <div id="displayElement">€</div>
                          </div>
                          <div id="output1"></div>
                          <div style="color: rgb(255, 199, 43); font-size: 22px;">
                            <?php
                            echo "&#9733;";
                            echo "&#9733;";
                            echo "&#9733;";
                            echo "&#9733;";
                            echo "&#9733;";
                            ?>
                          </div>
                          
                          

                          <div>Seller: <?php echo $row2['username']; ?></div>
                          
                          <button>Add to Cart</button>
                          <button class="buy">Buy</button>
                        </div>
                      </div>
                </div>
              </div>


              <div id="div2" class="content" style="display: none;">
                <div class="course-box" style="min-height: 850px;">
                  <h1>Affiliate</h1>
                  <div class="flex">
                    <div class="flexbox">
                      <form method="POST" action="upload" enctype="multipart/form-data" onsubmit="return validateFileCount2();">
                        <h1 class="blue">Product Name</h1>
                        <input type="text" class="name" id="name2" name="name" placeholder="Product Name">
                        <h1 class="blue">Description</h1>
                        <textarea class="description" id="description2" name="description" placeholder="Description" maxlength="250"></textarea>
                        <div id="charCount"></div>
                        <h1 class="blue">Price | Shipping | Currency</h1>
                        <input style="width: 195px;" type="text" class="price" id="price2" name="price" placeholder="Price">
                        <input style="width: 195px;" type="text" class="shipping" id="shipping2" name="shipping" placeholder="Shipping">
                        <select name="currancy" id="options2" class="selection" onchange="displaySelectedOption()">
                          <option value="€">€</option>
                          <option value="$">$</option>
                          <option value="¥">¥</option>
                          <option value="£">£</option>
                          <option value="Fr">Fr</option>
                        </select>
                        <h1 class="blue">Product Link</h1>
                        <input type="text" class="link" id="link" name="link" placeholder="Link">
                        <h1 class="blue">Category</h1>
                        <select id="catigory" class="catigory" name="catigory">
                          <option value="">Select a Category</option>
                          <option value="Haushalt">Haushalt</option>
                          <option value="Sport">Sport</option>
                          <option value="Spielzeug">Spielzeug</option>
                          <option value="Angebote">Angebote</option>
                          <option value="Körperpflege">Körperpflege</option>
                          <option value="Online Produkte">Online Produkte</option>
                        </select>
                        <h1 class="blue">Shipping duration</h1>
                        
                        <input type="text" class="days" id="days2" name="days" placeholder="Days" >
                        <select name="hour" id="hour2" class="selection">
                          <option disabled selected>hours</option>
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
                      <div>
                        <div class="flex">
                          <label for="preview3" class="label-upload">
                            <h1 class="blue">Preview Image</h1>
                            <div class="center">
                              <div id="hideDiv3" class="hide">
                                <i class="fas fa-upload"></i>
                                <div>Click to</div>
                                <div>Upload Picture here!</div>
                              </div>
                              <div id="fileDisplay3" class="img1"></div>
                            </div>
                          </label>
                          <div id="uploadForm">
                            <input type="file" id="preview3" name="preview" accept=".jpg, .jpeg, .png" style="display: none;" />
                          </div>

                          <label for="file-input5" class="label-upload">
                            <h1 class="blue">Product Images</h1>
                            <div id="hideDiv5" class="hide">
                              <i class="fas fa-upload"></i>
                              <div>Click to</div>
                              <div>Upload Pictures here!</div>
                              <div>Only 8 pics are allowed!</div>
                            </div>
                            <div class="container1">
                              <div class="slider-wrapper">
                                <div id="fileDisplay5" class="slider">

                                </div>
                            </div>
                          </label>
                          <div id="uploadForm">
                            <input type="file" id="file-input5" name="files[]" accept=".jpg, .jpeg, .png" multiple style="display: none;" />
                          </div>
                          
                        </div>
                          
                        
                      </div>
                          <input type="hidden" name="way" id="way" value="Affiliate">
                          <input type="submit" class="buy" name="submit" value="Upload" onclick="checkFileCount()"> 
                      </form>
                    </div>
                  </div>
                <div>
              </div>     
          </div>
              

                <div class="course-box" style="min-height: 850px; align-items: center;" id="course2">
                  <h1 class="blue">Affiliate Preview</h1>
                  <div class="row">
                    <div class="button-container">
                      <div id="file-display6" class="img2">
                        <div class="border"></div>
                      </div>
                    </div>
                    <div class="col1">
                      <div id="fileDisplay4" class="img3">
                        <div class="border2"></div>
                      </div>
                    </div>
                    <div class="col">
                      <h1 id="nameOutput2">Product Name</h1>
                      <p id="descriptionOutput2">Description</p>
                      <div class="flex">
                      <div id="result2">Price</div>
                        <div id="displayElement2">€</div>
                      </div>
                      <div id="output2"></div>
                      <div style="color: rgb(255, 199, 43); font-size: 22px;">
                        <?php
                        echo "&#9733;";
                        echo "&#9733;";
                        echo "&#9733;";
                        echo "&#9733;";
                        echo "&#9733;";
                        ?>
                      </div>
                      <div>Seller: <?php echo $row2['username']; ?></div>
                      <button class="buy">Buy</button>
                    </div>
                  </div>
                </div>
              </div>
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

window.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('preview');
    const fileDisplay = document.getElementById('fileDisplay');
    const fileDisplay2 = document.getElementById('fileDisplay2');
    const hideDiv = document.getElementById('hideDiv');

    fileInput.addEventListener('change', (event) => {
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = (e) => {
        const img = document.createElement('img');
        img.src = e.target.result;
        fileDisplay.innerHTML = '';
        fileDisplay2.innerHTML = ''; // Clear previous contents
        fileDisplay.appendChild(img);
        fileDisplay2.appendChild(img.cloneNode(true)); // Clone the image element
        hideDiv.style.display = 'none'; // Hide the div
      };

      reader.readAsDataURL(file);
    });
  });

  const fileInput = document.getElementById('file-input');
const fileDisplay = document.getElementById('file-display');
const fileDisplay2 = document.getElementById('file-display2');
const hideDiv = document.getElementById('hideDiv2');

// Add event listener for file selection
fileInput.addEventListener('change', handleFileSelect);

// Function to handle file selection
function handleFileSelect(event) {
  // Clear previous file display
  fileDisplay.innerHTML = '';
  fileDisplay2.innerHTML = ''; // Clear previous contents

  // Retrieve the selected files
  const selectedFiles = event.target.files;

  // Iterate over the selected files
  for (let i = 0; i < selectedFiles.length; i++) {
    const file = selectedFiles[i];

    // Create a file reader object
    const reader = new FileReader();

    // Define the onload event handler
    reader.onload = function (event) {
      // Create an image element
      const imgElement = document.createElement('img');
      imgElement.src = event.target.result;

      // Append the image to the file-display container
      fileDisplay.appendChild(imgElement);

      // Display only the first 8 images in the file-display2 container
      if (i < 8) {
        fileDisplay2.appendChild(imgElement.cloneNode(true)); // Clone the image element
      }
    };

    // Read the current file as a data URL
    reader.readAsDataURL(file);
  }

  // Hide the hideDiv2 element
  hideDiv.style.display = 'none';
}
  </script>

  <script>
        
        const input = document.getElementById("description");
        const charCount = document.getElementById("charCount");
    
    input.addEventListener("input", function() {
      const count = input.value.length;
      charCount.textContent = `${count} / 250`;
    
      if (count >= 251) {
        charCount.style.color = "red";
      } else {
        charCount.style.color = "black";
      }
    });
    
    
        </script>
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

<script>
  var nameInput = document.getElementById("name");
  var descriptionInput = document.getElementById("description");
  var priceInput = document.getElementById("price");
  
  var nameOutput = document.getElementById("nameOutput");
  var descriptionOutput = document.getElementById("descriptionOutput");
  var priceOutput = document.getElementById("priceOutput");

  nameInput.addEventListener("input", function() {
    nameOutput.textContent = nameInput.value;
  });

  descriptionInput.addEventListener("input", function() {
    descriptionOutput.textContent = descriptionInput.value;
  });

  priceInput.addEventListener("input", function() {
    priceOutput.textContent = priceInput.value;
  });

  var optionsInput = document.getElementById("options");
  var displayElement = document.getElementById("displayElement");

  optionsInput.addEventListener("change", function() {
    displayElement.textContent = optionsInput.value;
  });
</script>


<script>
  function validateFileCount() {
    var fileUpload = document.getElementById("file-input");
    var files = fileUpload.files;

    if (files.length > 8) {
      alert("Please select a maximum of 8 files.");
      return false;
    }

    // Proceed with form submission or upload process
    return true;
  }
</script>
<script>
    const daysInput = document.getElementById('days');
    const hourSelect = document.getElementById('hour');
    const outputDiv = document.getElementById('output1');

    // Add event listeners to both elements
    daysInput.addEventListener('input', calculateDate);
    hourSelect.addEventListener('change', calculateDate);

    function calculateDate() {
      const daysValue = parseInt(daysInput.value) || 0; // Parse input as integer or default to 0
      const hourValue = parseInt(hourSelect.value) || 0; // Parse select value as integer or default to 0

      const now = new Date(); // Current date and time
      const future = new Date(now.getTime()); // Create a copy of current date and time

      future.setDate(future.getDate() + daysValue); // Add days
      future.setHours(future.getHours() + hourValue); // Add hours

      const options = { month: 'long', day: 'numeric'};
      const formattedDate = future.toLocaleDateString(undefined, options); // Format the future date as a string

      outputDiv.textContent = `earliest delivery: ${formattedDate}`;
    }
  </script>



































<script>
  var nameInput2 = document.getElementById("name2");
  var descriptionInput2 = document.getElementById("description2");
  var priceInput2 = document.getElementById("price2");
  
  var nameOutput2 = document.getElementById("nameOutput2");
  var descriptionOutput2 = document.getElementById("descriptionOutput2");
  var priceOutput2 = document.getElementById("priceOutput2");

  nameInput2.addEventListener("input", function() {
    nameOutput2.textContent = nameInput2.value;
  });

  descriptionInput2.addEventListener("input", function() {
    descriptionOutput2.textContent = descriptionInput2.value;
  });

  priceInput2.addEventListener("input", function() {
    priceOutput2.textContent = priceInput2.value;
  });

  var optionsInput2 = document.getElementById("options2");
  var displayElement2 = document.getElementById("displayElement2");

  optionsInput2.addEventListener("change", function() {
    displayElement2.textContent = optionsInput2.value;
  });
</script>

<script>
  window.addEventListener('DOMContentLoaded', () => {
    const fileInput3 = document.getElementById('preview3');
    const fileDisplay3 = document.getElementById('fileDisplay3');
    const fileDisplay4 = document.getElementById('fileDisplay4');
    const hideDiv3 = document.getElementById('hideDiv3');

    fileInput3.addEventListener('change', (event) => { // Use fileInput3 instead of fileInput
      const file = event.target.files[0];
      const reader = new FileReader();

      reader.onload = (e) => {
        const img = document.createElement('img');
        img.src = e.target.result;
        fileDisplay3.innerHTML = ''; // Clear previous contents
        fileDisplay4.innerHTML = ''; // Clear previous contents
        fileDisplay3.appendChild(img);
        fileDisplay4.appendChild(img.cloneNode(true)); // Clone the image element
        hideDiv3.style.display = 'none'; // Hide the div
      };

      reader.readAsDataURL(file);
    });
  });





  const fileInput5 = document.getElementById('file-input5');
const fileDisplay5 = document.getElementById('fileDisplay5');
const fileDisplay6 = document.getElementById('file-display6');
const hideDiv5 = document.getElementById('hideDiv5');

// Add event listener for file selection
fileInput5.addEventListener('change', handleFileSelect);

// Function to handle file selection
function handleFileSelect(event) {
  // Clear previous file display
  fileDisplay5.innerHTML = '';
  fileDisplay6.innerHTML = ''; // Clear previous contents

  // Retrieve the selected files
  const selectedFiles5 = event.target.files;

  // Iterate over the selected files
  for (let i = 0; i < selectedFiles5.length; i++) {
    const file = selectedFiles5[i];

    // Create a file reader object
    const reader = new FileReader();

    // Define the onload event handler
    reader.onload = function (event) {
      // Create an image element
      const imgElement = document.createElement('img');
      imgElement.src = event.target.result;

      // Append the image to the file-display container
      fileDisplay5.appendChild(imgElement);

      // Display only the first 8 images in the file-display6 container
      if (i < 8) {
        fileDisplay6.appendChild(imgElement.cloneNode(true)); // Clone the image element
      }
    };

    // Read the current file as a data URL
    reader.readAsDataURL(file);
  }

  // Hide the hideDiv5 element
  hideDiv5.style.display = 'none';
}
</script>


<script>
  function validateFileCount() {
    var fileUpload = document.getElementById2("file-input5");
    var files = fileUpload.files;

    if (files.length > 8) {
      alert("Please select a maximum of 8 files.");
      return false;
    }

    // Proceed with form submission or upload process
    return true;
  }
</script>
<script>
window.addEventListener("DOMContentLoaded", function() {
    var priceInput = document.getElementById("price");
    var shippingInput = document.getElementById("shipping");

    priceInput.addEventListener("input", calculateTotal);
    shippingInput.addEventListener("input", calculateTotal);
});

function calculateTotal() {
    // Get the input field values
    var price = parseFloat(document.getElementById("price").value) || 0;
    var shipping = parseFloat(document.getElementById("shipping").value) || 0;

    // Calculate the total
    var total = price + shipping;
    total = total.toFixed(2);

    // Display the result in the div
    var resultDiv = document.getElementById("result");
    resultDiv.innerText = total;

    // Hide the input fields
    var priceInput = document.getElementById("price");
    var shippingInput = document.getElementById("shipping");
}

window.addEventListener("DOMContentLoaded", function() {
    var priceInput2 = document.getElementById("price2");
    var shippingInput2 = document.getElementById("shipping2");

    priceInput2.addEventListener("input", calculateTotal2);
    shippingInput2.addEventListener("input", calculateTotal2);
});

function calculateTotal2() {
    // Get the input field values
    var price2 = parseFloat(document.getElementById("price2").value) || 0;
    var shipping2 = parseFloat(document.getElementById("shipping2").value) || 0;

    // Calculate the total
    var total2 = price2 + shipping2;
    total2 = total2.toFixed(2);

    // Display the result in the div
    var resultDiv2 = document.getElementById("result2");
    resultDiv2.innerText = total2;

    // Hide the input fields
    var priceInput2 = document.getElementById("price2");
    var shippingInput2 = document.getElementById("shipping2");
}
</script>

<script>
  const daysInput2 = document.getElementById('days2');
  const hourSelect2 = document.getElementById('hour2');
  const outputDiv2 = document.getElementById('output2');

  // Add event listeners to the updated elements
  daysInput2.addEventListener('input', calculateDate2);
  hourSelect2.addEventListener('change', calculateDate2);

  function calculateDate2() {
    const daysValue2 = parseInt(daysInput2.value) || 0; // Parse input as integer or default to 0
    const hourValue2 = parseInt(hourSelect2.value) || 0; // Parse select value as integer or default to 0

    const now2 = new Date(); // Current date and time
    const future2 = new Date(now2.getTime()); // Create a copy of current date and time

    future2.setDate(future2.getDate() + daysValue2); // Add days
    future2.setHours(future2.getHours() + hourValue2); // Add hours

    const options2 = { month: 'long', day: 'numeric' };
    const formattedDate2 = future2.toLocaleDateString(undefined, options2); // Format the future date as a string

    outputDiv2.textContent = `earliest delivery: ${formattedDate2}`;
  }
</script>
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