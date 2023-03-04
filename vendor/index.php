

<html lang="en">
  <head>
  </head>
  <body>
  <?php 
	$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  
	$arr = explode(".", $actual_link, 2);
	$first = $arr[0];
	$web = str_replace("https://","",$first);
	$web = str_replace("http://","",$web);
	echo "<span>Ini adalah placeholder untuk website $web</span>";
  ?>
</body>
</html>