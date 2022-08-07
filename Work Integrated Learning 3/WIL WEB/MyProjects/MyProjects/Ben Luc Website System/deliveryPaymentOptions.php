<?php
session_set_cookie_params(0);
session_start();

require 'dbConn.php';
require 'item.php';

//if the user is not logged in they are re-directedto login before they can interact with the page 
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
	
	//executes when the user clicks submit button 
	if(isset($_POST['Proceed'])){
		$_SESSION['paymentOptn'] = $_POST['paymentOptn'];
		
		header('location: paymentType.php');
		
	}
	
	
	

?>

<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Payment Type</title>
   <link rel="stylesheet" href="loginStyleSheet.css"/>

</head>
<body>
	<form method="POST" action="">
		<div class="header">
        <div class="container">
        <div class="navbar">
       <div class="logo">
           <img src="pictures/logo2.JPG" width="125px" alt="logo" />
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
	</div>
	<section>
	<div class="form-container">
	<h1>Payment Type</h1>
	
	<div class="control">
<input type="radio" name="paymentOptn"  checked value="cash" style="font-size: 12px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">1. Cash On Delivery
</div>
<br/>
<div class="control">
<input type="radio" name="paymentOptn" value="creditCard/EFT" style="font-size: 12px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">2. EFT transaction 
<br>
</div>
<div class="control">
<br>
<center><button type="submit" class="btn" name="Proceed">Proceed!</button></center>

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
                    <div class="footer-col-4">
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
</body>
</html>