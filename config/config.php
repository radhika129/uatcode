<?php

ob_start();
session_start();

defined("DS") ? null : define("DS",DIRECTORY_SEPARATOR);

defined("DB_HOST") ? null : define("DB_HOST","localhost");
//defined("DB_HOST") ? null : define("DB_HOST","localhost");
//defined("DB_USER") ? null : define("DB_USER","root");
defined("DB_USER") ? null : define("DB_USER","root");
defined("DB_PASSWORD") ? null : define("DB_PASSWORD","");
//defined("DB_PASSWORD") ? null : define("DB_PASSWORD","Dev12345");
//defined("DB_NAME") ? null : define("DB_NAME","emart");
defined("DB_NAME") ? null : define("DB_NAME","radhika");

// To Accessing End Point From Root Directory
defined("DOMAIN") ? null : define("DOMAIN","http://localhost/dev");

// For App Name
defined("APP") ? null : define("APP","UatCode");

// For Moving Two directory for seller Panel UI Screens
defined("SELLER_TO_ROOT") ? null : define("SELLER_TO_ROOT","..".DS."..");

defined("UPLOAD_DIRECTORY") ? null : define("UPLOAD_DIRECTORY",__DIR__.DS."..".DS);

defined("UPLOAD_DIRECTORY_PROFILE") ? null : define("UPLOAD_DIRECTORY_PROFILE",__DIR__.DS."..".DS."images".DS."sellers".DS);

defined("UPLOAD_DIRECTORY_CATALOGUE") ? null : define("UPLOAD_DIRECTORY_CATALOGUE",__DIR__.DS."..".DS."images".DS."catalogues".DS);

defined("UPLOAD_DIRECTORY_PRODUCTS") ? null : define("UPLOAD_DIRECTORY_PRODUCTS",__DIR__.DS."..".DS."images".DS."products".DS);

defined("UPLOAD_DIRECTORY_GST") ? null : define("UPLOAD_DIRECTORY_GST",__DIR__.DS."..".DS."images".DS."gst".DS);

defined("UPLOAD_DIRECTORY_PANCARD") ? null : define("UPLOAD_DIRECTORY_PANCARD",__DIR__.DS."..".DS."images".DS."pancards".DS);

defined("UPLOAD_DIRECTORY_ADDRESSPROOF") ? null : define("UPLOAD_DIRECTORY_ADDRESSPROOF",__DIR__.DS."..".DS."images".DS."addressproofs".DS);

defined("UPLOAD_DIRECTORY_CHEQUE") ? null : define("UPLOAD_DIRECTORY_CHEQUE",__DIR__.DS."..".DS."images".DS."cheques".DS);


//SMS GATE WAY INFORMATION
defined("KEY") ? null : define("KEY","35F7DF4C8D9D3F");
defined("SENDER") ? null : define("SENDER","EASYMS");
defined("SMS_URL") ? null : define("SMS_URL","https://login.easywaysms.com/app/smsapi/index.php");

//PAYMENT GATEWAY INFORMATION
defined("SECREATKEY") ? null : define("SECREATKEY","e16b50357d2fa3971bd0ffdd9708f9e330cef047");
defined("APPID") ? null : define("APPID","387161a63257ae89517b9817561783");


$connection=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
require_once("functions.php");
?>
