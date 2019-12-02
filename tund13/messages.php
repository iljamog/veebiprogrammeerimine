<?php
  $database = "if19_ilja_mo_1";
  //require("functions_user.php");
  require("../../../config_vp2019.php");
  require("../../../functions_main.php");
  require("functions_message.php");

  require("classes/Session.class.php");
  //Sessioon, mis katkeb kui browser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
  SessionManager::sessionStart("vp", 0, "/~iljamog/", "greeny.cs.tlu.ee");

  if(!isset($_SESSION["userID"])){
	  //siis jõuga sisselogimise lehele
	  header("Location: page.php");
	  exit();
  }
  
  //väljalogimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }

  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  $userid = $_SESSION["userID"];
  $mydescription = $_SESSION["description"];
  
  $notice = null;
  $myBgcolor = null;
  $myTxtcolor = null;
  
if(isset($_POST["submitMessage"])) {
    if(isset($_POST["message"]) and !empty($_POST["message"])){
		$notice = storeMessage(test_input($_POST["message"]));
	}
  }
  $messagesHTML = readAllMessages();
  if(isset($_POST["showMyMessages"])){
	  $messagesHTML = readMyMessages();
  }
  require("header.php");
?>
<html>

<head>
<style>
	body{background-color: <?php $mybgcolor ?>; 
	color: <?php $mytxtcolor ?>} 
</style>
	<title>Profiili seadistamine</title>
</head>
<center>
<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <?php
	echo "<h3>" .$mydescription; "</h3>";
  ?>
</center>
  <hr>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Minu sõnum</label><br>
	  <textarea rows="5" cols="50" name="message" placeholder= "Siia tuleb sõnumi tekst..."></textarea>
	  <br>
	  <input name="submitMessage" type="submit" value="Salvesta sõnum"><span><?php echo $notice; ?></span>
</form>
<hr>
<?php
	echo "<h1>Hetkel saadaval sõnumid</h1>";
	echo $messagesHTML;
?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  
	  <input name="showMyMessages" type="submit" value="Näita minu sõnumeid">
</form>
<hr>
<p><a href="?logout=1">Logi välja!</a> | <a href="home.php">Pealehele</a> | <a href="messages.php">Sõnumid</a></p>
</body>
</html>