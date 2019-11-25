  <?php
  if(!isset($_SESSION["userID"])){
  $_SESSION["mybgcolor"] = "#FFFFFF";
  $_SESSION["mytxtcolor"] = "#000000";
  $userName = "Sisselogimata kasutaja";
}
  $pageHeaderHTML = "<!DOCTYPE html> \n";
  $pageHeaderHTML .= '<html lang="et">'. "\n";
  $pageHeaderHTML .= ' <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">' ."\n";
  $pageHeaderHTML .='<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">';
  $pageHeaderHTML .='<style>body{background-color: ' .$_SESSION["mybgcolor"] .'; color: ' .$_SESSION["mytxtcolor"] .'} </style>';
  $pageHeaderHTML .= "<head> \n";
  $pageHeaderHTML .=  "\t" .'<meta charset="utf-8">' ."\n \t<title>" .$userName ." progeb veebi</title> \n";
  $pageHeaderHTML .= "</head>";
  echo $pageHeaderHTML;
  ?>