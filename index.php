<?php
include 'config.php';
function is_image($path) {
	$a = getimagesize($path);
	$image_type = $a[2];

	if (in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG , IMAGETYPE_PNG , IMAGETYPE_BMP))) {
		return true;
	}
	return false;
}


if (isset($_POST["i"]) && !empty($_POST["i"])) {
	$uri=$_POST["i"];
	//create data uri from post
	$uriPhp = 'data://' . substr($uri, 5);
	//get the binary image data
	$binary = file_get_contents($uriPhp);
	//create name for the img, md5 works well
	$n=md5($uri).".png";
	file_put_contents("i/".$n, $binary);
	if (!is_image("i/".$n)) { die("Not an image!"); unlink($n); }
	//redirect to retrick to show more options
	header("Location: retrick.php?r=$n");
	die();

}

?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">

	body{
		    height: 100vh;

	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b5bdc8+0,828c95+36,28343b+100;Grey+Black+3D */
background: #b5bdc8; /* Old browsers */
background: -moz-radial-gradient(center, ellipse cover, #b5bdc8 0%, #828c95 36%, #28343b 100%); /* FF3.6-15 */
background: -webkit-radial-gradient(center, ellipse cover, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* Chrome10-25,Safari5.1-6 */
background: radial-gradient(ellipse at center, #b5bdc8 0%,#828c95 36%,#28343b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b5bdc8', endColorstr='#28343b',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
		color:white;

	}
	p{
				position: relative;
				text-align: center;
top: 50%;
transform: translateY(-50%);

 -webkit-text-stroke: 1px black;
   color: white;
  font-weight: bolder;
   text-shadow:

     -1px -1px 0 #000,
      1px -1px 0 #000,
      -1px 1px 0 #000,
       1px 1px 0 #000;

       font-family: sans-serif;
       font-size: 20pt;
	}
</style>
<title></title>
</head>
<body>
<p id="t"><?php echo $_imup["fronttext"]; ?></p>
<br /><br />
<canvas id="my_canvas" width="300" height="300" style="display:none;"></canvas>


<script type="text/javascript">
	var CLIPBOARD = new CLIPBOARD_CLASS("my_canvas", true);

/**
 * image pasting into canvas
 *
 * @param {string} canvas_id - canvas id
 * @param {boolean} autoresize - if canvas will be resized
 */
function CLIPBOARD_CLASS(canvas_id, autoresize) {
	var _self = this;
	var canvas = document.getElementById(canvas_id);
	var ctx = document.getElementById(canvas_id).getContext("2d");

	//handlers
	document.addEventListener('paste', function (e) { _self.paste_auto(e); }, false);

	//on paste
	this.paste_auto = function (e) {
		if (e.clipboardData) {
			var items = e.clipboardData.items;
			if (!items) return;

			//access data directly
			for (var i = 0; i < items.length; i++) {
				if (items[i].type.indexOf("image") !== -1) {
					//image
					var blob = items[i].getAsFile();
					var URLObj = window.URL || window.webkitURL;
					var source = URLObj.createObjectURL(blob);
					this.paste_createImage(source);
				}
			}
			e.preventDefault();
		}
	};
	//draw pasted image to canvas
	this.paste_createImage = function (source) {
		var pastedImage = new Image();
		pastedImage.onload = function () {
			if(autoresize == true){
				//resize
				canvas.width = pastedImage.width;
				canvas.height = pastedImage.height;
			}
			else{
				//clear canvas
				ctx.clearRect(0, 0, canvas.width, canvas.height);
			}
			ctx.drawImage(pastedImage, 0, 0);
		};
		pastedImage.src = source;
		setTimeout(function(){ save(canvas.toDataURL("image/png")); },100);
	};
}

function save(s) {
	document.getElementById("i").value=s;
	document.getElementById("t").innerHTML="<img src='<?php echo $_imup["loader"]; ?>'>"
	setTimeout('document.getElementById("y").submit()',100);
}
</script>
<form method="post" id="y">
<textarea name="i" id="i" style="display:none;"></textarea>
</form>
</body>
</html>
