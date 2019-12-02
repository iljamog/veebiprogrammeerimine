  <?php
  if(!isset($_SESSION["userID"])){
  $_SESSION["mybgcolor"] = "#FFFFFF";
  $_SESSION["mytxtcolor"] = "#000000";
  $userName = "Sisselogimata kasutaja";
}
  $userName = $_SESSION["userFirstname"] ." " .$_SESSION["userLastname"];
  $pageHeaderHTML = "<!DOCTYPE html> \n";
  $pageHeaderHTML .= '<html lang="et">'. "\n";
  $pageHeaderHTML .= "<head> \n";
  $pageHeaderHTML .= "\t" .'<meta charset="utf-8">' ."\n \t<title>" .$userName ." progeb veebi</title> \n";
  $pageHeaderHTML .= "\t" ."<style> \n";
  $pageHeaderHTML .= "\t \t body{background-color: " .$_SESSION["mybgcolor"] ."; \n";
  $pageHeaderHTML .= "\t \t color: " .$_SESSION["mytxtcolor"] ."\n";
  $pageHeaderHTML .= "\t }";
  $pageHeaderHTML .= "</style> \n";
  $pageHeaderHTML .= $toScript;
  $pageHeaderHTML .= "</head>";
  echo $pageHeaderHTML;