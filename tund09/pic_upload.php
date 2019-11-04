<?php
$database = "if19_ilja_mo_1";
require("functions_user.php");
require("../../../config_vp2019.php");
require("functions_pic.php");
require("functions_message.php");
require("../../../functions_main.php");
require("classes/Picupload.class.php");
//require("classes/Test.class.php");

    //kui pole sisseloginud
if(!isset($_SESSION["userID"])){
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
  
  //$myTest = new Test(1337);
  //echo "Salajane:".$myTest ->secretNumber;
  //echo "avalik:".$myTest ->publicNumber;
  //$myTest ->showValues();
  //$myTest ->tellSecret();
  //unset($myTest);
  
  $notice = null;
  $fileName = "vp_";
  $picMaxW = 600;
  $picMaxH = 400;
  //pic upload algab
	//$target_dir = "uploads/";
  
  if(isset($_POST["submitPic"])){
	//var_dump($_FILES["fileToUpload"]);
	//$target_file = $pic_upload_dir_orig . basename($_FILES["fileToUpload"]["name"]);
	//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
	//failinime jaoks ajatempel
	$timeStamp = microtime(1) * 10000;
	$fileName .= $timeStamp ."." .$imageFileType;
	$targetFile = $pic_upload_dir_orig .$fileName;
	
	$uploadOk = 1;
	
	// Kas on üldse pilt
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			$notice =  "Ongi pilt - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			$notice =  "Ei ole pilt!";
			$uploadOk = 0;
		}
	
	// Check if file already exists
	if (file_exists($targetFile)) {
		$notice =  "Pilt juba serveris!";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 2500000) {
		$notice =  "Kahjuks on fail liiga suur!";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		$notice =  "Kahjuks on lubatud ainult JPG, JPEG, PNG ja GIF failid!";
		$uploadOk = 0;
	}
	
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$notice =  "Kahjuks faili üles ei laeta!";
	// if everything is ok, try to upload file
	} else {
		//kasutan classi
		$myPic = new Picupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
		//suuruse muutmine
		$myPic->resizeImage($picMaxW, $picMaxH);
		$myPic->saveImage($pic_upload_dir_W600 .$fileName);
		unset($myPic);
		
		//kopeerin originaali
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
			$notice .=  "Originaalfail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles!";
		} else {
			$notice =  "Vabandame, originaalfaili ei õnnestunud üles laadida!";
		}
		
		//salvestan info andmebaasi
		$notice .= addPicData($fileName, test_input($_POST["altText"]), $_POST["privacy"]);
		
	}
	
  }//nupuvajutuse kontroll
  
  //pic upload lõppeb
  
  require("header.php");
?>


<body>
  <?php
    echo "<h1>" .$userName ." koolitöö leht</h1>";
  ?>
  <p>See leht on loodud koolis õppetöö raames
  ja ei sisalda tõsiseltvõetavat sisu!</p>
  <hr>
  <p><a href="?logout=1">Logi välja!</a> | Tagasi <a href="home.php">avalehele</a></p>
  <hr>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	  <label>Vali üleslaetav pilt!</label>
	  <input type="file" name="fileToUpload" id="fileToUpload">
	  <br>
	  <label>Alt tekst: </label><input type="text" name="altText">
	  <br>
	  <label>Privaatsus</label>
	  <br>
	  <input type="radio" name="privacy" value="1"><label>Avalik</label>&nbsp;
	  <input type="radio" name="privacy" value="2"><label>Sisseloginud kasutajatele</label>&nbsp;
	  <input type="radio" name="privacy" value="3" checked><label>Isiklik</label>
      <br>
	  <input name="submitPic" type="submit" value="Lae pilt üles!"><span><?php echo $notice; ?></span>
	</form>
	<hr>
</body>
</html>