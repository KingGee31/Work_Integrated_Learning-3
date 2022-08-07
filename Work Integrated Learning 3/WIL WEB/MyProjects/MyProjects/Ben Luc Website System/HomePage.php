<?php
session_set_cookie_params(0);

// Include the database configuration file
require 'dbConn.php';
include_once('createTable.php');

//Starting the website session to know the user logged in or not and to also pass the values from 1 html form to the other 
session_start();
//unset($_SESSION['username']); 
//if the user clicked the start shopping then the user is navigated to the shopping page to start shopping 
if(isset($_POST['shop'])){
    header("location:shop.php");
}
//if the user clicked the Admin button then the user will be navigated to login with the Admin credentials to access the admin privileges 
if(isset($_POST['admin'])){
    header("location:login.php");
}

//declaring arrays to display the customer comments during runtime
$customerIDs = array();
$customerEmailAddress = array();
$customerComment = array();
	
	//introducing count to help array incerement between the array subscripts 
$count = 1;

//loading the customer cumments for display
 $comment = mysqli_query($con, 'select * from tblcustomer_comment');

if(mysqli_num_rows($comment) >= 1){
    while($rowRetrieve = mysqli_fetch_assoc($comment)){
		//Assigning the arrays information for display in the homepage 
		$customerIDs[$count] = $rowRetrieve['cid'];
		$customerComment[$count] = $rowRetrieve['Comment'];

		//loading the customer email address from tblcustomers
	$customerEmail = mysqli_query($con, 'select email from tblcustomers where cid='.$rowRetrieve['cid']);
		$commentData = mysqli_fetch_array($customerEmail);
		
		$customerEmailAddress[$count] = $commentData['email'];
		
		//Incrementing count to allow the iteration
		$count +=1;
} 
} else{
   echo "<script>alert('The Are No Comments Found ');</script>";
   
 }
	
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Ben Luc Designer Clothing Store | Homepage</title>
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
        <div class="row">
            <div class="col-2" style="margin-top: -65px;">
                <h1>BenLuc 'Wear Authentic Threads</h1>
                <p>Tune into some trending vibes that the Ben Luc<br /> Designer Clothing Store is up to</p>            
				 <p>Our Purpose is to design South African streetwear clothing brand items that specialize on Authentic Threads.</p>
				<!---  <a href="productExplore.aspx" class="btn">Explore Now &#8594;</a>--->
				  
            </div>
            <div class="col-2">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="pictures/beigeSkinDress.jpg" width="70%" style="margin-top: -65px;" />
            </div>
        </div>
    </div>
    
    </div>
	 <!---------Featured Categories-------->
    <div class="categories">
        <div class="small-container">
            <h2 class="title">Trending Products</h2>
             <div class="row">
            <div class="col-3">
			<img src="pictures/brownEssentialPuffer.jpg" />
                 </div>		
            <div class="col-3">                
              <img src="pictures/greenInternationalSweatSet.jpg" />
            </div>
            <div class="col-3">
                <img src="pictures/essentialPufferJacket2.jpg" />
            </div>
        </div>
        </div>
       
    </div>
	
	 <!---------Featured Products-------->
    <div class="small-container">
        <h2 class="title">Featured Products</h2>
        <div class="row">
            <div class="col-4">          
				<img src="pictures/blackOrBrownWindBreaker.jpg"/>
                <h4>Black Or Brown Wind Breaker</h4>
                <div class="rating">
                    <i class="fa fa-star"></i>
                     <i class="fa fa-star"></i>              
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                </div>
                
               <!--Area that used to have the product price--->
               
            </div>
             <div class="col-4">
               
				<img src="pictures/heavyWeightNylonPants.jpg"/>
                <h4>Heavy Weight Nylon Pants</h4>
               <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
               </div>
              
            </div>
             <div class="col-4">
              
			   <img src="pictures/brownEssentialPufferJacket.jpg"/>
                <h4>Brown Essential Puffer Jacket</h4>
                 <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                 </div>
                
                
            </div>
             <div class="col-4">
               
				 <img src="pictures/ladiesPufferVest.jpg"/>
                <h4>Ladies Puffer Vest</h4>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
               
            </div>
        </div>
        <h2 class="title">Latest Products</h2>
        <div class="row">
            <div class="col-4">
               
				<img src="pictures/blackOrGoldMiniDress.jpg"/>
                <h4>Black Or Brown Mini Dress</h4>
                <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                </div>
               
              
            </div>
             <div class="col-4">
            
			   <img src="pictures/blackCargoShorts.jpg"/>
                <h4>Black Cargo Shorts</h4>
                 <div class="rating">
                 <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
                 </div>
              
              
            </div>
             <div class="col-4">
               
				 <img src="pictures/blueInternationalSweatSet.jpg" />
                <h4>Blue International Sweat Set</h4>
                 <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                 </div>
                
              
            </div>
             <div class="col-4">
              
			   <img src="pictures/bFullSet.jpg"/>
                <h4>B Full Set</h4>
                 <div class="rating">
                      <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                 </div>
               
             
            </div>
        </div>
        <!-------Registered Customer Product Specials------->
        <div class="registeredCustomerSpecial">
            <h2 class="title">Discounted Products</h2>
            <div class="row">
            <div class="col-4">
                 
				  <img src="pictures/brownSweatPantsPlusSweatShirt.jpg"/>
                <h4>Brown Sweat Pants Plus Sweat Shirt</h4>
                <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>

                </div>
               
                
            </div>
             <div class="col-4">
               
				<img src="pictures/beigeSkinDress.jpg"/>
                <h4>Beige Skin Dress</h4>
                 <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>

                 </div>
                
              
            </div>
             <div class="col-4">
                
				 <img src="pictures/membersClubCropTop.jpg"/>
                <h4>Members Club Crop Top</h4>
                 <div class="rating">
                       <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                 </div>
              
                
            </div>
             <div class="col-4">
              
				<img src="pictures/blackSkinCropTop.jpg" />
                <h4>Black Skin Crop Top</h4>
                 <div class="rating">
                     <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>

                 </div>
                
              
            </div>
        </div>
        </div>
        <!--------Special Product Offer------->
        <div class="offer">
            <div class="small-container">
                <div class="row">
                <div class="col-2">
                    <img src="pictures/Screenshot_20210925-110802.jpg" class="offer-img" />
                </div>
                    <div class="col-2">
                        <p>Exclusively Available on Ben Luc</p>
                        <h1>White Puffer Jacket</h1>
                        <small>The White Puffer Jacket has been uniquely designed with exotic fabrics, A jacket for events, casual wear and  
                            for keeping warm.
                        </small>
                      <!---<a href="" class="btn">Explore! &#8594;</a>--->
                    </div>
                </div>
            </div>
        </div>


    </div>
	
	<!---Add The Customer Comment Section here--->
	<div class="testimonial">
	<h2 class="title">Customer Comments Section</h2>
		<div class="small-container">
		<div class="row">
		<div class="col-3">
		<i class="fa fa-quote-left"></i>
		<p><?php if(!empty($customerComment[1])){echo $customerComment[1]; }else{ echo "Customer Comments Will Appear Here";}  ?></p>
		<img src="pictures/userCommentProfileIcon.png"/>
		<h3><?php if(!empty($customerEmailAddress[1])){ echo $customerEmailAddress[1]; }else{ echo"Customer Email Address";}  ?></h3>
		</div>
		<div class="col-3">
		<i class="fa fa-quote-left"></i>
		<p><?php if(!empty($customerComment[2])){echo $customerComment[2]; }else{echo "Customer Comments Will Appear Here"; }   ?></p>
		<img src="pictures/userCommentProfileIcon.png"/>
		<h3><?php if(!empty($customerEmailAddress[2])){ echo $customerEmailAddress[2]; }else{ echo "Customer Email Address"; }  ?></h3>
		</div>
		<div class="col-3">
		<i class="fa fa-quote-left"></i>
		<p><?php if(!empty($customerComment[3])){echo $customerComment[3];  }else{echo "Customer Comments Will Appear Here";}    ?></p>
		<img src="pictures/userCommentProfileIcon.png"/>
		<h3><?php if(!empty($customerEmailAddress[3])){echo $customerEmailAddress[3]; }else{ echo "Customer Email Address";}  ?></h3>
		</div>
		</div>
		</div>
	</div>
	
	<!---You Can Add The Brand That The Webiste Uses In This Section--->
	
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