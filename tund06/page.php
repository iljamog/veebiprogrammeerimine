<?php
  require("../../../functions_main.php");
  require("functions_user.php");
  require("../../../config_vp2019.php");
  $database = "if19_ilja_mo_1";
  
  $userName = "Sisselogimata kasutaja";
  
  $notice = "";
  $email = "";
  $emailError = "";
  $passwordError = "";

$title= "I.Mogilnõi koolitöö leht";
date_default_timezone_set("Europe/Helsinki");

//$fullTimeNow = date("d.m.Y H:i:s");

$weekDaysET = ["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
$monthsET = ["jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsemeber"];
$monthNow = date("n");
$dayNow = date("N");

$hourNow = date ("H");
$partOfDay = "hägune aeg";
if($hourNow == 1 && $hourNow <= 5){
        $partOfDay = "peaksid sa magama";
}
if($hourNow < 8){
        $partOfDay = "varajane hommik";
}
if($hourNow >= 8 && $hourNow <= 10){
        $partOfDay = "hommik";
}
if($hourNow >= 10){
        $partOfDay = "päev";
}
if($hourNow >= 17){
        $partOfDay = "õhtu";
}

        $semesterStart = new DateTime ("2019-9-2");
        $semesterEnd = new DateTime ("2019-12-13");
        $semesterDuration = $semesterStart -> diff($semesterEnd);
        $today = new DateTime ("now");
        $fromSemesterStart = $semesterStart -> diff($today);
        //var_dump($fromSemesterStart);
		$semesterInfoHTML = "<p>Siin peaks olema info semestri kulguse kohta</p>";
		$elapsedValue = $fromSemesterStart -> format ("%r%a");
		$durationValue = $semesterDuration -> format ("%r%a");
if ($elapsedValue > 0){
        $semesterInfoHTML = " <p>Semester on täies hoos: ";
        $semesterInfoHTML .= '<meter min="0" max="' .$durationValue. '" ';
        $semesterInfoHTML .= ' value="'.$elapsedValue .'">';
        $semesterInfoHTML .= round ($elapsedValue / $durationValue * 100 , 1) . "%";
        $semesterInfoHTML .="</meter>";
        $semesterInfoHTML .="</p>";
}
if ($elapsedValue > $durationValue){
        $semesterInfoHTML = " <p>Semester on läbi!</p> ";
}
if ($today < $semesterStart){
        echo "Semester pole veel alanud!";
		$semesterInfoHTML = " <p>Semester pole alanud!</p> ";
}
        

        //<meter min="0" max="155" value="33" >Väärtus</meter>

        // foto lisamine lehele
        
		$photoDir = "../photos/";
		$picFileTypes = ["image/jpeg", "image/png"];
        $allPhotos = [];
        $dirContent = array_slice(scandir($photoDir),2);
        //var_dump($dirContent);
        foreach($dirContent as $file){
                $fileInfo = getImagesize($photoDir .$file);
                //var_dump($fileInfo);
                if(in_array($fileInfo["mime"], $picFileTypes) == true){
                        array_push($allPhotos, $file);
                }
        }
        //var_dump($allPhotos)
        $picCount = count($allPhotos);
        $picNum = mt_rand(0, ($picCount - 1));
        //echo $allPhotos[$picNum];
        $photoFile = $photoDir .$allPhotos[$picNum];
        $randomImgHTML = '<img src="' .$photoFile .'" alt="TLÜ Terra Õppehoone">';
		
	  if(isset($_POST["login"])){
		if (isset($_POST["email"]) and !empty($_POST["email"])){
		  $email = test_input($_POST["email"]);
		} else {
		  $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
		}
	  
		if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
		  $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
		}
	  
		if(empty($emailError) and empty($passwordError)){
		   $notice = signIn($email, $_POST["password"]);
		} else {
			$notice = "Ei saa sisse logida!";
		}
	  }
        
        // lisame lehepäise
		
		
?>
<!DOCTYPE html>
<html lang="et">
  <head>
    <meta charset="utf-8">
	<title>Katseline veebileht</title>
  </head>
<body>
<center>
<?php
        echo"<h1>Koolitöö leht</h1>";
        ?>
        
<p>See leht on loodud koolitöö raames ja
  ei sisalda tõsiseltvõetavat sisu!</p>
  </center>
  <hr>
  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>E-mail (kasutajatunnus):</label><br>
	  <input type="email" name="email" value="<?php echo $email; ?>">&nbsp;<span><?php echo $emailError; ?></span><br>
	  
	  <label>Salasõna:</label><br>
	  <input name="password" type="password">&nbsp;<span><?php echo $passwordError; ?></span><br>
	  
	  <input name="login" type="submit" value="Logi sisse">&nbsp;<span><?php echo $notice; ?>
	</form>
  <hr>  
        <?php 
		
        echo $semesterInfoHTML;
        ?>
        <p> Lehe avamisel on:
        <?php
		echo $weekDaysET[$dayNow-1]," "; 
        echo date("d."), $monthsET[$monthNow-1],  date(".Y H:i:s");
        ?> .</p>
        <?php
        echo "<p> Lehe avamise hetkel oli " .$partOfDay .
        ".</p>";
        ?>
        
        <?php
$d = date("D");
if($d == "Fri"){
  echo "Mõnusat nädalavahetust!";
} elseif($d == "Sun"){
    echo "Ilusat pühapäeva!";
} else{
    echo "Ilusat päeva!";
}
?>

<center>
<img src="funycat.jpg" alt="kassipilt" />
</center>
<hr>
<center>
<?php
echo $randomImgHTML;
?>
</center>
</body>
</html> 

