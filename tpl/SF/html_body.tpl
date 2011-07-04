<body>
	<div id="margin">
<!-- PROFILE -->
		<div id="profile">
{include file="tpl/{$SF->getDesign()}/menu_profile.tpl"}
		</div>
<!-- LOGO -->
		<div id="logo">
{include file="tpl/{$SF->getDesign()}/logo.tpl"}
		</div>
<!-- HEADNAVI -->
		<div id="headnavi">
{include file="tpl/{$SF->getDesign()}/menu_top.tpl"}
		</div>
<!-- BODY -->
		<div id="body">
{if $SF->isDisplayed('navileft')}
<!--LEFT NAVIGATION -->
			<div id="left" class="navigation">
{include file="tpl/{$SF->getDesign()}/navi_left.tpl"}
			</div>
{else}
			<div id="left">
				<a href="{$SF->getIndex('navileft')}navileft=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Navigation"></a>
			</div>
{/if}
<!-- CENTERED MIDDLE -->
			<div id="middle">
{if $SF->isDisplayed('shell')}
<!-- SHELL -->
				<div id="smallshell" class="shell">
{include file="module/SF/tpl/SF/shortshell.tpl"}
				</div>
{/if}
<!-- CONTENT -->
				<div id="content">
<!--PAGE Beginn -->					
					<div class="inhalt {if $SF->getMoMe('SF_Shell')}shell" id="largeshell{/if}">
						<div class="GWF_FTW">
{$messages}
{$errors}