							<br>
						</div>
					</div><hr>
<!-- PAGE End -->
					<p class="bottom">
						<a class="backbutton" href="{$lastURL}" title="{$lastURL}">{$SF->lang('back')} ({$lastURL})</a>
					</p>
				</div>
			</div>
{if $SF->is_displayed('naviright')}
<!-- RIGHT NAVIGATION -->
			<div id="right" class="navigation">
{include file="tpl/{$SF->design()}/navi_right.tpl"}
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
{if $SF->is_displayed('details')}
<!-- DETAILS -->
		<div id="details">
{include file="templates/{$SF->design()}/details.tpl"}
		</div>
{/if}
<!-- FOOTER -->
		<div id="footer"><hr>
{include file="tpl/{$SF->design()}/html_footer.tpl"}
		</div>
	</div>
	<p style="text-align: center;">
{include file="tpl/{$SF->design()}/debug_time.tpl"}
	</p>
</body>