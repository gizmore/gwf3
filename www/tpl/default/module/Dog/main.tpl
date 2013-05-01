<div data-role="page" id="main_page" data-theme="b"> 
	<div data-role="header" data-theme="b" data-position="fixed"><h1>Shadowlamb4.2!</h1></div> 
	<div data-role="content" data-theme="b">
		
		<div id="party_bar" data-theme="b" data-position="fixed"><ul id="party_list"><li>gizmore</li></ul></div>
		<div id="screen_tablinks"><ul>
			<li><a href="#" onclick="sl4.showScreen('chat');">Chat</a></li>
			<li><a href="#" onclick="sl4.showScreen('location');">#v</a></li>
			<li><a href="#" onclick="sl4.showScreen('mount');">#mo</a></li>
			<li><a href="#" onclick="sl4.showScreen('equipment');">#q</a></li>
			<li><a href="#" onclick="sl4.showScreen('combat');">##</a></li>
		</ul></div>
		
		<fieldset class="ui-grid-a">
			<div class="ui-block-a" id="screen_tabs">
				<ul id="chat" data-role="listview"><li>Welcome to Shadowsockets 4.2! I am loading...</li></ul>
				<ul id="equipment" data-role="listview"></ul>
				<ul id="location" data-role="listview"></ul>
				<ul id="mount" data-role="listview"></ul>
				<div id="combat"></div>
			</div>
			<div class="ui-block-b">
				<ul id="inventory" data-role="listview"></ul>
			</div>
		</fieldset>
		
		
		
	</div>
	<div data-role="footer" data-theme="b" data-position="fixed">
		<ul id="commands">
			<a onclick="sl4.exec('#explore');" id="cmd_explore">explore</a>
		</ul>
		<form>
			<input type="text" id="chat_input" />
			<input type="submit" name="send" value="Send" onclick="sl4.send(); return false;" />
		</form>
	</div> 
</div> 
