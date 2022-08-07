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


//checking which collection method the user chose 
	if($_SESSION['collection'] == "delivery"){
		//executes when the user picks delivery 
		//Showing an html page that will retreive the customer address
		?>
		<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Delivery Address</title>
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
	<h1>Delivery Address</h1>
	
	<div class="control">
	<!----Retrieve the user delivery address--->
	<p style="font-size: 16px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; ">Enter Delivery Address:</p>
	</div>
	<div class="control">
	<textarea  name="deliveryAddress" rows="8" cols="47" placeholder="Expected address format must include street name, post code, province, " style="margin: 0px; width: 316px; height: 170px; font-size: 18px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;" required></textarea>
	<br>
	</div>
	<div class="control">
	<br>
	<center><a href="deliveryPaymentOptions.php" class="btn" >Proceed!</a></center>
	
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
	else if($_SESSION['collection'] == "collect"){
		
		//executes when the user picks collect  
		//Showing an html page that will show the customer their orderNo and product receipt
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



		//the order is saved to the database if the user clicks the proceed button after reviewing the order 
if(isset($_POST['Proceed'])){ 	
	
header('location:HomePage.php');
	exit;
	
}	
		
		
		
		?>
		<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Collect </title>
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
<div class="form-container">
<div class="control">
	<!---Display The User OrderNo Here---->
<h1>Order Details Below</h1>
</div>
<div class="control">
<p>Order Receipt</p>
<p>**Customer: <b><?php echo $_SESSION['username']; ?>**</b> <br/>**Order No:<?php echo $_SESSION['oid']; ?>**<br/>**Order Date:<?php echo $date; ?>**</p>
Visit Soon and take care!<b><?php echo $_SESSION['username']; ?></b>
<br>
<center><button type="submit" class="btn" name="Proceed">Proceed!</button></center>
</div>
<br>
<div class="control">
<p style="font-size: 13.5px;  font-family: Consolas; ">We Appreciate Your Feedback Because It Helps Us Improve, Share Your Thoughts With Us In The Comments Section</p>
<!---<center><button type="submit" class="btn" name="comment">Comment!</button></center>---->
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
		

?>
