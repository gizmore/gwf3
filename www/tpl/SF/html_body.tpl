<body>
<!-- @start margin -->
	<div id="margin">
<!-- @start profile -->
		<div id="profile">
{include file="tpl/{$design}/menu_profile.tpl" assign='menu_profile'}
{$menu_profile|indent:3:"\t"}
		</div>
<!-- @end profile -->
<!-- @start logo -->
		<div id="logo">
{include file="tpl/{$design}/logo.tpl" assign='logo'}
{$logo|indent:3}
		</div>
<!-- @end logo -->
<!-- @start headnavi -->
		<div id="headnavi">
{include file="tpl/{$design}/menu_top.tpl" assign='menu_top'}
{$menu_top|indent:3:"\t"}
{*GWF_Navigation::getPageMenu()|indent:3:"\t"*}
{*GWF_Module::loadModuleDB('Navigation')->execute()->getPageMenu()|indent:3:"\t"*}
		</div>
<!-- @end headnavi -->
<!-- @start body -->
		<div id="body">
<!--@start left -->
{if $SF->isDisplayed('navileft')}
			<div id="left" class="navigation">
{include file="tpl/{$design}/navi.tpl" assign='navi_left' side='navileft' navigation="{SF_Navigation::display_navigation(SF_Navigation::SIDE_LEFT)}"}
{$navi_left|indent:4:"\t"}
			</div>
{else}
			<div id="left">
				<a href="{$SF->getIndex('navileft')}navileft=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Navigation"></a>
			</div>
{/if}
<!-- @end left -->
<!-- @start middle -->
			<div id="middle">
{if $SF->isDisplayed('shell')}
<!-- @start shell -->
				<div id="smallshell" class="shell">
					<span class="fr">
						<a href="{$SF->getIndex('shell')}shell=hidden"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/sub.png" alt="[-]" title="Hide Shell"></a>
					</span><br>
{include file="tpl/{$design}/greeting.tpl" assign='greeting'}
{include file="tpl/SF/module/SF/shortshell.tpl" assign='shortshell'}
{$greeting|indent:5:"\t"}
{$shortshell|indent:5:"\t"}
				</div>
<!-- @end shell -->
{else}
				<span class="fr">
					<a href="{$SF->getIndex('shell')}shell=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Shell"></a>
				</span>
{/if}
<!-- @start content -->
				<div id="content" class="inhalt {if $SF->getMoMe('SF_Shell')}shell" id="largeshell{/if}">
<!-- @begin errormessages -->
{$errors}
<!-- @end errormessages -->
