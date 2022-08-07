<?php
session_set_cookie_params(0);
session_start ();
require 'dbConn.php';
require 'item.php';



if (isset ( $_GET ['id'] ) && !isset($_POST['update'])) {

	$retrievedData = mysqli_query ( $conn, 'select * from tblproducts where pid=' . $_GET ['id'] );
	$productData = mysqli_fetch_object ( $retrievedData );
	$item = new Item ();
	$item->id = $productData->pid;
	$item->name = $productData->pname;
	$item->price = $productData->price;
	$item->quantity = 1;
	// Check product is existing in cart
	$index = - 1;
	if (isset ( $_SESSION ['cart'] )) {
		$cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
		for($i = 0; $i < count ( $cart ); $i ++)
		if ($cart [$i]->id == $_GET ['id']) {
			$index = $i;
			break;
		}
	}
	if ($index == - 1)
	$_SESSION ['cart'] [] = $item;
	else {
		$cart [$index]->quantity ++;
		$_SESSION ['cart'] = $cart;
	}
}else {
	//displays the table when the user updates the quantity of the items in the cart
	
}

// Deleting the product in the cart when the user clicks the delete link 
if (isset ( $_GET ['index'] ) && !isset($_POST['update'])) {
	$cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
	unset ( $cart [$_GET ['index']] );
	$cart = array_values ( $cart );
	$_SESSION ['cart'] = $cart;
}

// Updating the quantity of the product in the cart 
if(isset($_POST['update'])) {
	$arrQuantity = $_POST['quantity'];

	// Check validate quantity
	$valid = 1;
	for($i=0; $i<count($arrQuantity); $i++)
	if(!is_numeric($arrQuantity[$i]) || $arrQuantity[$i] < 1){
		$valid = 0;
		break;
	}
	if($valid==1){
		$cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
		for($i = 0; $i < count ( $cart ); $i ++) {
			$cart[$i]->quantity = $arrQuantity[$i];
		}
		$_SESSION ['cart'] = $cart;
	}
	else
		$error = "<script>alert('Products quantity cannot be 0 or a negative number, select valid product quantity')</script>";
	
}


?>
<?php echo isset($error) ? $error : ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Ben Luc Designer Clothing Store | Cart</title>
<link rel="stylesheet" href="homeStyleSheet.css"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
	
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
                   <li><a href="About us.php">About Us</a></li>
                 <li><a href="Contact Us.php">Contact Us</a></li>
            </ul>
        </nav>
            <img src="pictures/cart.png" width="40" height="40" alt="cart photo" />
            <img src="pictures/menuIcon.png" class="menu-icon" alt="menuIcon photo" onclick="menutoggle()" />
    </div>
    
    </div>
    
    </div>
	
<center>
	<table  width="100%" style="border: 3px solid black;">
		<tr>
			<th  style="color: black; background: red; border: 2px solid black; ">Option</th>
			<th   style="color: black; background: red; border: 2px solid black;" >Name</th>
			<th  style="color: black; background: red; border: 2px solid black; " >Price</th>
			<th style="color: black; background: red; border: 2px solid black; " >Quantity <input type="image" src="images\save.jpg"> <input
				type="hidden" name="update">
			</th>
			<th  style="color: black; background: red; border: 2px solid black;" >Sub Total</th>
		</tr>
		<?php
		if(!empty($_SESSION ['cart']) ){
			
		}else{
		//invoking the function that will alert the user  		
			header('location: emptyCart.php');	
		
		}
				
		$cart = unserialize ( serialize ( $_SESSION ['cart'] ) );
		
		$grandTotal = 0;
		$index = 0;
		for($i = 0; $i < count ( $cart ); $i ++) {
			$grandTotal += $cart [$i]->price * $cart [$i]->quantity;
			?>
		<tr>
			<td style=""><a href="cart.php?index=<?php echo $index; ?>"
				onclick="return confirm('Are you sure?')">Delete</a></td>
			<td><?php echo $cart[$i]->name; ?></td>
			<td><center><?php echo "R :".$cart[$i]->price; ?></center></td>
			<td><center><input type="number" value="<?php echo $cart[$i]->quantity; ?>"
				style="width: 50px;" name="quantity[]"></center></td>
			<td><?php echo "R :".$cart[$i]->price * $cart[$i]->quantity; ?></td>
		</tr>
		<?php
		$index ++;
		
		}
		?>
		<tr>
		<br>
			<td colspan="4" style=" border-top: 3px solid #ff523b; " align="right"><b>Grand Total</b></td>
			<td  style=" border-top: 3px solid #ff523b;  " ><?php echo "<b>R :$grandTotal</b>"; ?></td>
			
		</tr>
	</table>
	<br>
	<a align="right" class="btn" href="shop.php">Continue Shopping</a> | <a align="right" class="btn"   href="checkout.php" name="checkOutLink">Checkout</a>
</center>

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