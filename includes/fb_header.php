<?php 
	include("FB_module.php");	
	$data = $facebook->getAccessToken();	
	if($uid!='')
	{
		$count=0;
		$query="select id,email from user where uid='".$uid."'";
		$result = mysql_query($query);
		$userdtls=@mysql_fetch_assoc($result);
		$_SESSION['csUserId']=$userdtls['id'];
		$date = date("Y-m-d H:i:s");
		
		if($result)
		{
			$count = mysql_num_rows($result);
		}
		
		//print_r($friends_list);
		if($count == '0')
		{
			if($email=='')
			{
				$url = $facebook->getLoginUrl(array(
				   'canvas' => 1,
				   'fbconnect' => 0,
				   'req_perms' => 'email,publish_stream,status_update,user_location',
				   'next' => 'http://apps.facebook.com/'.$name_space	//'http://apps.facebook.com/'.$name_space.'		   
			   ));

		echo "<script type='text/javascript'>top.location.href = '$url';</script>";		
			}
			
			$query = "insert into user(uid,fname,lname,email,location,added_date,access_token) values ('$uid','$name','$lname','$email','$location','$date','$data')";
			
			//echo $query;//$rs = mysql_query("insert into contests(ownerid,visitorid,type,sequence,message,added_date) values('$uid','$uid','star','1','','$date')");
			mysql_query($query);
			
			//post_to_wall();
			
		}
		else
		{
			$query = "update user set email='$email' where id='".$userdtls['id']."'";
			
			//echo $query;//$rs = mysql_query("insert into contests(ownerid,visitorid,type,sequence,message,added_date) values('$uid','$uid','star','1','','$date')");
			mysql_query($query);
		}
	}
	
	
?>