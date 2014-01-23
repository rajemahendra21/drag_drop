<?php
	//require_once('config.php');
	//include_once('includes/database.class.php');
	//include_once('includes/function.class.php');
	//include_once('includes/facebook.class.php');
	
	//$database = new Database_class();
	//$function = new Base_function();	
	
	//get_permission($facebook,$database); 
	
	
	
	//$uid = $_SESSION['userId'];
	//$fbId = $_SESSION['fbId']; 
	
	$imgData = $_POST['imgBase64'];	
	$img2Data = $_POST['img2Base64'];

	
	//$name = $fbId . time(). '.png';
	$name = 'mahe' . time(). '.png';
	$date = date('Y-m-d H:i:s');
	$path = 'assets/uploads/';
	$pathThum = 'assets/uploads/downloads/';

	saveImage(utf8_decode($imgData),$name,$path);	 
	saveImage(utf8_decode($img2Data),$name,$pathThum); 
	// saveImage($imgData,$name);	
	// saveImage2($img2Data,$name); 	


	$qry=$database->prepare("INSERT INTO canvas (user_id,c_image,added_date) 
							VALUES (:UID,:CIMG,:DATE)");
		$qry->bindParam(":UID",$uid);
		$qry->bindParam(":CIMG",$name);
		$qry->bindParam(":DATE",$date);
		$qry->execute();
		

 

function saveImage($base64img,$name,$dir)
{
   
    $base64img = str_replace('data:image/png;base64,', '', $base64img);
    $data = base64_decode($base64img);
    $file = $dir . $name;
	
    file_put_contents($file, $data);

}
// function saveImage($base64img,$name)
// {
    // define('UPLOAD_DIR', 'assets/uploads/');
    // $base64img = str_replace('data:image/png;base64,', '', $base64img);
    // $data = base64_decode($base64img);
    // $file = UPLOAD_DIR . $name;
	
    // file_put_contents($file, $data);
// }


// function saveImage2($base64img,$name)
// {
    // define('UPLOAD_DIR2', 'assets/uploads/downloads/');
    // $base64img = str_replace('data:image/png;base64,', '', $base64img);
    // $data = base64_decode($base64img);
    // $file = UPLOAD_DIR2 . $name;
	
    // file_put_contents($file, $data);
// }



?>