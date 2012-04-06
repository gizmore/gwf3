<?php

$lang = array(
	'err_manifest1' => 'Can not find manifest file in zip package.',
	'err_manifest2' => 'Can not find magic bytes in manifest file.',
	'err_manifest3' => 'The manifest timestamp is invalid.',
	'err_package_broken' => 'A downloaded file is broken: %s.',
	'err_file_broken' => 'One of your installed files is broken: %s.',
	'err_update' => 'There are %s errors unresolveable.<br/>The only thing you can try now is to reset your update-datestamp and reinstall all files (Clean Upgrade).',

	'msg_update_archive_ok' => 'Downloaded update archive. Filesize: %s.',
	'msg_update_done' => 'Update finished. %s Files were old and fine. %s Files have been replaced.',
	
	'info_update' => 'Update GWF2 core files.<br>Your datestamp is %s (server time).<br/>Your upgrade token is %s.<br/>Server URL is %s.<br/>Use Clean update to reset your update datestamp.',

	'ft_update' => 'Update GWF2 Files',

	'btn_simulate' => 'Simulate Update',
	'btn_update' => 'Update',
	'btn_cleanupdate' => 'Clean Update',


	'tt_cfg_vc_datestamp' => 'Reset this datestamp to 00000000000000 to trigger a full re-install.',
	'tt_cfg_vc_token' => 'A valid upgrade token is required to package your installation.',

	'cfg_vc_datestamp' => 'Upgrade Datestamp',
	'cfg_vc_server' => 'Upgrade Server',
	'cfg_vc_token' => 'Upgrade Token',

);
?>