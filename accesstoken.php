<?php
//mpesa keys
$consumerKey = "hWtjnypKDum8Rp3Vn7nnoGsJPajYfvDLV2RsZqHU6SR05wuj";
$ConsumerSecret = "RlAD0oL6TVfzBW5XINCDFXG09W8G2PmsIJkI1y90Q5yAD919ovvRTAC7IMzLYCJ3";
$access_token_url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
$headers = ['Content-Type:application/json; charset=utf8'];
$curl = curl_init($access_token_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $ConsumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
// echo $result;
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);
