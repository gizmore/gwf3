<div id="topmenu">
		{* Both *}
		<a href="{$root}news">News{GWF_Notice::getUnreadNews($user)}</a>
		<a href="{$root}contact">Contact</a>
		
		{* Member *}
		{if $user->isLoggedIn()}
		{if $user->isStaff()}
		{/if}
		{if $user->isAdmin()}
		<a href="{$root}nanny">Admin</a>
		{/if}
		<a href="{$root}logout">Logout</a>[<a href="{$root}account">{$user->display('user_name')}</a>]
		{* Guest *}
		{else}
		<a href="{$root}login">Login</a>
		<a href="{$root}register">Register</a>
		{/if}
		
	</ul>
</div>
