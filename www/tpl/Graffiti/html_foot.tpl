				{*<!--<br/>
				<hr/>
				<p class="bottom copyright">
					&copy; copyright 2011 by Florian Best
				</p>-->*}
<!-- CONTENT End -->
			</div>
		</div>
	</div>
	<p style="text-align: center;">
		Valid <a href="http://validator.w3.org/check?uri=referer">HTML5</a> and <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">CSS 3</a>
	{assign var="timings" value=GWF_DebugInfo::getTimings()}
<br/>Time:
PHP: {$timings['t_php']|string_format:"%.03f"}s;
TOTAL: {$timings['t_total']|string_format:"%.03f"}s;<br/>
Memory:
PHP: {$timings['mem_php']};
USER: {$timings['mem_user']};
TOTAL: {$timings['mem_total']};<br/>
{*MODULES LOADED: {$SF->getLoadedModules('%count% (%mods%)')};
*}

	</p>
</body>