<body>
	<div id="gwf_wrap">
		<div id="gwf_inner_wrap">
			<div id="ptonline">{GWF_Notice::getOnlineUsers()}</div>
			{GWF_Notice::loadModuleClass('PoolTool', 'PT_Menu.php')}
			{PT_Menu::display()}
			<div id="ptpage">
{$messages}
{$errors}
