<?php
### This is wechall html_foot!


if(defined('WC_HTML_HEAD__DEFINED')) {
	return;
}
define('WC_HTML_HEAD__DEFINED', true);
?>
</div>
</div>
<div class="cb"></div>
<?php #if (WC_HTML::wantFooter()) { echo '<div id="wc_footersp"></div>'; } ?>
<?php echo WC_HTML::displayFooter(); ?>
<div id="wc_profile_slide" ></div>
<?php GWF_Session::commit(); ?>
<?php echo '</body>'.PHP_EOL; ?>
<?php echo '</html>'.PHP_EOL; ?>
