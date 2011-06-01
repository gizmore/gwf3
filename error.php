<?php
# Time measurement
$t = microtime(true);

# Include the core (always a good and safe idea)
require_once 'inc/_gwf_include.php';

# Init core for http/html
GWF_Website::init(dirname(__FILE__));

GWF_Module::autoloadModules();

# Get the error page
$errors = array(403, 404);
$realcode = Common::getGetInt('code', 0);
$code =  in_array($realcode, $errors, true) ? $realcode : 0;

if ($realcode === 404) {
	gwf_error_404_mail();
}

$page = GWF_Template::templatePHPMain(sprintf("%03d.php", $code), array(
	'code' => $realcode,
	'file' => htmlspecialchars($_SERVER['REQUEST_URI']),
));

# Commit Session
GWF_Session::commit(false);

# Display Page
echo GWF_Website::displayPage($page, GWF_DebugInfo::getTimings($t));

function gwf_error_404_mail()
{
	$blacklist = array(
	);
	$pagename = $_SERVER['REQUEST_URI'];
	if (in_array($pagename, $blacklist, true)) {
		return;
	}
	$mail = new GWF_Mail();
	$mail->setSender(GWF_BOT_EMAIL);
	$mail->setReceiver(GWF_ADMIN_EMAIL);
	$mail->setSubject(GWF_SITENAME.': 404 Error');
	$mail->setBody(sprintf('The page %s threw a 404 error.', $pagename));
	$mail->sendAsText();
}
?>