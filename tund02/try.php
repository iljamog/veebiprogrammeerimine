<?php
$userName = "Ilja Mogilnõi";
$fullTimeNow = date("d.m.Y H:i:s");
$hourNow = date ("H");
$partOfDay = "hägune aeg";
if($hourNow == 1 && $hourNow <= 5){
	$partOfDay = "peaksid sa magama";
}
if($hourNow < 8){
	$partOfDay = "varajane hommik";
}
if($hourNow > 8 && $hourNow < 10){
	$partOfDay = "hommik";
}
if($hourNow >= 10){
	$partOfDay = "päev";
}
if($hourNow >= 17){
	$partOfDay = "õhtu";
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
	<?php
$d = date("D");
if($d == "Fri"){
    echo "Mõnusat nädalavahetust!";
} elseif($d == "Sun"){
    echo "Ilusat pühapäeva!";
} else{
    echo "Ilusat päeva!";
}
?>	   
  <hr>
</body>
</html> 