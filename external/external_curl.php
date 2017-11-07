<?php 
$json_return = array(
	'is_success' => false
);
$data = $_GET;

$post_fields = array();
foreach( $data as $key => $value ){
	$post_fields[$key] = $value;
}

$ch  = curl_init();
$url = 'http://holisticwebpresencecrm.com/external_requests/ajax_post_register_leads';
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close($ch);

/*
$ch  = curl_init();
$url = 'http://holisticwebpresencecrm.com/beta/beta_external_requests/ajax_post_register_leads';
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);

curl_close($ch);
*/

if ($server_output == "OK") { 
	$json_return['is_success'] = true;
}

echo json_encode($json_return);