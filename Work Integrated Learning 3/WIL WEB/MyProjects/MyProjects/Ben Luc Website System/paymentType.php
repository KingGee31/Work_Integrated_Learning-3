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
	

//checking if the comment section button was clicked and re-directing the user to the comments page 
if(isset($_POST['comment'])){
	header('location: customerComments.php');
}

	if(isset($_POST['Proceed'])){
		
		header('location: HomePage.php');
	}
	
	
	if($_SESSION['paymentOptn'] == "cash" ){
		//loads the cash payment html page 
		
		
			//retreving the loggednin user username
$cid = $_SESSION['cid'];
$date = date('Y-m-d');
	
	//variables to display and store user order
$data = NULL;

//Save new order
mysqli_query($conn, "insert into tblorders(cid, datecreation)
values($cid,'$date')");
$_SESSION['oid'] = $ordersid = mysqli_insert_id($conn);

try{
	
	// Save order details for new order
$cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
for($i=0; $i<count($cart); $i++) {
	$result = mysqli_query($con, 'insert into tblorderproduct(oid, pid, price, qnty)
values('.$ordersid.', '.$cart[$i]->id.','.$cart[$i]->price.', '.$cart[$i]->quantity.')');

//updating the quantity of the product table 

$qntyUpdate = mysqli_query($con, 'select * from tblproducts where pid ='.$cart[$i]->id);
 $data = mysqli_fetch_array($qntyUpdate);
 
 $updatedQnty = $data['qnty'] - $cart[$i]->quantity;
 
 $updateTblProductsQnty = mysqli_query($con, 'update tblproducts set qnty ='.$updatedQnty.' where pid ='.$cart[$i]->id);

 if($result && $updateTblProductsQnty ){
			// Clear all products in cart
	unset($_SESSION['cart']);
			
		}

}
	
}catch(TypeError $e){
	echo "The cart object is empty".$e ;
	header('location:customerComments.php');
	exit;
	
}
		
				
		
?>
	<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Cash Option Order</title>
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
	<h1>Cash Payment Order Details</h1>
	<!---Show Order Details Here----->
	<div class="control">
<p>Order Receipt</p>
<p>**Customer: <b><?php echo $_SESSION['username']; ?>**</b> <br/>**Order No:<?php echo $_SESSION['oid']; ?>**<br/>**Order Date:<?php echo $date; ?>**</p>
Visit Soon and take care!<b><?php echo $_SESSION['username']; ?></b>
<br>
</div>
	<div class="control">
	<br>
<p style="font-size: 13.5px;  font-family: Consolas; ">We Appreciate Your Feedback Because It Helps Us Improve, Share Your Thoughts With Us In The Comments Section</p>
<!---<center><button type="submit" class="btn" name="comment">Comment!</button></center>--->
</div>
<div class="control">
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
				
		
<?php
	}else if($_SESSION['paymentOptn'] == "creditCard/EFT"){
		//loads the credit card payment html page
		
			//retreving the loggednin user username
$cid = $_SESSION['cid'];
$date = date('Y-m-d');
	
	//variables to display and store user order
$data = NULL;

//Save new order
mysqli_query($conn, "insert into tblorders(cid, datecreation)
values($cid,'$date')");
$_SESSION['oid'] = $ordersid = mysqli_insert_id($conn);

try{
	
	// Save order details for new order
$cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
for($i=0; $i<count($cart); $i++) {
	$result = mysqli_query($con, 'insert into tblorderproduct(oid, pid, price, qnty)
values('.$ordersid.', '.$cart[$i]->id.','.$cart[$i]->price.', '.$cart[$i]->quantity.')');

//updating the quantity of the product table 

$qntyUpdate = mysqli_query($con, 'select * from tblproducts where pid ='.$cart[$i]->id);
 $data = mysqli_fetch_array($qntyUpdate);
 
 $updatedQnty = $data['qnty'] - $cart[$i]->quantity;
 
 $updateTblProductsQnty = mysqli_query($con, 'update tblproducts set qnty ='.$updatedQnty.' where pid ='.$cart[$i]->id);

 if($result && $updateTblProductsQnty ){
			// Clear all products in cart
	unset($_SESSION['cart']);
			
		}

}
	
}catch(TypeError $e){
	echo "The cart object is empty".$e ;
	header('location:customerComments.php');
	exit;
	
}
			
		
?>
		<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Credit Card/EFT</title>
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
	<h1>Credit Card/EFT Order Details</h1>		
	
<div class="control">
<br>
<p style="font-size: 17px; font-family: Consolas;  ">To Complete An EFT transtaction successfully, Deposit the money at a local Capetic Bank with the following account details:<br> Account Number: 154 080 5792<br>Reference: tshwane 0002 </p>
<p style="font-size: 17px; font-family: Consolas;  ">The transcation may take up to 48hrs to go through, wait for the order delivery date to appear in the manage account section before you can receive the products</p>

</div>
<!---Show The Credit Card Details Here--->	
<div class="control">
<p>Order Receipt</p>
<p>**Customer: <b><?php echo $_SESSION['username']; ?>**</b> <br/>**Order No:<?php echo $_SESSION['oid']; ?>**<br/>**Order Date:<?php echo $date; ?>**</p>
Visit Soon and take care!<b><?php echo $_SESSION['username']; ?></b>
<br>
</div>

<div class="control">
<p style="font-size: 13.5px;  font-family: Consolas; ">We Appreciate Your Feedback Because It Helps Us Improve, Share Your Thoughts With Us In The Comments Section</p>
<!----<center><button type="submit" class="btn" name="comment">Comment!</button></center>---->
</div>

<div class="control">
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
<?php	
	
	}	
	else{
		//Do nothing if the customer selected option is not one of the available options
		
	}

?>