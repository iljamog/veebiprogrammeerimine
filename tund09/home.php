<?php
	require("../../../functions_main.php");
	require("functions_user.php");
	require("../../../config_vp2019.php");
	require("functions_message.php");
	$database = "if19_ilja_mo_1";
  
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
  
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  $mydescription = $_SESSION["description"];
  
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
	<li><a href="showfilminfo.php">Filmid</a></li>
  </ul>
  
</body>
</html>





