<?php

 
if (!isset($_SERVER['HTTP_X_DV_SIGNATURE'])) { 
    echo 'Error: Signature not found'; 
    http_response_code(400);
    exit; 
} 
 
$data = file_get_contents('php://input'); 
 
$signature = hash_hmac('sha256', $data, '09951B72BEC383B85F0FAD4BB92F34B24DA39294'); 
if ($signature != $_SERVER['HTTP_X_DV_SIGNATURE']) { 
    echo 'Error: Signature is not valid'; 
    http_response_code(400);
    exit; 
} 

if(!empty($data))
{
  // $data = json_decode($data);
  //Token
  $params_token = array(
    "refresh_token" => "1000.7b3877758eee5d19902f66c591ef1563.df24ebfe89662ed0c0a16019cd3a47c2",
    "client_id" => "1000.09ODQ6CRGHXKVMSA0EHHWG29LJ9HPK",
    "client_secret" => "6e7e8c803f4ad6b0e089df99ea9336f36a4309b389",
    "grant_type" => "refresh_token"
  );
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://accounts.zoho.com/oauth/v2/token");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$params_token);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $server_output = curl_exec ($ch);
  curl_close ($ch);
  $result = json_decode($server_output, true);
  $access_token = $result['access_token'];

  //Insert Response
  $params = array(
    "Response" => $data,
  );
  $params = array("data" => $params);
  $params_string = json_encode($params);
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL,"https://creator.zoho.com/api/v2/denniscsanjuan/chatbuddyportal/form/test");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS,$params_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $headers = [
    "Authorization:Zoho-oauthtoken " . $access_token
  ];
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $server_output = curl_exec ($ch);
  curl_close ($ch);
}




?>