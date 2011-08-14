<ol class="navi">
{if $user->isLoggedIn()}
	<li class="sec">
		<h2><a href="{$root}profile/{$user->display('user_name')}">[{$user->display('user_name')}]</a></h2>
		<ul>
			<li class="cat"><h2>Settings:</h2></li>
			<li class="cat"><h2><a href="{$root}account">Account</a></h2></li>
			<li class="cat"><h2><a href="{$root}profile_settings">Profile</a></h2></li>		
			<li class="cat"><h2><a href="{$root}forum/options">Forum</a></h2></li>		
			<li class="cat"><h2><a href="{$root}pm/options">PM</a></h2></li>		
		</ul>
	</li>
	{if $user->isAdmin()}{* Admin *}
	<li class="sec">
		<h2>[CMS]</h2>
		<ul>
			{$SF->displayNavi('left')}
		</ul>
	</li>
	<li class="sec">
		<h2><a href="{$root}nanny">[Admin]</a></h2>
		<ul>
			<li class="cat"><h2><a href="{$root}nanny">Admin</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Admin&amp;me=Users">Benutzer</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Admin&amp;me=Groups">Gruppen</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Admin&amp;me=LoginAs&amp;username=">Einloggen als</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=PageBuilder&amp;me=Admin">CMS</a></h2></li>
		</ul>
	</li>
	<li class="sec">
		<h2><a href="{$root}challs">[Wechall]</a></h2>
		<ul>
			<li class="cat"><h2><a href="{$root}challs">Challenges</a></h2></li>
			<li class="cat"><h2><a href="{$root}challenge">Challenge</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=WeChall&me=Admin">Admin</a></h2></li>
			<li class="cat"><h2><a href="{$root}linked_sites">Linked Sites</a></h2></li>
		</ul>
	{/if}
	<li class="sec">
		<h2><a href="{$root}links">[Modules]</a></h2>
		<ul>
			<li class="cat"><h2><a href="{$root}links">Links{$SF->getUnreadLinks($user)}</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Links&amp;me=Add&amp;tag=">Link hinzufügen</a></h2></li>
			<li class="cat"><h2><a href="{$root}forum">Forum{$SF->getUnreadForum($user)}</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Forum&amp;me=Unread">ungelesene</a></h2></li>
			<li class="cat"><h2><a href="{$root}pm">PM{$SF->getUnreadPM($user)}</a></h2></li>
			<li class="cat"><h2><a href="{$root}news">News{$SF->getUnreadNews($user)}</a></h2></li>
		</ul>
	</li>
	{if $user->isInGroupName(klasse)}
	<li class="sec"><h2><a href="{$root}Stundenplan">Stundenplan</a></h2></li>
	{/if}
	<li class="sec"><h2><a href="{$root}logout">Logout</a></h2></li>

{else}{* Guest *}
	<li class="sec"><h2><a href="{$root}news">News{$SF->getUnreadNews($user)}</a></h2></li>
	<li class="sec"><h2><a href="{$root}links">Links</a></h2></li>
	<li class="sec"><h2><a href="{$root}forum">Forum</a></h2></li>
	<li class="sec"><h2><a href="{$root}register">Register</a></h2></li>
	<li class="sec"><h2><a href="{$root}login">Login</a></h2></li>
{/if}

</ol>
