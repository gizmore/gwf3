
				{$gwff->module_PageBuilder_calender()}
				{$gwff->module_PageBuilder_monthly()}
			</div>
		</div>
		<div id="gwf_footer_space"></div>
	</div>
	<div id="gwf_footer">
		<div id="gwf_footer_box">
			<div>{GWF_Copyright::display()}</div>
			<div>{GWF_Copyright::displayGWF()}</div>
			{assign var="timings" value=GWF_DebugInfo::getTimings()}
			<div>{{$timings['queries']}} queries in {$timings['t_sql']|string_format:"%.03f"} - PHP: {$timings['t_php']|string_format:"%.04f"}s - Total Time: {$timings['t_total']|string_format:"%.04f"}s - Memory: {$timings['mem_total']|filesize:"2":"1024"} - {GWF_Module::getModulesLoaded()} Modules Loaded</div>
		</div>
	</div>
</body>
