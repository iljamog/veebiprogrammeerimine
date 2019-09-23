<?php
	require("../../../config_vp2019.php");
	require("../../../functions_film.php");
	$userName = "Ilja Mogilnõi";
	$title= "I.Mogilnõi koolitöö leht";
	date_default_timezone_set("Europe/Helsinki");
	$database = "if19_ilja_mo_1";
	//echo "Film title: " ,$filmTitle," ";
	$filmInfoHtml = readAllFilms();
	readAllFilms();
	require("header.php");
?>

<center>
<body>

<?php
    echo"<h1>" .$userName ." koolitöö leht</h1>";
?>

	<p>See leht ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	
    <h2>Eesti filmid</h2>
	<p>Hetkel on andmebaasis saadaval: </p>
	<?php
	echo $filmInfoHtml;
	?>
	<?php
	// echo "Server: " .$serverHost ." .Kasutaja: " .$serverUsername;
	?>


</center>
</body>
</html> 

