<?php
include 'config.php';
//Rewrite handler
$f=str_replace(array("/", ".php", ".."), "", htmlspecialchars($_GET["i"]));
if (!file_exists("i/".$f)) die("404 Not Found");

if (isset($_POST["y"])) {
//If retrick.php notified us, show HTML
?>
<!DOCTYPE html>
<html><head><?php echo $_imup["sharethis"]; ?><meta name="viewport" content="width=device-width, minimum-scale=0.1"><title><?php echo $f." | ".$_imup["title"]; ?></title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
  function copyToClipboard(t) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(t).select();
  document.execCommand("copy");
  $temp.remove();
}

</script>

</head>
<body style="margin: 0px; background: #0e0e0e;text-align: center;font-family: sans-serif;color:white;"><br>
<h2><?php echo $_imup["uploaded"]; ?></h2>
<p><?php echo $_imup["imageurl"]; ?> <a href="<?php echo $_imup["baseurl"]; ?>/<?php echo $f; ?>"><?php echo $_imup["baseurl"]; ?>/<?php echo $f; ?></a> <a href="#" onclick="copyToClipboard('<?php echo $_imup["baseurl"]; ?>/<?php echo $f; ?>');return false;"><?php echo $_imup["copy"]; ?></a></p>
	<img style="-webkit-user-select: none;background-position: 0px 0px, 10px 10px;background-size: 20px 20px;background-image:linear-gradient(45deg, #eee 25%, transparent 25%, transparent 75%, #eee 75%, #eee 100%),linear-gradient(45deg, #eee 25%, white 25%, white 75%, #eee 75%, #eee 100%);" src="<?php echo $_imup["baseurl"]; ?>/<?php echo $f; ?>">
<br><br><div class="sharethis-inline-share-buttons"></div>
</body></html>

<?php }else {
//Else return the raw image (in PNG)
	header('Content-Type: image/png');
	die(file_get_contents("i/".$f));
} 
?>
