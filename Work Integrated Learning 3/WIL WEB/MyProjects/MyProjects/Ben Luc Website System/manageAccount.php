<?php
	/*Using the Session function to check if the user has logged in, the session function is also useful in helping access the username/email address of the 
	* from another webpage easily*/
	session_set_cookie_params(0);
	session_start();
	
	require 'dbConn.php';
require 'item.php';
	
//redirecting the user to login if the before the user can access the webpage
if(!isset($_SESSION['username'])){	
//creating a session variable that will allow the user to  be re-directed to the previous page after successful login 
	
	$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];	
    header("location:login.php");
	exit;
}
	
	//when the user clicks the logout link, the user session ends.
	if(isset($_POST['logOut'])){
		 //The Unset function here is used to clear all data stored in the session function/method
    unset($_SESSION['username']);  
	//This method removes all user data from the session and then deletes the session
    session_destroy(); 
	header('location: index.php');
	exit;
	}
	
	//navigating the user to the relevant pages when the user clicks the page buttons
	if(isset($_POST['orderProgress'])){
		header('location: manageAccountCategories.php');
		
	}
	if(isset($_POST['orderHistory'])){
		header('location:  manageAccountCategories.php');
		
	}
	if(isset($_POST['changePassword'])){
		header('location:  manageAccountCategories.php');
		
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Manage Account  </title>
	 <link rel="stylesheet" href="loginStyleSheet.css"/>
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
				 <li><a href="index.php?logOut=9" name="logOut">Log Out!</a></li>
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
			<h1>Manage Account</h1>
			<p style="font-size: 20px; font-family: Consolas;">1. Check order Progress</p>
		<div class="control">
		<center><a href="manageAccountCategories.php?option=1" name="orderProgress" class="btn">Order Progress!</a></center>
		
		
		<br>
		
		</div>
		
		<p style="font-size: 20px; font-family: Consolas;">2. Check Order History</p>
		<div class="control">
		<center><a href="manageAccountCategories.php?option=2" name="orderHistory" class="btn">Order History!</a></center>
		<br>
		
		</div>
		
		<p style="font-size: 20px; font-family: Consolas;">3. Change Password</p>
		<div class="control">
		<center><a href="manageAccountCategories.php?option=3" name="changePassword" class="btn">Change Password!</a></center>
		
		</div>
		
		

		</div>
</section>

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
</form>
</body>
</html>