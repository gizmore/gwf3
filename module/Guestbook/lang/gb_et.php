<?php

$lang = array(

	# Default GB Name
	'default_title' => GWF_SITENAME.' Külalisteraamat',
	'default_descr' => 'The '.GWF_SITENAME.' Külalisteraamat',

	# Errors
	'err_gb' => 'Külalisteraamatut ei ole.',
	'err_gbm' => 'Külalisteraamatu sissekannet ei ole.',
	'err_gbm_username' => 'Teie kasutajanimi on vigane. See peab olema %1% kuni %2% tähte pikk.',
	'err_gbm_message' => 'Teie sõnum on vigane. See peab olema %1% kuni %2% tähte pikk.',
	'err_gbm_url' => 'Teie veebisait ei ole kättesaadav või on see vigane.',
	'err_gbm_email' => 'Teie e-mail on vigane.',
	'err_gb_title' => 'Teie pealkiri on vigane. See peab olema %1% kuni %2% tähte pikk.',
	'err_gb_descr' => 'Teie kirjeldus on vigane. See peab olema %1% kuni %2% tähte pikk.',

	# Messages
	'msg_signed' => 'Olete edukalt teinud sissekande külalisteraamatusse.',
	'msg_signed_mod' => 'Tegite sissekande, kuid enne avaldamist vaadatakse see üle.',
	'msg_gb_edited' => 'Külalisteraamatut on muudetud.',
	'msg_gbm_edited' => 'Sissekannet on muudetud.',
	'msg_gbm_mod_0' => 'Sissekanne on nüüd nähtav.',
	'msg_gbm_mod_1' => 'Sissekanne on modereerimisjärjekorras.',
	'msg_gbm_pub_0' => 'Sissekanne on nüüd mittenähtav külalistele.',
	'msg_gbm_pub_1' => 'Sissekanne on nüüd nähtav külalistele.',

	# Headers
	'th_gbm_username' => 'Sinu nimi',
	'th_gbm_email' => 'Sinu e-mail',
	'th_gbm_url' => 'Sinu veebilehekülg',
	'th_gbm_message' => 'Sinu sõnum',
	'th_opt_public' => 'Sõnum nähtav kõigile?',
	'th_opt_toggle' => 'Luba kasutada avalikke lippe?',
	'th_gb_title' => 'Pealkiri',
	'th_gb_locked' => 'Lukus?',
	'th_gb_moderated' => 'Modereeritav?',
	'th_gb_guest_view' => 'Teistele nähtav?',
	'th_gb_guest_sign' => 'Külalistele märgistatav?',
	'th_gb_bbcode' => 'Luba BBCode?',
	'th_gb_urls' => 'Luba kasutajate URL?',
	'th_gb_smiles' => 'Luba smailid?',
	'th_gb_emails' => 'Luba kasutajatel e-mailida?',
	'th_gb_descr' => 'Kirjeldus',
	'th_gb_nesting' => 'Lubatud?',

	# Tooltips
	'tt_gbm_email' => 'Kui sa valid e-maili, on see kõigile nähtav!',
	'tt_gb_locked' => 'Jutumärgid, et ajutiselt sissekanne nähtamatuks muuta',

	# Titles
	'ft_sign' => 'Märgi %1%',
	'ft_edit_gb' => 'Muuda külalisteraamatut',
	'ft_edit_entry' => 'Muuda külalisteraamatu sissekannet',

	# Buttons
	'btn_sign' => 'Märgi %1%',
	'btn_edit_gb' => 'Muuda külalisteraamatut',
	'btn_edit_entry' => 'Muuda sissekannet',
	'btn_public_hide' => 'Varja see sissekanne külaliste eest',
	'btn_public_show' => 'Näita seda sissekannet kõigile',
	'btn_moderate_no' => 'Luba seda kõigil näha',
	'btn_moderate_yes' => 'Varja see postitus ja pane see modereerimis järjekorda',
	'btn_replyto' => 'Vasta %1%',

	# Admin Config
	'cfg_gb_allow_email' => 'Luba ja näita e-maile?',
	'cfg_gb_allow_url' => 'Luba ja näite veebisaite?',
	'cfg_gb_allow_guest' => 'Luba külaliste postitused?',
	'cfg_gb_captcha' => 'Captcha külalistele?',
	'cfg_gb_ipp' => 'Sissekandeid lehekülje kohta',
	'cfg_gb_max_msglen' => 'Suurim sõnumi pikkus',
	'cfg_gb_max_ulen' => 'Maksimaalne külalise nime pikkus',
	'cfg_gb_max_titlelen' => 'Maksimaalne sissekande pealkirja pikkus',
	'cfg_gb_max_descrlen' => 'Maksimaalne sissekande kirjelduse pikkus',

	# v2.01 fixes and mail
	'cfg_gb_level' => 'Minimaalne tase, et teha külalisteraamatut',
	'mails_signed' => GWF_SITENAME.': Külalisteraamat märgistatud',
	'mailb_signed' => 
		'Kallis meeskond'.PHP_EOL.
		PHP_EOL.
		'%1% külalisteraamat sai märgistatud %2% poolt(%3%)'.PHP_EOL.
		'Sõnum:'.PHP_EOL.
		'%4%'.PHP_EOL.
		PHP_EOL.
		'Saad seda postitust automaatselt näidata, kui külastad:'.PHP_EOL.
		'%5%'.PHP_EOL,

	# v2.02 Mail on Sign
	'th_mailonsign' => 'EMail on new entry?',
	'mails2_signed' => GWF_SITENAME.': Guestbook signed',
	'mailb2_signed' => 
		'Dear %1%'.PHP_EOL.
		PHP_EOL.
		'The %2% guestbook got signed by %3% (%4%)'.PHP_EOL.
		'Message:'.PHP_EOL.
		'%5%'.PHP_EOL,

	# v2.03 (Delete entry)
	'btn_del_entry' => 'Delete entry',
	'msg_e_deleted' => 'The entry got deleted.',

	# v2.04 (finish)
	'cfg_gb_menu' => 'Show in menu?',
	'cfg_gb_nesting' => 'Allow nesting?',
	'cfg_gb_submenu' => 'Show in submenu?',
	'err_locked' => 'This guestbook is currently locked.',

	# v2.05 (showmail)
	'th_opt_showmail' => 'Show EMail to public?',
);

?>

