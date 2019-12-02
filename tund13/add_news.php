<?php
  $database = "if19_ilja_mo_1";
  //require("functions_user.php");
  require("../../../config_vp2019.php");
  require("../../../functions_main.php");
  require("functions_news.php");


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
  
$error = "";
$newsTitle = "";
$news = "";
$expiredate = date("Y-m-d");
$notice = null;

if(isset($_POST["newsBtn"])) {
    if(!empty($_POST["newsEditor"]) and !empty($_POST["newsTitle"])){
		$expiredate = $_POST["expiredate"];
		$newsTitle = test_input($_POST["newsTitle"]);
		$content = $_POST["newsEditor"]	;
		$notice = storeNews($newsTitle, $content, $expiredate);
	}
  }

require("header.php");
?>


<html>
<!-- //Javascript osa:-->
<!-- Lisame tekstiredaktory TinyMCE -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<script>
tinymce.init({
		selector:"textarea#newsEditor",
		plugins: "link",
		menubar: "edit",
});
</script>




<h2>Lisa uudis</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value="<?php echo $newsTitle; ?>"><br>
		<label>Uudise sisu:</label><br>
		<textarea name="newsEditor" id="newsEditor"><?php echo $news; ?></textarea>
		<br>
		<label>Uudis nähtav kuni (kaasaarvatud)</label>
		<input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="<?php echo $expiredate; ?>">
		
		<input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis!"
		<?php if ($notice == "Uudis salvestatud!"){echo "disabled";} ?>> <span>&nbsp;</span><span><?php echo $error; ?></span>
	</form>
	
	<p><a href="?logout=1">Logi välja!</a> | <a href="home.php">Pealehele</a></p>
	
</html>