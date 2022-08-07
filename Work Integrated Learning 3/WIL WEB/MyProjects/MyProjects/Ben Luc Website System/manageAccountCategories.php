<?php
/*Using the Session function to check if the user has logged in, the session function is also useful in helping access the username/email address of the 
	* from another webpage easily*/
	session_start();
	require 'dbConn.php';
	
//redirecting the user to login if the before the user can access the webpage
if(!isset($_SESSION['username'])){	
//creating a session variable that will allow the user to  be re-directed to the previous page after successful login 
	
	$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];	
    header("location:login.php");
	exit;
}

//declaring arrays to display the customer comments during runtime
$custOrderIDs = array();
$custIDs = array();
$custDateCreations = array();
$custDeliveryDate = array();
	
	//introducing count to help array incerement between the array subscripts 
$count = 1;

	
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
			
		
		$searchOrder = mysqli_query($con, 'select * from tblorders where oid ='.$customerOrderNo);
 $orderData = mysqli_fetch_array($searchOrder);
 
		$orderId = $orderData['oid'];
		$customerID = $orderData['cid'];
		$orderDate = $orderData['datecreation'];
		$DeliveryDate= $orderData['delivery_date'];
 
		
	}
	//executes when the customer clicks the button to view their order history 
	if(isset($_POST['viewOrderHistory'])){
		$custId = $_SESSION['cid'];
		
		$orderHistory = mysqli_query($con, 'select * from tblorders where cid ='.$custId);
		
		if(mysqli_num_rows($orderHistory) >= 1){
    while($rowData = mysqli_fetch_assoc($orderHistory)){
		//Assigning the arrays information for displaying the customer order history
		$custOrderIDs[$count] = $rowData['oid'];
		$custIDs[$count] = $rowData['cid'];
		$custDateCreations[$count] = $rowData['datecreation'];
		$custDeliveryDate[$count] = $rowData['delivery_date'];
		//Incrementing count to allow the iteration
		$count +=1;
} 
} else{
   echo "<script>alert('The is no order history for the customer ');</script>";
   
 }
		
	}
	
	//executes when the user changes their password by clicking the proceed button
	if(isset($_POST['changePassBtn'])){
				
		if(!empty($_POST['psw']) && !empty($_POST['confirmPsw'])){
			$pass1 = $_POST['psw'];
		$pass2 = $_POST['confirmPsw'];
			
		}else{
			$pass1 = NULL;
		$pass2 = ".";
		}
		
		
		//using an if statement to check if the 2 enetered passwords are equal before changing the user password in the database 
		if( $pass1 == $pass2 ){
			$updator = md5($pass1);
			$username =  $_SESSION['username'];
			
			$query = mysqli_query($conn, "UPDATE tblcustomers SET password ='$updator' WHERE email = '$username'");
			
		
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
	
	//checking which manager account category did the user choose
	if($_GET['option'] == 1){
		//loading the check order progress html page 
		?>
		<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Check Order Progress</title>
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
	<h1>Order Progress</h1>
	<div class="control">
	<p style=" font-size: 17px;  font-family: Consolas; " >Enter order no:</p>
	</div>
	<div class="control">
	<textarea pattern="[0-9]+" title="Please enter numbers only."  name="orderProgress" rows="1" cols="80"  placeholder="Enter Order No: "  style="margin: 0px; width: 338px; height: 32px; font-size: 18px;  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"  required></textarea>
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
			<td><?php if(!empty($DeliveryDate)){ echo $DeliveryDate; }else{ echo "no order found "; }  ?></td>
			</tr>
			
			
	</table></center>
	
	
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
		
		
		
		<?php
	}else if($_GET['option'] == 2){
		//loads and displays the order history page 
		?>
		
		<!DOCTYPE html>
		<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Customer Order History</title>
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
	<h1>Customer Order History</h1>
	
	
	<div class="control">
	<center><button type="submit" class="btn" name="viewOrderHistory">View!</button></center>
	</div>
	<p style=" font-size: 17px;  font-family: Consolas; " >Order history Details Below</p>
	<center><table cellpadding="5" cellspacing="5" border="3">
			<tr>
			<th>OrderId</th>
			<th>Customer id</th>
			<th>Order Date</th>
			<th>Delivery Date</th>
			</tr>
			<!---Order Hisorty item 1--->
			<tr>
			<td><?php if(!empty($custOrderIDs[1])){ echo $custOrderIDs[1]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custIDs[1])){ echo $custIDs[1]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDateCreations[1])){ echo $custDateCreations[1]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDeliveryDate[1])){ echo $custDeliveryDate[1]; }else{ echo "no order found "; }  ?></td>
			</tr>
			<!---Order Hisorty item 2--->
			<tr>
			<td><?php if(!empty($custOrderIDs[2])){ echo $custOrderIDs[2]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custIDs[2])){ echo $custIDs[2]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDateCreations[2])){ echo $custDateCreations[2]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDeliveryDate[2])){ echo $custDeliveryDate[2]; }else{ echo "no order found "; }  ?></td>
			</tr>
			<!---Order Hisorty item 3--->
			<tr>
			<td><?php if(!empty($custOrderIDs[3])){ echo $custOrderIDs[3]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custIDs[3])){ echo $custIDs[3]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDateCreations[3])){ echo $custDateCreations[3]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDeliveryDate[3])){ echo $custDeliveryDate[3]; }else{ echo "no order found "; }  ?></td>
			</tr>
			<!---Order Hisorty item 4--->
			<tr>
			<td><?php if(!empty($custOrderIDs[4])){ echo $custOrderIDs[4]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custIDs[4])){ echo $custIDs[4]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDateCreations[4])){ echo $custDateCreations[4]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDeliveryDate[4])){ echo $custDeliveryDate[4]; }else{ echo "no order found "; }  ?></td>
			</tr>
			<!---Order Hisorty item 5--->
			<tr>
			<td><?php if(!empty($custOrderIDs[5])){ echo $custOrderIDs[5]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custIDs[5])){ echo $custIDs[5]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDateCreations[5])){ echo $custDateCreations[5]; }else{ echo "no order found "; }  ?></td>
			<td><?php if(!empty($custDeliveryDate[5])){ echo $custDeliveryDate[5]; }else{ echo "no order found "; }  ?></td>
			</tr>
			
	</table></center>
	
	
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
		
		
		
		
		
		<?php
	}else if($_GET['option'] == 3){
	//loads the html page that will allow the user to change their loggin password
	?>
		
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<title>Change Password  </title>
	  <link rel="stylesheet" href="loginStyleSheet.css"/>
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
				<li><a href="manageAccount.php" name="manageAccountLink">Manage Account</a></li>
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
		<h1>Change Password</h1>
	
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
		
	
	
	
	<?php
	}
?>

