<?php

/**
* Wrapper Class for LinkedIn API
*
* @author : Prabodh Meshram <prabodh.mehsram7@gmail.com>
*           2014-11-23 : 15:34
*/

class LinkedIn {

	//URI segments
	CONST AUTH_URL  = "https://www.linkedin.com/";
	CONST OAUTH_URI = "uas/oauth2/";
	CONST AUTHORIZATION = "authorization";


	CONST SCOPE = "r_basicprofile r_emailaddress"; // Need to Move in Configuration File
	// CONST 


	private $sAPI_KEY;
	private $sAPI_SECRET;
	private $sRedirectURI;

	public function __construct($sApiKey,$sApiSecret,$sRedirectURI){
		$this->sAPI_KEY 	= $sApiKey;
		$this->sAPI_SECRET  = $sApiSecret;
		$this->sRedirectURI = $sRedirectURI;
	}

	//Todo :: Need to make API request using Curl Request
	private function curlRequest(){

	}

	public function getAccessTokenForAuthCode($code){
		
		$params = array(
        'grant_type' => 'authorization_code',
        'client_id' => $this->sAPI_KEY,
        'client_secret' => $this->sAPI_SECRET,
        'code' => $code,
        'redirect_uri' => $this->sRedirectURI,
    	);
     
	    // Access Token request
	    $url = self::AUTH_URL . self::OAUTH_URI . self::ACCESS_TOKEN . '?' . http_build_query($params);
	     
	    // Tell streams to make a POST request
	    $context = stream_context_create(
	        array('http' => 
	            array('method' => 'POST',
	            )
	        )
	    );
	 
	    // Retrieve access token information
	    $response = file_get_contents($url, false, $context);
	 
	    // Native PHP object, please
	    $token = json_decode($response);
	    var_dump($token);
	    return $token;
	}

	public function getAuthorizationCode(){
		
		$params = array(
        'response_type' => 'code',
        'client_id' => $this->sAPI_KEY,
        'scope' => self::SCOPE, // Need to take from config.php
        'state' => uniqid('', true), // unique long string
        'redirect_uri' => $this->sRedirectURI,
    	);

    	$url = self::AUTH_URL.self::OAUTH_URI.self::AUTHORIZATION."?". http_build_query($params);
     
	    // Needed to identify request when it returns to us
	    $_SESSION['state'] = $params['state'];
	 
	    // Redirect user to authenticate
	    header("Location: $url");
	}


}