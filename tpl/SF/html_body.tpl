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
{/if}
<!-- CENTERED MIDDLE -->
			<div id="middle">
{if $SF->isDisplayed('shell')}
<!-- SHELL -->
				<div id="smallshell" class="shell">
{include file="tpl/{$SF->getDesign()}/shell.tpl"}
				</div>
{/if}
<!-- CONTENT -->
				<div id="content">
					<p class="top">
						<span style="float:left;">{$SF->getPath()}, {date('d.m.Y')}</span>
						<span style="float:right;">{$SF->lang('last_change')}</span>
					</p><hr style="clear:both;">
<!--PAGE Beginn -->					
					<div class="inhalt {if $smarty.get.mo == 'SF_Shell'}shell" id="largeshell{/if}">
						<div class="GWF_FTW">
{$messages}
{$errors}