<?php
$database = "if19_ilja_mo_1";
require("functions_user.php");
require("../../../config_vp2019.php");
require("functions_pic.php");
require("functions_message.php");

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
  
  $myBgcolor = null;
  $myTxtcolor = null;
  
  
  $notice = null;
  $fileName = "vp_";
  $picMaxW = 600;
  $picMaxH = 400;
  
  
//PIC UPLOAD ALGUS
	//$target_dir = "uploads/";

  // PIC UPLOAD NUPU VAJUTAMISEL
if(isset($_POST["submitPic"])){
	var_dump($_FILES["fileToUpload"]);
	//$target_file = $pic_upload_dir_orig . basename($_FILES["fileToUpload"]["name"]);
	
	$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
	//Failinime jaoks ajatempel
	$timeStamp = microtime(1) * 10000;
	$fileName .= $timeStamp .".". $imageFileType;
	$target_file = $pic_upload_dir_orig . $fileName;
	$uploadOk = 1;
	
	// Kas on üldse pilt

		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "Ongi pilt - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "Ei ole pilt!";
			$uploadOk = 0;
		}
	
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Pilt juba serveris!";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 2500000) {
		echo "Kahjuks on fail liiga suur!";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Kahjuks on lubatud ainult JPG, JPEG, PNG ja GIF failid!";
		$uploadOk = 0;
	}
	// Suuruse muutmine
	//loome ajutise "pildiobjekti" - image
	if($imageFileType == "jpg" or $imageFileType == "jpeg"){
		$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
	}
	if($imageFileType == "png"){
		$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
	}
	if($imageFileType == "gif"){
		$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
	}
	//pildi originaalmõõt
	$imageW = imagesx($myTempImage);
	$imageH = imagesy($myTempImage);
	//kui on liiga suur
	if($imageW > $picMaxW or $imageH > $picMaxH){
		//muudamegi suurust
		if($imageW / $picMaxW > $imageH / $picMaxH){
			$picSizeRatio = $imageW / $picMaxW;
		} else {
			$picSizeRatio = $imageH / $picMaxH;
		}
		//loome uue "pildiobjekti" juba uute mõõtudega
		$newW = round($imageW / $picSizeRatio, 0);
		$newH = round($imageH / $picSizeRatio, 0);
		$myNewImage = setPicSize($myTempImage, $imageW, $imageH, $newW, $newH);
		//salvestan vähendatud pildi faili
		if($imageFileType == "jpg" or $imageFileType == "jpeg"){
			if(imagejpeg($myNewImage, $pic_upload_dir_W600 .$fileName, 90)){
				$notice = "Vähendatud pildi salvestamine õnnestus! ";
			} else {
				$notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
			}
		}
		if($imageFileType == "png"){
			if(imagepng($myNewImage, $pic_upload_dir_W600 .$fileName, 6)){
				$notice = "Vähendatud pildi salvestamine õnnestus! ";
			} else {
				$notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
			}
		}
		if($imageFileType == "gif"){
			if(imagegif($myNewImage, $pic_upload_dir_W600 .$fileName)){
				$notice = "Vähendatud pildi salvestamine õnnestus! ";
			} else {
				$notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
			}
		}
		
	}//kui liiga suur lõppeb
		
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Kahjuks faili üles ei laeta!";
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			$notice .= "Fail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles!";
		} else {
			$notice .= "Vabandame, faili ei õnnestunud üles laadida!";
		}
	}
	}//Nupuvajutuse kontrolli lõpp
  
  
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
</center>
  <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>
  <hr>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	  <label>Vali üleslaetav pilt!</label><br><br>
	  <input type="file" name="fileToUpload" id="fileToUpload">
	  <br>
	  <br>
	  <br>
	  <input name="submitPic" type="submit" value="Lae pilt üles!"><span><?php echo $notice; ?></span>
	</form>
	<hr>
</body>
</html>