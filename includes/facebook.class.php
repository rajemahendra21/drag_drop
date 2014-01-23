<?php
	
	// Get Permission from user (app permission) and insert into database
	function get_permission($facebook,$database)
	{
		$user = $facebook->getUser();	
		
		if (!$user) 
		{
			$url = $facebook->getLoginUrl(array(
					   'canvas' => 1,
					   'fbconnect' => 0,
					   'req_perms' => 'email,publish_stream,status_update,user_location',
					   'next' => 'http://apps.facebook.com/'.APPNAMESPACE.'/index1.php'	   
				   ));
				
				   
			echo "<script type='text/javascript'>top.location.href = '$url';</script>";	
		} 
		else 
		{			
			try 
			{				
				$me = $facebook->api($user);

				$profile_pic =  "http://graph.facebook.com/".$uid."/picture";
				$email = $me['email'];
				$name = $me['first_name'];
				$lname = $me['last_name'];
				$location = $me['location']['name'];
							
				$fbUserId 		= $me['id'];
				$fbUserName 	= $me['name'];
				$fbUserFname 	= $me['first_name'];
				$fbUserLname 	= $me['last_name'];
				$fbUserGender 	= $me['gender'];
				$fbUserEmail 	= $me['email'];
				//$fbUserUpdateTime 	= $me['updated_time'];
				$date = date('Y-m-d H:i:s');
				
				// Check user already entry.
				$statement  = $database->prepare("SELECT user_id FROM user WHERE fbid = :FBID");
				$statement->execute(array(':FBID' => $fbUserId));
				$check_user = $statement->rowCount();
				
				
				// IF user not exist in database inser its details
				if($check_user == 0)
				{				
					$statement  = $database->prepare("INSERT INTO user (user_id, fbid, email, fname, lname, location, phone_no, address, added_date, access_token, reg_flag)
														VALUES ('', :fbUserId, :fbUserEmail, :fbUserFname, :fbUserLname, '', '', '', :date, '', '')");
					
					$statement->bindParam(":fbUserId",$fbUserId);
					$statement->bindParam(":fbUserEmail",$fbUserEmail);
					$statement->bindParam(":fbUserFname",$fbUserFname);
					$statement->bindParam(":fbUserLname",$fbUserLname);
					$statement->bindParam(":date",$date);
					$statement->execute();					
				}			
				
				// Create Session for the user
				$statement  = $database->prepare("SELECT user_id,fbid FROM user WHERE fbid = :FBID");
				$statement->execute(array(':FBID' => $fbUserId));
				$row = $statement->fetch();
				
				$_SESSION['userId'] = $row['user_id'];
				$_SESSION['fbId'] = $row['fbid'];
				
				
			} 
			catch (FacebookApiException $e) 
			{        

			}
		}
	
	}
 
?>