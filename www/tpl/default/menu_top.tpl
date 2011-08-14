<div class="gwf3_top">
	<div class="fl">
		<h1>GWF v{$smarty.const.GWF_CORE_VERSION}</h1>
	</div>
	<div class="fl">
		<p>{$gwff->module_Heart_beat()}</p>
	</div>
	<div class="cl"></div>
</div>

<div class="gwf3_topmenu">
	<ul>
		{* Both *}
		<li><a href="{$root}news">News{$gwff->module_News_unread($user)}</a></li>
		<li><a href="{$root}about_gwf">About</a></li>
		
		{* Member *}
		{if $user->isLoggedIn()}
		<li><a href="{$root}links">Links{$gwff->module_Links_unread($user)}</a></li>
		<li><a href="{$root}forum">Forum{$gwff->module_Forum_unread($user)}</a></li>
		<li><a href="{$root}irc_chat">Chat</a></li>
		<li><a href="{$root}pm">PM{$gwff->module_PM_unread($user)}</a></li>
		<li><a href="{$root}account">Account</a></li>
		<li><a href="{$root}profile_settings">Profile</a></li>
		{if $user->isAdmin()}
		<li><a href="{$root}nanny">Admin</a></li>
		<li><a href="{$root}index.php?mo=PageBuilder&me=Admin">CMS</a></li>
		{/if}
		<li><a href="{$root}logout">Logout</a>[<a href="{$root}account">{$user->display('user_name')}</a>]</li>

		{* Guest *}
		{else}
		<li><a href="{$root}links">Links</a></li>
		<li><a href="{$root}forum">Forum</a></li>
		<li><a href="{$root}irc_chat">Chat</a></li>
		<li><a href="{$root}register">Register</a></li>
		<li><a href="{$root}login">Login</a></li>
		{/if}
		
	</ul>
</div>
