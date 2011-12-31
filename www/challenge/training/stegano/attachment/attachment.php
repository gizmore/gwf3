<?php
chdir('../../../../');
require_once '../gwf3.class.php';
$gwf = new GWF3(getcwd(), array(
		'website_init' => true,
		'autoload_modules' => true,
		'load_module' => false,
		'get_user' => true,
//		'config_path' => 'protected/config.php',
//		'logging_path' => 'protected/logs',
		'do_logging' => true,
		'blocking' => true,
		'no_session' => false,
		'store_last_url' => true,
		'ignore_user_abort' => true,
));
//GWF_Session::start();
//GWF_Language::init();
//GWF_HTML::init();
$wechall = GWF_Module::loadModuleDB('WeChall');

require_once GWF_CORE_PATH.'module/WeChall/WC_CryptoChall.php';

$jpg_path = 'challenge/training/stegano/attachment/the.jpg';
$jpg_file = file_get_contents($jpg_path);

$solution = WC_CryptoChall::generateSolution('YouLikeAttachmentEh', true, false);

$zip_path = GWF_WWW_PATH.'temp/steganoattach/'.GWF_Session::getSessID().'.zip';
$zip = new GWF_ZipArchive();
if (false === $zip->open($zip_path, GWF_ZipArchive::CREATE)) {
	die('zip error 1');
}
if (false === $zip->addFromString('solution.txt', $solution)) {
	die('zip error 2');
}
if (false === $zip->close()) {
	die('zip error 3');
}

$jpg_file .= file_get_contents($zip_path);

unlink($zip_path);

header('Content-Type: image/jpeg');
echo $jpg_file;

die();
?>