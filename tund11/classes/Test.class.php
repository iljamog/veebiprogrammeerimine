<?php 
	class Test{
		//muutujad ehk properties
		private $secretNumber;
		public $publicNumber;
		
		function __construct($sentValue){
			$this ->secretNumber = 10;
			$this ->publicNumber = $sentValue * $this->secretNumber;
			echo "Salajane on " .$this ->secretNumber = 10 ." ja avalik on ".$this ->publicNumber = 5;
		}//konstruktor lõppeb
		
		function __destruct(){
			echo " class on valmis ja lõpetas";
		}//destructor lõppeb
		
		public function showValues(){
			echo " VÄGA Salajane on ".$this ->secretNumber;
			$this->tellSecret();
		}
		private function tellSecret(){
			echo " näidis class on peaaegu valmis";			
		}
	}//class lõppeb















?>