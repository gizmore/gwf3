<body>
	<div id="gwf_wrap">
		<div id="gwf_inner_wrap">
			<div id="ptonline">{$gwff->module_Heart_beat()}</div>
			{$gwff->module_PoolTool_menu()}
			<div id="ptpage">
				{$page}
				{$gwff->module_PageBuilder_calender()}
				{$gwff->module_PageBuilder_monthly()}
			</div>
		</div>
		<div id="gwf_footer_space"></div>
	</div>
	<div id="gwf_footer">
		<div id="gwf_footer_box">
			<div>{$gwf->Copyright()->display()}</div>
			<div>{$gwf->Copyright()->displayGWF()}</div>
			<div>{{$timings['queries']}} queries in {$timings['t_sql']|string_format:"%.03f"} - PHP: {$timings['t_php']|string_format:"%.04f"}s - Total Time: {$timings['t_total']|string_format:"%.04f"}s - Memory: {$timings['mem_total']|filesize:"2":"1024"} - {$gwf->Module()->getModulesLoaded()} Modules Loaded</div>
		</div>
	</div>
</body>
