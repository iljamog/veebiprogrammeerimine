<?php

	class Picupload{
		
		private $tempName;
		private $imageFileType;
		private $myTempImage;
		private $MyNewImage;
		
		function __construct($tempName, $imageFileType){
			
			$this->tempName = $tempName;
			$this->imageFileType = $imageFileType;
			$this->createImageFromFile();
		} // construct lõppeb
		
		function __destruct(){
			imagedestroy ($this->myTempImage);
			imagedestroy ($this->myNewImage);
		}
		//faili nime moodustaja
		
		public function createFileName($fileName){
		//failinime jaoks ajatempel
			$timeStamp = microtime(1) * 10000;
			$fileName .= $timeStamp ."." .$imageFileType;
			$targetFile = $pic_upload_dir_orig .$fileName;
			
			return $fileName;
			return $targetFile;			
		}
		
		
		// Kas on üldse pilt
		private function checkIfImage(){
			
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice =  "Ongi pilt - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				$notice =  "Ei ole pilt!";
				$uploadOk = 0;
			}
			return $uploadOk;
			return $notice;
		} // Kas on üldse pilt lõppeb
		
		//Kontrollime kas on juba olemas
		private function checkIfExists($targetFile){
			
			if (file_exists($targetFile)) {
				$notice =  "Pilt juba serveris!";
				$uploadOk = 0;
			}
			return $notice;
			return $uploadOk;			
		} //Kontroll lõppeb
		
		// Check file size
		private function checkFileSize(){
		
			if ($_FILES["fileToUpload"]["size"] > 2500000) {
				$notice =  "Kahjuks on fail liiga suur!";
				$uploadOk = 0;
			}
			return $notice;
			return $uploadOk;
		}// Check file size lõppeb
		
		private function checkFileFormat($imageFileType){
			// Allow certain file formats
			if($this->imageFileType != "jpg" && $this->imageFileType != "png" && $this->imageFileType != "jpeg"
			&& $this->imageFileType != "gif" ) {
				$notice =  "Kahjuks on lubatud ainult JPG, JPEG, PNG ja GIF failid!";
				$uploadOk = 0;
			}
			return $notice;
			return $uploadOk;			
		} //Format check lõppeb
		
		private function createImageFromFile(){
			
			if($this->imageFileType == "jpg" or $this->$imageFileType == "jpeg"){
				$this->myTempImage = imagecreatefromjpeg($this->tempName);
			}
			if($this->imageFileType == "png"){
				$this->myTempImage = imagecreatefrompng($this->tempName);
			}
			if($this->imageFileType == "gif"){
				$this->myTempImage = imagecreatefromgif($this->tempName);
			}
		} //CreateImageFromFile lõppeb.
		
		public function resizeImage($picMaxW, $picMaxH){
			
			//pildi originaalmõõt
			$imageW = imagesx($this->myTempImage);
			$imageH = imagesy($this->myTempImage);
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
				$this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $newW, $newH); // kui liiga suur lõppeb			
			} else {
				$imageW = imagesx($this->myTempImage);
				$imageH = imagesy($this->myTempImage);
				$this->myNewImage = imagecreatetruecolor($imageW,$imageH);
			}
		} // resizeImage lõppeb
		
		private function setPicSize($myTempImage, $imageW, $imageH, $newW, $newH){
			$newImage = imagecreatetruecolor($newW, $newH);
			imagecopyresampled($newImage, $myTempImage, 0, 0, 0, 0, $newW, $newH, $imageW, $imageH);
			return $newImage;
		} // setPicSize lõppeb
		
		public function addWaterMark($waterMarkFile){
			$waterMark = imagecreatefrompng($waterMarkFile);
			$waterMarkW = imagesx($waterMark);
			$waterMarkH = imagesy($waterMark);
			$waterMarkX = imagesx($this->myNewImage) - $waterMarkW - 10;
			$waterMarkY = imagesy($this->myNewImage) - $waterMarkH - 10;
			// kopeerin vesimärgi pixlid pildile
			imagecopy($this->myNewImage, $waterMark, $waterMarkX, $waterMarkY, 0, 0, $waterMarkW, $waterMarkH);
			imagedestroy($waterMark);
		}
		
		//salvestan vähendatud pildi faili
		public function saveImage($targetFile){
			
			$notice = null;			
			if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
				if(imagejpeg($this->myNewImage, $targetFile, 90)){
					$notice = "Vähendatud pildi salvestamine õnnestus! ";
				} else {
					$notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
				}
			}
			if($this->imageFileType == "png"){
				if(imagepng($this->myNewImage, $targetFile, 6)){
					$notice = "Vähendatud pildi salvestamine õnnestus! ";
				} else {
					$notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
				}
			}
			if($this->imageFileType == "gif"){
				if(imagegif($this->myNewImage, $targetFile)){
					$notice = "Vähendatud pildi salvestamine õnnestus! ";
				} else {
					$notice = "Vähendatud pildi salvestamine ebaõnnestus! ";
				}
			}
			return $notice;
		} //saveImage lõppeb
		
		public function saveImageOrig($targetFile){
			
			//kopeerin originaali
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
				$notice .=  "Originaalfail ". basename( $_FILES["fileToUpload"]["name"]). " laeti üles!";
			} else {
				$notice =  "Vabandame, originaalfaili ei õnnestunud üles laadida!";
			}
			return $notice;
		} //originaali kopeerimine lõppeb
		
		
	} //class lõppeb