<?php
# fake a http request

ini_set('display_errors', 1);
error_reporting(E_ALL);

$json = json_decode($_SERVER['argv'][1], true);
$gwffile = $_SERVER['argv'][2];

foreach(array('_SERVER', '_GET', '_POST', '_REQUEST', '_COOKIE') as $k)
{
	${$k} = $json[$k];
}

$_REQUEST_HEADER = $json['header'];
global $_REQUEST_HEADER;

$code = 0;

try
{
	ob_start();
	require_once $gwffile;
	$output = ob_get_contents();
	ob_end_clean();
}
catch (Exception $e)
{
	http_response_code(500);
	$output = htmlspecialchars($e);
	$code = 1;
}

$header = GWF_HTTPHeader::getResponseHeaders();

echo json_encode(array(
	'header' => $header,
	'output' => $output,
	'status' => http_response_code()
));
die($code);
