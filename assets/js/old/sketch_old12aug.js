var mousePressed = false;
var lastX, lastY;
var ctx;
var z = 1;
var iz = 1;

function setScale(a) {
	if(a == true && z >= 1) { z += 0.3; $(".pan").show(); } else { z -+ 0.3; }
}

function setCursor() {
	
}

function InitThis() {
	
	$("#paint").panzoom({
		disablePan: true,
		minScale: 1,
		maxScale: 5,
		onZoom: function(){ var iz = 1/z; },
		$zoomIn: $(".zoom"),
		$zoomOut: $(".unzoom"),
	});
	$("#stroke_cursor").bind('mousedown', function(){
		document.body.style.cursor = 'url(assets/img/pencil.png) 1 520 ,auto';
	});
	$("#eraser_cursor").bind('mousedown', function(){
		document.body.style.cursor = 'url(assets/img/eraser.png) 1 520 ,auto';
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
	$(".left").click(function() {
		if(z > 1) {
			$("#paint").panzoom("pan", -10, 0, { relative: true, matrix: false });
		}
	});
	$(".right").click(function() {
		if(z < 1) {
			$("#paint").panzoom("pan", 10, 0, { relative: true, matrix: false });
		}
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
        Draw(e.pageX - $(this).offset().left, e.pageY - $(this).offset().top, false);
		//alert(e.pageX+' '+$(this).offset().left+' '+e.pageY+' '+$(this).offset().top);
    });

    $('#paint').mousemove(function (e) {
        if (mousePressed) {
            Draw((e.pageX - $(this).offset().left)*iz, (e.pageY - $(this).offset().top)*iz, true);
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
		$.ajax({
		  type: "POST",
		  url: "script.php",
		  data: { 
			 imgBase64: document.getElementById('paint').toDataURL("image/png")
		  }
		}).done(function(o) {
			window.location.replace("thankyou.php");
		  	console.log('saved');
		});
	});
	
    drawImage();
}

function drawImage() {
    var image = new Image();
    image.src = 'assets/img/initial.jpg';
    $(image).load(function () {
        ctx.drawImage(image, 0, 0);
        cPush();
    });    
}

function zoom() {
	ctx.scale(2, 2);
}
function unzoom() {
	ctx.scale(0.5, 0.5);
}

function preset() {
	$(".preset").show();
	$(".preset .galimg").click(function() {
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
        		//ctx.drawImage(image, e.pageX, e.pageY);
			});
			$(".overlay").click(function(e) {
				ctx.drawImage(image, valX, valY);
				cPush();
				$(".pasteImg").remove();
				$(this).unbind('click');
				$(".preset .galimg").unbind('click');
			});
			//ctx.drawImage(image, 50, 50);
			//cPush();
		});
	});
}

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
    }
}
function cRedo() {
    if (cStep < cPushArray.length-1) {
        cStep++;
        var canvasPic = new Image();
        canvasPic.src = cPushArray[cStep];
        canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
        document.title = cStep + ":" + cPushArray.length;
    }
}