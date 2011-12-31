<?php
require 'checkit.php'; # required to check your solution/injection

chdir('../../'); # chroot to web root
define('GWF_PAGE_TITLE', 'Yourself PHP'); # Wrapper hack
require_once('challenge/html_head.php'); # output start of website

# Get the challenge
if (false === ($chall = WC_Challenge::getByTitle('Yourself PHP'))) {
	$chall = WC_Challenge::dummyChallenge('Yourself PHP', 4, 'challenge/yourself_php/index.php', false);
}
# And display the header
$chall->showHeader();

# Show mission box (translated)
echo GWF_Box::box($chall->lang('mission_i', array('index.php?highlight=christmas')), $chall->lang('mission_t'));

# Check your injection and fix the hole by silently applying htmlsepcialchars to the vuln input.
if (phpself_checkit())
{
	$chall->onChallengeSolved(GWF_Session::getUserID());
}

# Show this file as highlighted sourcecode, if desired
if ('christmas' === Common::getGetString('highlight'))
{
	$msg = file_get_contents('challenge/yourself_php/index.php');
	$msg = '['.'code=php title=index.php]'.$msg.'['.'/code]';
	echo GWF_Box::box(GWF_Message::display($msg));
}



# __This is the challenge:
if (isset($_POST['username']))
{
	echo GWF_Box::box(sprintf("Well done %s, you entered your username. But this is <b>not</b> what you need to do.", htmlspecialchars(Common::getPostString('username'))));
}
echo '<div class="box box_c">'.PHP_EOL;
echo sprintf('<form action="%s" method="post">', $_SERVER['PHP_SELF']).PHP_EOL;
echo sprintf('<div>%s</div>', GWF_CSRF::hiddenForm('phpself')).PHP_EOL;
echo sprintf('<div>Username:<input type="text" name="username" value="" /></div>').PHP_EOL;
echo sprintf('<div><input type="submit" name="deadcode" value="Submit" /></div>').PHP_EOL;
echo sprintf('</form>').PHP_EOL;
echo '</div>'.PHP_EOL;
# __End of challenge



# Print Challenge Footer
echo $chall->copyrightFooter();
# Print end of website
require_once('challenge/html_foot.php');
?>