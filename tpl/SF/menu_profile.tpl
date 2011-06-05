{if $user->isLoggedIn()}
<span style="float:left; vertical-align: middle;">
	Hi <a href="{$root}profile/{$user->display('user_name')}" title="{$user->display('user_name')}'S Profile">{$user->display('user_name')}</a>; 
	unseen: 
	<a href="{$root}pm">MSG's: {$gwff->module_PM_unread($user)}</a>,
	<a href="{$root}news">News: {$gwff->module_News_unread($user)}</a>, 
	<a href="{$root}forum">Forum: {$gwff->module_Forum_unread($user, true)}</a>, 
	<a href="{$root}links">Links{$gwff->module_Links_unread($user)}</a>
	{*Answers: 3; Articles: 3, Changes: 0, *}  ; 
</span>
{else}

{$gwf->Module()->loadModuleDB('Login', true, true)->execute('Form')}

{/if}

<span style="float:right; vertical-align: middle;">
{if $user->isLoggedIn()}
	Last Login: <span class="color">{GWF_Time::displayTimestamp($user->getVar('user_lastlogin'))}</span>
{/if}
	<a href="{$root}de/"><img src="/templates/{$SF->design()}/images/German.png" alt="[DE]" title="{$SF->lang('change_language')}"></a>
	<a href="{$root}en/"><img src="/templates/{$SF->design()}/images/America.png" alt="[EN]" title="{$SF->lang('change_language')}"></a>
</span>