var canvas = document.getElementById('canvas');
var ctx = canvas.getContext("2d");

girl = new Image();
girl.src = "image/girl.jpg";
girl.onload = function(){
	ctx.drawImage(girl, 10, 10);
}
