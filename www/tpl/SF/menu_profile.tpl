{if $user->isLoggedIn()}
<p class="fl">
	Hi {$user->displayProfileLink()}; 
	unseen: 
	<a href="{$root}pm">MSG's: {GWF_Notice::getUnreadPM($user)}</a>,
	<a href="{$root}news">News: {GWF_Notice::getUnreadNews($user)}</a>, 
	<a href="{$root}forum">Forum: {GWF_Notice::getUnreadForum($user, true)}</a>, 
	<a href="{$root}links">Links{GWF_Notice::getUnreadLinks($user)}</a>
	<a href="{$root}chall">Challenges: {GWF_Notice::getUnreadChallenges($user)}</a>
	<a href="{$root}pagebuilder/news">Articles: {GWF_Notice::getUnreadPageBuilder($user)}</a>
	<a href="{$root}comments/news">Comments: {GWF_Notice::getUnreadComments($user)}</a>
	<p class="fr">Last Login: <span class="color">{GWF_Time::displayTimestamp($user->getVar('user_lastlogin'))}</span></p>
</p>
{else}
{GWF_Module::loadModuleDB('Login', true, true)->getMethod('Form')->setTemplate('shortlogin.tpl')->execute()}
{/if}

<p class="fr" style="width: auto;">
	<a href="{$SF->getIndex('print')}print"><img src="{$root}img/SF/printer.png" alt="Druckansicht" title="Druckansicht"></a>
	<a href="{$SF->getIndex('plain')}plain"><img src="{$root}img/SF/paper.png" alt="HTML-Quelltext" title="Quelltext anzeigen"></a>
	<a href="de/"><img src="{$root}img/{$iconset}/country/Germany.png" alt="[DE]" title="{$SF->lang('change_language')}"></a>
	<a href="en/"><img src="{$root}img/{$iconset}/country/UnitedStates.png" alt="[EN]" title="{$SF->lang('change_language')}"></a>
</p>
