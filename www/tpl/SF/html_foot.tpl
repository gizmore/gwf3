				</div>
<!-- @end content -->
				<hr/>
				<p class="bottom">
					<a class="backbutton" href="{GWF_Session::getLastURL()|escape}" title="{$SF->getLastURL()}">{$SF->lang('back')} ({GWF_Session::getLastURL()|escape})</a>
				</p>
			</div>
<!-- @end middle -->
<!-- @start right -->
{if $SF->isDisplayed('naviright')}
			<div id="right" class="navigation">
{include file="tpl/{$design}/navi.tpl" assign='navi_right' side='naviright' navigation="{SF_Navigation::display_navigation(SF_Navigation::SIDE_LEFT)}"}
{$navi_right|indent:4:"\t"}
			</div>
{else}
			<div id="right">
				<a href="{$SF->getIndex('naviright')}naviright=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Navigation"></a>
			</div>
{/if}
<!-- @end right -->
		</div>
<!-- @end body -->
<!-- @start copyright -->
		<div id="copyright">
			<p class="copyright">
				SPACE-Framework is copyright by 
				<a href="{$root}profile/space" title="space's profile">Florian Best</a> &amp; 
				<a href="http://wechall.net" title="GWF"><span title="Gizmore Website Framework">GWF</span> &copy; under <span title="Wechall Public License">WPL</span></a>
			</p>
{if false === $SF->isDisplayed('details')}
<!-- @start shortdetails -->
{include file="tpl/{$design}/shortdetails.tpl" assign='shortdetails'}
{$shortdetails|indent:3:"\t"}
{else}
			<p class="copyright fr">
				<a href="{$SF->getIndex('details')}details=hidden"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/sub.png" alt="[+]" title="Hide Details"></a>
			</p>
{/if}
		</div>
<!-- @end copyright -->
{if $SF->isDisplayed('details')}
<!-- @start details -->
		<div id="details">
{include file="tpl/{$design}/details.tpl" assign='details'}
{$details|indent:3:"\t"}
		</div>
{/if}
<!-- @end details -->
<!-- @start footer -->
		<div id="footer">
			<hr style="margin: 0 auto;"/>
			<a href="{$root}contact/">{$SF->lang('contact')}</a>
			<a href="{$root}impress/">{$SF->lang('impress')}</a>
			<a href="{$root}disclaimer/">{$SF->lang('disclaimer')}</a>
			<a href="{$root}sitemap/">{$SF->lang('sitemap')}</a>
			<a href="{$root}roadmap/">{$SF->lang('roadmap')}</a>
			<a href="{$root}changelog/">{$SF->lang('changelog')}</a>
			<a href="{$root}credits/">{$SF->lang('credits')}</a>
			<a href="{$root}helpdesk/">{$SF->lang('helpdesk')}</a>
			<a href="{$root}todo/">{$SF->lang('todo')}</a>
			<a href="{$root}project">{$SF->lang('project')}</a>
			<a href="#" class="last">{$SF->lang('bookmark')}</a>
		</div>
<!-- @end footer -->
	</div>
<!-- @end margin -->
<!-- @start debug-->
	<p style="text-align: center;">
{include file="tpl/{$design}/debug_time.tpl" assign='debug_time'}
{$debug_time|indent:2:"\t"}
		<br/>
		Valid <a href="http://validator.w3.org/check?uri=referer">HTML5</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS 3</a>
	</p>
<!-- @end debug -->
</body>
