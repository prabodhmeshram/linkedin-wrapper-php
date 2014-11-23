<?php
require("../api/linkedin.php");

$sKey = '';
$sSecret = '';
$sRedirectURL = '';
$oLN = new LinkedIn($sKey,$sSecret,$sRedirectURL);

if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
	var_dump($_GET['code']); exit;
    $oLN->getAccessToken($_GET['code']);
} else { 
	$oLN->getAuthorizationCode();
 }