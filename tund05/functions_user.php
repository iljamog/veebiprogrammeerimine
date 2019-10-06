<?php
  function signUp($name, $surname, $email, $gender, $birthDate, $password){
	  $notice = null;
	  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?,?,?,?,?,?)");
	  echo $conn->error;
	  
	  //valmistame parooli salvestamiseks ette
      $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	  $pwdhash = password_hash($password,PASSWORD_BCRYPT, $options );
	  
	  $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	  
	  if($stmt->execute()){
		  $notice = "  Uue kasutaja salvestamine õnnestus!";
	  } else {
		  $notice = "  Kasutaja salvestamisel tekkis tehniline viga: " .$stmt->error;
	  }
	  
	  $stmt->close();
	  $conn->close();
	  return $notice;
  }
	function signIn($email, $password){
		
		//parooli õigsust kontrollib
		//if(password_verify($password, $passwordFromDB))
		$notice = null;
		$firstName = null;
		$lastName= null;
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT email, password FROM vpusers WHERE email='$email'");
		$stmt->bind_result($email,$passwordFromDB);
		echo $conn->error;
		$stmt->execute();
		
		
		if($stmt->fetch()){
			if(password_verify($password, $passwordFromDB)){
				$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
				$stmt = $conn->prepare("SELECT firstname, lastname FROM vpusers WHERE email='$email'");
				$stmt->bind_result($firstName,$lastName);
				echo $conn->error;
				$stmt->execute();
				if($stmt->fetch()){
					$notice .="<br><br><b>Tere ".$firstName ." ".$lastName ."!</b>";
				}
				$notice .= "<br><br><b>Sisselogimine edukas!</b>";
				echo "<script type='text/javascript'>alert(\"$notice\");</script>";
				header('Location: page.php');
				
			} else {
				$notice = "<br><br><b>Sisselogimine ebaõnnestus, palun korrake tegevust!</b>";
			}
			
		}
				
	
		
		$stmt->close();
		$conn->close();
		return $notice;
		

	} 
?>