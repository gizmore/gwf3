							<br/>
						</div>
					</div><hr/>
<!-- PAGE End -->
					<p class="bottom">
						<a class="backbutton" href="{$SF->getLastURL()}" title="{$SF->getLastURL()}">{$SF->lang('back')} ({$SF->getLastURL()})</a>
					</p>
				</div>
			</div>
{if $SF->isDisplayed('naviright')}
<!-- RIGHT NAVIGATION -->
			<div id="right" class="navigation">
{include file="tpl/{$SF->getDesign()}/navi_right.tpl"}
			</div>
{else}
			<div id="right">
				<a href="{$SF->getIndex('naviright')}naviright=shown"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/add.png" alt="[+]" title="Show Navigation"></a>
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
			<p style="text-align: left;" class="copyright">
{if !$SF->isDisplayed('details')}
<!-- SHORTDETAILS -->
{include file="tpl/{$SF->getDesign()}/shortdetails.tpl"}
{else}
<span style="float:right;">
<a href="{$SF->getIndex('details')}details=hidden"><img style="margin: 10px 0; height: 10px;" src="{$root}img/{$iconset}/sub.png" alt="[+]" title="Hide Details"></a>
</span>
{/if}
			</p>
		</div>
{if $SF->isDisplayed('details')}
<!-- DETAILS -->
		<div id="details">
{include file="tpl/{$SF->getDesign()}/details.tpl"}
		</div>
{/if}
<!-- FOOTER -->
		<div id="footer"><hr style="margin: 0;">
{include file="tpl/{$SF->getDesign()}/html_footer.tpl"}
		</div>
	</div>
	<p style="text-align: center;">
{include file="tpl/{$SF->getDesign()}/debug_time.tpl"}<br/>
		Valid <a href="http://validator.w3.org/check?uri=referer">HTML5</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS 3</a>
	</p>
</body>