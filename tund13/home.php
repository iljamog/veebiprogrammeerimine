<?php
	require("../../../functions_main.php");
	require("functions_user.php");
	require("../../../config_vp2019.php");
	require("functions_message.php");
	$database = "if19_ilja_mo_1";
	require("functions_news.php");
	
  //Sessioon
  require("classes/Session.class.php");
  //Sessioon, mis katkeb kui browser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
  SessionManager::sessionStart("vp", 0, "/~iljamog/", "greeny.cs.tlu.ee");
  
  //kui pole sisseloginud
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
  
  
  //Tegeleme küpsistega (cookies)
  //setcookie peab olema enne <html> elementi / kõige alguses
  //nimi[väärtus , aegumine, path e kataloog, domeen, kas https, https only e kindalsti üle veebi]
  setcookie("vpname", $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"], time() + (86400 * 31), "/iljamog/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  
  if(isset($_COOKIE["vpname"])){
	  echo "Küpsisest selgus nimi: " .$_COOKIE["vpname"];
  } else {
	  echo "Küpsiseid ei leitud!";
  }
  
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  $mydescription = $_SESSION["description"];
  
  
  $newsHTML = readAllNews();
  require("header.php");
?>


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
  <hr>
  <p><a href="?logout=1">Logi välja!</a></p>
  <ul>
    <li><a href="userprofile.php">Kasutajaprofiil</a></li>
	<li><a href="messages.php">Sõnumid</a></li>
	<li><a href="showfilminfo.php">Filmid</a></li>
	<li><a href="pic_upload.php">Piltide üleslaadimine</a></li>
	<li><a href="passwordchange.php">Parooli vahetamine</a></li>
	<li><a href="public_gallery.php">Galerii</a></li>
	<li><a href="add_news.php">Uudise lisamine</a></li>
  </ul>
  <hr>
  <?php
	echo $newsHTML;
  ?>
  
</body>
</html>





