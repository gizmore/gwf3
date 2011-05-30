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
<!--LEFT NAVIGATION -->
			<div id="left" class="navigation">
				<p class="top" style="background-image: url('/templates/{$smarty.const.GWF_DEFAULT_DESIGN}/{$settings['template']['layout']}/images/navilefthead.png');">
					[+]
				</p><hr>
{SF_Website::display_navigation('left')}
				<hr><p class="bottom"></p>
			</div>
<!-- CENTERED MIDDLE -->
			<div id="middle" style="background-color: #131313;">
{if $smarty.get.mo != 'SMF'}
<!-- SHELL -->
				<div id="smallshell" class="shell">
{include file="templates/Form/shell.tpl"}
				</div>
{/if}
<!-- CONTENT -->
				<div id="content">
					<p class="top" style="background-image:url('templates/{$smarty.const.GWF_DEFAULT_DESIGN}/{$settings['template']['layout']}/images/contenthead.png');">
						<span style="float:left;">{*getPath::displayPath()*}, {date('d.m.Y')}</span>
						<span style="float:right;">{$lang->lang('last_change')}</span>
					</p><hr style="clear:both;">
<!--PAGE Beginn -->					
					<div class="inhalt">
{if $smarty.get['mo'] == 'SMF'}
<!-- SHELL -->
				<div id="largeshell" class="shell">
{include file="templates/Form/shell.tpl"}
					<br>
					<br>
					{$page}
				</div>
{else}
						<div style="width: 100%;" class="GWF_FTW">
{if isset($smarty.get['sec'])} 
Please login to see content!
{/if}		
							{$page}
							<br>
						</div>
{/if}
					</div><hr>
<!-- PAGE End -->
					<p class="bottom">
						<a class="backbutton" href="{$smarty.const.GWF_LastURL}" title="{$smarty.const.GWF_LastURL}">{$lang->lang('back')} ({$smarty.const.GWF_LastURL}) {*GWF_Session::getLastURL()*}</a>
					</p>
				</div>
			</div>
{if isset($smarty.get['mo'])}
{if $smarty.get['mo'] != 'Forum'}
{if $smarty.get['mo'] != 'Admin'}
<!-- RIGHT NAVIGATION -->
			<div id="right" class="navigation">
				<p class="top" style="background-image:url('templates/{$smarty.const.GWF_DEFAULT_DESIGN}/{$settings['template']['layout']}/images/navirighthead.png');"> _</p><hr>

{SF_Website::display_navigation('right')}
				<hr><p class="bottom"></p>
			</div>
{/if}
{/if}
{/if}
		</div>
<!-- COPYRIGHT -->
		<div id="copyright"><p class="copyright">SPACE-Framework is copyright by <a href="{$root}profile/space" title="space's profile">Florian Best</a> & <a href="http://wechall.net" title="GWF"><span title="Gizmore Website Framework">GWF</span> &copy; under <span title="Wechall Public License">WPL</span></a></p></div>
<!-- DETAILS -->
		<div id="details">
{include file="templates/{$smarty.const.GWF_DEFAULT_DESIGN}/details.tpl"}
		</div>
<!-- FOOTER -->
		<div id="footer"><hr>
			<p style="vertical-align: middle; text-align: center; line-height: 20px;">
				<a href="contact/" class="footlink">Kontakt</a> | 
				<a href="impressum/" class="footlink">Impressum</a> | 
				<a href="disclaimer/" class="footlink">Disclaimer</a> | 
				<a href="sitemap/" class="footlink">Sitemap</a> | 
				<a href="roadmap/" class="footlink">Roadmap</a> | 
				<a href="changelog/" class="footlink">Changelog</a> | 
				<a href="credits/" class="footlink">Credits</a> | 
				<a href="bugreport/" class="footlink">Report Bug</a> | 
				<a href="todo/" class="footlink">TO-DO Liste</a> | 
				<!--<a href="SF/framework-latest.tar.gz" class="footlink">Space-Framework</a> | -->
				<a href="#" class="footlink">Bookmark</a>
			</p>
		</div>
	</div>
	<p style="text-align:center;">
{include file="tpl/{$smarty.const.GWF_DEFAULT_DESIGN}/html_foot.tpl"}
	</p>
</body>