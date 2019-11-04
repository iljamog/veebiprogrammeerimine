<?php
$database = "if19_ilja_mo_1";
require("functions_user.php");
require("../../../config_vp2019.php");
require("../../../functions_main.php");
require("header.php");


  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  $userid = $_SESSION["userID"];

  $notice = null;
  
  $password = null;
  $confirmpassword = null;
  $confirmpassword2 = null;
  
  $passwordError= null;
  $confirmpasswordError= null;
  $notice= null;
  
	if(isset($_POST["submitNewPassowrd"])){
		
		if(isset($_POST["existingPassword"])and !empty($_POST["existingPassword"])){
			$password = test_input($_POST["existingPassword"]);
		}   else {
			$passwordError = "Palun sisestage parool!";
		}
		if(isset($_POST["newPassword"])and !empty($_POST["newPassword"])){
			$confirmpassword = test_input($_POST["newPassword"]);
		}   else {
			$confirmpasswordError = "Palun valige uus parool!";
		}
		if(isset($_POST["confirmNewPassword"])and !empty($_POST["confirmNewPassword"])){
			$confirmpassword2 = test_input($_POST["confirmNewPassword"]);
		}   else {
			$confirmpasswordError = "Palun korrake uut parooli!";
		}
		if($password == $confirmpassword){
			$passwordError= "Vana ja uus parool on samad, palun valige uuesti";
			$confirmpasswordError = null;
		}
		if($confirmpassword != $confirmpassword2){
			$passwordError= "Uued paroolid erinesid, palun proovige uuesti";
			$confirmpasswordError = null;
		}
	
		if((strlen($password)<8) or (strlen($confirmpassword)<8) or (strlen($confirmpassword2)<8)){
			$passwordError = "Valitud paroolidest on üks liiga lühike, miinimum pikkus on 8 märki";
			$confirmpasswordError = null;
		}
		if(empty($passwordError) and empty($confirmpasswordError)){
			$notice = changePassword($userid, $password, $confirmpassword);
		}
	
	}
	
?>

<html>

<head>
<style>
	body{background-color: <?php $mybgcolor ?>; 
	color: <?php $mytxtcolor ?>} 
</style>
	<title>Parooli vahetamine</title>
</head>
<body>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  
	  <label>Salasõna (min 8 tähemärki):</label><br>
	  <input name="existingPassword" type="password"><span><br><?php echo $passwordError; ?></span><br>
	  <label>Uus salasõna:</label><br>
	  <input name="newPassword" type="password"><span><br><?php echo $confirmpasswordError; ?></span><br>
	  <label>Korrake uut salasõna:</label><br>
	  <input name="confirmNewPassword" type="password"><span><br><?php echo $confirmpasswordError; ?></span><br>
	  <input name="submitNewPassowrd" type="submit" value="Muuda parool"><span><?php echo $notice; ?></span>
</form>
<hr>
<p><a href="home.php">Tagasi</a> | <a href="messages.php">Sõnumid</a></p>
</body>
</html>
