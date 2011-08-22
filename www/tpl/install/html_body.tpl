<body>
	{$wizard_banner}
	<div id="gwf_inst_main">
		<div id="gwf_inst_head">
			<!-- Welcome + Progress-->
			<span>WELCOME TO GWF3 INSTALLATION WIZARD!!!</span><br>
			<span>Install Progress: 0%... GWF_PATH: {$gwfpath}; GWF_WEB_PATH:{$gwfwebpath}</span>
		</div>
		<div id="gwf_inst_logo">
			<div class="logo"></div>
			<div class="stepmenu">
				<ol>
					<li id="step1">Status</li>
					<li id="step2">Init Install</li>
					<li id="step3">Create CoreDB</li>
					<li id="step4">Languages</li>
					<li id="step5">Modules</li>
					<li id="step6">Admins</li>
					<li id="step7">foo</li>
					<li id="step8">htaccess</li>
					<li id="step9">finish</li>
				</ol>
			</div>
		</div>
		<div id="gwf_inst_body">
			<div class="gwf_inst_errors">
				{$messages}
				{$errors}
			</div>