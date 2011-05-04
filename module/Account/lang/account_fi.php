<?php
$lang = array(

	# Titles
	'form_title' => 'Tilin asetukset',
	'chmail_title' => 'Kirjoita uusi sähköpostiosoitteesi',

	# Headers
	'th_username' => 'Käyttäjänimesi',
	'th_email' => 'E-mail yhteydenotoille',
	'th_demo' => 'Väestörakenne Asetukset - Voit vaihtaa näitä vain kerran %1%.',
	'th_countryid' => 'Maa',	
	'th_langid' => 'Ensisijainen Kieli',	
	'th_langid2' => 'Toissijainen Kieli',
	'th_birthdate' => 'Syntymäaikasi',
	'th_gender' => 'Sukupuolesi',
	'th_flags' => 'Asetukset - Voit vaihtaa näitä lennossa',
	'th_adult' => 'Halutakto nähdä aikuisviihdettä?',
	'th_online' => 'Piilotetaanko online tilasi?',
	'th_show_email' => 'Näytetäänkö sähköpostiosoitettasi muille?',
	'th_avatar' => 'Avatarisi',
	'th_approvemail' => '<b>Sähköpostiosoitettasi<br/>ei hyväksytty</b>',
	'th_email_new' => 'Uusi sähköpostiosoitteesi',
	'th_email_re' => 'Kirjoita sähköpostiosoitteesi uudestaan',

	# Buttons
	'btn_submit' => 'Tallenna muutokset',
	'btn_approvemail' => 'Hyväksy sähköpostiosoite',
	'btn_changemail' => 'Aseta uusi sähköpostiosoite',
	'btn_drop_avatar' => 'Poista avatar',

	# Errors
	'err_token' => 'Virheellinen merkki.',
	'err_email_retype' => 'Sinun täytyy kirjoittaa sähköpostiosoitteesi uudestaan oiken.',
	'err_delete_avatar' => 'Virhe poistettaessa avatatariasi.',
	'err_no_mail_to_approve' => 'Sinulla ei ole sähköpostia jonka voisi hyväksyä.',
	'err_already_approved' => 'Sähköpostisi on jo hyväksytty.',
	'err_no_image' => 'Lähettämäsi tiedosto ei ole kuva tai se on liian pieni.',
	'err_demo_wait' => 'Vaihdoit väestönrakenne asetukset juuri. Ole hyvä ja odota %1%.',
	'err_birthdate' => 'Syntymäpäiväsi on virheellinen.',

	# Messages
	'msg_mail_changed' => 'Yhteyssähköpostiosoiteesi muutettiin <b>%1%</b>.',
	'msg_deleted_avatar' => 'Avatarisi on poistettu.',
	'msg_avatar_saved' => 'Uusi avatarisi on tallenettu.',
	'msg_demo_changed' => 'sinun Väestönrakenne asetukset ovat vaihdettu.',
	'msg_mail_sent' => 'Olemme lähettäneet sinulle sähköpostia suorittaaksesi muutokset. Seuraa sähköpostissa saamiasi ohjeita.',
	'msg_show_email_on' => 'Sähköpostiosoitteesi on nyt kaikkien nähtävissä.',
	'msg_show_email_off' => 'Sähköpostiosoitteesi on nyt piiloitettu muilta.',
	'msg_adult_on' => 'Näet nyt myös aikuisviihdettä.',
	'msg_adult_off' => 'Aikuisviihde on piilotettu sinulta.',
	'msg_online_on' => 'Onlinetilasi on nyt piiloitettu.',
	'msg_online_off' => 'Online tilasi on nyt näkyvissä.',

	# Admin Config
	'cfg_avatar_max_x' => 'Avatarin maksimi leveys',
	'cfg_avatar_max_y' => 'Avatarin maksimi korkeus',
	'cfg_avatar_min_x' => 'Avatarin minimi leveys',
	'cfg_avatar_min_y' => 'Avatarin minimi korkeus',
	'cfg_adult_age' => 'Minimi Ikä Aikuisviihteelle',
	'cfg_demo_changetime' => 'Väestörakenteen muutoksen aikaloppui',
	'cfg_mail_sender' => 'Muuta tilin sähköpostin lähettäjää.',
	'cfg_show_adult' => 'Sivulla on aikuisviihdettä?',
	'cfg_show_gender' => 'Näytä sukupuoli?',
	'cfg_use_email' => 'Vaadi sähköpostia tehdessä tili muutoksia?',
	'cfg_show_avatar' => 'Näytä Avataren lataus?',

############################
# --- EMAIL BELOW HERE --- #
	# CHANGE MAIL A
	'chmaila_subj' => GWF_SITENAME.': Muuta sähköpostin',
	'chmaila_body' => 
		'Hyvä %1%,'.PHP_EOL.
		PHP_EOL.
		'Olet pyytänyt muuttamaan sähköpostisi '.GWF_SITENAME.'.'.PHP_EOL.
		'Tehdä niin, sinun täytyy vierailla alla olevaa linkkiä.'.PHP_EOL.
		'Jos et pyytäny vaihtamaan sähköpostiasi, voit jättää tämän viestin tai ilmoituksen siitä meille.'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Tervehdys'.PHP_EOL.
		GWF_SITENAME.'  Henkilöstö',
				
	# CHANGE MAIL B
	'chmailb_subj' => GWF_SITENAME.': Vahvista sähköpostiosoitteesi',
	'chmailb_body' => 
		'Hyvä %1%,'.PHP_EOL.
		PHP_EOL.
		'Voit käyttää tätä sähköpostiosoite apusi osoitteen sinun on vahvistettava sen käymällä linkki alla:'.PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Tervehdys'.PHP_EOL.
		GWF_SITENAME.' Henkilöstö',
		
	# CHANGE DEMO
	'chdemo_subj' => GWF_SITENAME.': Muuta Väestörakenteen Asetukset',
	'chdemo_body' =>
		'Hyvä %1%'.PHP_EOL.
		PHP_EOL.
		'Olet pyytänyt setup tai vaihtaa väestörakenteen asetukset.'.PHP_EOL.
		'Voit tehdä tämän vain kerran %2%, joten varmista tiedot ovat oikein ennen kuin jatkat.'.PHP_EOL.
		PHP_EOL.
		'Sukupuoli: %3%'.PHP_EOL.
		'Maa: %4%'.PHP_EOL.
		'Ensisijainen kieli: %5%'.PHP_EOL.
		'Toissijainen kieli: %6%'.PHP_EOL.
		'Syntymäaika: %7%'.PHP_EOL.
		PHP_EOL.
		'Jos haluat pitää nämä asetukset clickaa alla olevaa linkkiä:'.PHP_EOL.
		'%8%'.
		PHP_EOL.
		'Tervehdys'.PHP_EOL.
		GWF_SITENAME.' Henkilöstö',

	# New Flags 
	'th_allow_email' => 'Sallin ihmisten lähettää sähköpostia',
	'msg_allow_email_on' => 'Ihmiset voivat nyt lähettää sinulle sähköpostia pilaamatta sähköpostiosoittettasi.',
	'msg_allow_email_off' => 'Sähköpostitse tavoittaminen otettu pois.',
		
	'th_show_bday' => 'Näytä syntymäpäivä',
	'msg_show_bday_on' => 'Sinun syntymäpäivä on nyt ilmoittanut jäsenille, jotka haluavat sitä.',
	'msg_show_bday_off' => 'Sinun syntymäpäivää ei ilmoiteta.',
		
	'th_show_obday' => 'Näytä muut syntymäpäivät',
	'msg_show_obday_on' => 'Näät nytten muitten syntymäpäivät.',
	'msg_show_obday_off' => 'Sivuutat syntymäpäivä ilmoitukset nyt.',
		
	# v2.02 Account Deletion
	'pt_accrm' => 'Poista tili',
	'mt_accrm' => 'Poista tilisi '.GWF_SITENAME,
	'pi_accrm' =>
		'Näyttää siltä että haluat poistaa tilisi '.GWF_SITENAME.'.<br/>'.
		'Olemme surullisia sillä, Tiliäsi ei poisteta, se vain otetaan pois käytöstä .<br/>'.
		'Kaikki linkit tähän käyttäjänimeen, profiiliin, jne, tulee käyttökelvottmaksi tai Nimetään uudelleen vieraalle. Tämä on peruuttamatonta.<br/>'.
		'Ennen kuin jaktat tilin poistamista, voit jättää meille tiedon syyt(t) miksi poistat sen.<br/>',
	'th_accrm_note' => 'Merkintä',
	'btn_accrm' => 'Poista tili',
	'msg_accrm' => 'Sinun tilisi on merkattu poistetuksi Kaikki viittaukset pitäisi olla poistettu.<br/>kirjauduit ulos.',
	'ms_accrm' => GWF_SITENAME.': %1% Tilin poisto',
	'mb_accrm' =>
		'Dear Staff'.PHP_EOL.
		''.PHP_EOL.
		'%1% on juuri poistanut tilinsö ja jättänyt tämän merkinnän (voi olla tyhjä):'.PHP_EOL.PHP_EOL.
		'%2%',

	# v2.03 Email Options
	'th_email_fmt' => 'Preferred EMail Format',
	'email_fmt_text' => 'Plain Text',
	'email_fmt_html' => 'Simple HTML',
	'err_email_fmt' => 'Please select a valid EMail Format.',
	'msg_email_fmt_0' => 'You will now receive emails in simple html format.',
	'msg_email_fmt_4096' => 'You will now receive emails in plain text format.',
	'ft_gpg' => 'Setup PGP/GPG Encryption',
	'th_gpg_key' => 'Upload your public key',
	'th_gpg_key2' => 'Or paste it here',
	'tt_gpg_key' => 'When you have set a pgp key all the emails sent to you by the scripts are encrypted with your public key',
	'tt_gpg_key2' => 'Either paste your public key here, or upload your public key file.',
	'btn_setup_gpg' => 'Upload Key',
	'btn_remove_gpg' => 'Remove Key',
	'err_gpg_setup' => 'Either upload a file which contains your public key or paste your public key in the text area.',
	'err_gpg_key' => 'Your public key seems invalid.',
	'err_gpg_token' => 'Your gpg fingerprint token does not match our records.',
	'err_no_gpg_key' => 'The user %1% did not submit a public key yet.',
	'err_no_mail' => 'You don`t have an approved main contact email address.',
	'err_gpg_del' => 'You don`t have a validated GPG key to delete.',
	'err_gpg_fine' => 'You already have a GPG key. Please delete it first.',
	'msg_gpg_del' => 'Your GPG key has been deleted successfully.',
	'msg_setup_gpg' => 'Your GPG has been stored and is in use now.',
	'mails_gpg' => GWF_SITENAME.': Setup GPG Encryption',
	'mailb_gpg' =>
		'Dear %1%,'.PHP_EOL.
		PHP_EOL.
		'You have decided to turn on gpg encryption for emails sent by this robot.'.PHP_EOL.
		'To do so, follow the link below:'.PHP_EOL.
		PHP_EOL.
		'%2%'.PHP_EOL.
		PHP_EOL.
		'Kind Regards'.PHP_EOL.
		'The '.GWF_SITENAME.' staff',

	# v2.04 Change Password
	'th_change_pw' => '<a href="%1%">Change your password</a>',
	'err_gpg_raw' => GWF_SITENAME.' does only support ascii armor format for your public GPG key.',
	# v2.05 (fixes)
	'btn_delete' => 'Delete Account',
	'err_email_invalid' => 'Your email looks invalid.',
);
?>