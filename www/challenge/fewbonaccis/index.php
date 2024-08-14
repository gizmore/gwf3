<?php
chdir('../../');
define('GWF_PAGE_TITLE', "Few Bonaccis");
require_once('challenge/html_head.php');
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
    $chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 1, 'challenge/fewbonaccis/index.php', false);
}

$chall->showHeader();

if (isset($_POST['try']))
{
    require __DIR__ . '/try.php';
    if (trying())
    {
        $chall->onChallengeSolved();
    }
    else
    {
        echo GWF_HTML::error(GWF_PAGE_TITLE, $chall->lang('err_wrong'));
    }
}

$user = GWF_User::getStaticOrGuest();
$name = $user->isGuest() ? 'hacker' : $user->displayUsername();
$info = $chall->lang('info', array($name));
$title = $chall->lang('title');
echo GWF_Box::box($info, $title);

?>
<form method="post" action="?">
<input type="text" name="host" value="http://<?=$_SERVER['REMOTE_ADDR']?>/fib.php?n=" />
<input type="submit" name="try" value="TRY MICROSERVICE" />
</form>
<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
