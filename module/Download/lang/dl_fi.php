<?php
$lang = array(
	# Page Titles
	'pt_list' => 'Latausosio',
	'mt_list' => 'Latausosio, Ladattavat, Yksinoikeudelliset ladattavat, '.GWF_SITENAME,
	'md_list' => 'Yksinoikeudelliset ladattavat sivulla '.GWF_SITENAME.'.',

	# Page Info
	'pi_add' => 'Saadaksesi parhaan käyttökokemuksen lähetä tiedostosi ensin, se varastoidaan istuntoosi. Muuta asetuksia jälkeenpäin.<br/>Lähetyksen maksimikoko on %1%.',

	# Form Titles
	'ft_add' => 'Lähetä tiedosto',
	'ft_edit' => 'Muokkaa latausta',
	'ft_token' => 'Ilmoita latauskoodisi',

	# Errors
	'err_file' => 'Sinun täytyy lähettää tiedosto.',
	'err_filename' => 'Määrittelemäsi tiedostonimi on virheellinen. Maksimipituus on %1%. Käytä tavallisia ascii-merkkejä.',
	'err_level' => 'Käyttäjätason täytyy olla >= 0.',
	'err_descr' => 'Kuvauksen täytyy 0-%1% merkkiä pitkä.',
	'err_price' => 'Hinnan täytyy olla väliltä %1% - %2%.',
	'err_dlid' => 'Lataamisen kohdetta ei löytynyt.',
	'err_token' => 'Latauskoodisi on virheellinen.',

	# Messages
	'prompt_download' => 'Paina OK ladataksesi tiedoston',
	'msg_uploaded' => 'Tiedostosi on lähetetty onnistuneesti.',
	'msg_edited' => 'Lataustasi on muokattu onnistuneesti.',
	'msg_deleted' => 'Lataus on poistettu onnistuneesti.',

	# Table Headers
	'th_dl_filename' => 'Tiedostonimi',
	'th_file' => 'Tiedosto',
	'th_dl_id' => 'ID ',
	'th_dl_gid' => 'Tarvittava ryhmä',
	'th_dl_level' => 'Tarvittava taso',
	'th_dl_descr' => 'Kuvaus',
	'th_dl_price' => 'Hinta',
	'th_dl_count' => 'Latausten määrä',
	'th_dl_size' => 'Tiedostokoko',
	'th_user_name' => 'Lähettäjä',
	'th_adult' => 'Aikuissisältöä??',
	'th_huname' => 'Piilota käyttäjänimi?',
	'th_vs_avg' => 'Äänestä',
	'th_dl_expires' => 'Raukeaa',
	'th_dl_expiretime' => 'Latauksen voimassaoloaika',
	'th_paid_download' => 'Tiedoston lataaminen vaatii maksun',
	'th_token' => 'Latauskoodi',

	# Buttons
	'btn_add' => 'Lisää',
	'btn_edit' => 'Muokkaa',
	'btn_delete' => 'Poista',
	'btn_upload' => 'Lähetä',
	'btn_download' => 'Lataa',
	'btn_remove' => 'Poista',

	# Admin config
	'cfg_anon_downld' => 'Salli vieraiden ladata',
	'cfg_anon_upload' => 'Salli vieraiden lähettää',
	'cfg_user_upload' => 'Salli käyttäjien lähettää',
	'cfg_dl_gvotes' => 'Salli vieraiden äänestää',	
	'cfg_dl_gcaptcha' => 'Vieraiden lähetysten Captcha',	
	'cfg_dl_descr_max' => 'Kuvauksen maksimipituus',
	'cfg_dl_descr_min' => 'Kuvauksen minimipituus',
	'cfg_dl_ipp' => 'Kohteita/sivu',
	'cfg_dl_maxvote' => 'Äänestyksen maksimipistemäärä',
	'cfg_dl_minvote' => 'Äänestyksen minimipistemäärä',

	# Order
	'order_title' => 'Latauskoodi kohteelle %1% (Koodi: %2%)',
	'order_descr' => 'Latauskoodi ostettu kohteelle %1%. Voimassaoloaika %2%. Koodi: %3%',
	'msg_purchased' => 'Maksusuorituksesi on vastaanotettu ja latauskoodi lisätty.<br/>Koodisi on \'%1%\' ja voimassaoloaika %2%.<br/><b>Kirjoita koodi muistiin, jos sinulla ei ole tunnusta palvelussa '.GWF_SITENAME.'!</b><br/>Muutoin <a href="%3%">paina tästä</a>.',

	# v2.01 (+col)
	'th_purchases' => 'Ostot',

	# v2.02 Expire + finsih
	'err_dl_expire' => 'Raukeamisajan täytyy olla väliltä 0 sekuntia ja 5 vuotta.',
	'th_dl_expire' => 'Lataus raukeaa jälkeen',
	'tt_dl_expire' => 'Keston määritelmä kuten 5 sekuntia tai 1 kuukausi ja 3 päivää.',
	'th_dl_guest_view' => 'Näkyy vieraille?',
	'tt_dl_guest_view' => 'Saavatko vieraat nähdä tämän ladattavan?',
	'th_dl_guest_down' => 'Vieraiden ladattavissa?',
	'tt_dl_guest_down' => 'Saavatko viearaat ladata tämän tiedoston??',
	'ft_reup' => 'Uudelleenlähetä tiedosto',
	'order_descr2' => 'Latauskoodi ostettu kohteelle %1%. Koodi: %2%.',
	'msg_purchased2' => 'Maksusuorituksesi on vastaanotettu ja latauskoodi asetettu.<br/>Koodisi on \'%1%\'.<br/><b>Kirjoita koodi muistiin, jos sinulla ei ole tunnusta palvelussa '.GWF_SITENAME.'!</b><br/>Muutoin <a href="%2%">paina tästä</a>.',
	'err_group' => 'Sinun täytyy kuulua käyttäjäryhmään %1% ladataksesi tämän tiedoston.',
	'err_level' => 'Käyttäjätasosi tulee olla %1% ladataksesi tämän tiedoston.',
	'err_guest' => 'Vieraat eivät saa ladata tätä tiedostoa.',
	'err_adult' => 'Tämä on aikuissisältöinen.',

	'th_dl_date' => 'Date',
);
?>
