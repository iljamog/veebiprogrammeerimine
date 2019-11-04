<?php

	require("../../../functions_main.php");
	require("functions_user.php");
	require("../../../config_vp2019.php");
	$database = "if19_ilja_mo_1";
	
	$email = null;
	$emailError = null;
	$notice = null;
	$passwordError = null;
	$password = null;
	
	if(isset($_POST["submitLogin"])){
		if(isset($_POST["email"])and !empty($_POST["email"])){
			$email = test_input($_POST["email"]);
		} else {
			$emailError = "Palun sisestage e-mail!";
		}
		if(isset($_POST["password"]) and !empty($_POST["password"])){
			$password = test_input($_POST["password"]);
		} else {
			$passwordError = "Palun sisestage parool!";
		}
		if(!empty($emailError)){
			$passwordError = null;
		}
		if(empty($emailError) and empty($passwordError)){
			$notice = signIn($email, $password);
		}
	
	}

?>
<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
	<title>Sisselogimine</title>
  </head>
<body>
<center>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>E-mail (kasutajatunnus):</label><br>
	<input type="email" name="email" value="<?php echo $email; ?>"><br><span><?php echo $emailError; ?></span><br>
	<br>
	<label>Salasõna:</label><br>
	<input name="password" type="password"><span><br><?php echo $passwordError; ?></span><br>
	<input name="submitLogin" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
</form>


</form>
</body>