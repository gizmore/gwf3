<body>
	<div id="gwf_inst_main">
		<div id="gwf_inst_logo">
			<h1 class="fl">GWF</h1>
			<h2>{$il->lang('title_long', $step)}</h2>
			<h3>{$il->lang('title_step', $step)}</h3>
		</div>
		<div class="fl">
			<div id="gwf_inst_stepmenu">
				<ol>
					<li id="step0"><a href="?step=0">{$il->lang('menu_0')}</a></li>
					<li id="step1"><a href="?step=1">{$il->lang('menu_1')}</a></li>
					<li id="step2"><a href="?step=2">{$il->lang('menu_2')}</a></li>
					<li id="step3"><a href="?step=3">{$il->lang('menu_3')}</a></li>
					<li id="step4"><a href="?step=4">{$il->lang('menu_4')}</a></li>
					<li id="step5"><a href="?step=5">{$il->lang('menu_5')}</a></li>
					<li id="step6"><a href="?step=6">{$il->lang('menu_6')}</a></li>
					<li id="step7"><a href="?step=7">{$il->lang('menu_7')}</a></li>
					<li id="step8"><a href="?step=8">{$il->lang('menu_8')}</a></li>
					<li id="step9"><a href="?step=9">{$il->lang('menu_9')}</a></li>
					<li id="step10"><a href="?step=10">{$il->lang('menu_10')}</a></li>
				</ol>
			</div>
		</div>
		
		<div class="cb"></div>
		
		<div id="gwf_inst_errors">
			{$messages}
			{$errors}
		</div>
		
		<div id="gwf_inst_body">
