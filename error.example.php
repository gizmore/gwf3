<?php
/**
 * This is an example how your error.php could look like!
 */
require_once 'gwf3.class.php';
$gwf = new GWF3(__FILE__, true, false);

$_GET['mo'] = 'GWF';
$_GET['me'] = 'Error';

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

# Display Page
echo $gwf->onDisplayPage($page);

# Commit Session
$gwf->onSessionCommit(false);

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