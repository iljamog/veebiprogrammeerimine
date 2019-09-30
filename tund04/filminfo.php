<?php
	require("../../../config_vp2019.php");
	require("../../../functions_film.php");
	$userName = "Ilja Mogilnõi";
	$title= "I.Mogilnõi koolitöö leht";
	date_default_timezone_set("Europe/Helsinki");
	$database = "if19_ilja_mo_1";
	//echo "Film title: " ,$filmTitle," ";
	$filmInfoHtml = readAllFilms();
	require("header.php");
?>

<center>
<body>

<?php
    echo"<h1>" .$userName ." koolitöö leht</h1>";
?>

	<p>See leht ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
		<h2>Otsi film: </h2>
	
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
		<input type="submit" value="Otsi filmi" name="searchFilm">
		<br>
		<?php
	if(isset($_POST["searchFilm"])){
		if(!empty($_POST["filmTitle"])){
			searchFilmInfo();
		}else{
			echo "<b>" .$errorNoTitle ."</b>";
			echo "<p></p>";
		}
	}
	?>
	
	<hr>
    <h2>Eesti filmid</h2>
	<p>Hetkel on andmebaasis saadaval: </p>
<?php
	echo $filmInfoHtml;
	// echo "Server: " .$serverHost ." .Kasutaja: " .$serverUsername;
?>


</center>
</body>
</html> 

