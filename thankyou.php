<?php
	require_once('config.php');
	include_once('includes/database.class.php');
	include_once('includes/function.class.php');
	include_once('includes/facebook.class.php');
	
	$database = new Database_class();
	$function = new Base_function();	
	
	//get_permission($facebook,$database); 
	
	$uid = $_SESSION['userId'];
	$fbId = $_SESSION['fbId'];
	
	$statement  = $database->prepare("SELECT c_id,c_image FROM canvas WHERE user_id = :UID ORDER BY c_id DESC");
	$statement->execute(array(':UID' => $uid));
	$row = $statement->fetch();
	
	$statement  = $database->prepare("SELECT user_id, fbid, email, fname, lname FROM user WHERE fbid = :FBID");
	$statement->execute(array(':FBID' => $fbId));
	$user = $statement->fetch();
	
	//echo "<pre>";
	//print_r($row['c_image']);
	
	
	if(isset($_POST['downloadimg']) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$img = $function->sanitise_input($_POST['img']);
	
		$img = 'assets/uploads/downloads/'.$img;
		
		$function->output_file($img,'canvas.png','text/plain');
	
	}
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title><?php echo PAGETITLE; ?></title>
<link href="assets/style/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="assets/js/jquery.min.1.7.2.js"></script>
<script type="text/javascript" src="assets/js/sketch.js"></script>
<head>
<body>

<!-- Facebook Include Files -->
<div id="fb-root"></div>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">	
	window.fbAsyncInit = function () {
		FB.init({
			appId: '<?php echo APPID; ?>',
			oauth: true,
			status: true,
			cookie: true,
			channelUrl: '<?php echo APPURL; ?>',
			xfbml: true
		});
		FB.Canvas.setSize({
			width: 810,
			height: 850
		});
	};
	(function () {
		var e = document.createElement('script');
		e.async = true;
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		document.getElementById('fb-root').appendChild(e);
	}());

	function sizeChangeCallback() {
		FB.Canvas.setSize({
			width: 810,
			height: 850
		});
	}

	function share()
	{ 
	FB.ui(
				   {
					 method: 'feed',
					 name: '<?php echo PAGETITLE; ?>',
					 link: 'https://apps.facebook.com/<?php echo APPNAMESPACE; ?>',
					 picture: '<?php echo ASSETS.'/uploads/'.$row['c_image']; ?>',
					 caption: ' ',
					 description: 'This is what represents freedom to me! You too can draw anything that represents freedom to you & win a brand new Canvas Doodle 2!',
					 message: '',
					

				   }
		);
	}

	function fbinvite()
	{
		FB.ui(
				{
					method: 'apprequests', 
					message: 'Hi, <?php echo $user['fname'].' '.$user['lname'];?>, Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
				}
			);
	}	
	
	
	// function download_img()
	// {
	
		
	
		// $.ajax({
			// type: "POST",
			// url: "download.php",
			// beforeSend : function(){
				// $('#ajax').html('<img src="assets/img/ajax_loader.gif" />');
			// },
			// data: "imgid=<?php echo $row['c_image']; ?>",		
			// success: function(res) {	
						//alert(res);
						//document.location = 'assets/img/ajax_loader.gif';
				//$('#ajax_'+imgid).html(res);
				
				// console.log(res);
				
			// }
		// });
	// } 
</script>

<!-- //END Facebook Include Files -->
<!--<div>
	<a href="javascript:void(0)" onClick="share()">Share</a>
	<a href="javascript:void(0)" onClick="download_img()">Download</a>
	<a href="gallery.php">Gallery</a>
	<form method="post" action="" name="form" id="form">
            <button type="button" name="submit" onclick="$('#form').submit()">Download</button> 
		<input type="hidden" name="img" value="<?php //echo $row['c_image']; ?>" />
		<input type="submit" name="downloadimg" value="Download" />
	</form> 
</div>
<div>
	<a href="">
		<img src="<?php echo ASSETS; ?>img/thankyou.jpg" height="" weight="">
	</a>
</div>-->
<div class="container">
    <?php include("logo.php"); ?>
    <div class="main">
        <div class="thank_you_left">
            <div class="overlay_frame">
			
			<img class="downloadImg" height="508" width="412" src="<?php echo ASSETS; ?>uploads/<?php echo $row['c_image']; ?> " />
                    
            </div>
            <img src="assets/img/shadow.png" width="428"/>
        </div>
        <div class="thank_you_right">
            <div class="thank_you_doodle"><img src="assets/img/thank_you_doodle.png"/></div>
            <div class="btn_share"><a href="javascript:void(0)" onClick="share()"><img src="assets/img/btn_share.png"/></a></div>
            <div class="download_form">
           <!-- <a class="bt_download" href="#" onClick="downloadImg()"><img src="assets/img/btn_download.png"/></a> -->
            <form method="post" action="" name="form" id="form">
				<input type="hidden" name="img" value="<?php echo $row['c_image']; ?>" />
				<input type="submit" name="downloadimg" value="" class="btn_download" />
            </form>
            
            </div>
            <div class="btn_gallery"><a href="gallery.php"><img src="assets/img/btn_gallery.png"/></a></div>
            <div class="btn_canvas"><a href="home.php"><img src="assets/img/drawing.png"/></a></div>
        </div>
    </div>
    <?php include("foot.php"); ?>
</div>
</body>
</html>