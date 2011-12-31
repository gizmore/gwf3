<?php
chdir('../../');
define('GWF_PAGE_TITLE', 'Snake');
define('CHEAT_SNAKE_SCORE', 300000);
require_once('challenge/html_head.php');
if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE))) {
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 4, 'challenge/snake/index.php', false);
}
$chall->showHeader();

htmlTitleBox($chall->lang('title'), $chall->lang('info', array(CHEAT_SNAKE_SCORE, 'CGI_Highscore.php', 'http://snake.gizmore.org', 'http://snake.gizmore.org/CGI_Highscore.php')));

echo '<div class="box box_c">'.PHP_EOL;
echo '<applet code="SnakeApplet.class" archive="snake.jar?v=1.06" width="500" height="400"><param name="sessid" value="'.GWF_HTML::display(GWF_Session::getSessID()).'" ></param></applet>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
?>