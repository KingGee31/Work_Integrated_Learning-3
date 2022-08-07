<?php
		include_once('dbConn.php');
   // include_once('createTable.php');

	//Declaring Variables To Receive the User Input From The Form Fields
		$emailAddress = NULL;
		$loginPassword = NULL;
		$adminUserName = NULL;
		$adminPassword = NULL;
	
	/*Using the Session function to check if the user has logged in, the session function is also useful in helping access the username/email address of the 
	* from another webpage easily*/
	session_set_cookie_params(0);
	session_start();
    //unset($_SESSION['username']); 
	//Checking if the Login Button Was Clicked and Processing the user data else the user is required to enter correct information
	if(isset($_POST['submitLogin'])){
		/*Assigning the Session function the user email address that i might be able to display the username after the user successfully loggs in before the user 
		starts shopping */
		$_SESSION['username'] = $_POST['username'];
		//Assigning the declared variables values from the Login Form
		$emailAddress = $_POST['username'];
		$loginPassword = $_POST['psw'];
		//Hashing the user password, to match it with the database saved user password 
		 $hashPassword = md5($loginPassword);
		
		//Admin login Credentials 
					//Retrieve user admin login credentials from the database for login
$adminLogin = mysqli_query($conn, "select * from tbladmin where Admin_Email= '$emailAddress'");
if(mysqli_num_rows($adminLogin) > 0)
        {
			$adminData = mysqli_fetch_array($adminLogin);
			
			$adminUserName = $adminData['Admin_Email'];
		$adminPassword = $adminData['password'];
			
        }else {
		
		echo "<script>alert('No records found for the admin to login')</script>";
		}		
		
		
		//Retrieving the user data from the database table tblCustomers and assigning them to variables
		 $query = "SELECT * FROM tblCustomers WHERE email = '$emailAddress' && password = '$hashPassword'";
        
        $retrieve = mysqli_query($conn,$query);
		
		$data = mysqli_fetch_array($retrieve);

		$_SESSION['cid'] = $data['cid'];
        $compareToUsername = $data['email'];
        $compareToUserPassword = $data['password'];
		//checking if the user did not submit the login form without entering values 
		 if(empty($emailAddress) || empty($loginPassword))
        {
           echo "<script>alert('The Username/Password textfield cannot be empty, please enter data')</script>";
        }
		else{ #Checking if the user entered credentials that match the ones stored in the database
			if($compareToUsername == $emailAddress && $compareToUserPassword == $hashPassword) 
             { #When the credentials match the user is re-directed to the index page start his shopping 
				$_SESSION['email'] = $emailAddress;
				$_SESSION['username'] = $emailAddress;
				//This section will be used to re-direct the user to the different relevant pages that require the user to login first before advancing forward 
				if(isset($_SESSION['redirect_url'])){
                $redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url']: '/';
				unset($_SESSION['redirect_url']);
				header("location: $redirect_url",true,303);
				}
				else{
					echo "<script>alert('Login Successful, Continue to Shop')</script>";
				}
             }
			 			 
            else if($emailAddress == $adminUserName && md5($loginPassword) == $adminPassword ){ 			
			
			//Navigating the user to the Admin page To edit, add and delete the items 
			$adminTbl =   $_SESSION['adminEmail'] = $emailAddress;		
				
				header("location:admin/productList.php");	
            }else{
				#When the credentials are incorrect the user is requested to enter correct login credentials 
                 echo "<script>alert('Incorrect Username or password, please Enter correct data')</script>";
			}
		}
		 
        
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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, inital-scale=1.0">
<title>Login </title>
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
		<h1>Login Form</h1>
	
			<div class="control">
				<label for="name">Username</label>
				<input type="text" name="username" id="username" placeholder="Enter Email Address" minlength="3" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="The email address must contain letters(lowercase only), maybe numbers in the format: characters@characters.domain" value = "<?php echo $emailAddress; ?>" autofocus required>
			</div>
		<div class="control">
			<label for="psw">Password</label>
			<input type="password" name="psw" id="psw" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title=" Password Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
		</div>
			<div class="control">
				<input type="submit" name="submitLogin" value="Login">
				<p>No Account? : Click here to <a href="register.php">Register</a></p> 
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