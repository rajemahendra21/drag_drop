<?php
$user = $facebook->getUser();
$_SESSION['uid']=$user;
if (!$user) {
		$url = $facebook->getLoginUrl(array(
				   'canvas' => 1,
				   'fbconnect' => 0,
				   'req_perms' => 'email,publish_stream,status_update,user_location',
				   'next' => 'http://apps.facebook.com/'.$name_space.'/home.php'	//'http://apps.facebook.com/'.$name_space.'/index1.php	   
			   ));

		echo "<script type='text/javascript'>top.location.href = '$url';</script>";		
	

} else {
    try {

		$uid=$_SESSION['uid'];
		//echo $uid;
        $me = $facebook->api($uid);		
		//print_r($me);
		$profile_pic =  "http://graph.facebook.com/".$uid."/picture";
		$email = $me['email'];
		$name = $me['first_name'];
		$lname = $me['last_name'];
		$location = $me['location']['name'];
		//$userid = $session['uid'];
		$birthday=$me['birthday'];	
    } catch (FacebookApiException $e) {        

    }
	
	
	function get_userid()
	{
		global $uid;
		return $uid;
	}
	
		
}


?>