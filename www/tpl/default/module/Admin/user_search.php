<?php
# Form
echo $tVars['form'];

# Action?
if (!$tVars['searched'])
{
}
elseif ($tVars['hits'] === 0)
{
	echo GWF_HTML::err('ERR_SEARCH_NO_MATCH', array(GWF_HTML::display($tVars['term'])));
//	$raw_body = sprintf('<tr><td colspan="5"></td></tr>', GWF_HTML::lang('no_math', GWF_HTML::display($tVars['term'])));
}
else
{
	echo $tVars['pagemenu'];
	
	$headers = array(
		array($tLang->lang('th_userid'), 'user_id'),
		array($tLang->lang('th_country'), 'user_countryid'),
		array($tLang->lang('th_user_name'), 'user_name'),
		array($tLang->lang('th_regdate'), 'user_regdate'),
		array($tLang->lang('th_email'), 'user_email'),
		array($tLang->lang('th_birthdate'), 'user_birthdate'),
		array($tLang->lang('th_regip'), 'user_regip'),
		array($tLang->lang('th_lastactivity'), 'user_lastactivity')
	);
	
	echo GWF_Table::start();
	echo GWF_Table::displayHeaders1($headers, $tVars['sort_url']);
	foreach ($tVars['users'] as $user)
	{
		$href = Module_Admin::getUserEditURL($user->getID());
		
		echo GWF_Table::rowStart();
		echo '<td>'.GWF_HTML::anchor($href, $user->getID()).'</td>';
		echo sprintf('<td><a href="%s">%s</a></td>', $href, $user->displayCountryFlag());
		echo '<td>'.GWF_HTML::anchor($href, $user->display('user_name')).'</td>';
		echo '<td>'.GWF_HTML::anchor($href, GWF_Time::displayDate($user->getVar('user_regdate'))).'</td>';
		echo '<td>'.GWF_HTML::anchor($href, $user->display('user_email')).'</td>';
		echo '<td>'.GWF_HTML::anchor($href, GWF_Time::displayDate($user->getVar('user_birthdate'))).'</td>';
		echo '<td>'.GWF_HTML::anchor($href, GWF_IP6::displayIP($user->getVar('user_regip'), GWF_IP_EXACT)).'</td>';
		echo '<td>'.GWF_HTML::anchor($href, GWF_Time::displayAgeTS($user->getVar('user_lastactivity'))).'</td>';
		echo GWF_Table::rowEnd();
	}
	echo '</table>';
}
?>