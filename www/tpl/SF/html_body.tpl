<body>
<!-- @start margin -->
	<div id="margin">
<!-- @start profile -->
		<div id="profile">
{include file="tpl/{$design}/menu_profile.tpl"}
		</div>
<!-- @end profile -->
<!-- @start logo -->
		<div id="logo">
			<span style="background-color: {$SF->getLayoutcolor('design_light')};">
			 - the perfection of WebApplication -
			</span>
		</div>
<!-- @end logo -->
<!-- @start headnavi -->
		<div id="headnavi">
{include file="tpl/{$design}/menu_top.tpl"}
		</div>
<!-- @end headnavi -->
<!-- @start body -->
		<div id="body">
<!--@start left -->
{if true === $SF->isDisplayed('navileft')}
			<div id="left" class="navigation">
{include file="tpl/{$design}/navi_left.tpl"}
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
{include file="{$SF->getGWFPath()}core/module/SF/tpl/SF/shortshell.tpl"}
				</div>
<!-- @end shell -->
{else}
				<span class="fr">
					<a href="{$SF->getIndex('shell')}shell=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Shell"></a>
				</span>
{/if}
<!-- @start content -->
				<div id="content">
<!-- @begin page -->
					<div class="inhalt {if $SF->getMoMe('SF_Shell')}shell" id="largeshell{/if}">
<!-- @begin error/success messages -->
{$messages}
{$errors}
<!-- @end error/success messages -->
