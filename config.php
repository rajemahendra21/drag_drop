<?php header('P3P:CP="CAO IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
//header('p3p: CP="NOI ADM DEV PSAi COM NAV OUR OTR STP IND DEM"');
//header('P3P: CP="CAO PSA OUR"');

@session_start();

define("BASEURL",   "http://aeonit.name/micromax_doodles/"); 
define("ASSETS",   "http://aeonit.name/micromax_doodles/assets/"); 
define("PAGETITLE", "Micromax Doodles"); 

// Database Config 
define("DB_HOST", "localhost"); 
define("DB_USER", "aeonitn"); 
define("DB_PASS", "rw9lsDBVtj2sCz5");
define("DB_NAME", "aeonitn_micromax_doodles");


// FB Config
define("APPID",     	"152303808299125"); 
define("APPSECRET", 	"31fd64f3f00ec7aac8d2f17170409b79"); 
define("APPNAMESPACE", 	"micromax_doodles"); 
define("PAGENAME",  	"Aeontest"); 

define("TABPATH", "https://www.facebook.com/".PAGENAME."?sk=app_".APPID); 
define("APPURL",  BASEURL."channel.html"); 

// Define Date Time
date_default_timezone_set('Asia/Calcutta');


// ************
include_once "includes/src/facebook.php";

$facebook = new Facebook(array(
    'appId'  => APPID,
    'secret' => APPSECRET
));



?>