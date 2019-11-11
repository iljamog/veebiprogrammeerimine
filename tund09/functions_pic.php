<?php
	
	function addPicData($fileName, $altText, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userID"], $fileName, $altText, $privacy);
		if($stmt->execute()){
			$notice = " Pildi andmed salvestati andmebaasi!";
		} else {
			$notice = " Pildi andmete salvestamine ebaönnestus tehnilistel põhjustel! " .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function getRandomImage(){
		//$privacy = 1;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE id=(SELECT MAX(id) FROM vpphotos WHERE privacy=1 AND deleted IS NULL)");
		echo $conn->error;
		//$stmt->bind_param("i", $privacy);
		$stmt->bind_result($picNameFromDb,$altTextFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			$photoDir = "../pic_uplaod_orig/";
			$targetFile = $photoDir .$picNameFromDb;
			if(file_exists($targetFile)){
				$randomImgHTML = '<img src="' .$targetFile .'" alt="'.$altTextFromDb. '">';
			}			
			
		}
		return $randomImgHTML;
	
	}
	