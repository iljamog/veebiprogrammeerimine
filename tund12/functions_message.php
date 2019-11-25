<?php
function storeMessage($message){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn -> prepare(" INSERT INTO vpmsg (userid, message) VALUE (?,?) ");
	echo $conn -> error;
	$stmt -> bind_param("is", $_SESSION["userID"], $message);
	if($stmt->execute()){
		$notice = "Sõnum salvestatud";
	} else {
		$notice = "Sõnumit salvestatada ei õnnestunud" .$stmt->error;
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}
// kõik sõnumid
function readAllMessages(){
		
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT userid, message, created FROM vpmsg WHERE deleted IS NULL ");
	// seome saadava tulemuse muutujaga ,andme baasist võttes tuleb alati bind result
	echo $conn -> error;	
	$stmt->bind_result($senderID, $messageFromDB,$createdFromDB );
	$stmt->execute();
	
	$messagesHTML = null;
	while($stmt->fetch()){
		$messagesHTML .= "<h3>" .$senderID. "</h3>";
		$messagesHTML .= "<h2><b>" .$messageFromDB. "</b></h2>";
		$messagesHTML .= "<p>" .$createdFromDB. "</p>";
	}
	if (empty($messagesHTML)){
		$messagesHTML = "<h2>Sõnumeid ei ole :( </h2>";
	}
	$stmt->close();
	$conn->close();
	return $messagesHTML;
}
// Ainult enda sõnumid
function readMyMessages(){
	$messagesHTML = null;
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//$stmt = $conn->prepare("SELECT message, created FROM vpmsg3");
	$stmt = $conn->prepare("SELECT message, created FROM vpmsg WHERE userid = ? AND deleted IS NULL");
    echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userID"]);
	$stmt->bind_result($messageFromDB, $createdFromDB);
	$stmt->execute();
	while($stmt->fetch()){
		$messagesHTML .= "<h2><b>" .$messageFromDB. "</b></h2>";
		$messagesHTML .= "<p>" .$createdFromDB. "</p>";
	}
	if(empty($messagesHTML)){
		$messagesHTML = "<p>Otsitud sõnumeid pole!</p> \n";
	}
	
	$stmt->close();
	$conn->close();
	return $messagesHTML;
}
?>