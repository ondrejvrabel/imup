<?php include 'config.php'; ?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="2; url=<?php echo str_replace("/", "#", htmlspecialchars($_GET["r"])); ?>">
</head>
<body style="margin: 0px; background: #0e0e0e;text-align: center;">Redirecting...
<br><a href="<?php echo str_replace("/", "#", htmlspecialchars($_GET["r"])); ?>"></a>
<form id="a" method="post" action="<?php echo str_replace("/", "#", htmlspecialchars($_GET["r"])); ?>">
<!-- By posting dummy form to the image we can distinguish between direct traffic or link and show options after the upload -->
	<input type="hidden" name="y" value="y">

</form>
<script type="text/javascript">
		document.getElementById('a').submit();
	</script>
</body>
</html>
