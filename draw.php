<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Micromax Doodle</title>
<link href="assets/style/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/custom.css" /><!--
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
<!--[if IE]><script type="text/javascript" src="assets/js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="js/jquery.1.8.2.min.js"></script>
<!--<script type="text/javascript" src="assets/js/jquery.min.js"></script> -->
    <script src="js/jquery-ui.1.10.3.js"></script>
<!--<script type="text/javascript" src="assets/js/jquery-ui-1.10.3.custom.min.js"></script> -->
<script type="text/javascript" src="js/kinetic-v4.6.0.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.panzoom.js"></script>
<script type="text/javascript" src="assets/js/sketch.js"></script> 
<script src="js/modernizr.custom.17475.js"></script>
 <style>
/*#draggable { width: 16em; padding: 0 1em; }
#draggable ul li { margin: 1em 0; padding: 0.5em 0; } * html #draggable ul li { height: 1%; }
#draggable ul li span.ui-icon { float: left; }
#draggable ul li span.count { font-weight: bold; }
.ui-state-default.ui-corner-all {
    background: none repeat scroll 0 0 #FFFFFF;
}.ui-widget.ui-widget-content {
    background-color: #FFFFFF;
    left: 0;
    position: absolute;
    top: 0;
    width: 400px;
    z-index: 1;
}*/
</style>
 <script>
 $(window).load(function() {
 // bind event handler to clear button
	var canvas = document.getElementById("paint");
	var context2 = canvas.getContext('2d');
	
      document.getElementById("reset2").addEventListener('click', function() {
        context2.clearRect(0, 0, canvas.width, canvas.height);
		callajax();
		//alert('hi');
      }, false);
	//
	  //images_drag();
 });
$(function() {

	$("#paint").droppable({
	drop: function( event, ui ) {
	//$( this )
	ui.helper.data('dropped', true);
	tolerance: 'fit'
	}
	});
	
	var $start_counter = $( "#event-start" ),
	$drag_counter = $( "#event-drag" ),
	$stop_counter = $( "#event-stop" ),
	counts = [ 0, 0, 0 ];
	$( ".draggable" ).draggable(
	{ revert: "invalid" },
	{
	start: function(event, ui) {
	ui.helper.data('dropped', false);
			$('.elastislide-carousel').css('height','691px');
			$('.elastislide-wrapper').css('z-index','7777777');
	
	counts[ 0 ]++;
	//updateCounterStatus( $start_counter, counts[ 0 ] );
	},
	drag: function(event, ui) {
	counts[ 1 ]++;
	var first = counts[ 1 ]++;
	//updateCounterStatus( $drag_counter,first );
	},
	stop: function(event, ui) {
			$('.elastislide-wrapper').css('z-index','55555');
	//$(this).draggable('option','revert','invalid');
	
	//alert(dx +'-' +dy);
	
		//alert('stop: dropped=' + ui.helper.data('dropped'));
	
			if(ui.helper.data('dropped') == true){
				$(this).css('opacity','0','visibility','hidden');
				var paint_left = $("#paint").offset().left;
				var paint_top = $("#paint").offset().top;
				
				var dx = ($(this).offset().left) - paint_left;
				var dy = ($(this).offset().top) - paint_top;
				var first = counts[ 1 ]++;
				var second = counts[ 2 ]++;
				var image = new Image();
				image.src = $(this).attr("src");
				
				//alert(image.src);
		
					ctx.drawImage(image, dx, dy); 
					//alert(image.src);
					
				
				  //alert(imageObj.src);
				  /*var layer = new Kinetic.Layer();
			
				  var box = new Kinetic.Rect({
					x: 100,
					y: 40,
					width: 100,
					height: 50,
					fill: '#00D2FF',
					stroke: 'black',
					strokeWidth: 4,
					draggable: true
				  });
				  // add cursor styling
				  image.on('mouseover', function() {
					document.body.style.cursor = 'pointer';
				  });
				  image.on('mouseout', function() {
					document.body.style.cursor = 'default';
				  });*/
				  
					callajax();
					//alert(first +'-' +second);
					//cPush();
						//$('.elastislide-carousel').css('height','auto');
						//
						//images_drag()
						//callajax()
						//$('#carousel').elastislide();
			
		counts[ 2 ]++;
						}

	else{

}
//updateCounterStatus( $stop_counter, second );
}
});
});
	function images_drag(){
		
	$(function() {
	
	$("#paint").droppable({
	drop: function( event, ui ) {
	//$( this )
	ui.helper.data('dropped', true);
	tolerance: 'fit'
	}
	});
	
	var $start_counter = $( "#event-start" ),
	$drag_counter = $( "#event-drag" ),
	$stop_counter = $( "#event-stop" ),
	counts = [ 0, 0, 0 ];
	
	$('.elastislide-carousel').css('height','auto');
	$( ".draggable" ).draggable(
	{ revert: "invalid" },
		{
		start: function(event, ui) {
			ui.helper.data('dropped', false);
			$('.elastislide-carousel').css('height','691px');
			$('.elastislide-wrapper').css('z-index','7777777');
			
			counts[ 0 ]++;
			//updateCounterStatus( $start_counter, counts[ 0 ] );
			},
			drag: function(event, ui) {
			counts[ 1 ]++;
			var first = counts[ 1 ]++;
			//updateCounterStatus( $drag_counter,first );
			},
			stop: function(event, ui) {
				
			$('.elastislide-wrapper').css('z-index','55555');
			//$(this).draggable('option','revert','invalid');
			
			//alert(dx +'-' +dy);
	
			//alert('stop: dropped=' + ui.helper.data('dropped'));
		
				if(ui.helper.data('dropped') == true){
					$(this).css('opacity','0','visibility','hidden');
					var paint_left = $("#paint").offset().left;
					var paint_top = $("#paint").offset().top;
					
					var dx = ($(this).offset().left) - paint_left;
					var dy = ($(this).offset().top) - paint_top;
					var first = counts[ 1 ]++;
					var second = counts[ 2 ]++;
					var image = new Image();
					image.src = $(this).attr("src");
					//alert(image.src);
	
					ctx.drawImage(image, dx, dy);
					//alert(first +'-' +second);
					//cPush();
						//$('.elastislide-carousel').css('height','auto');
						//
						//images_drag()
						callajax()
						//$('#carousel').elastislide();
						counts[ 2 ]++;
					}
	
		else{
	
	}
	//updateCounterStatus( $stop_counter, second );
	}
	});
	
	});
}
//fetch all slider images
function callajax(){
  $.ajax({
		type: "POST",
		url:"slider_img.php",
		//data: "frnd_id=",
		success: function(data) {
		$('.elastislide-wrapper').remove();
		$('.main').append(data);
		//$('.elastislide-carousel').append(data);
		 $('#carousel').elastislide();
		 
	 	 images_drag();
		}
			
		});
}
</script>
</head>

