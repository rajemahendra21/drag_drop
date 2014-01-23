<?php
	require_once('config.php');
	include_once('includes/database.class.php');
	include_once('includes/function.class.php');
	include_once('includes/facebook.class.php');
	
	$database = new Database_class();
	$function = new Base_function();	
	
	get_permission($facebook,$database); 
	
	$uid = $_SESSION['userId'];
	$fbId = $_SESSION['fbId'];
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Micromax Doodle</title>
<link href="assets/style/style.css" rel="stylesheet" type="text/css">
<!--[if IE]><script type="text/javascript" src="assets/js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.panzoom.js"></script>
<script type="text/javascript" src="assets/js/sketch.js"></script>

</head>

<body onLoad="InitThis()">

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
	
		
	

</script>

<!-- //END Facebook Include Files -->
	<div class="container">
        <div class="logo">
            <div>
                <img src="assets/img/logo.png" />
            </div>
            <div class="logor">
                <img src="assets/img/canvas.png" />
            </div>
        </div>
        <div class="preset">
            <div class="container">
            	<img src="assets/img/presets.png" class="presetbanner" /><br />
                <img src="assets/img/doodle1.png" class="galimg" />
                <img src="assets/img/doodle2.png" class="galimg" />
                <img src="assets/img/doodle3.png" class="galimg" /><br />
                <img src="assets/img/doodle4.png" class="galimg" />
                <img src="assets/img/doodle5.png" class="galimg" />
                <img src="assets/img/doodle6.png" class="galimg" /><br />
                <img src="assets/img/doodle7.png" class="galimg" />
                <img src="assets/img/doodle8.png" class="galimg" />
                <img src="assets/img/doodle9.png" class="galimg" />
            </div>
        </div>
        <div class="main">
            <div class="left">
                <figure>
                    <img src="assets/img/info.png" />
                </figure>
                <div class="controls">
                	<a href="#" onClick="javascript:ctx.strokeStyle='black';return false;" id="stroke_cursor"><img src="assets/img/pencil.png" /></a>
                    <a href="#" onClick="javascript:ctx.strokeStyle='white';return false;" id="eraser_cursor"><img src="assets/img/eraser.png" /></a>
                    <img src="assets/img/size.png" style="display:inline-block;" />
                    <div id="slider" style="display:inline-block;"></div>
                    <span class="line" style="margin-bottom:10px;"></span>
                    <a href="#" onClick="javascript:cUndo();return false;"><img src="assets/img/undo.png" /></a>
                    <a href="#" onClick="javascript:cRedo();return false;"><img src="assets/img/redo.png" /></a>
                    <a href="#" class="zoom" onClick="javascript:setScale(true);return false;"><img src="assets/img/zoom.png" /></a>
                    <a href="#" class="unzoom" onClick="javascript:setScale(false);return false;"><img src="assets/img/unzoom.png" /></a>
                    <span class="line" style="margin-bottom:40px;"></span>
                </div>
                <br />
                <a href="#" class="presetbutton" onClick="javascript:preset();return false;"><img src="assets/img/presets.png" /></a>
                <span class="line" style="width:100px;margin-left:70px;"></span>
            </div>
            <div class="right" id="right">
            	<div class="overlay">
	                <canvas id="paint" width="412" height="508"></canvas>
                </div>
                <img src="assets/img/shadow.png" />
                <div class="pan">
                	<img class="up" src="assets/img/up.png" />
                    <img class="left" style="display:inline-block;" src="assets/img/left.png" />
                    <img class="right" style="display:inline-block;" src="assets/img/right.png" />
                    <img class="down" src="assets/img/down.png" />
                </div>
                <a href="gallery.php" class="gallery"><img src="assets/img/gallery.png" /></a>
                <a href="#" class="submit"><img src="assets/img/submit.png" /></a>
            </div>
        </div>
        <div class="foot">
        </div>
     </div>
     <div class="terms">
        <a href="#">Terms & Conditions</a> | <a href="#">Privacy policy</a>
    </div>
</body>
</html>
