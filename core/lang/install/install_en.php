<?php
$lang = array(
	'err_create_config' => 'Please create &quot;protected/config.php&quot; and make it writeable for the web-server.',
	'err_no_config' => 'The &quot;protected/config.php&quot; file is missing.',
	'err_no_db' => 'Cannot establish a connection to the database.',
	'err_config_value' => 'In your config.php, the defined value for &quot;%s&quot; is invalid. The default value has been restored.',
	'err_unknown_type' => 'Unknown vartype for config var: %s.',
	'err_unknown_var' => 'Unknown config variable: %s.',
	'err_text' => 'The var \'%s\' has to be a string.',
	'err_int8' => 'The var \'%s\' has to be an octal number.',
	'err_int10' => 'The var \'%s\' has to be a decimal number.',
	'err_bool' => 'The var \'%s\' has to be either true or false.',
	'err_script' => 'The var \'%s\' has an invalid default value.',
	'err_no_smarty' => 'Cannot find Smarty library.',
	'err_no_mods_selected' => 'Please select some modules.',
	'err_htaccess' => 'Could not write the root .htaccess file.',
	'err_copy' => 'Cannot copy to file %s.',
	'err_clear_smarty' => 'Could not clear smarty cache.',
		
	'msg_copy' => 'Successfully made a copy of %s.',
	'msg_copy_untouched' => 'Your copy of %s has not been touched.',
	'msg_htaccess' => 'I have successfully written the root .htaccess file.',
	
	'pt_wizard' => 'GWF - Install Wizard',
	'mt_wizard' => 'GWF,Install,Wizard',
	'md_wizard' => 'GWFv4 installation wizard. You should not see me ;)',

	'foot_progress' => 'Install progress: %0.02f%%',
	'license' => 'GWF3 is &copy; by gizmore.<br/>GWF3 is currently unlicensed. MIT compatible licensed is planned.<br/>GWF3 shall be free as in beer.',
	'pagegen' => 'Page generated in %.03fs.',

	'menu_0' => 'Status',
	'menu_1' => 'WriteConfig',
	'menu_2' => 'TestConfig',
	'menu_3' => 'CoreTables',
	'menu_4' => 'Locales',
	'menu_5' => 'Robots',
	'menu_6' => 'Modules',
	'menu_7' => 'Examples',
	'menu_8' => 'HTAccess',
	'menu_9' => 'Admins',
	'menu_10' => 'Backup',
	'menu_11' => 'Cache',
	'menu_12' => 'Protect',
		
	'title_long' => 'Space &amp; Gizmore Website Framework',
	'title_step' => 'Installation wizard - Step %d',
	
	'wizard' => 'Install Wizard',
	'step' => 'Step %s',
	'yes' => 'yes',
	'no' => 'no',
	'ok' => 'OK.',
	'error' => 'ERROR: ',
	'no_cfg_file' => 'No config exists',

	'step_0'    => 'Check requirements',
	'step_0_0'  => 'Welcome to the GWF install wizard.<br/>Please create a database for your installation first.<br/>MySQL commands to create a database:',
	'step_0_0a' => 'First make sure all fields marked with (*) are green.',
	'step_0_1'  => 'Is directory &quot;protected/&quot; .htaccess protected?',
	'step_0_2'  => 'Is the root .htaccess writable?(*)',
	'step_0_3'  => 'Can write &quot;protected/config.php&quot;?(*)',
	'step_0_4'  => 'config.php exists?',
	'step_0_5'  => 'Can write to dir &quot;dbimg/&quot;?(*)',
	'step_0_6'  => 'Can write to dir &quot;extra/temp/&quot;?(*)',
	'step_0_7'  => 'Can write to dir &quot;protected/logs/&quot;?(*)',
	'step_0_8'  => 'Can write to dir &quot;protected/rawlog/&quot;?(*)',
	'step_0_9'  => 'Can connect to database?',
	'step_0_10' => 'Is PHP hash library installed?(*)',
	'step_0_11' => 'Is PHP ZipArchive installed?',
	'step_0_12' => 'Is PHP curl library installed?',
	'step_0_13' => 'Is PHP Fileinfo or mime_content_type available?',
	'step_0_14' => 'Are dangerous functions (exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen,link) disabled?',
	'step_0_15' => 'Are GnuPG functions available?',

	'step_1' => 'Create &quot;protected/config.php&quot;',

	'step_1a' => 'Test database connection',
	'step_1a_0' => 'Looking for protected/config.php configuration file... %s.',
	'step_1a_1' => 'Trying to connect to database... %s.',
	'step_1b' => 'Write &quot;protected/config.php&quot;',
	'step_1b_0' => 'Writing the configuration file... %s.',

	'step_2' => 'Test &quot;protected/config.php&quot;',
	'step_2_0' => 'Your config seems solid. You may now try to setup the core tables.',

	'step_3' => 'Install core tables',
	'create_table' => 'Creating table for class %s... ',
	'step_3_0' => 'We will now create the tables for the core classes.<br/>You can find these in the &quot;core/inc/&quot; directory.<br/>Every class takes care of one database table.',

	'step_4' => 'Install country+language tables',
	'step_4_0' => 'You may now either install country/language tables with or without ip2country mapping.<br/>IP2country mapping may take several minutes to install.',
	'step_4_1' => 'Install country+language tables',
	'step_4_2' => 'Install country+language+ip2country tables',

	'step_5' => 'Install useragent table',
	'step_5_0' => 'You can now install or skip the useragent database.<br/>It is recommended to skip that part, as the useragent database is completely unused currently.',
	'step_5_1' => 'Installing useragent map',

	'step_6' => 'Install modules',
	'step_6_0' => 'You should now choose which modues you want to install.',
	'step_6_1' => 'Installing modules',

	'step_7' => 'Copy dynamic example files',

	'step_8' => 'Create .htaccess',

	'step_9' => 'Create admin account(s)',

	'step_10' => 'Create Backup Folders',
	'step_10_0' => 'You should add the following to your crontab:<br/><br/>%s<br/>%s<br/><br/>You will find data here: %s.<br/><br/>Backup strategy is important!',
		
	'step_11' => 'Clear Caches',
	'step_11_0' => 'Install has been finished.<br/>All caches have been cleared.<br/>You can login now or enhance the protection of your install folder.',
		
	'step_12' => 'Protect the install folder',
	'step_12_0' => 'Your install folder should now be protected by throwing 404 errors.',
	
	'msg_all_done' => 'Congratulations, your installation is complete!<br/>Thank you for choosing GWF3<br/>We hope you will enjoy it.<br/><br/>gizmore and spaceone',
);
