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
				$this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $newW, $newH);				
			}// kui liiga suur lõppeb
		} // resizeImage lõppeb
		
		private function setPicSize($myTempImage, $imageW, $imageH, $newW, $newH){
			$newImage = imagecreatetruecolor($newW, $newH);
			imagecopyresampled($newImage, $myTempImage, 0, 0, 0, 0, $newW, $newH, $imageW, $imageH);
			return $newImage;
		} // setPicSize lõppeb
		
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
		
		
	} //class lõppeb