<?php
session_set_cookie_params(0);
session_start ();

  include('..\dbConn.php');

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
	
	
	//executes when the admin changes their password by clicking the proceed button
	if(isset($_POST['changePassBtn'])){
				
		if(!empty($_POST['psw']) && !empty($_POST['confirmPsw'])){
			$pass1 = $_POST['psw'];
		$pass2 = $_POST['confirmPsw'];
			
		}else{
			$pass1 = NULL;
		$pass2 = ".";
		}
		
		
		//using an if statement to check if the 2 entered passwords are equal before changing the admin password in the database 
		if( $pass1 == $pass2 ){
			$updator = md5($pass1);
			$adminUsername =  $_SESSION['adminEmail'];
			
			$query = mysqli_query($conn, "UPDATE tbladmin SET password ='$updator' WHERE Admin_Email = '$adminUsername'");
			
		
		if($query){
			echo "<script>alert('Hooray, Account Password changed successfully');</script>";
			//Re-directing the user to the login page to Login with the registered credentials 
			
		}
		else if($query  !== TRUE) {
			echo "<script>alert('Could not change Account Password changed successfully ');</script>";
		}
		}else{
			//executes when the user enter 2 passwords that do not match 
			echo "<script>alert('Entered Passwords do not match, Please enter matching passwords. ');</script>";
		
			
		}
		
	}
?>
		
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<title>Admin Change Password  </title>
	  <link rel="stylesheet" href="../loginStyleSheet.css"/>
	   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	 
</head>

<body>
<form method="POST" action="">
  <div class="header">
        <div class="container">
        <div class="navbar">
       <div class="logo">
           <img src="../pictures/logo2.JPG" width="100" alt="logo" />
       </div>
        <nav>
            <ul id="MenuItems">
				<li><a href="../manageAccount.php" name="manageAccountLink">Manage Account</a></li>
                <li><a href="../HomePage.php">Home</a></li>
                 <li><a href="../shop.php">Shop</a></li>
                <li><a href="../cart.php">Cart</a></li>
                 <li><a href="../login.php">Account</a></li>
				 <li><a href="../index.php?logOut=9" name="logOut">Log Out!</a></li>
                   <li><a href="../About us.php">About Us</a></li>
                 <li><a href="../Contact Us.php">Contact Us</a></li>
            </ul>
        </nav>
            <img src="../pictures/cart.png" width="40" height="40" alt="cart photo" />
            <img src="../pictures/menuIcon.png" class="menu-icon" alt="menuIcon photo" onclick="menutoggle()" />
    </div>
        
    </div>         
    </div>
	
<section>
	<div class="form-container">
		<h1>Admin Change Password</h1>
	
			<div class="control">
			<label for="psw">Password</label>
			<input type="password" name="psw"  placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
		</div>
		<div class="control">
			<label for="psw"> Confirm Password</label>
			<input type="password" name="confirmPsw" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
		</div>
			<div class="control">
			<br>
				<center><button type="submit" name="changePassBtn" class="btn">Proceed!</button></center>			
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
                            <img src="../pictures/googlePlayLogoIcon.png" alt="googlePlayLogoIcon"/>
                        </div>
                    </div>
                    <div class="footer-col-2">
                        <img src="../pictures/logo1.jpg"  alt="whiteLogo" />
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
                             <li><a href="../HomePage.php">Home</a></li>
                 <li><a href="../shop.php">Shop</a></li>
                <li><a href="../cart.php">Cart</a></li>
                 <li><a href="../login.php">Account</a></li>
                  <li><a href="../About us.php">About Us</a></li>
                 <li><a href="../Contact Us.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <hr />
                <p class="copyright">Copyright 2021 - BenLuc 'Wear Authentic Threads'</p>
            </div>
        </div>
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
		
	
