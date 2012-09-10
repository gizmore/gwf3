<?php
# fake a http request

$json = json_decode($_SERVER['argv'][1]);
$gwffile = $json['config']['GWF']; # $_SERVER['argv'][2]; ?

foreach(array('_SERVER', '_GET', '_POST', '_REQUEST', '_COOKIE') as $k)
{
	$$k = $json[$k];
}

# TODO: fake request header
$json['header'];

try
{
	ob_start();
	require_once $gwffile;
	$output = ob_get_contents();
	ob_end_clean();
}
catch (Exception $e)
{
	# TODO
}

$header = GWF_HTTPHeader::getResponseHeaders();

echo json_encode(array(
	'header' => $header,
	'cookie' => NULL, #TODO
	'output' => $output,
	'status' => http_response_code()
));
die(0);
