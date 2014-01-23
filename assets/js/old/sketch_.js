var c;

$(function () {

	c = TeledrawCanvas('paint', {
		fullWidth: 1024,
		fullHeight: 1024
	});
	
	var grid = createGrid(1024, 512),
		previewgrid =createGrid(1024, 512, 0.25);
		
	c.on('display.update:after', function () {
		// draw gridlines
		var scanv = this.canvas();
		var off = this.state.currentOffset;
		var zoom = this.state.currentZoom;
		var dctx = $('#paint').get(0).getContext('2d');
		if (grid) {
			var dw = dctx.canvas.width,
				dh = dctx.canvas.height,
				sw = dw / zoom,
				sh = dh / zoom;
			dctx.save();
			dctx.globalAlpha = 0.5;
			dctx.drawImage(grid, off.x, off.y, sw, sh, 0, 0, dw, dh);
			dctx.restore();
		}
	});
	
	c.on('zoom', function (newZoom) {
		grid = createGrid(1024, 512, newZoom);
	});
	var previewctx = $('#paint-preview').get(0).getContext('2d'),
		tmppreview = $('#paint-preview').clone().get(0)
		tmppreviewctx = tmppreview.getContext('2d');
		
	c.on('zoom pan resize clear', _.throttle(redrawPreview, 30));
	c.on('mousemove mouseup', _.throttle(redrawPreview, 150));
	
	c.zoom(0);
	
	function createGrid(fullSize, tileSize, zoom) {
		var grid = $('<canvas>').attr({width: fullSize, height: fullSize}).get(0);
		var ctx = grid.getContext('2d');
		var t = fullSize/tileSize;
		if (t > 1) {
			ctx.lineWidth = 2/zoom;
			ctx.strokeStyle="#aaa";
			for (var i = 1; i < t; ++i) {
				ctx.moveTo(i*tileSize, 0);
				ctx.lineTo(i*tileSize, fullSize);
				ctx.moveTo(0, i*tileSize);
				ctx.lineTo(fullSize, i*tileSize);
				ctx.stroke();
			}
			return grid;
		}
		return null;
	}
	
	function redrawPreview() {
		var off = this.state.currentOffset,
			zoom = this.state.currentZoom,
			wm = previewctx.canvas.width/this._canvas.width,
			hm = previewctx.canvas.height/this._canvas.height,
			x = off.x*wm,
			y = off.y*hm,
			w = this._displayCanvas.width/zoom*wm,
			h = this._displayCanvas.height/zoom*hm;
		previewctx.clearRect(0,0,previewctx.canvas.width, previewctx.canvas.height);
		previewctx.drawImage(this.canvas(), 0, 0, previewctx.canvas.width, previewctx.canvas.height);
		tmppreviewctx.clearRect(0,0,previewctx.canvas.width, previewctx.canvas.height);
		tmppreviewctx.fillStyle = 'black';
		tmppreviewctx.globalAlpha = 0.5;
		tmppreviewctx.fillRect(0,0,previewctx.canvas.width, previewctx.canvas.height);
		tmppreviewctx.clearRect(x, y, w, h);
		previewctx.drawImage(tmppreview, 0, 0);
		if (grid) {
			previewctx.save();
			previewctx.globalAlpha = 0.5;
			previewctx.drawImage(previewgrid, 0, 0, previewctx.canvas.width, previewctx.canvas.height);
			previewctx.restore();
		}
	}
	
	$('#paint').bind('mousewheel', function (e, d, dx, dy) {
		c.pan(-dx*10, dy*10);
		e.preventDefault();
	});
	
	$('#paint-preview').bind('mousedown touchstart', function (event) {
		var element = $(this);
		var offset = element.offset();
		var display = $('#paint')[0];
		var canvas = c.canvas();
		function getCoord(e) {
			var pageX = e.pageX || e.originalEvent.touches && e.originalEvent.touches[0].pageX,
				pageY = e.pageY || e.originalEvent.touches && e.originalEvent.touches[0].pageY;
			return {x: pageX - offset.left, y: pageY - offset.top };
		}
		function move(e) {
			var pt = getCoord(e);
			c.pan(
				(pt.x*canvas.width/element.get(0).width)*c.state.currentZoom - display.width/2,
				(pt.y*canvas.height/element.get(0).height)*c.state.currentZoom - display.height/2,
				true);
			e.preventDefault();
		}
		move(event);
		$(window).bind('mousemove touchmove', move);
		$(window).one('mouseup touchend', function () {
			$(window).unbind('mousemove touchmove', move);
		});
		event.preventDefault();
	});
	
});

function preset() {
	$(".preset").show();
	$(".preset figure").click(function() {
		image = new Image();
		image.src = $(this).find("img").attr("src");
		image.onload = function() {
			var dctx = $('#paint').get(0).getContext('2d');
			dctx.drawImage(image, 100, 100);
			dctx.restore();
		}
	});
}