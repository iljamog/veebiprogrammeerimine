<?php
  $pageHeaderHTML = "<!DOCTYPE html> \n";
  $pageHeaderHTML .= '<html lang="et">'. "\n";
  $pageHeaderHTML .='<style>body{background-color: ' .$_SESSION["mybgcolor"] .'; color: ' .$_SESSION["mytxtcolor"] .'} </style>';
  $pageHeaderHTML .= "<head> \n";
  $pageHeaderHTML .=  "\t" .'<meta charset="utf-8">' ."\n \t<title>" .$userName ." progeb veebi</title> \n";
  $pageHeaderHTML .= "</head>";
  echo $pageHeaderHTML;