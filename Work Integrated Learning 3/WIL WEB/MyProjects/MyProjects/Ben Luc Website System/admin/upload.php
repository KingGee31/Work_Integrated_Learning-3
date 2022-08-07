<?php
session_start();

if(isset($_POST['upload'])){
	$file = $_FILES['file'];
	
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];
	$fileSize = $_FILES['file']['size'];
	
	
	$fileExt = explode('.',$fileName);
	$fileActualExt =strtolower(end($fileExt));
	
	$allowed = array('jpg','jpeg','png');
	
	if(in_array($fileActualExt,$allowed)){
		if($fileError === 0){
			if($fileSize < 500000){
				$fileNameNew ="pic".uniqid(''.true).".".$fileActualExt;				
				
				$fileDestination = '../image/'.$fileNameNew;
				//using the session attribute to store the image url for usage 
				$_SESSION['imageURL'] = $fileDestination;
				
				//uploading the file to the designated destination 
				move_uploaded_file($fileTmpName,$fileDestination);
				//redirecting the user to the Admin page to add more pictures if need be
				header('location: productList.php?uploadsucess');
			}else{
				echo "Your File Was Too big to upload!";
			}
		}else{
			echo "There was an error uploading your file";
		}
	}
	else{
		echo "You Cannot upload files of this type!";
	}
	
}


?>