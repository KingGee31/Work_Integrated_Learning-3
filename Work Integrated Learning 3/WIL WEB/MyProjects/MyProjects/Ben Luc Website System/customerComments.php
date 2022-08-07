<?php
session_set_cookie_params(0);
session_start();

require 'dbConn.php';


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
	
	//retreiving the logged in customer id and customer entered comment 
	$cid = $_SESSION['cid'];
	$comment = NULL;
	
	
//if the customer clikcs the submit button the customer comment is saved in the database 
		if(isset($_POST['submit'])){
			 
			  $comment = $_POST['customerComment'];
			  
			  //Save customer comment in the database table 
 $saveComment = mysqli_query($conn, "insert into tblcustomer_comment(cid, Comment)
values($cid,'$comment')");


	if($saveComment){
			
		 	 
			 header('location: HomePage.php');
	}			
			 
		}


?>

<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Comment Section </title>
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
	<section>
	<!----Add the Customer Comment Here--->
		<div class="form-container">
	<h1>Customer Comment Section</h1>
		<p style=" font-family: Consolas; color: red; background-color: white; ">Express Your Views in the text field below, no profane language or rude comments!</p>
	<div class="control">
	<br>
	<p style=" font-size: 17px;  font-family: Consolas; " >Enter Comment, Customer:</p>
	</div>
	<div class="control">
	<textarea  name="customerComment" rows="8" cols="47"  placeholder="Enter Feedback Here!"  style="margin: 0px; width: 316px; height: 222px; font-size: 18px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"  required></textarea>
	</div>
	<div class="control">
	<center><button type="submit" class="btn" name="submit">Submit!</button></center>
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
</body>
</html>