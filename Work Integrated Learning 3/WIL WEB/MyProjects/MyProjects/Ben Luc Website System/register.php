<?php
session_set_cookie_params(0);
include('dbConn.php');
//Declaring variables to hold the user input 
$firstName = NULL;
$lastName = NULL;
$emailAddress = NULL;
$password = NULL;
$rPassword = NULL;

//Declaring a variable to check if the user email address is already registered, if it is registered then the user must enter another email address. the textbox is wiped
$problemThere = NULL;
//Checking if the submit regitrastion has beeen clicked to process the user inputs 
	if(isset($_POST['submitRegistration'])){
		//Assigning the variables user submitted data from the Register Form
		$firstName = $_POST['name'];
		$lastName = $_POST['lastName'];
		$emailAddress = $_POST['email'];
		$password = $_POST['psw'];
		$rPassword = $_POST['rpsw'];
		
		//Checking if the user might have submitted the form without entering input
		 if(empty($firstName) || empty($lastName) || empty($emailAddress) || empty($password) || empty($rPassword))
        {
           echo "<script>alert('The Form Fields Cannot Be Empty, Please enter Data');</script>";
        } #Cheking if the 2 passwords match, if they don't a sticky form will appear for the user to enter data again 
		 else if($password != $rPassword)
        {
            echo "<script>alert('The 2 Passwords Do Not Match, Please Enter Matching Passwords');</script>";
        }
		else{
			#hashing the user passwor before saving it to the database 
		$hashedPassword = md5($password);
			//Checking if the user exists in the database, if the user exists then the user will be asked to enter different registration credentials
			
        $checkUserIfRegistered = "SELECT * FROM tblCustomers WHERE email = '$emailAddress'";
		 $checkUserExists = mysqli_query($conn,$checkUserIfRegistered);
		if(mysqli_num_rows($checkUserExists) > 0)
        {
			echo "<script>alert('email address already registered to an account, use different email address to create account');</script>";
			$problemThere = TRUE;
			
        }
		else if(mysqli_num_rows($checkUserExists) == 0){
			
			#Writing the User data to the database Table when every field has been entered correctly
		$query ="INSERT INTO tblcustomers(fname,lname,email,password) Values('$firstName ','$lastName','$emailAddress','$hashedPassword')";
			#Registering the user account 
			$run = mysqli_query($conn,$query) or die(mysqli_error($conn));
		
		if($run){
			echo "<script>alert('Hooray,account creation successful!!');</script>";
			//Re-directing the user to the login page to Login with the registered credentials 
			 header("location:login.php");
		}
		else if($run  !== TRUE) {
			echo "<script>alert('Could Not Successfully Register The User Account');</script>";
		}
		}
		
	}
	}
	/*SOURCE CODE USED FOR THIS PAGE WAS ACCESSED FROM YOUTUBE 
Code Opacity( 2020).Responsive Transparent Login Form with Html and Css. https://www.youtube.com/watch?v=yiIi82xVjqo
.13/05/2021

*THIS ONE BELOW IS FOR THE WEBPAGE FOOTER

The WebShala(2020).Responsive Footer Design using Html & Css.
https://www.youtube.com/watch?v=YOb67OKw62s .14/05/2021
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<title>Register</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <link rel="stylesheet" href="RegistrationStyleSheet.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>

<body>
<form method="POST" action="">
 <div class="header">
        <div class="container">
        <div class="navbar">
       <div class="logo">
           <img src="pictures/logo2.JPG" width="100" alt="logo" />
       </div>
        <nav>
            <ul id="MenuItems">
                <li><a href="HomePage.php">Home</a></li>
                 <li><a href="shop.php">Shop</a></li>
                <li><a href="cart.php">Cart</a></li>
                 <li><a href="login.php">Account</a></li>
                <li><a href="About us.php">About Us</a></li>
                 <li><a href="Contact Us.php">Contact Us</a></li>
            </ul>
        </nav>
            <img src="pictures/cart.png" width="40" height="40" alt="cart photo" />
            <img src="pictures/menuIcon.png" class="menu-icon" alt="menuIcon photo" onclick="menutoggle()" />
    </div>
        
    </div>
    </div>



<section>
	<div class="form-container">
		<h1>Register Form</h1>
		<form action="" method="POST">
			<div class="control">
				<label for="name">First Name</label>
				<input type="text" name="name" id="name" placeholder="Enter First Name" minlength="3" maxlength="20" pattern="[A-Za-z]{3,20}" title="First Name must contains letters only without numbers or special characters" value = "<?php echo $firstName; ?>" required>
					<label for="lastName">Last Name</label>
				<input type="text" name="lastName" id="lastName" placeholder="Enter Last Name" minlength="3" maxlength="20" pattern="[A-Za-z]{3,20}" title="Last Name must contains letters only without numbers or special characters" value = "<?php echo $lastName; ?>"  required>
						<label for="email">Email Address</label>
				<input type="text" name="email" id="email" placeholder="Enter Email Address" minlength="3" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="The email address must contain letters(lowercase only), maybe numbers in the format: characters@characters.domain" value = "<?php if($problemThere == TRUE){$emailAddress = NULL;} else{echo $emailAddress;} ?>" required>
			</div>
		<div class="control">
			<label for="psw">Password</label>
			<input type="password" name="psw" id="psw" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
			<label for="rpsw">Confirm Password</label>
			<input type="password" name="rpsw" id="rpsw" placeholder="Enter repeat Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
		</div>
			<div class="control">
				<input type="submit" name="submitRegistration" value="Register">
			</div>
			<div class="control">
    <p>Already have an account?<a href="index.php">Sign in</a>.</p>
  </div>
		</form>
		
	</div>
</section>



 <footer>
        <!----Footer Content here--->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="footer-col-1">
                        <h3>Download Our App</h3>
                            <p>Download App for Android mobile phone.</p>
                        <div class="app-logo">
                            <img src="pictures/googlePlayLogoIcon.png" alt="googlePlayLogoIcon"/>
                        </div>
                    </div>
                    <div class="footer-col-2">
                        <img src="pictures/logo1.jpg"  alt="whiteLogo" />
                        <p>Our Purpose is to design South African streetwear clothing brand items that specialize on Authentic Threads.</p>
                    </div>
                    <div class="footer-col-3">
                       <h3>Follow Us</h3>
                        <ul>
                            <li>Facebook</li>
                            <li>Instagram</li>
                            <li>Twitter</li>
                        </ul>
                    </div>
                    <div class="footer-col-3">
                       <h3>Navigation Links</h3>
                        <ul>
                             <li><a href="HomePage.php">Home</a></li>
                 <li><a href="shop.php">Shop</a></li>
                <li><a href="cart.php">Cart</a></li>
                 <li><a href="login.php">Account</a></li>
                  <li><a href="About us.php">About Us</a></li>
                 <li><a href="Contact Us.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <hr />
                <p class="copyright">Copyright 2021 - BenLuc 'Wear Authentic Threads'</p>
            </div>
        </div>
    </footer>
</form>
</body>
  <!----js for toogle menu---->
    <script>
        var MenuItems = document.getElementById("MenuItems");
        MenuItems.style.maxHeight = "0px";

        function menutoggle(){
            if (MenuItems.style.maxHeight == "0px") {
                MenuItems.style.maxHeight = "200px";
            }
            else {
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>
</html>