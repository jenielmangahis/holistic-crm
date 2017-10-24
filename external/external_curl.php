<?php 
$json_return = array(
	'is_success' => false
);

$data     = $_POST;
$data_get = $_GET;

$post_fields = array();
foreach( $_GET as $key => $value ){
	$post_fields[$key] = $value;
}

$data_json_encode  = json_encode($post_fields);
$data_http_b_query = http_build_query($post_fields, '', '&');

$ch  = curl_init();
$url = 'http://holisticwebpresencecrm.com/external_requests/ajax_register_leads';

/*
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$post_fields);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
*/

curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_http_b_query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$server_output = curl_exec ($ch);

if($server_output === false) {
    echo 'Curl error: ' . curl_error($ch);
}

curl_close($ch);

if ($server_output == "OK") { 
	$json_return['is_success'] = true;
}

echo json_encode($json_return);