<body onLoad="InitThis()">
<div id="dr aggable" class="ui-widget ui-widget-content">
<ul class="ui-helper-reset" style="display:none;">
<p>Drag me to trigger the chain of events.</p>
<li id="event-start" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-play"></span>"start" invoked <span class="count">0</span>x</li>
<li id="event-drag" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-arrow-4"></span>"drag" invoked <span class="count">0</span>x</li>
<li id="event-stop" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-stop"></span>"stop" invoked <span class="count">0</span>x</li>
</ul>
</div>
	<div class="container">
        <div class="logo">
            <div></div>
            <div class="logor"></div>
        </div>        
        <div class="main">
        <!-- Elastislide Carousel -->
				<ul id="carousel" class="elastislide-list">
					<li><a href="#"><img src="images/small/2.jpg" alt="image02" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/3.jpg" alt="image03" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/4.jpg" alt="image04" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/5.jpg" alt="image05" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/6.jpg" alt="image06" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/7.jpg" alt="image07" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/8.jpg" alt="image08" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/9.jpg" alt="image09" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/10.jpg" alt="image10" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/11.jpg" alt="image11" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/12.jpg" alt="image12" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/13.jpg" alt="image13" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/14.jpg" alt="image14" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/15.jpg" alt="image15" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/16.jpg" alt="image16" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/17.jpg" alt="image17" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/18.jpg" alt="image18" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/19.jpg" alt="image19" class="draggable" /></a></li>
					<li><a href="#"><img src="images/small/20.jpg" alt="image20" class="draggable" /></a></li>
				</ul>
				<!-- End Elastislide Carousel -->
            <div class="left">
                <figure></figure>
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
                    <div><input type="button" id="reset2" value="Clear"></div>
                </div>
                <br />
                <span class="line" style="width:100px;margin-left:70px;"></span>
            </div>
            <div class="right" id="right">
            	<div class="overlay">
	                <canvas id="paint" width="412" height="508" draggable="true"></canvas>
                </div>
                <img src="assets/img/shadow.png" />
                <div class="pan">
                	<img class="up" src="assets/img/up.png" />
                    <img class="left1" style="display:inline-block;" src="assets/img/left.png" />
                    <img class="right1" style="display:inline-block;" src="assets/img/right.png" />
                    <img class="down" src="assets/img/down.png" />
                </div>
                <a href="gallery.php" class="gallery"><img src="assets/img/gallery.png" /></a>
                <a href="#" class="submit"><img src="assets/img/submit.png" /></a>
                <div class="downloadLayer" style="display:none;"></div>
            </div>
        </div>
        <div class="foot">
        </div>
     </div>
     <div class="terms">
        <a href="#">Terms & Conditions</a> | <a href="#">Privacy policy</a>
    </div>
	<script type="text/javascript" src="js/jquery.elastislide.js"></script>
	<script type="text/javascript">
        $( '#carousel' ).elastislide();
    </script>
</body>
</html>
