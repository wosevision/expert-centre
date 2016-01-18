<?php

const KEY = "gznwwcp0";
const SECRET = "6b0b2bbf-3df9-4fa2-b5c0-251f1d1db2ee";
const ID = "4844";

function getAccessToken($key, $secret, $uri){
	$consumer_key = urlencode($key);
	$consumer_secret = urlencode($secret);
	$req_url = urlencode($uri);

	$ch = curl_init("https://public-api.expertfile.com/v1/" . ID . "/accessToken?oauth_consumer_key=" . $consumer_key . "&oauth_consumer_secret=" . $consumer_secret . "&request_uri=" . $req_url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$responsefromwcf = curl_exec($ch);

	curl_close($ch);

	$responseData = json_decode($responsefromwcf);

	if($responseData->success){
		return $responseData->data->authorization;
	}
	else{
		return $responseData->msg;
	}
}
   
function getResults(){
	$consumer_key = KEY;
	$consumer_secret = SECRET;
	$req_url = 'https://public-api.expertfile.com/v1/organization/' . ID . '/search';

	$oauth = getAccessToken($consumer_key,$consumer_secret,$req_url);

	$parameters = array(
	'fields' => urlencode('user:firstname,user:lastname,user:job_title,tagline,user:location:city,user:location:state,user:location:country'),
	'keywords' => urlencode(''),
	'location' => urlencode(''),
	'industry' => urlencode(''),
	'portfolio' => urlencode(''),
	'availability' => urlencode(''),
	'fee_min' => urlencode(''),
	'fee_max' => urlencode(''),
	'page_number' => urlencode(1),
	'page_size' => 99999,
	'keyword' => urlencode(''),
	);

	$req_url = $req_url;
	$params = http_build_query($oauth) . '&' .http_build_query($parameters);

	$ch = curl_init($req_url . '?' . $params);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$responsefromwcf = curl_exec($ch);

	curl_close($ch);

	$responseData = json_decode($responsefromwcf);

	return $responseData;
}

$responseData = getResults($currPage, $keyword, $availability, $industry);

if($responseData->success){
	echo json_encode($responseData->speakers);
}