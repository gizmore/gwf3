<?php
if (false === ($user = GWF_Session::getUser()))
{
	return '';
}

$mo = Common::getGet('mo');
$me = Common::getGet('me');

echo '<nav>'.PHP_EOL;
echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo WC_HTML::button('btn_linked_sites', GWF_WEB_ROOT.'linked_sites', $me==='LinkedSites');
echo WC_HTML::button('btn_warboxes', GWF_WEB_ROOT.'warboxes', $me==='Warbox');
echo WC_HTML::button('btn_view_profile', GWF_WEB_ROOT.'profile/'.$user->urlencode('user_name'));
echo WC_HTML::button('btn_your_stats', GWF_WEB_ROOT.'stats/'.$user->urlencode('user_name'));
echo WC_HTML::button('btn_delete_account', GWF_WEB_ROOT.'account/delete', $mo==='Account'&&$me==='Delete');
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo WC_HTML::button('btn_wc_settings', GWF_WEB_ROOT.'wechall_settings', $me==='WeChallSettings');
echo WC_HTML::button('btn_account', GWF_WEB_ROOT.'account', $mo==='Account'&&$me==='Form');
echo WC_HTML::button('btn_pm_settings', GWF_WEB_ROOT.'pm/options', $mo==='PM'&&$me==='Options');
echo WC_HTML::button('btn_forum_settings', GWF_WEB_ROOT.'forum/options', $mo==='Forum'&&$me==='Options');
echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;

echo '<div class="gwf_buttons_outer">'.PHP_EOL;
echo '<div class="gwf_buttons">'.PHP_EOL;
echo WC_HTML::button('btn_edit_profile', GWF_WEB_ROOT.'profile_settings', $mo==='Profile'&&$me==='Form');
echo WC_HTML::button('btn_view_groups', GWF_WEB_ROOT.'my_groups');
echo WC_HTML::button('btn_guestbook', GWF_WEB_ROOT.'index.php?mo=WeChall&me=CreateGB', $mo==='Guestbook'||$me==='CreateGB');
#echo WC_HTML::button('btn_helpdesk', GWF_WEB_ROOT.'helpdesk');
echo WC_HTML::button('btn_hackerspace', GWF_WEB_ROOT.'places', $mo==='Profile'&&$me==='Places');

echo '</div>'.PHP_EOL;
echo '</div>'.PHP_EOL;
echo '</nav>'.PHP_EOL;
?>
