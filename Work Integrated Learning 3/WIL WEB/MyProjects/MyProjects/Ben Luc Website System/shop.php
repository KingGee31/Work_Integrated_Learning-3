<?php
session_set_cookie_params(0);
session_start();

// Include the database configuration file
include('dbConn.php');

// Retrieving images from the database tblProducts
$sql = "SELECT * FROM tblProducts";
$query = mysqli_query($conn,$sql);
//Declaring arrays to hold the picture, picture name, picture description,product table primary key and picture price 
$pictureArray = array();
$pictureDescriptionArray = array();
$pictureSellPriceArray = array();
$productPrimaryKey = array();
//introducing count to help array incerement between the array subscripts 
$count = 1;
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
		//Assigning the arrays that have picture information  values from the while loop, while it iterates 
		$pictureArray[$count] = $row["image"];
		$pictureDescriptionArray[$count] = $row["pname"];
		$pictureSellPriceArray[$count] = $row["price"];
		$productPrimaryKey[$count] = $row["pid"];
		//Incrementing count to allow the iteration
		$count +=1;
} 
} else{
   echo "<script>alert('The Are No Images Found In The Database Table');</script>";
   
 }	
//checking if the user clicked the add to cart button for all the items displayed in the page , if clicked then re-direct the user to the Cart page 
	/*if(isset($_POST['addToCart'])){
		header("location:cart.php");
	}*/

 
/*SOURCE CODE USED FOR THIS PAGE WAS ACCESSED FROM YOUTUBE 
Code Opacity( 2020).Responsive Transparent Login Form with Html and Css. https://www.youtube.com/watch?v=yiIi82xVjqo
.13/05/2021

*THIS ONE BELOW IS FOR THE WEBPAGE FOOTER

The WebShala(2020).Responsive Footer Design using Html & Css.
https://www.youtube.com/watch?v=YOb67OKw62s .14/05/2021

*THIS ONE BELOW IS FOR THE CARDS THAT HOLD THE IMAGES 

CODING_SCRIPT_(2021).Build beautiful Ecommerce product pages using HTML and CSS. https://www.youtube.com/watch?v=I89vL0YzmjU. 13/05/2021
*/
//if the user clicked the start shopping then the user is navigated to the shopping page to start shopping 

?>
<!DOCTYPE html>
	<html lang="en">
	
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			 <title>Shop</title>
     <link rel="stylesheet" href="ShopPageStyleSheet.css"/>
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
		<!---------Featured Products-------->
    <div class="small-container">
     	<!---Creating a row of 4 columns to hold the item products--->
						 <h2 class="title">Featured Products</h2>
        <div class="row">
            <div class="col-4">
                <!---image--1-->
				<img src="<?php echo $pictureArray[1]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[1]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[1]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
               			            
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[1]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
            </div>
			<!---image--2-->
            <div class="col-4">
          <img src="<?php echo $pictureArray[2]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[2]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[2]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[2]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>

            <!---image--3-->
            <div class="col-4">
         <img src="<?php echo $pictureArray[3]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[3]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[3]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
               
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[3]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
            <!---image--4-->
              <div class="col-4">
         <img src="<?php echo $pictureArray[4]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[4]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[4]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              
				 <a href="exploreProduct.php?id=<?php echo $productPrimaryKey[4]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
        </div>
        <h2 class="title">Trending Products</h2>
        <!---creating a row to display the product items----->
      
         <div class="row">
               <!---image--5-->
              <div class="col-4">
       <img src="<?php echo $pictureArray[5]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[5]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[5]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
               
				 <a href="exploreProduct.php?id=<?php echo $productPrimaryKey[5]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
        <!---image--6-->
        <div class="col-4">
         <img src="<?php echo $pictureArray[6]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[6]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[6]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[6]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
             <!---image--7-->
          <div class="col-4">
        <img src="<?php echo $pictureArray[7]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[7]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[7]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[7]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
             <!---image--8-->
		<div class="col-4">
       <img src="<?php echo $pictureArray[8]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[8]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[8]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                
				 <a href="exploreProduct.php?id=<?php echo $productPrimaryKey[8]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
         </div>

      
        <div class="row">
            <!---image--9-->
            <div class="col-4">
          <img src="<?php echo $pictureArray[9]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[9]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[9]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
             
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[9]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
       <!---image--10-->
        <div class="col-4">
        <img src="<?php echo $pictureArray[10]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[10]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[10]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              	
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[10]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
            <!---image--11-->
        <div class="col-4">
         <img src="<?php echo $pictureArray[11]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[11]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[11]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
               	<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[11]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>

        <!---image--12-->
        <div class="col-4">
          <img src="<?php echo $pictureArray[12]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[12]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[12]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
               
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[12]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
        </div>

        
        <div class="row">
             <!---image--13-->
            <div class="col-4">
        <img src="<?php echo $pictureArray[13]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[13]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[13]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
               
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[13]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
       <!---image--14-->
        <div class="col-4">
         <img src="<?php echo $pictureArray[14]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[14]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[14]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                	
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[14]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>
            <!---image--15-->
        <div class="col-4">
       <img src="<?php echo $pictureArray[15]; ?>" />
             <center><h4 class="product-name"><?php echo $pictureDescriptionArray[15]; ?></h4></center>	
				<h5 class="product-price"><?php echo $pictureSellPriceArray[15]; ?></h5>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
              
				<a href="exploreProduct.php?id=<?php echo $productPrimaryKey[15]; ?>"><button type="button" class="btn">Explore! &#8594;</button></a>
									
            </div>

       
        </div>

      

            </div>
           
		   
		   
		    <footer>
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
    </footer>
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