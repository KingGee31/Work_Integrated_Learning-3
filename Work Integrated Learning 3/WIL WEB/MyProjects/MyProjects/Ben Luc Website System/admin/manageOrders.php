<?php
/*Using the Session function to check if the user has logged in, the session function is also useful in helping access the username/email address of the 
	* from another webpage easily*/
	session_start();
	require '../dbConn.php';
	
	//declaring a variable that will retrieve the orderId 
	$custOrderN = NULL;
	
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

	//executes when the user clicks the search button to search for their order 
	if(isset($_POST['search'])){
		$customerOrderNo = $_POST['orderProgress'];
			
		$custOrderN = $customerOrderNo;
		
		$searchOrder = mysqli_query($con, 'select * from tblorders where oid ='.$customerOrderNo);
 $orderData = mysqli_fetch_array($searchOrder);
 
		$orderId = $orderData['oid'];
		$customerID = $orderData['cid'];
		$orderDate = $orderData['datecreation'];
		$DeliveryDate= "Pending...";
 
		
	}
	if(isset($_POST['saveDate'])){
		$orderDeliverDate = $_POST['orderDeliveryDatePicker'];
		$custOrderN = $_POST['orderProgress'];
			#Writing the User data to the database Table when every field has been entered correctly
		$query = mysqli_query($conn, "UPDATE tblorders SET delivery_date ='$orderDeliverDate' WHERE oid = $custOrderN");
			
		
		if($query){
			echo "<script>alert('Hooray, Delivery Date Updated');</script>";
			//Re-directing the user to the login page to Login with the registered credentials 
			
		}
		else if($query  !== TRUE) {
			echo "<script>alert('Could Not Successfully update the delivery date ');</script>";
		}
	}

?>
<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Check Order Progress</title>
  <link rel="stylesheet" href="../loginStyleSheet.css"/>
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
	<h1>Update Order Progress</h1>
	<div class="control">
	<p style=" font-size: 17px;  font-family: Consolas; " >Enter order no:</p>
	</div>
	<div class="control">
	<textarea pattern="[0-9]+" title="Please enter numbers only."   name="orderProgress" rows="1" cols="80"  placeholder="Enter Order No: "  style="margin: 0px; width: 338px; height: 32px; font-size: 18px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;" required></textarea>
	</div>
	<div class="control">
	<center><button type="submit" class="btn" name="search">Search!</button></center>
	</div>
	<p style=" font-size: 17px;  font-family: Consolas; " >Order Details Below</p>
	<center><table cellpadding="1" cellspacing="1" border="3">
			<tr>
			<th>OrderId</th>
			<th>Customer id</th>
			<th>Order Date</th>
			<th>Delivery date</th>
			</tr>
			<!---Order Progress--->
			<tr>
			<td><?php if(!empty($orderId)){ echo $orderId; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($customerID)){ echo $customerID; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($orderDate)){ echo $orderDate; }else{ echo "no order found "; }  ?></td>
			<td><label><input type="date" name="orderDeliveryDatePicker" ></label></td>
			</tr>
					
	</table></center>
	<div class="control">
	<center><button type="submit" class="btn" name="saveDate">Save!</button></center>
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
</html>	
		
		
