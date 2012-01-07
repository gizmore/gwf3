<div class="gwf3_top">
	<div class="fl">
		<h1>GWF v{$smarty.const.GWF_CORE_VERSION}</h1>
	</div>
	<div class="fl">
		<p>{GWF_Notice::getOnlineUsers()}</p>
	</div>
	<div class="cl"></div>
</div>

<div id="slay_np_header">
</div>

<div class="gwf3_topmenu">
	<ul>
		{* Both *}
		<li><a href="{$root}about_slaytags.html">About</a></li>
		<li>↷↷<a href="{$root}index.php?mo=Slaytags&amp;me=Main">Slaytags</a>↶↶</li>
		<li>↷↷<a href="{$root}index.php?mo=Slaytags&amp;me=Search">Tagsearches</a>↶↶</li>
		<li>↷↷<a href="{$root}index.php?mo=Slaytags&amp;me=Songs">All Songs</a>↶↶</li>
		{* Member *}
		{if $user->isLoggedIn()}
		<li>↷↷<a href="{$root}index.php?mo=Slaytags&amp;me=MyTags">MyTags</a>↶↶</li>
		<li>↷↷<a href="{$root}index.php?mo=Slaytags&amp;me=MyPlaylist">MyPlaylist</a>↶↶</li>
		<li><a href="{$root}pm">PM{GWF_Notice::getUnreadPM($user)}</a></li>
		<li><a href="{$root}account">Account</a></li>
		<li><a href="{$root}profile_settings">Profile</a></li>
		{if $user->isAdmin()}
		<li><a href="{$root}nanny">Admin</a></li>
		{/if}
		<li><a href="{$root}logout">Logout</a>[<a href="{$root}account">{$user->display('user_name')}</a>]</li>
		{* Guest *}
		{else}
		<li><a href="{$root}register">Register</a></li>
		<li><a href="{$root}login">Login</a></li>
		{/if}
	</ul>
</div>
