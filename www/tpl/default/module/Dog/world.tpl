<div data-role="page" id="world_page" data-theme="b"> 
	<div data-role="header" data-theme="b"><h1>Shadowlamb4.2!</h1></div> 
	<div data-role="content" data-theme="b">
		<div>Choose your gameworld. Currently only #shadowlamb is available, which is a test server.</div>
		<hr/>
		<ul data-role="listview">
{foreach from=$worlds item=world}
			<li><a href="#" onclick="sl4.chooseWorld('{$world['url']}');">{$world['name']} {$world['descr']}</a></li>
{/foreach}
		</ul>
	</div>
	<div data-role="footer" data-theme="b">(c)2008-2013 gizmore@wechall.net</div> 
</div> 
