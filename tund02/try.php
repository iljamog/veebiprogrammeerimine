<?php
$userName = "Ilja Mogilnõi";
$fullTimeNow = date("d.m.Y H:i:s");
$hourNow = date ("H");
$partOfDay = "hägune aeg";
if($hourNow < 8){
$partOfDay = "varajane hommik";
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
<meta charset="utf-8">
  
  <title>
	<?php
	echo $userName;
	?>
  häkib </title>
</head>

<body>
<?php
	echo"<h1>" .$userName ." koolitöö leht</h1>";
	?>
	
<p>See leht on loodud koolitöö raames ja
  ei sisalda tõsiseltvõetavat sisu!</p>
	
	<p> Lehe avamisel on:
	<?php
	echo $fullTimeNow;
	?> .</p>
	
	<?php
	echo "<p> Lehe avamise hetkel oli " .$partOfDay .".</p>";
	?>
	  
  <img src="funycat.jpg" alt="kassipilt" />
</body>
</html> 