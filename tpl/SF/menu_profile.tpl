<span style="float:left; vertical-align: middle;">
{if $user->isLoggedIn()}
	Hi <a href="{$root}profile/{$user->display('user_name')}" title="{$user->display('user_name')}'S Profile">{$user->display('user_name')}</a>; 
	unseen: 
	<a href="{$root}pm">MSG's: {$gwff->module_PM_unread($user)}</a>,
	<a href="{$root}news">News: {$gwff->module_News_unread($user)}</a>, 
	<a href="{$root}forum">Forum: {$gwff->module_Forum_unread($user, true)}</a>, 
	<a href="{$root}links">Links{$gwff->module_Links_unread($user)}</a>,
	{*Answers: 3; Articles: 3, Changes: 0, *}  ; 
	
{else}
{include file='tpl/Form/login/shortlogin.tpl'}
{/if}
</span>
<span style="float:right; vertical-align: middle;">
{if $user->isLoggedIn()}
	Last Login: <span class="color">{GWF_Time::displayTimestamp($user->getVar('user_lastlogin'))}</span>
{/if}
	<a href="{$root}de/"><img src="/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/images/German.png" alt="[DE]" title="{$lang->lang('change_language')}"></a>
	<a href="{$root}en/"><img src="/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/images/America.png" alt="[EN]" title="{$lang->lang('change_language')}"></a>
</span>