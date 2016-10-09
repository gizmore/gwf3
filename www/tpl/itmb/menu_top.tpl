<div id="topmenu">
		{* Both *}
		<a href="{$root}news">News{GWF_Notice::getUnreadNews($user)}</a>
		<a href="{$root}contact">Contact</a>
		
		{* Member *}
		{if $user->isLoggedIn()}
		<a href="{$root}account">Account</a>
		{if $user->isStaff()}
		<a href="{$root}index.php?mo=Audit&amp;me=Logs">Replays</a>
		{/if}
		{if $user->isAdmin()}
		<a href="{$root}nanny">Admin</a>
		{/if}
		<li><a href="{$root}logout">Logout</a>[<a href="{$root}account">{$user->display('user_name')}</a>]
		{* Guest *}
		{else}
		<a href="{$root}login">Login</a>
		<a href="{$root}register">Register</a>
		{/if}
		
	</ul>
</div>
