{if $user->isLoggedIn()}
<p style="float:left; vertical-align: middle; line-height: 25px; height: 25px;">
	Hi <a href="{$root}profile/{$user->display('user_name')}" title="{$user->display('user_name')}'S Profile">{$user->display('user_name')}</a>; 
	unseen: 
	<a href="{$root}pm">MSG's: {$SF->getUnreadPM($user)}</a>,
	<a href="{$root}news">News: {$SF->getUnreadNews($user)}</a>, 
	<a href="{$root}forum">Forum: {$SF->getUnreadForum($user, true)}</a>, 
	<a href="{$root}links">Links{$SF->getUnreadLinks($user)}</a>
	{*Answers: 3; Articles: 3, Changes: 0, *}  ; 
</p>
{else}
{$SF->getLoginForm()}
{/if}

<p style="float:right; vertical-align: middle; line-height: 25px; height: 25px; width: auto;">
{if $user->isLoggedIn()}
	Last Login: <span class="color">{GWF_Time::displayTimestamp($user->getVar('user_lastlogin'))}</span>
{/if}
	<a href="{$SF->getIndex('print')}print"><img src="{$root}img/SF/printer.png" alt="Druckansicht" title="Druckansicht"></a>
	<a href="{$SF->getIndex('plain')}plain"><img src="{$root}img/SF/paper.png" alt="HTML-Quelltext" title="Quelltext anzeigen"></a>
	<a href="de/"><img src="/tpl/{$SF->getDesign()}/images/German.png" alt="[DE]" title="{$SF->lang('change_language')}"></a>
	<a href="en/"><img src="/tpl/{$SF->getDesign()}/images/America.png" alt="[EN]" title="{$SF->lang('change_language')}"></a>
</p>