<?php
echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo GWF_Button::generic('ConvertDB', $tVars['href_convert']);
echo GWF_Button::generic('Fix Chall Tags', $tVars['href_chall_cache']);
echo GWF_Button::generic('Fix Site Tags', $tVars['href_sitetags']);
echo GWF_Button::generic('Recalc Everything', $tVars['href_recalc_all']);
echo GWF_Button::generic('Freeze User', $tVars['href_freeze']);
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;


$headers = array(
	array($tLang->lang('th_user_name'), 'user_name'),
	array($tLang->lang('th_site_name'), 'site_name'),
	array(),
);

echo $tVars['page_menu'];

echo GWF_Form::start($tVars['form_action']);
echo GWF_Table::start();
echo GWF_Table::displayHeaders2($headers, $tVars['sort_url']);
$unfreeze = $tLang->lang('btn_unfreeze');
foreach ($tVars['frozen'] as $row)
{
	$row instanceof WC_Freeze;
	$user = $row->getUser();
	$site = $row->getSite();
	echo GWF_Table::rowStart();
	echo GWF_Table::column($user->displayUsername());
	echo GWF_Table::column($site->displayName());
	echo GWF_Table::column(sprintf('<input type="submit" name="unfreeze[%s,%s]" value="%s" />', $user->getVar('user_id'), $site->getVar('site_id'), $unfreeze));
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
echo GWF_Form::end();

echo $tVars['page_menu'];

echo $tVars['form'];
?>