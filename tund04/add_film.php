<?php
	date_default_timezone_set("Europe/Helsinki");
	require("../../../config_vp2019.php");
	require("../../../functions_film.php");
	
	$userName = "Ilja Mogilnõi";
	$title= "I.Mogilnõi koolitöö leht";
	$database = "if19_ilja_mo_1";
	//echo "Film title: " ,$filmTitle," ";
	//var_dump($_POST);
	//Kui on nuppu vajutaud
	if(isset($_POST["submitFilm"])){
		if(!empty($_POST["filmTitle"]))
		saveFilmInfo($_POST["filmTitle"],$_POST["filmYear"],$_POST["filmDuration"],$_POST["filmGenre"],$_POST["filmCompany"],$_POST["filmDirector"]);
	}
	require("header.php");
	
?>

<center>
<body>

<?php
    echo"<h1>" .$userName ." koolitöö leht</h1>";
?>

	<p>See leht ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
    <h2>Eesti filmid, lisame uue</h2>
	<p>Täida kõik failid ja lisa film andmebaasi </p>
	<form method="POST">
		<label> Sisesta pealkiri: </label><input type="text" name="filmTitle">
		<br>
		<label> Sisesta filmi tootmisaasta: </label><input type="number" min="1912" max="2019" value="2019" name="filmYear">
		<br>
		<label> Sisesta filmi kestus(min): </label><input type="number" min="1" max="300" value="80" name="filmDuration">
		<br>
		<label> Sisesta filmi žanr: </label><input type="text" name="filmGenre">
		<br>
		<label> Sisesta filmi tootja: </label><input type="text" name="filmCompany">
		<br>
		<label> Sisesta filmi lavastaja: </label><input type="text" name="filmDirector">
		<br>
		<input type="submit" value="Salvesta filmi andmed" name="submitFilm">
		
	</form>
	
	<?php
	//echo $filmInfoHtml;
	// echo "Server: " .$serverHost ." .Kasutaja: " .$serverUsername;
	?>


</center>
</body>
</html> 

