		</div>
		<div id="gwf_inst_progress">
			{$il->lang('foot_progress', [(int)(100.0 / $steps * $step)])}<br />
			[#{str_repeat('#', (int)(100.0 / $steps * $step/2.0))}{str_repeat('-', (int)(100.0-100.0 / $steps * $step))}] <br>
			<!-- Progressbar with CSS by steps / percent-->
			GWF_PATH: {$gwfpath}<br>
			GWF_WEB_PATH: {$gwfwebpath}<br>
			GWF_WEB_ROOT: {$root}
		</div>
		<div id="gwf_inst_foot">
			<div>{$il->lang('license')}</div>
			<div>{$il->lang('pagegen', [$timings['t_total']])}</div>
		</div>
	</div>
</body>
</html>