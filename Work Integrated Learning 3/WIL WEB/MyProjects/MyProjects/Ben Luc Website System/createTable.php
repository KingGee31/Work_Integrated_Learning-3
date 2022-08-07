<?php
include('dbConn.php');

		$sqla = "CREATE TABLE `tblcustomers` (
		  `cid` int(10) NOT NULL AUTO_INCREMENT,
		  `fname` varchar(50) NOT NULL,
		  `lname` varchar(50) NOT NULL,
		  `email` varchar(50) NOT NULL,
		  `password` varchar(200) NOT NULL,
		  PRIMARY KEY (`cid`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";

		$sqlb = "CREATE TABLE `tblproducts` (
		  `pid` int(10) NOT NULL AUTO_INCREMENT,
		  `pname` varchar(50) NOT NULL,
		  `price` decimal(10,2) NOT NULL,
		  `image` varchar(50) NOT NULL,
		  `qnty` int(10) NOT NULL,
		  PRIMARY KEY (`pid`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";

		$sqlc = "CREATE TABLE `tblorders` (
				  `oid` int(10) NOT NULL AUTO_INCREMENT,
				  `cid` int(10) NOT NULL,
				  `datecreation` date NOT NULL,
				  `delivery_date` date DEFAULT NULL,
				  PRIMARY KEY (`oid`),
				  KEY `cid` (`cid`),
				  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `tblcustomers` (`cid`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";

			$sqld = "CREATE TABLE `tblorderproduct` (
				  `oid` int(10) NOT NULL,
				  `pid` int(10) NOT NULL,
				  `price` decimal(10,2) NOT NULL,
				  `qnty` int(10) NOT NULL,
				  KEY `oid` (`oid`),
				  KEY `pid` (`pid`),
				  CONSTRAINT `orderproduct_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `tblproducts` (`pid`),
				  CONSTRAINT `orderproduct_ibfk_2` FOREIGN KEY (`oid`) REFERENCES `tblorders` (`oid`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";

				$sqle = "CREATE TABLE `tblCUSTOMER_COMMENT` (
				  `Comment_ID` int(10) NOT NULL AUTO_INCREMENT,
				  `cid` int(10) NOT NULL,
				`Comment` varchar(200) NOT NULL,
				 PRIMARY KEY (`Comment_ID`),
				  KEY `cid` (`cid`),
				 FOREIGN KEY (`cid`) REFERENCES `tblcustomers` (`cid`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";
				
				$sqlf = "CREATE TABLE `tblADMIN` (
				  `Admin_Email` varchar(50) NOT NULL, 
				  `password` varchar(200) NOT NULL,
					PRIMARY KEY (`Admin_Email`)			  
				) ENGINE=InnoDB DEFAULT CHARSET=latin1";
				
				
		$CreateTableA = mysqli_query($conn, $sqla);
		$CreateTableB = mysqli_query($conn, $sqlb);
		$CreateTableC = mysqli_query($conn, $sqlc);
		$CreateTableD = mysqli_query($conn, $sqld);
		$CreateTableE = mysqli_query($conn, $sqle);
		$CreateTableF = mysqli_query($conn, $sqlf);

		if ($CreateTableA && $CreateTableB && $CreateTableC && $CreateTableD && $CreateTableE && $CreateTableF == TRUE) {
			
				//echo "<br>Tables created<br>";
				#echo "There was an error :".mysqli_error($conn);
				
		} else {

			//echo "<br>Tables exsist";
			
		}
		
		
		#Select any/all data that exists in the tbl customers 
		$query = "SELECT * FROM tblCustomers";

		$result = mysqli_query($conn,$query);
		#using an if statement to check if there is any data in the tbl customers, if the is no data then inserting the data 
		if (mysqli_num_rows($result) == 0) {
		//Loading the clothing items into the database 		
			uploadProductsData();
		}		
				
		function uploadProductsData(){

		global $conn;
		#Openning the textfile to upload the data with only read previleges 
		$open = fopen('productData.txt','r');

		while (!feof($open)) 
			
			{
				$getTextLine = fgets($open);
				$explodeLine = explode(",",$getTextLine);

				list($pname,$price,$image,$qnty) = $explodeLine;

				$qry = "insert into tblProducts 
				(pname, price, image, qnty) values('$pname','$price','$image','$qnty')";
				mysqli_query($conn,$qry);
			}

		fclose($open);  
		}
	
	
		

		
?>