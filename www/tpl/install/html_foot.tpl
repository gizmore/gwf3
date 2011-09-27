		</div>
		<div id="gwf_inst_progress">
			Install Progress: {(int)(100 / 11 * $step)}%<br>
			|#{str_repeat('#', (int)(100 / 11 * $step/2))}{str_repeat('-', 100-100 / 11 * $step)}>| <br>
			<!-- Progressbar with CSS by steps / percent-->
			GWF_PATH: {$gwfpath}<br>
			GWF_WEB_PATH:{$gwfwebpath}<br>
			GWF_WEB_ROOT: {$root}
		</div>
		<div id="gwf_inst_foot">
			<!-- Licensing, Copyright, Links, Date -->
			GWF3 is &copy; by Gizmore - GWF3 is licensed under WPL - GWF3 is free as in bear
		</div>
	</div>
</body>
</html>