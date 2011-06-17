<?
# Only allow these ID's
$whitelist = array(1, 2, 3);

# if show is not set die with error.
if (false === ($show = isset($_GET['show']) ? $_GET['show'] : false)) {
	die('MISSING PARAMETER; USE foo.bar?show=[1-3]');
}
# check if get var is sane (is it in whitelist ?)
elseif (in_array($show, $whitelist))
{
	$query = "SELECT 1 FROM `table` WHERE `id`=$show";
	echo 'Query: '.htmlspecialchars($query, ENT_QUOTES).'<br/>';
	die('SHOWING NUMBER '.htmlspecialchars($show, ENT_QUOTES));
}
else # Not in whitelist !
{
	die('HACKER NONONO');
}
?>