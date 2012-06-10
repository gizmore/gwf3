<?php
# Higlighter Plain
if (isset($_GET['show']) && $_GET['show'] === 'source')
{
	header('Content-Type: text/plain; charset=utf8;');
	echo file_get_contents('index.php');
	die();
}

# Change dir to web root
chdir('../../../../../');

# Print the website header
define('GWF_PAGE_TITLE', 'Local File Inclusion');
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle('Training: PHP LFI'))) {
	$chall = WC_Challenge::dummyChallenge('Training: PHP LFI', 2, 'challenge/training/php/lfi/up/index.php', false);
}
$chall->showHeader();


# Highlighter BBCode
if (isset($_GET['highlight']) && $_GET['highlight'] === 'christmas')
{
	echo GWF_Message::display('[PHP]'.file_get_contents($_SERVER['SCRIPT_FILENAME']).'[/PHP]');
	require_once('challenge/html_foot.php');
	return;
}

###############################
### Here is your exploit :) ###
###############################
$code = '$filename = \'pages/\'.(isset($_GET["file"])?$_GET["file"]:"welcome").\'.html\';';
$code_emulate_pnb = '$filename = Common::substrUntil($filename, "\\0");'; # Emulate Poison Null Byte for PHP>=5.3.4
$code2 = 'include $filename;';
### End of exploit ###

# Show the mission box
$url = 'index.php?file=';
$ex = array('welcome', 'news', 'forums');
$showsrc1 = 'index.php?show=source';
$showsrc2 = 'index.php?highlight=christmas';
foreach ($ex as $i => $e) { $ex[$i] = htmlspecialchars($url.$e); }
echo GWF_Box::box($chall->lang('info', array(GWF_Message::display('[PHP]'.$code.PHP_EOL.$code2.'[/PHP]'), '../solution.php', $showsrc1, $showsrc2, $ex[0], $ex[1], $ex[2])), $chall->lang('title'));

# Execute the code, using eval.
GWF_Debug::setDieOnError(false);
GWF_Debug::setMailOnError(false);
eval($code.$code_emulate_pnb); # eval the first line

echo '<div class="box">'.PHP_EOL;
echo '<div class="box_t">'.$chall->lang('example_title').' ('.htmlspecialchars($filename).')'.'</div>'.PHP_EOL;
echo '<div class="box_c">'.PHP_EOL;
if (lfiIsSafeDir($filename) === true) { eval($code2); } # Eval the second line, when safe.
else { echo GWF_HTML::error('LFI', $chall->lang('err_basedir'), false); }
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;
GWF_Debug::setMailOnError(true);
GWF_Debug::setDieOnError(true);

# Show credits box
if (false !== ($minus = GWF_User::getByName('minus')))
{
	echo GWF_Box::box($chall->lang('credits', array($minus->displayProfileLink())));
}

# Show end of website
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');


### Safety first ###
function lfiIsSafeDir($filename)
{
	$valid = array(
		'pages',
		'pages/../..',
		'pages/..',
	);
	$d = dirname($filename);
	return in_array($d, $valid, true);
}
?>
