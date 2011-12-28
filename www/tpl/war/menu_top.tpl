<div class="gwf3_top">
	<div class="fl">
		<h1>GWF v{$smarty.const.GWF_CORE_VERSION}</h1>
	</div>
	<div class="fl">
{*		<p>{$gwff->module_Heart_beat()}</p> *}
	</div>
	<div class="cl"></div>
</div>

<div id="topmenu">
	<ul>
		{* Both *}
{*		<li><a href="{$root}news">News{GWF_Notice::getUnreadNews($user)}</a></li> *}
		
		{* Member *}
		{if $user->isLoggedIn()}
		<li><a href="{$root}account">Account</a></li>
		{if $user->isStaff()}
		<li><a href="{$root}index.php?mo=Audit&amp;me=Logs">Replays</a></li>
		{/if}
		{if $user->isAdmin()}
		<li><a href="{$root}nanny">Admin</a></li>
		{/if}
		<li><a href="{$root}logout">Logout</a>[<a href="{$root}account">{$user->display('user_name')}</a>]</li>
		{* Guest *}
		{else}
		<li><a href="{$root}login">Login</a></li>
		<li><a href="{$root}register">Register</a></li>
		{/if}
		
	</ul>
</div>
