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
	
// initialize variables
	$pname = "";
	$price = "";
	$pid = 0;
	$update = false;

	if (isset($_POST['save']) && !empty($_POST['save'])) {
		
		
		$pname = $_POST['pname'];
		$price = $_POST['price'];
		$imageURL = $_SESSION['imageURL'] ;
		$qnty = 10;
		//splitting the umage url to change its format for database saving 
		$arrayImg = explode("/",$imageURL);
		
		
		$newImageURL ="image\\\\".$arrayImg[2];
		mysqli_query($conn, "INSERT INTO tblproducts (pname, price, image, qnty) VALUES ('$pname','$price','$newImageURL',$qnty)"); 
		$_SESSION['message'] = "Product added!!!"; 
		$textfileUpdatedData = $pname.",".$price.",".$newImageURL.",".$qnty;
		//Appending the newly created data to the product text file as the product now exists 
			$fproducts = fopen('../ProductData.txt', 'a')or die("Unable to open file!");//opens file in append mode

		fwrite($fproducts,"\n".$textfileUpdatedData);	
		//Closing the file after successfully writing to it 
		fclose($fproducts);		
		//header('location: productList.php?savesuccess');		
	}else{
		//executes when the user clicks the save button without uploading anything 
		
	}
	
		if (isset($_GET['edit'])) {
		$pid = $_GET['edit'];
		$update = true;
		$record = mysqli_query($conn, "SELECT * FROM tblproducts WHERE pid=$pid");

		if (mysqli_num_rows($record) == 1 ) {
			$n = mysqli_fetch_array($record);
			$pname = $n['pname'];
			$price = $n['price'];
		}
	}
	
	if (isset($_POST['update'])) {
		$pid = $_POST['pid'];
		$pname = $_POST['pname'];
		$price = $_POST['price'];

		mysqli_query($conn, "UPDATE tblproducts SET pname='$pname', price = '$price' WHERE pid=$pid");
		$_SESSION['message'] = "Product updated!"; 
		header('location:productList.php');
	}
	
		if (isset($_GET['del'])) {
		$id = $_GET['del'];
		mysqli_query($conn, "DELETE FROM tblproducts WHERE pid=$id");
		$_SESSION['message'] = "Product deleted!"; 
		header('location: productList.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Control Board</title>
<title>Ben Luc Designer Clothing Store | Admin | productList</title>
  <link rel="stylesheet" href="../loginStyleSheet.css"/>
  <style>
		body{
		background-color: blue;
	}
  </style>
</head>
<body>
				 <form method="post">
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
	
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php 
          	echo $_SESSION['success']; 
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['adminEmail'])) : ?>
    	<p style="font-size:24px;">Welcome <strong><?php echo $_SESSION['adminEmail']; ?></strong></p><br>
		<p style="font-size:20px;">Available Editable Section Below</p> 
    	<p>  <a href="productList.php" style="color: red; font-size:18px; font-family: Consolas; font-weight: 400;">1. Manage Products</a>&nbsp; <-- Click Here</p>
		<p>  <a href="manageOrders.php" style="color: green; font-size:18px; font-family: Consolas; font-weight: 400;">2. Manage Orders</a>&nbsp; <-- Click Here</p>
		<p>  <a href="adminChangePassword.php" style="color: yellow; font-size:18px; font-family: Consolas; font-weight: 400;">3. Change Password</a>&nbsp; <-- Click Here</p>&nbsp;
    <?php endif ?>
</div>

<?php $results = mysqli_query($conn, "SELECT * FROM tblproducts"); ?>

<center>
	<h3> Available Products List </h3>
	
	<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
<?php endif ?>
<br>

	<table width="100%" border="2" cellspacing="2" cellpadding="1" style="border: 3px solid black;">
		<thead style="color: black; background: red; border: 2px solid black; ">
			<tr>
				<th style="color: black; background: red; border: 2px solid black; ">Name</th>
				<th style="color: black; background: red; border: 2px solid black; ">Price</th>
				<th colspan="2" style="color: black; background: red; border: 2px solid black; ">Action</th>
			</tr>
		</thead>
		
		<?php while ($row = mysqli_fetch_array($results)) { ?>
			<tr>
				<td><?php echo $row['pname']; ?></td>
				<td><?php echo "<b>R :</b>".$row['price']; ?></td>
				<td>
					<button type="button"><a href="productList.php?edit=<?php echo $row['pid']; ?>" >Edit</a></button>
				</td>
				<td>
					<button type="button"><a href="productList.php?del=<?php echo $row['pid']; ?>">Delete</a></button>
				</td>
			</tr>
		<?php } ?>
	</table>
	</center>
	<br>

	<h3 style="text-align: left; font-size:26px;"> Add New Product And upload Product Picture </h3>
		<p style="text-align: left; font-size:22px;"><strong>NOTE!</strong>it is recommended that you scale the picture to 150 x 150 <i>before uploading it.</i></p>
		<p style="text-align: left; font-size:22px;">It is recommended that you upload the picture first before defining the image attributes and clicking the <strong>Save </strong> button</p>
<hr width = "595">	
<div>
<!---this will allow the user to ass new images into the website---->
		<form action="upload.php" method="POST" enctype="multipart/form-data">
			<input type="file" name="file">
			<button  type="submit" name="upload" class="btn" >Upload!</button>
		</form>
	<form method="post" action="" >
	<input type="hidden" name="pid" value="<?php echo $pid; ?>">
		<table>
		<tr>
			<td>Name</td><td><input type="text" name="pname" value="<?php echo $pname; ?>"></td>
		</tr>
		<tr>
			<td>Price</td><td><input type="text" name="price" value="<?php echo $price; ?>"></td>
		</tr>
		<tr><td></td>
			<td>
			<?php if ($update == true): ?>
				<button class="btn" type="submit" name="update" style="background: #556B2F;" class="btn" >update</button>
			<?php else: ?>
				<button class="btn" type="submit" name="save" class="btn" >Save</button>
			<?php endif ?>
			</td>
		
		</tr>
		</table>
		
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
	
</div>
</center>
</body>
</html>