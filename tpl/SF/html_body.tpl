<body>
	<div id="margin">
<!-- PROFILE -->
		<div id="profil">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/menu_profile.tpl"}
		</div>
<!-- LOGO -->
		<div id="logo">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/logo.tpl"}
		</div>
<!-- HEADNAVI -->
		<div id="headnavi">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/menu_top.tpl"}
		</div>
<!-- BODY -->
		<div id="body">
{if $settings.display.navileft}
<!--LEFT NAVIGATION -->
			<div id="left" class="navigation">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/navi_left.tpl"}
			</div>
{/if}
<!-- CENTERED MIDDLE -->
			<div id="middle">
{if $smarty.get.mo != 'SF_Shell'}
<!-- SHELL -->
				<div id="smallshell" class="shell">
{include file="tpl/Form/shell.tpl"}
				</div>
{/if}
<!-- CONTENT -->
				<div id="content">
					<p class="top">
						<span style="float:left;">{*$gwf->SF_getPath->displayPath()*}, {date('d.m.Y')}</span>
						<span style="float:right;">{$lang->lang('last_change')}</span>
					</p><hr style="clear:both;">
<!--PAGE Beginn -->					
					<div class="inhalt {if $smarty.get.mo == 'SF_Shell'}shell" id="largeshell{/if}">
						<div style="width: 100%;" class="GWF_FTW">
							{if isset($smarty.get.sec)}Please login to see content!{/if}
							{$page}
							<br>
						</div>
					</div><hr>
<!-- PAGE End -->
					<p class="bottom">
						<a class="backbutton" href="{$lastURL}" title="{$lastURL}">{$lang->lang('back')} ({$lastURL})</a>
					</p>
				</div>
			</div>
{if $settings.display.naviright}
<!-- RIGHT NAVIGATION -->
			<div id="right" class="navigation">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/navi_right.tpl"}
			</div>
{/if}
		</div>
<!-- COPYRIGHT -->
		<div id="copyright">
			<p class="copyright">
				SPACE-Framework is copyright by 
				<a href="{$root}profile/space" title="space's profile">Florian Best</a> & 
				<a href="http://wechall.net" title="GWF"><span title="Gizmore Website Framework">GWF</span> &copy; under <span title="Wechall Public License">WPL</span></a>
			</p>
		</div>
{if $settings['display']['details']}
<!-- DETAILS -->
		<div id="details">
{include file="templates/{$smarty.const.GWF_DEFAULT_DESIGN}/details.tpl"}
		</div>
{/if}
<!-- FOOTER -->
		<div id="footer"><hr>
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/html_foot.tpl"}
		</div>
	</div>
	<p style="text-align: center;">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/debug_time.tpl"}
	</p>
</body>