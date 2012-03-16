<body>
<div><a id="header" href="{$root}about_baim" >B.AIM</a></div>
{if false !== GWF_Module::loadModuleDB('BAIM', true, true, true)}
{BAIM::displayMenu()}
{/if}
<div id="baimonline">{GWF_Notice::getOnlineUsers()}</div>
<div id="page">
{$errors}
