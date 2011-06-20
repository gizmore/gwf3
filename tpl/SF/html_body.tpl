<body>
	<div id="margin">
<!-- PROFILE -->
		<div id="profile">
{include file="tpl/{$SF->design()}/menu_profile.tpl"}
		</div>
<!-- LOGO -->
		<div id="logo">
{include file="tpl/{$SF->design()}/logo.tpl"}
		</div>
<!-- HEADNAVI -->
		<div id="headnavi">
{include file="tpl/{$SF->design()}/menu_top.tpl"}
		</div>
<!-- BODY -->
		<div id="body">
{if $SF->is_displayed('navileft')}
<!--LEFT NAVIGATION -->
			<div id="left" class="navigation">
{include file="tpl/{$SF->design()}/navi_left.tpl"}
			</div>
{/if}
<!-- CENTERED MIDDLE -->
			<div id="middle">
{if $SF->is_displayed('shell')}
<!-- SHELL -->
				<div id="smallshell" class="shell">
{include file="tpl/{$SF->design()}/shell.tpl"}
				</div>
{/if}
<!-- CONTENT -->
				<div id="content">
					<p class="top">
						<span style="float:left;">{$SF->display_Path()}, {date('d.m.Y')}</span>
						<span style="float:right;">{$SF->lang('last_change')}</span>
					</p><hr style="clear:both;">
<!--PAGE Beginn -->					
					<div class="inhalt {if $smarty.get.mo == 'SF_Shell'}shell" id="largeshell{/if}">
						<div class="GWF_FTW">
{$messages}
{$errors}