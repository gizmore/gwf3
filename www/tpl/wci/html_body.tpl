<body>
	<div id="page_wrap">
		{GWF_Notice::loadModuleClass('WeChall', 'WC_HTML.php')}
		{GWF_Template::templatePHPMain('wcmenu.php')}
		{GWF_Template::templatePHPMain('wcheader.php')}
		<div id="wc_banner_space"></div>
		{*WC_HTML::displaySidebar2()*}
		<div id="page">
{$errors}
