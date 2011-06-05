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
		<h2><a href="{$root}nanny">[Admin]</a></h2>
		<ul>
			<li class="cat"><h2><a href="{$root}nanny">Admin</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Admin&amp;me=Users">Benutzer</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Admin&amp;me=Groups">Gruppen</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=Admin&amp;me=LoginAs&amp;username=">Einloggen als</a></h2></li>
			<li class="cat"><h2><a href="{$root}index.php?mo=PageBuilder&amp;me=Admin">CMS</a></h2></li>
		</ul>
	</li>
	{/if}
	<li class="sec">
		<h2><a href="{$root}links">Links{$gwff->module_Links_unread($user)}</a></h2>
		<ul>
			<li class="cat"><h2><a href="{$root}index.php?mo=Links&amp;me=Add&amp;tag=">hinzufügen</a></h2></li>
		</ul>
	</li>
	<li class="sec">
		<h2><a href="{$root}forum">Forum{$gwff->module_Forum_unread($user)}</a></h2>
		<ul>
			<li class="cat"><h2><a href="{$root}index.php?mo=Forum&amp;me=Unread">ungelesene</a></h2></li>
		</ul>
			
	</li>
	<li class="sec"><h2><a href="{$root}pm">PM{$gwff->module_PM_unread($user)}</a></h2></li>
	<li class="sec"><h2><a href="{$root}news">News{$gwff->module_News_unread($user)}</a></h2></li>
	{if $user->isInGroupName(klasse)}
	<li class="sec"><h2><a href="{$root}Stundenplan">Stundenplan</a></h2></li>
	{/if}
	<li class="sec"><h2><a href="{$root}logout">Logout</a></h2></li>

{else}{* Guest *}
	<li class="sec"><h2><a href="{$root}news">News{$gwff->module_News_unread($user)}</a></h2></li>
	<li class="sec"><h2><a href="{$root}links">Links</a></h2></li>
	<li class="sec"><h2><a href="{$root}forum">Forum</a></h2></li>
	<li class="sec"><h2><a href="{$root}register">Register</a></h2></li>
	<li class="sec"><h2><a href="{$root}login">Login</a></h2></li>
{/if}
	<li class="sec">
		<a title="Designfarbe: Rot" href="{$root}?layoutcolor=red">
			<img src="{$root}img/SF/circle_red.png" style="height: 20px; border: 0px;" alt="Designfarbe:Rot">
       </a>
       <a title="Designfarbe: Blau" href="{$root}index.php?layoutcolor=blue">
            <img src="{$root}img/SF/circle_blue.png" style="height: 20px; border: 0px;" alt="Designfarbe:Blau">
       </a>
       <a title="Designfarbe: Grün" href="{$root}index.php?layoutcolor=green">
            <img src="{$root}img/SF/circle_green.png" style="height: 20px; border: 0px;" alt="Designfarbe:Grün">
       </a>
       <a title="Designfarbe: Orange" href="{$root}index.php?layoutcolor=orange">
            <img src="{$root}img/SF/circle_orange.png" style="height: 20px; border: 0px;" alt="Designfarbe:Orange">
       </a>
	</li>
</ol>
