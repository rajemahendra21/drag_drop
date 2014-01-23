var mousePressed = false;
var lastX, lastY;
var ctx;
var z = 1;
var iz = 1;

function setScale(a) {
	//if(a == true && z >= 1) { z += 0.3; $(".pan").show(); } else { z -+ 0.3; }
	$(".pan").show(); 
	if(a == true && z >= 1) { z += 0.3;	}
	else if(a == false && z >= 1.3)	{ z -= 0.3;	}
	else { z == 1; }
}

function setCursor() {
	
}

function InitThis() {
	
	//document.body.style.cursor = 'url(assets/img/pencil.gif), auto';
	$(".overlay").append('<img src="assets/img/pencil.gif" class="pencilCursor" style="position:absolute;" />');
	
	
	$("#paint").panzoom({
		disablePan: true,
		increment: 0.3,
		minScale: 1,
		maxScale: 5,
		onZoom: function(){ var iz = 1/z; },
		$zoomIn: $(".zoom"),
		$zoomOut: $(".unzoom"),
		$reset: $("#reset")
	});
	
	$("#stroke_cursor").click(function() {
		document.body.style.cursor = 'url(assets/img/pencil.gif), auto';
		//$(".overlay").css("cursor", "url(../img/pencil.gif)");
		
	});
	
	$("#eraser_cursor").bind('mousedown', function(){
		document.body.style.cursor = 'url(assets/img/eraser.gif), auto';
	});
	
	$(".unzoom").click(function() {
		if(z == 1) {
		$(".pan").hide(); 

		}
	});
	
	$(".up").click(function() {
		if(z > 1) {
			$("#paint").panzoom("pan", 0, -10, { relative: true, matrix: false });
		}
	});
	$(".down").click(function() {
		if(z > 1) {
			$("#paint").panzoom("pan", 0, 10, { relative: true, matrix: false });
		}
	});
	
	$(".left1").click(function() {
		//alert('left');
		if(z > 1) {
			$("#paint").panzoom("pan", -10, 0, { relative: true, matrix: false });
		}
		
	});
	$(".right1").click(function() {
		//alert('right');
		if(z > 1) {
			$("#paint").panzoom("pan", 10, 0, { relative: true, matrix: false });
		}
	});
	$("#reset").click(function() {
		//alert('right');
		//if(z < 1) {
			$("#paint").panzoom("pan", 0, 0, { relative: true, matrix: false });
		//}
	});
	
	$( "#slider" ).slider({
		min: 2,
        max: 12,
        value: 4,
		change: function(event, ui) { 
			ctx.lineWidth = ui.value; 
		} 		
	});
	
    ctx = document.getElementById('paint').getContext("2d");
	
	ctx.lineWidth = 4; 
	
    $('#paint').mousedown(function (e) {
        mousePressed = true;
		console.log(z);
		
		//document.body.style.cursor = 'url(assets/img/pencil.png) 1 520 ,auto';
        //Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
		Draw((e.pageX - $(this).offset().left)/z, (e.pageY - $(this).offset().top)/z, false);
		//alert(e.pageX+' '+$(this).offset().left+' '+e.pageY+' '+$(this).offset().top);
    });

    $('#paint').mousemove(function (e) {
		//$(".pencilCursor").css({left:(e.pageX - $(this).offset().left)/z-32+"px", top:(e.pageY - $(this).offset().top)/z+"px" });
        if (mousePressed) {
            Draw((e.pageX - $(this).offset().left)/z, (e.pageY - $(this).offset().top)/z, true);
        }
    });

    $('#paint').mouseup(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush();
        }
    });

    $('#paint').mouseleave(function (e) {
        if (mousePressed) {
            mousePressed = false;
            cPush();
        }
    });
	
	$(".submit").click(function() {
		//var paint_left = $("#paint").offset().left;
		//var paint_top = $("#paint").offset().top;
		
				//var dx = ($(this).offset().left) - paint_left;
				//var dy = ($(this).offset().top) - paint_top;
				//var first = counts[ 1 ]++;
				//var second = counts[ 2 ]++;
				//var image = new Image();
				//image.src = $('.overlay_game img:first').attr("src");
				
				//alert(image.src);
		
					//ctx.drawImage(image, dx, dy); 
					//alert(image.src);
					
		$(this).css("opacity", "0.25").unbind("click");
		
		$(".downloadLayer").append('<canvas id="downloadCanvas" height="450" width="460" />');

		var logo = new Image();
		var clogo = new Image();
		var bottom = new Image();
	
		logo.src = 'assets/img/logo.png';
		clogo.src = 'assets/img/canvas.png';
		bottom.src = 'assets/img/bigger.png';
		
		var cty = document.getElementById('downloadCanvas').getContext("2d");
		var ctz = document.getElementById('paint');
		
		cty.drawImage(ctz, 24, 61);
		$(logo).load(function () {
			cty.drawImage(logo, 10, 11);
			$(clogo).load(function () {
				cty.drawImage(clogo, 189, 10);
				$(bottom).load(function () {
					cty.drawImage(bottom, 178, 575);
					// var mainImage = document.getElementById('paint').toDataURL("image/png").replace("image/png", "image/octet-stream");
					// var logoImage = document.getElementById('downloadCanvas').toDataURL("image/png").replace("image/png", "image/octet-stream");
					var mainImage = document.getElementById('paint').toDataURL("image/png");
					var logoImage = document.getElementById('downloadCanvas').toDataURL("image/png");
					
					//alert(logoImage);
					
					$.ajax({
					  type: "POST",
					  url: "script.php",
					  data: { 
						 //imgBase64: document.getElementById('paint').toDataURL("image/png")
						 imgBase64: mainImage,
						 img2Base64: logoImage
					  }
					 //data:'imgBase64 ='+ mainImage + '&img2Base64 ='+ logoImage
					}).done(function(o) {
						//console.log('saved');
						//window.location.replace("thankyou.php");
						$('.downloadLayer').show();
					});
				});
			});
		});
	});
	
    drawImage();
	
}

