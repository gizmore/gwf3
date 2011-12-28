<body>
<div><a id="header" href="{$root}about_baim" >B.AIM</a></div>
{$gwff->module_BAIM_menu()}
<div id="baimonline">{GWF_Notice::getOnlineUsers()}</div>
<div id="page">
{$messages}
{$errors}