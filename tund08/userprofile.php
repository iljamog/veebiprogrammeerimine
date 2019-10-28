<?php
$database = "if19_ilja_mo_1";
require("functions_user.php");
require("../../../config_vp2019.php");
require("../../../functions_main.php");
require("header.php");


  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  $userid = $_SESSION["userID"];

  $notice = null;
  $mydescription = $_SESSION["description"];
  $mybgcolor = $_SESSION["mybgcolor"];
  $mytxtcolor = $_SESSION["mytxtcolor"];
  
if(isset($_POST["submitProfile"])) {
    if(!empty($_POST["description"])) {
      $mydescription = test_input($_POST["description"]);
    }else {
      $descriptionError = "Palun sisesta profiili kirjeldus!";
    }
    if(!empty($_POST["bgcolor"])) {
      $mybgcolor = $_POST["bgcolor"];
    } 
    if(!empty($_POST["txtcolor"])) {
      $mytxtcolor = $_POST["txtcolor"];
    } 
    if(!empty($mydescription) and !empty($mybgcolor) and !empty($mytxtcolor)) {
      $notice = createProfile($userid, $mydescription, $mybgcolor, $mytxtcolor);
    }
  }
  
?>
<html>

<head>
<style>
	body{background-color: <?php $mybgcolor ?>; 
	color: <?php $mytxtcolor ?>} 
</style>
	<title>Profiili seadistamine</title>
</head>
<body>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu kirjeldus</label><br>
	  <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea>
	  <br>
	  <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	  <label>Minu valitud tekstivärv: </label><input name="txtcolor" type="color" value="<?php echo $mytxtcolor; ?>"><br>
	  <input name="submitProfile" type="submit" value="Salvesta profiil">
</form>
<hr>
<p><a href="home.php">Tagasi</a> | <a href="messages.php">Sõnumid</a></p>
</body>
</html>