function drawImage() {
var image = new Image();
image.src = 'assets/img/initial.jpg';
//var image = new Image();
//imageObj.src = $(this).attr("src");
// darth vader
var image2 = new Kinetic.Image({
//image: image.src,
//x: stage.getWidth() / 2 - 200 / 2,
// y: stage.getHeight() / 2 - 137 / 2,
width: 200,
height: 137,
draggable: true
});
$(image).load(function () {
ctx.drawImage(image, 0, 0);
cPush();
});
} 

/*function drawImage() {
    var image = new Image();
    image.src = 'assets/img/initial.jpg';
    $(image).load(function () {
        ctx.drawImage(image, 0, 0);
        cPush();
    });    
}*/
function zoom() {
	ctx.scale(2, 2);
}
function unzoom() {
	ctx.scale(0.5, 0.5);
}

//function preset() {
	//$(".preset").show();
	
	
	$("#carousel li img").live('click',function() {
		document.body.style.cursor = 'default';
		var image = new Image();
		image.src = $(this).attr("src");
		
		$(image).load(function () {
			$(".preset").hide();
			$(".right .overlay").append('<img class="pasteImg" style="position:absolute;" src="'+image.src+'" />');
			var dx;
			var dy;
			var valX;
			var valY;
			$(".overlay").mousemove(function(e) {
				dx = $("#paint").offset().left;
				dy = $("#paint").offset().top;
				valX = e.pageX - dx - 200;
				valY = e.pageY - dy - 200;
				$(".pasteImg").css({ left : valX+"px", top: valY+"px" });
				$(".pasteImg").css({ cursor : "move" });
        		ctx.drawImage(image, e.pageX, e.pageY);
			});
			/*$(".overlay").click(function(e) {
				ctx.drawImage(image, valX, valY);
				cPush();
				$(".pasteImg").remove();
				$(this).unbind('click');
				$("#carousel li img").unbind('click');
			});*/
			//ctx.drawImage(image, 50, 50);
			//cPush();
		});
	});
//}

function Draw(x, y, isDown) {
    if (isDown) {
        ctx.beginPath();
        ctx.lineJoin = "round";
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.closePath();
        ctx.stroke();
    }
    lastX = x;
    lastY = y;
}

var cPushArray = new Array();
var cStep = -1;

function cPush() {
    cStep++;
    if (cStep < cPushArray.length) { cPushArray.length = cStep; }
    cPushArray.push(document.getElementById('paint').toDataURL("image/png"));
    document.title = cStep + ":" + cPushArray.length;
}

function cUndo() {
    if (cStep > 0) {
        cStep--;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
        document.title = cStep + ":" + cPushArray.length;
	$('.overlay_game').empty();
	callajax();
	setTimeout(function(){$('.overlay_game').show();},1);
	document.body.style.cursor = 'default';
    }
}

function cRedo() {
    if (cStep < cPushArray.length-1) {
        cStep++;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
        document.title = cStep + ":" + cPushArray.length;
		setTimeout(function(){$('.overlay_game').show();},1);
    }
}

function downloadImg() {
	
	
   
}
//$('#reset').click(function(){
//	ctx.clearRect(0, 0, canvas.width, canvas.height);
//	ctx.restore();
	//canvas.width = canvas.width;
//});
function drawImage_move(imageObj_move) { 
        var stage = new Kinetic.Stage({
          container: "paint",
          width: 578,
          height: 200
        });
        var layer = new Kinetic.Layer();

        // darth vader
        var darthVaderImg = new Kinetic.Image({
          image: imageObj_move,
          x: 100,
          y: 30,
          width: 200,
          height: 137,
          draggable: true
        });

        // add cursor styling
       /* darthVaderImg.on('mouseover', function() {
          document.body.style.cursor = 'pointer';
        });
        darthVaderImg.on('mouseout', function() {
          document.body.style.cursor = 'default';
        });*/

        layer.add(darthVaderImg);
        stage.add(layer);
      }
      var imageObj_move = new Image();
      imageObj_move.onload = function() {
        drawImage_move(this);
      };
      imageObj_move.src = 'http://www.html5canvastutorials.com/demos/assets/darth-vader.jpg';
	  
$(function(){
	//$('#reset3').click(function(){
		
	//});
	$('.controls').click(function(){
		$('.elastislide-wrapper').css('z-index','55555');
		$('.overlay_game').empty();
		$('.overlay_game').hide();
	});
});