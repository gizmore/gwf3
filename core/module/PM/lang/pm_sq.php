<?php

$lang = array(
	'hello' => 'Përshëndetje %s',
	'sel_username' => 'Zgjidh një përdorues',
	'sel_folder' => 'Zgjidhni një dosje',

	# Info
	'pt_guest' => GWF_SITENAME.' Mysafir PN',
	'pi_guest' => 'Më '.GWF_SITENAME.' ato gjithashtu mund të dërgojë një PN si mysafir. Perdoruesi duhet në mënyrë eksplicite lejen e tij, ai mund të shkruani atyre një përgjigje. Megjithatë, ajo mund të përdoret për të shpejt të raportojnë një gabim.',

	'pi_trashcan' => 'Këtu është PN-plehra. Mesazhet nuk mund te fshihet me të vërtetë. Megjithatë, ju mund të rivendosur mesazhe nga plehra.',
	
	# Buttons
	'btn_ignore' => '%s injoro',
	'btn_ignore2' => 'Shpërfill',
	'btn_save' => 'Ruaj Rregullimet',
	'btn_create' => 'PN te ri',
	'btn_preview' => 'Shoh',
	'btn_send' => 'Dërgoj',
	'btn_delete' => 'Fshij',
	'btn_restore' => 'Rikthe',
	'btn_edit' => 'Redaktoj',
	'btn_autofolder' => 'Rendit',
	'btn_reply' => 'Përgjigje',
	'btn_quote' => 'Citim',
	'btn_options' => 'PN Paneli i punëve',
	'btn_search' => 'Kërkim',
	'btn_trashcan' => 'Garbage',
	'btn_auto_folder' => 'Rendit Në dosjet',

	# Errors
	'err_pm' => 'Ky mesazh nuk ekziston.',
	'err_perm_read' => 'Ju mund të lexoni këtë mesazh.',
	'err_perm_write' => 'Ju nuk mund të modifikojnë këtë mesazh.',
	'err_no_title' => 'Keni harruar titullin.',
	'err_title_len' => 'Titulli i juaj është shumë i gjatë. Lejohet një maksimum %s Shenjë.',
	'err_no_msg' => 'Ju keni harruar mesazhin.',
	'err_sig_len' => 'Firma juaj është shumë i gjatë. lejohet një maksimum %s Shenjë.',
	'err_msg_len' => 'Mesazhi juaj është shumë i gjatë. Lejohet një maksimum %s Shenjë.',
	'err_user_no_ppm' => 'Ky përdorues nuk dëshiron vizitorëve-PN.',
	'err_no_mail' => 'Nuk keni dhënë një email të konfirmuar për këtë llogari.',
	'err_pmoaf' => 'Vlera për dosje automatike është i pavlefshëm.',
	'err_limit' => 'Ju keni arritur kufirin e tyre për PN sot. Ju mund të hyjë deri %s Mesazh brenda %s dërgoj.',

	'err_ignored' => '%s injoruar ato.<br/>%s',
	'err_delete' => 'Një gabim ndodhi gjatë fshini mbi PN e tyre.',
	'err_folder_exists' => 'Kjo dosje tashmë ekziston.',
	'err_folder_len' => 'Emri i dosjes duhet të jetë një deri në %s Figurë.',
	'err_del_twice' => 'Ju keni fshirë PN tashmë.',
	'err_folder' => 'Dosje është i panjohur.',
	'err_pm_read' => 'Mesazhi juaj u lexuar. Ju nuk mund të ndryshojë tani.',

	# Messages
	'msg_sent' => 'Mesazhi juaj është dërguar me sukses. Ju mund të redaktoni deri sa u lexuar.',
	'msg_ignored' => 'Ata injorojë mesazhet nga tani %s.',
	'msg_unignored' => 'Ato lejojnë mesazhe nga përsëri %s.',
	'msg_changed' => 'Cilësimet e tuaja janë ruajtur.',
	'msg_deleted' => 'Ajo u %s Mesazh shënoi për fshirje.',
	'msg_moved' => 'Ajo u %s Mesazh vonuar.',
	'msg_edited' => 'Mesazhi i juaj është ndryshuar.',
	'msg_restored' => 'Ajo u %s Mesazh restauruar.',
	'msg_auto_folder_off' => 'Ju nuk kanë bërë të mundur dosje automatike. PN është shënuar, si të lexuar.',
	'msg_auto_folder_none' => 'Ka vetëm %s PN me këtë përdorues. Ajo ishte ishin nuk mesazh e vonuar. Mesazhi është shënuar si të lexuar.',
	'msg_auto_folder_created' => 'Ajo u krijua %s.',
	'msg_auto_folder_moved' => 'Ka qenë %s Mesazh për %s lëvizur. Mesazhet janë shënuar si të lexuar.',
	'msg_auto_folder_done' => 'Sorting automatik dosje ishte kryer.',


	# Titles
	'ft_create' => 'Një mesazh i ri per %s shkruaj',
	'ft_preview' => 'Shoh',
	'ft_options' => 'Parametrat e PN',
	'ft_ignore' => 'Shpërfill dikush',
	'ft_new_pm' => 'mesazh i ri',
	'ft_reply' => 'Përgjigju %s',
	'ft_edit' => 'puno Mesazh',
	'ft_quicksearch' => 'Kërkim',
	'ft_advsearch' => 'Kërkim zgjeruar',

	# Tooltips
	'tt_pmo_auto_folder' => 'Nëse ju shkruani një përdorues që numrin e mesazheve automatikisht krijon një dosje për këtë përdorues, dhe PN, do të zhvendoset atje automatikisht me këtë përdorues.',

	
	# Table Headers
	'th_pmo_options&1' => 'Dërgo me email per PN reja',
	'th_pmo_options&2' => 'Më lejoni të dërgojë vizitorë PN',
	'th_pmo_auto_folder' => 'Perdorues dosje pas N generate mesazhe',
	'th_pmo_signature' => 'Juaj PN Nënshkrim',

	'th_pm_options&1' => 'I ri',
	'th_actions' => ' ',
	'th_user_name' => 'Përdorues',
	'th_pmf_name' => 'Dosje',
	'th_pmf_count' => 'Numër',
	'th_pm_id' => 'ID ',
	'th_pm_to' => 'Te',
	'th_pm_from' => 'E',
//	'th_pm_to_folder' => 'To Folder',
//	'th_pm_from_folder' => 'From Folder',
	'th_pm_date' => 'Data',
	'th_pm_title' => 'Titull',
	'th_pm_message' => 'Mesazh',
//	'th_pm_options' => 'Einstellungen',

	# Welcome PM
	'wpm_title' => 'Mirë se vini në '.GWF_SITENAME,
	'wpm_message' => 
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Mirë se vini në '.GWF_SITENAME.''.PHP_EOL.
		PHP_EOL.
		'Ne shpresojmë që ju si faqen tonë të internetit dhe të argëtohen me të.'.PHP_EOL,
		
	# New PM Email
	'mail_subj' => GWF_SITENAME.': Të PN %s',
	'mail_body' =>
		'Hallo %s'.PHP_EOL.
		PHP_EOL.
		'Nuk është një mesazh të ri privat në për ju '.GWF_SITENAME.'.'.PHP_EOL.
		PHP_EOL.
		'E: %s'.PHP_EOL.
		'Titull: %s'.PHP_EOL.
		PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		PHP_EOL.
		'--------------------------------------------------------------------------'.
		PHP_EOL.
		PHP_EOL.
		'Ju tani mund të ...'.PHP_EOL.
		'Ky mesazh automatikisht do lloj:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'Kjo fshini mesazh:'.PHP_EOL.
		'%s'.PHP_EOL.
		PHP_EOL.
		'I juaji sinqerisht,'.PHP_EOL.
		''.GWF_SITENAME.' Dorëshkrim'.PHP_EOL,
		
	# Admin Config
	'cfg_pm_captcha' => 'Mysafir-CAPTCHA?',
	'cfg_pm_causes_mail' => 'EMail on PN lejoj?',
	'cfg_pm_for_guests' => 'Mysafir PN lejoj?',
	'cfg_pm_welcome' => 'Mirëpritur-PN dërgoj?',
	'cfg_pm_limit' => 'Maksimale PN (Numër)',
	'cfg_pm_maxfolders' => 'Numri maksimal i dosjeve për përdorues',
	'cfg_pm_msg_len' => 'Gjatësia më e madhe e një mesazhi',
	'cfg_pm_per_page' => 'PN për faqe',
	'cfg_pm_sig_len' => 'Gjatësia më e madhe e një nënshkrim',
	'cfg_pm_title_len' => 'Gjatësia më e madhe e një titull',
	'cfg_pm_bot_uid' => 'Mirë se vini PN - UID e dërguesit',
	'cfg_pm_sent' => 'Dërgo PN akuzë',
	'cfg_pm_mail_sender' => 'Email Sender Email PN',
	'cfg_pm_re' => 'Titulli i paraprirë (RE: )',
	'cfg_pm_limit_timeout' => 'Maksimale PN (Periudhë)',
	'cfg_pm_fname_len' => 'Gjatësia më e madhe e një emri dosje',
	
	# v2.01
	'err_ignore_admin' => 'Ju mund të injoroni çdo administratorëve.',
	'btn_new_folder' => 'Re Dosja',
		
	# v2.02
	'msg_mail_sent' => 'Një email me mesazhin e saj origjinal është dërguar %s dërguar.',
		
	# v2.03 SEO
	'pt_pm' => 'PN',
		
	# v2.04 fixes
	'ft_new_folder' => 'Krijo një dosje të re',

	# v2.05 (prev+next)
	'btn_prev' => 'mesazhin e mëparshme',
	'btn_next' => 'tjetër mesazhin',
		
	# v2.06 (icon titles+bots)
	'gwf_pm_deleted' => 'Marrësit e ka fshi kete mesazh.',
	'gwf_pm_read' => 'Marrësi ka lexuar mesazhin.',
	'gwf_pm_unread' => 'Mesazhi është i palexuar.',
	'gwf_pm_old' => 'Mesazh Lexoni.',
	'gwf_pm_new' => 'PN të reja për ta.',
	'err_bot' => 'Robot nuk mund të dërgoni PN.',

	# v2.07 (fixes)
	'err_ignore_self' => 'Ju nuk mund të injorojë veten.',
	'err_folder_perm' => 'Kjo dosje nuk i takon ti.',
	'msg_folder_deleted' => 'Dosje %s dhe %s mesazh ishte te re në Shportë.',
	'cfg_pm_delete' => 'Lejon fshirjen e të PN?',
	'ft_empty' => 'Bosh plehra',
	'msg_empty' => 'Plehra juaj (%s Mesazha) pastrohen.<br/>%s Mesazh ishte do të eleminohet nga database.<br/>%s Mesazh nuk mund të fshihet sepse e kundërta ka arkivuar mesazh akoma.',
	# v2.08 (GT)
	'btn_translate' => 'Translate with Google',
	# monnino fixes
	'cfg_pm_limit_per_level' => 'PM limit per level',
	'cfg_pm_own_bot' => 'PM own bot',
	'th_reason' => 'Reason',
	# v2.09 (pmo_level)
	'err_user_pmo_level' => 'This user requires you to have a userlevel of %s to send him PM.',
	'th_pmo_level' => 'Min userlevel of sender',
	'tt_pmo_level' => 'Set a minimal userlevel requirement to allow to send you PM',
);
