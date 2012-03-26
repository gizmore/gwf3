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
		SQL: {$timings['t_sql']|string_format:"%.03f"}s ({$timings['queries']} Queries);
		PHP: {$timings['t_php']|string_format:"%.03f"}s;
		TOTAL: {$timings['t_total']|string_format:"%.03f"}s;<br/>
		MEM PHP: {$timings['mem_php']|filesize:"2":"1024"};
		MEM USER: {$timings['mem_user']|filesize:"2":"1024"};
		MEM TOTAL: {$timings['mem_total']|filesize:"2":"1024"};<br/>
		SPACE FREE: {$timings['space_free']|filesize:"2":"1024"}
		SPACE USED: {$timings['space_used']|filesize:"2":"1024"}
		SPACE TOTAL: {$timings['space_total']|filesize:"2":"1024"}<br/>
		MODULES LOADED: {GWF_Module::getModulesLoaded('%2$s (%1$s)')};
	</p>
</body>
