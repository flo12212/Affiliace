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
$sql3 = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);

$row1 = $result->fetch_assoc();
$row2 = $result2->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $row2['company']; ?>: Profil</title>
    <link rel="shortcut icon" href="smalllogo.png" />
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="account.css">
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
        <li><a href="account" style="background-color: #c5d5fd;">
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
        <li><a href="product-view">
          <i class="fas fa-shopping-cart"></i>
          <span class="nav-item">Products</span>
        </a></li>
        <li><a href="help" class="help">
          <i class="fas fa-question-circle"></i>
          <span class="nav-item">Help</span>
        </a></li>
        <li><a href="logout" class="logout">
        <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>
  </div>


    <section class="main">
        <div class="main-top">
            <h1 class="blue">Profil Settings</h1>
            <div><a class="a"href="index">back</a></div>
        </div>
        <button id="changePositionButton"><img src="arrow.png"></button>
        <section class="main-course">
            <div class="course-box">
              <h1 class="blue">Profil</h1>
              <div class="profil-box">
              <form action="update-profil?id=<?php echo $user_id; ?>" method="POST" enctype="multipart/form-data">
                <div class="block">
                  <div>Pre- and Lastname</div>
                  <input id="name" type="text" name="name" value="<?php echo $row2['username']; ?>" placeholder="Name">
                  <div>Email Address:</div>
                  <input id="email" type="text" name="email" value="<?php echo $row2['email']; ?>" placeholder="Email" required>
                  <div>Password:</div>
                  <a href="reset_password">Reset</a>
                  <div>Website:</div>
                  <input id="website" type="text" name="website" value="<?php echo $row2['website']; ?>" placeholder="Website">
                </div>
                <div class="block">
                  <div>Company</div>
                  <input id="company" type="text" name="company" value="<?php echo $row2['company']; ?>" placeholder="Company">
                  <div>Profile Picture | Logo</div>
                  <label for="image-upload">
                    <div class="center">
                        <?php if (!empty($row2['profilpicture'])) {
                        ?>
                        <div id="image-preview" class="preview-image"><img src="profilpictures/<?php echo $row2['profilpicture']; ?>" alt="Current Image" class="upimg"></div>
                        <?php
                      } else { ?>
                          <h1 id="image-preview" class="preview-image">Upload</h1>
                      <?php } ?>
                      
                    </div>
                    
                  </label>
                  <input type="hidden" id="no_file_upload" name="no_file_upload" value="<?php echo $row2['profilpicture']; ?>">
                  <input id="image-upload" name="file-upload" type="file" style="display: none;">
                </div>
                <div class="block">
                  <div>Address</div>
                  <input id="address" type="text" name="address" value="<?php echo $row2['address']; ?>" placeholder="Address">
                  <div>Zip</div>
                  <input id="zip" type="text" name="zip" value="<?php echo $row2['zip']; ?>" placeholder="Zip">
                  <div>City</div>
                  <input id="city" type="text" name="city" value="<?php echo $row2['city']; ?>" placeholder="City">
                  <div>Country</div>
                  <select name="country" id="country" class="country">
                    <option value="<?php echo $row2['country']; ?>"><?php echo $row2['country']; ?></option>
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
                <button type="submit" class="submit-button">Save Changes</button>
              </form>
            </div>
        </section>
        <section class="main-course">
            <div class="course-box" style="margin-top: 80px;">
              <h1 class="blue">Social Media</h1>
              <div class="profil-box">
                <form action="update-profil-media?id=<?php echo $user_id; ?>" method="POST" enctype="multipart/form-data">
                  <div class="block">
                    <div>Instagram</div>
                    <input id="instagram" type="text" name="instagram" value="<?php echo $row2['instagram'];?>" placeholder="Instagram">
                    <div>Tik Tok</div>
                    <input id="tiktok" type="text" name="tiktok" value="<?php echo $row2['tiktok'];?>" placeholder="Tik Tok">
                    <div>Twitter</div>
                    <input id="twitter" type="text" name="twitter" value="<?php echo $row2['twitter'];?>" placeholder="Twitter">
                  </div>
                  <div class="block">
                    <div>Facebook</div>
                    <input id="facebook" type="text" name="facebook" value="<?php echo $row2['facebook'];?>" placeholder="Facebook">

                    <div>YouTube</div>
                    <input id="youtube" type="text" name="youtube" value="<?php echo $row2['youtube'];?>" placeholder="YouTube">

                    <div>WhatsApp</div>
                    <input id="whatsapp" type="text" name="whatsapp" value="<?php echo $row2['whatsapp'];?>" placeholder="WhatsApp">
                  </div>
                  <div class="block">
                    <div>LinkedIn</div>
                    <input id="linkedin" type="text" name="linkedin" value="<?php echo $row2['linkedin'];?>" placeholder="LinkedIn">

                    <div>Snapchat</div>
                    <input id="snapchat" type="text" name="snapchat" value="<?php echo $row2['snapchat'];?>"  placeholder="Snapchat">

                    <div>Reddit</div>
                    <input id="reddit" type="text" name="reddit" value="<?php echo $row2['reddit'];?>" placeholder="Reddit">
                    <button type="submit" class="submit-button2">Save Changes</button>
                </form>
              </div>
            </div>
            <div style="padding-top: 25px;"><a href="seller?id=<?php echo $user_id ;?>">view your "Seller" page</a></div>
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
    const imageUpload = document.getElementById('image-upload');
    const imagePreview = document.getElementById('image-preview');

    imageUpload.addEventListener('change', function(event) {
      const file = event.target.files[0];

      const reader = new FileReader();

      reader.onload = function(e) {
        const imageURL = e.target.result;
        imagePreview.innerHTML = `<img src="${imageURL}" alt="Current Image" class="upimg">`;
      };

      reader.readAsDataURL(file);
    });
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