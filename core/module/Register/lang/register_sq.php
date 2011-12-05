<?php
$lang = array(
	'pt_register' => 'Regjistrohu në '.GWF_SITENAME,

	'title_register' => 'Regjistër',

	'th_username' => 'Emri i përdoruesit',
	'th_password' => 'Fjalëkalim',
	'th_email' => 'E-Mail',
	'th_birthdate' => 'Data e lindjes',
	'th_countryid' => 'Vend',
	'th_tos' => 'Unë pajtohem me kushtet',
	'th_tos2' => 'Pajtohem ne <a href="%s">bazen e Shërbimit </a>',
	'th_register' => 'Regjistër',

	'btn_register' => 'Regjistër',
	
	'err_register' => 'Ka ndodhur një gabim gjatë regjistrimit.',
	'err_name_invalid' => 'Emri i përdoruesit juaj është i pavlefshëm.',
	'err_name_taken' => 'Emri i përdoruesit e zgjedhur është marrë tashmë.',
	'err_country' => 'Vendi juaj i zgjedhur është i pavlefshëm.',
	'err_pass_weak' => 'Fjalëkalimi juaj zgjedhur është shumë e shkurtër. Tippi: <b>Përdoreni fjalëkalimet e rëndësishme më shumë se një herë</b>.',
	'err_token' => 'kod aktivizimi juaj është i pavlefshëm. Ndoshta ata janë aktivizuar tashmë.',
	'err_email_invalid' => 'Emaili juaj është i pavlefshëm.',
	'err_email_taken' => 'Emaili juaj eshte i zene.',
	'err_activate' => 'Kur ju aktivizoni nje gabim ka ndodhur.',

	'msg_activated' => 'Llogaria juaj është aktivizuar tani, dhe ata mund të identifikohem me të dhënat e tyre të përdoruesit.',
	'msg_registered' => 'Ju faleminderit per regjistrimin tuaj.',

	'regmail_subject' => GWF_SITENAME.': Aplikim',
	'regmail_body' => 
		'Përshëndetje %s<br/>'.
		'<br/>'.
		'Ju faleminderit per regjistrimin tuaj ne '.GWF_SITENAME.'.<br/>'.
		'Për të mbaruar regjistrimin, llogaria juaj duhet të aktivizohet duke vizituar linkun e mëposhtëm.<br/>'.
		'Nëse ata nuk janë edhe më '.GWF_SITENAME.' janë regjistruar, ju lutem injoroni kete email, ose të regjistroheni në këtë përmes një e-mail '.GWF_SUPPORT_EMAIL.'.<br/>'.
		'<br/>'.
		'%s<br/>'.
		'<br/>'.
		'%s'.
		'Te Mire,<br/>'.
		''.GWF_SITENAME.' Teami.',

	'err_tos' => 'Ju duhet të bien dakord me termat e përdorimit.',

	'regmail_ptbody' => 
		'Këtu përsëri fjalëkalimin tuaj:<br/><b>'.
		'Emri i përdoruesit: %s<br/>'.
		'Fjalëkalim: %s<br/>'.
		'</b><br/>'.
		'Kjo është një ide e mirë për të fshini kete e-mail dhe fjalëkalimin mbajtur të sigurt.<br/>'.
		'Ne dyqan fjalëkalimin tuaj në tekst i qartë edhe nga, por ato mund të aplikohen në çdo kohë nëpërmjet këtij e-mail një të ri.<br/>'.
		'<b>Sigurinë e llogarisë tuaj varet shumë nga sigurinë e kjo llogari e-mailit.</b>.'.
		'<br/>',

	### Admin Config ###
	'cfg_auto_login' => 'Auto-login pas aktivizimi?',	
	'cfg_captcha' => 'Captcha Përdorimi?',
	'cfg_country_select' => 'Vendet zgjedhjes?',
	'cfg_email_activation' => 'Aktivizimi Përdorimi Email?', ## Deutsche Version ist hier falsch!
	'cfg_email_twice' => 'Në të njëjtin email disa herë e lejuar?',
	'cfg_force_tos' => 'Shërbimi Kontrollo?',
	'cfg_ip_usetime' => 'IP për të bllokuar aktivizimin e',
	'cfg_min_age' => 'moshën minimale / përzgjedhjes ditëlindjen.',
	'cfg_plaintextpass' => 'Fjalëkalimi Dërgo në tekstin e qartë kur prerjet.',
	'cfg_activation_pp' => 'Numri i linjave për faqe Admin',
	'cfg_ua_threshold' => 'Afati i fundit për të kompletuar regjistrimin',

	'err_birthdate' => 'ditëlindjen e juaj nuk është e vlefshme.',
	'err_minage' => 'Ju nuk jeni të vjetër të mjaftueshme për të përshtatur për të '.GWF_SITENAME.' të regjistroheni. Ju duhet të jetë së paku %s Vjeçare.',
	'err_ip_timeout' => 'Kjo IP ka krijuar kohët e fundit një llogari.',
	'th_token' => 'Kod',
	'th_timestamp' => 'Data e regjistrimit',
	'th_ip' => 'IP e identifikimit',
	'tt_username' => 'Emri i përdoruesit duhet të fillojë me një letër.'.PHP_EOL.'Ai duhet të përmbajë vetëm numrat, dhe _ Letra. Gjatësia e lejuara: 3 - %s Shenjë.', 
	'tt_email' => 'Një email vlefshme është e nevojshme për aplikimin.',

	'info_no_cookie' => 'Shfletuesi juaj nuk e përkrah cookie-t, ose nuk është i lejuar ato. Për të kyçeni këto janë të nevojshme, megjithatë.',

	# v2.01 (fixes)
	'msg_mail_sent' => 'Ju do të dërgohet një email të aktivizoni llogarinë tuaj.',

	# v2.02 (Detect Country)
	'cfg_reg_detect_country' => 'Përdorues të hyrë në vend gjithmonë automatikisht',

	# v2.03 (Links)
	'btn_login' => 'Hyni',
	'btn_recovery' => 'Keni harruar fjalëkalimin',
	# v2.04 (Fixes)
	'tt_password' => 'Your password can be chosen freely. Please do not re-use important passwords. Consider a short phrase as password.',
	# v2.05 (Blacklist)
	'err_domain_banned' => 'Your email provider is on the blacklist.',
);
?>
