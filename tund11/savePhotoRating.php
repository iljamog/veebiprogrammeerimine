<?php
	//võtame vastu saadetud info
	$rating = $_REQUEST["rating"];
	
	$response = "Läks hästi, hinne: " .$rating * 2;
	echo $response;