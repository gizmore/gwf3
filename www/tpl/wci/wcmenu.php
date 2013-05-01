<nav id="wc_menu">
	<ul>
<?php
$module = Module_WeChall::instance();
echo WC_HTML::displayMenuLangSelect($module).PHP_EOL;
echo WC_HTML::displayMenuNews($module).PHP_EOL;
// echo WC_HTML::displayMenuAbout($module).PHP_EOL;
// echo WC_HTML::displayMenuLinks($module).PHP_EOL;
// echo WC_HTML::displayMenuSites($module).PHP_EOL;
// echo WC_HTML::displayMenuPapers($module).PHP_EOL;
// echo WC_HTML::displayMenuForum($module).PHP_EOL;
echo WC_HTML::displayMenuRankingNSC($module).PHP_EOL;
echo WC_HTML::displayMenuChallengesNSC($module).PHP_EOL;
// echo WC_HTML::displayMenuAccount($module).PHP_EOL;
// echo WC_HTML::displayMenuPM($module).PHP_EOL;
// echo WC_HTML::displayMenuStats($module).PHP_EOL;
// echo WC_HTML::displayMenuDownload($module).PHP_EOL;
// echo WC_HTML::displayMenuChat($module).PHP_EOL;
// echo WC_HTML::displayMenuGroups($module).PHP_EOL;
echo WC_HTML::displayMenuAdmin($module).PHP_EOL;
echo WC_HTML::displayMenuLogout($module).PHP_EOL;
?>
	</ul>
</nav>