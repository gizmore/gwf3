<?php
$headers = array(
	array($tLang->lang('th_site_name'), 'userhist_sid'),
	array($tLang->lang('th_userhist_percent'), 'userhist_percent'),
	array($tLang->lang('th_userhist_date'), 'userhist_date'),
	array($tLang->lang('th_userhist_comment')),
);

$args = array($tVars['duname']);
echo GWF_Box::box($tLang->lang('pi_texthis', $args), $tLang->lang('pt_texthis', $args));

echo $tVars['page_menu'];

echo '<table>'.PHP_EOL;
echo GWF_Table::displayHeaders2($headers, $tVars['sort_url']);

//$sitecache = array();

$user = $tVars['user']; $user instanceof GWF_User;
$data = $user->getUserData();
$priv = isset($data['WC_PRIV_HIST']);
$unknown = $priv === true ? WC_HTML::lang('unknown') : '';

foreach ($tVars['data'] as $row)
{
	$row instanceof WC_HistoryUser;
	
//	$sid = $row->getVar('userhist_sid');
//	if (!(isset($sitecache[$sid]))) {
//		$sitecache[$sid] = WC_Site::getByID($sid);
//	}
	
	echo GWF_Table::rowStart();
	echo sprintf('<td>%s</td>', $row->getSite()->displayName()).PHP_EOL;
	echo sprintf('<td class="gwf_num">%s</td>', $row->displayPercent());
	echo sprintf('<td class="gwf_date">%s</td>', ($priv === true ? $unknown : $row->displayDate()) );
	echo sprintf('<td>%s</td>', $row->displayComment());
	echo GWF_Table::rowEnd();
}
echo '</table>'.PHP_EOL;

echo $tVars['page_menu'];
?>