<?php
session_set_cookie_params(0);
session_start ();
require 'dbConn.php';
require 'item.php';
//declaring a variable to hold the value of the selected product 
$exploreProductPicture = NULL;
$exploreProductPictureDescription = NULL;
$exploreProductPicturePrice = NULL;
$exploreProductPicturePrimaryKey = NULL;
$exploreProductQnty = NULL;
$exploreProductAvailabilityLabel = NULL;
//using this function to retrieve the product id
if (isset ( $_GET ['id'] ) ) {
$retrievedData = mysqli_query ( $conn, 'select * from tblproducts where pid=' . $_GET ['id'] );

	if(mysqli_num_rows($retrievedData) > 0){
    while($row = mysqli_fetch_assoc($retrievedData)){
		//Assigning the arrays that have picture information  values from the while loop, while it iterates 
		$exploreProductPicture = $row["image"];
		$exploreProductPictureDescription = $row["pname"];
		$exploreProductPicturePrice = $row["price"];
		$exploreProductPicturePrimaryKey = $row["pid"];
		$exploreProductQnty = $row["qnty"];
} 
} else{
   echo "<script>alert('The Item Could Not Be Loaded To Be Explored');</script>";
   
 }
}
//using an if statement to check if the product still have enough items to purchase 
if($exploreProductQnty < 1){
	
$exploreProductAvailabilityLabel = "Out Of Stock!";
	
}else if($exploreProductQnty > 1){
	$exploreProductAvailabilityLabel = "Available!";
}

?>
<!DOCTYPE html>
	<html lang="en">
	<head>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  <link rel="stylesheet" href="homeStyleSheet.css"/>  
	  
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
                  <li><a href="About us.php">About Us</a></li>
                 <li><a href="Contact Us.php">Contact Us</a></li>
            </ul>
        </nav>
            <img src="pictures/cart.png" width="40" height="40" alt="cart photo" />
            <img src="pictures/menuIcon.png" class="menu-icon" alt="menuIcon photo" onclick="menutoggle()" />
    </div>
        
    </div>
    
    </div>
	<!---Single Products Details--->
	<div class="small-container single-product">
	<div class="row">
	<div class="col-2">
	<img src="<?php echo $exploreProductPicture; ?> " alt="explore product pic" width="69%" height="50%" id="productImg"/>
	
	</div>
	<div class="col-2">
	<h1><?php echo $exploreProductPictureDescription; ?></h1>
	<h4>ZAR: <?php echo $exploreProductPicturePrice; ?></h4>
	<select>
	<option>Select Size</option>
	<option>XL</option>
	<option>L</option>
	<option>M</option>
	<option>S</option>
	</select>
	<br/>
	
	<h3>Product Details</h3>
	<br/>
	<p><?php echo $exploreProductAvailabilityLabel; ?></p>
	
	<br/>
	
	 <p>Our Purpose is to design South African streetwear clothing brand items that specialize on Authentic Threads.</p>
	 <?php
	 if($exploreProductAvailabilityLabel == "Out Of Stock!"){
		 ?>
		 <a href="javascript: void(0)" class="btn" style="color: black;" ><b>Not Available!</b></a>
		 
		 <?php
	 }else{
		 ?>
		  <a href="cart.php?id=<?php echo $exploreProductPicturePrimaryKey; ?>" class="btn"  >Add To Cart!</a>
		 
		 <?php
	 }
	 
	 
	 ?>
	
	 
	</div>
	</div>
	</div>
	
	
	
	
	
	 <!---view More products link--->
       <div class="small-container">

           <center><h2  class="related-item">Related Products</h2><h3 class="related-item-label">(Items Not For Sale!)</h3></center>
            <div class="row">
            <div class="col-4">
               <img src="pictures/femaleJewellerySet.jpg" />
                <h4>Gorgeous Jewellery Set</h4>
                <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>           
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                </div>
               
              
            </div>
             <div class="col-4">
               <img src="pictures/jewellerySet.jpg" />
                <h4>Exlusive Jewellery Set</h4>
                 <div class="rating">
                 <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>               
                 </div>
              
              
            </div>
             <div class="col-4">
                <img src="pictures/ladiesWristWatch.jpg" />
                <h4>Ladies Wrist Watch</h4>
                 <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                 </div>
                
             
            </div>
             <div class="col-4">
               <img src="pictures/mensWristWatch.jpg" />
                <h4>Mens Wrist Watch</h4>
                 <div class="rating">                   
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                 </div>
               
              
            </div>
        </div>

       </div>
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
	
	<!----js for product supporting images---->
	<script>
	var ProductImg = document.getElementById("productImg");
	var SmallImg = document.getElementsByClassName("small-img");
	
	SmallImg[0].onclick = function(){
	ProductImg.src = SmallImg[0].src;
	}
	SmallImg[1].onclick = function(){
	ProductImg.src = SmallImg[1].src;
	}
	SmallImg[2].onclick = function(){
	ProductImg.src = SmallImg[2].src;
	}
	
	</script>
	</body>
	
	</html>