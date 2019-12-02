<?php
function storeNews($title,$content,$expiredate){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn -> prepare(" INSERT INTO vp_uudised (userid, title, content, expire) VALUES (?,?,?,?) ");
	echo $conn -> error;
	$stmt -> bind_param("isss", $_SESSION["userID"], $title,$content,$expiredate);	
	if($stmt->execute()){
		$notice = "Uudis salvestatud";
	} else {
		$notice = "Uudist salvestatada ei õnnestunud" .$stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

function readAllNews(){
	$notice = null;
	$today = date("Y-m-d");
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn -> prepare(" SELECT  userid, title, content, expire FROM vp_uudised WHERE deleted IS NULL AND expire>=?");
	$stmt -> bind_param("s",$today);
	echo $conn -> error;	
	$stmt->bind_result($authorId, $NewsTitleFromDB, $NewsContentFromDB, $expireFromDB );
	$stmt->execute();
	
	$newsHTML = null;
	while($stmt->fetch()){
		$newsHTML .= "<h3>" .$authorId. "</h3>";
		$newsHTML .= "<h3><b>" .$NewsTitleFromDB. "</b></h3>";
		$newsHTML .= "<h2><b>" .$NewsContentFromDB. "</b></h2>";
		$newsHTML .= "<p> See sõnum kaob andmebaasist: " .$expireFromDB. "</p>";
	}
	if (empty($newsHTML)){
		$newsHTML = "<h2>Sõnumeid ei ole :( </h2>";
	}
	$stmt->close();
	$conn->close();
	return $newsHTML;
	
	
}