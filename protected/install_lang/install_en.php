<?php
$lang = array(
	'err_create_config' => 'Please create &quot;protected/config.php&quot; and make it writeable for the web-server.',
	'err_no_config' => 'The &quot;protected/config.php&quot; file is missing.',
	'err_no_db' => 'Cannot establish a connection to the database.',
	'err_config_value' => 'In your config.php, the defined value for &quot;%1%&quot; is invalid. The default value has been restored.',
	'err_unknown_type' => 'Unknown vartype for config var: %1%.',
	'err_unknown_var' => 'Unknown config variable: %1%.',
	'err_text' => 'The var \'%1%\' has to be a string.',
	'err_int8' => 'The var \'%1%\' has to be an octal number.',
	'err_int10' => 'The var \'%1%\' has to be a decimal number.',
	'err_bool' => 'The var \'%1%\' has to be either true or false.',
	'err_script' => 'The var \'%1%\' has an invalid default value.',
	'err_no_smarty' => 'Cannot find Smarty library.',

	'pt_wizard' => 'GWF - Install Wizard',
	
	'wizard' => 'Install Wizard',
	'step' => 'Step %1%',
	'yes' => 'yes',
	'no' => 'no',
	'ok' => 'OK.',
	'error' => 'ERROR: ',
	'no_cfg_file' => 'No config exists',

	'step_0'    => 'Check requirements',
	'step_0_0'  => 'Welcome to the GWF install wizard.<br/>Please create a database for your installation first.<br/>MySQL commands to create a database:',
	'step_0_0a' => 'Then first make sure all fields marked with (*) are green.',
	'step_0_1'  => 'Is directory &quot;protected/&quot; .htaccess protected?',
	'step_0_2'  => 'Is the root .htaccess writable?(*)',
	'step_0_3'  => 'Can write &quot;protected/config.php&quot;?(*)',
	'step_0_4'  => 'config.php exists?',
	'step_0_5'  => 'Can write to dir &quot;dbimg/&quot;?(*)',
	'step_0_6'  => 'Can write to dir &quot;temp/&quot;?(*)',
	'step_0_7'  => 'Can write to dir &quot;protected/logs/&quot;?(*)',
	'step_0_8'  => 'Can write to dir &quot;protected/rawlog/&quot;?(*)',
	'step_0_9'  => 'Can connect to database?',
	'step_0_10' => 'Is PHP hash library installed?(*)',
	'step_0_11' => 'Is PHP ZipArchive installed?',
	'step_0_12' => 'Is PHP curl library installed?',
	'step_0_13' => 'Is PHP Fileinfo or mime_content_type available?',
	'step_0_14' => 'Are dangerous functions (exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen) disabled?',
	'step_0_15' => 'Are GnuPG functions available?',

	'step_1' => 'Create &quot;protected/config.php&quot;',

	'step_1a' => 'Test database connection',
	'step_1a_0' => 'Looking for protected/config.php configuration file... %1%.',
	'step_1a_1' => 'Trying to connect to database... %1%.',

	'step_1b' => 'Write &quot;protected/config.php&quot;',
	'step_1b_0' => 'Writing the configuration file... %1%.',

	'step_2' => 'Test &quot;protected/config.php&quot;',
	'step_2_0' => 'Your config seems solid. You may now try to setup the core tables.',

	'step_3' => 'Install core tables',
	'create_table' => 'Creating table for class %1%... ',
	'step_3_0' => 'We will now create the tables for the core classes.<br/>You can find these in the &quot;inc/&quot; directory.<br/>Every class takes care of one database table.',
	'step_3_1' => 'You may now either install country/language tables with or without ip2country mapping.<br/>IP2country mapping may take several minutes to install.',

	'step_4' => 'Install country+language tables',
	'step_4_0' => 'You can now install or skip the useragent database.<br/>It is recommended to skip that part, as the useragent database is completely unused currently.',

	'step_5' => 'Install country+language+ip2country tables',
	'step_5_0' => 'You can now install or skip the useragent database.<br/>It is recommended to skip that part, as the useragent database is completely unused currently.',

	'step_6' => 'Install useragent map',
	'step_6_0' => 'You should now install all modules that are shipped with your package of GWF2.',

	'step_7' => 'Install all modules',
	'step_7_0' => 'You should now create at least one admin account.',
	'step_7a' => 'Installed modules',
	
	'step_8' => 'Create an admin account',

	'step_9' => 'Finish installation',

	'step_10' => 'Protecting the &quot;protected/&quot; folder',
);
?>