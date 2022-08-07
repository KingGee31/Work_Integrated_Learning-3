<?php
// The User is first re-directed to the homepage to know more about the website and the products it sells
session_start();
if(!isset($_SESSION['username'])){
    header("location:HomePage.php");
}
//If the user clicks the log out button he/she exits the current page and is re-directed to the login page 
if(isset($_POST['submitLogOut']))
{
	  //The Unset function here is used to clear all data stored in the session function/method
    unset($_SESSION['username']);  
	//This method removes all user data from the session and then deletes the session
    session_destroy(); 
	
    header("location:index.php");
  
}

//logging the user out from different webpages 
if($_GET['logOut'] == 9){
	 //The Unset function here is used to clear all data stored in the session function/method
    unset($_SESSION['username']);  
		//This method removes all user data from the session and then deletes the session
    session_destroy(); 
	
    header("location:index.php");
	
}

//After The User Has Successfully registered/logged in, the user is allowed to go to the shop page. When they click the start shopping button

if(isset($_POST['startShopping']))
{
    header("location:shop.php");
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
<html>

<head>
    <title>The Loading page</title>
   <!---<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>--->   
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, inital-scale=1.0">
		<style>
		* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins',sans-serif;
}
	
/*----Login And Registration Styling----*/

section {
    position: relative;
    height: 100vh;
    width: 100%;
    background: url("pictures/benLucVibe.jpg");
    background-size: cover;
    background-position: center center;
}

.form-container {
    position: absolute;
    top: 52%;
    left: 50%;
    transform: translate(-50%,-50%);
    background: linear-gradient(rgba(0,0,0,0.3),rgba(0,0,0,0.3));
    width: 380px;
    padding: 50px 30px;
    border-radius: 10px;
    box-shadow: 7px 7px 60px #000;
}

h1 {
    text-transform: uppercase;
    font-size: 2em;
    text-align: center;
    margin-bottom: 2em;
}

.control input {
    width: 100%;
    display: block;
    padding: 10px;
    color: #222;
    border: none;
    outline: none;
    margin: 1em 0;
}

    .control input[type="submit"] {
        background: crimson;
        color: #fff;
        text-transform: uppercase;
        font-size: 1.2em;
        opacity: .7;
        transition: opacity .3s ease;
    }

        .control input[type="submit"]:hover {
            opacity: 1;
        }

.link {
    text-align: center;
}

    .link a {
        text-decoration: none;
        color: #fff;
        transition: opacity .3s ease;
    }

        .link a:hover {
            opacity: 1;
        }

	
		
		
		/*Footer*/
.footer {
    background: #000;
    color: #8a8a8a;
    font-size: 14px;
    padding: 60px 0 20px;
}

    .footer p {
        color: #8a8a8a;
    }

    .footer h3 {
        color: #fff;
        margin-bottom: 20px;
    }

.footer-col-1, .footer-col-2, .footer-col-3, .footer-col-4 {
    min-width: 250px;
    margin-bottom: 20px;
}

.footer-col-1 {
    flex-basis: 30%;
}

.footer-col-2 {
    flex: 1;
    text-align: center;
}

    .footer-col-2 img {
        width: 180px;
        margin-bottom: 20px;
    }

.footer-col-3, .footer-col-4 {
    flex-basis: 12%;
    text-align: center;
}

ul {
    list-style-type: none;
}

.app-logo {
    margin-top: 20px;
}

    .app-logo img {
        width: 140px;
    }

.footer hr {
    border: none;
    background: #b5b5b5;
    height: 1px;
    margin: 20px 0;
}

.copyright {
    text-align: center;
}

.menu-icon {
    width: 28px;
    margin-left: 20px;
    display: none;
}
		</style>
</head>

<body>
<form action=" " method="POST">
<section>
<center>
<div class="form-container">
<p>Welcome <b><?php echo $_SESSION['username']; ?></b>, You have successfully logged in!</p>
	
        <form method="post">
		<div class="control">
            <input type="submit" name="startShopping" value="Start Shopping" />
	</div>
		<div class="control">
            <input type="submit" name="submitLogOut" value="Logout" />
		</div>
        </form>
</div>
</center>
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