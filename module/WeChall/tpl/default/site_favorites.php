<?php
echo WC_HTML::accountButtons();

echo GWF_Box::box($tLang->lang('pi_sitefav'), $tLang->lang('pt_sitefav'));

echo '<div class="fl">'.PHP_EOL;


$txt_rem = $tLang->Lang('btn_remove');

$s = $tVars['favsites'];
if (count($s) > 0)
{
	$headers = array(
		array($tLang->lang('th_site_name'), 'site_name'),
		array($txt_rem),
	);
	echo '<table>';
	echo GWF_Table::displayHeaders1($headers);
	foreach ($s as $site)
	{
		$href_rem = GWF_WEB_ROOT.'favorite_sites/remove/'.$site->getVar('site_id');
		echo GWF_Table::rowStart();
		echo sprintf('<td><a href="%s">%s</a></td>', $site->getURL(), $site->displayName());
		echo sprintf('<td>%s</td>', GWF_Button::generic($txt_rem, $href_rem));
		echo GWF_Table::rowEnd();
	}
	echo '</table>';
}
echo $tVars['form'];

echo '</div>'.PHP_EOL;

echo '<div class="oa">'.PHP_EOL;

$fc = $tVars['favcats'];

if (count($fc) > 0)
{
	$headers = array(
		array($tLang->lang('th_cat'), 'wcfc_cat'),
		array($txt_rem),
	);
	echo GWF_Table::start();
	echo GWF_Table::displayHeaders1($headers, '');
	foreach ($fc as $cat)
	{
		$href_rem = GWF_WEB_ROOT.'index.php?mo=WeChall&me=WeChallSettings&remcat='.urlencode($cat);
		echo GWF_Table::rowStart();
		echo sprintf('<td>%s</td>', htmlspecialchars($cat));
		echo sprintf('<td>%s</td>', GWF_Button::generic($txt_rem, $href_rem));
		echo GWF_Table::rowEnd();
	}
	echo GWF_Table::end();
}

echo $tVars['form_cat'];

echo '</div>'.PHP_EOL;
echo '<div class="cb"></div>'.PHP_EOL;
?>