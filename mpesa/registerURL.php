<?php

$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
$credentials = base64_encode('gXf2JYhAjw6qizqavBjcXRGWJc9AGc0g:ZNY2QCnATtXUnuHh');
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials)); //setting a custom header
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$curl_response = curl_exec($curl);

$accessToken = json_decode($curl_response)->access_token;

$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';

$access_token = $accessToken; // check the mpesa_accesstoken.php file for this. No need to writing a new file here, just combine the code as in the tutorial.
$shortCode = '174379'; // provide the short code obtained from your test credentials

/* This two files are provided in the project. */
$confirmationUrl = 'https://51a94b9bfcc2.ngrok.io/phpmoney/confirmationURL.php'; // path to your confirmation url. can be IP address that is publicly accessible or a url
$validationUrl = 'https://51a94b9bfcc2.ngrok.io/phpmoney/validationURL.php'; // path to your validation url. can be IP address that is publicly accessible or a url



$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token)); //setting custom header


$curl_post_data = array(
    //Fill in the request parameters with valid values
    'ShortCode' => $shortCode,
    'ResponseType' => 'Confirmed',
    'ConfirmationURL' => $confirmationUrl,
    'ValidationURL' => $validationUrl
);

$data_string = json_encode($curl_post_data);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

$curl_response = curl_exec($curl);
print_r($curl_response);

echo $curl_response;
