$(function() {
    $("canvas").each(function () {
		var ctx=this.getContext("2d");
		var img=$("#"+$(this).data('image-id'))[0];
		var size_x = $(this).data('clip-size')/100*img.naturalWidth;
		var size_y = size_x /2;
		var x = Math.max($(this).data('clip-x')/100*img.naturalWidth-size_x/2,0);
		var y = Math.max($(this).data('clip-y')/100*img.naturalHeight-size_y/2,0);
		ctx.drawImage(img,x,y,size_x,size_y,0,0,300,150);
	});
	
});
