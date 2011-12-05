<?php

$lang = array(
	# Admin Config
	'cfg_link_guests' => 'Sallitaanko vieraitten linkit?',
	'cfg_link_guests_captcha' => 'näytetään Kuvavarmennus vieraille?',
	'cfg_link_guests_mod' => 'Hilitään vieraitten linkit?',
	'cfg_link_guests_votes' => 'Sallitaan vieraitten äänestää?',
	'cfg_link_long_descr' => 'Käytetäänkö toista / Pitkäää kuvausta?',
	'cfg_link_cost' => 'Pisteet per linkki',
	'cfg_link_max_descr2_len' => 'Suurin pituus Pitkässä kuvauksessa.',
	'cfg_link_max_descr_len' => 'Maksimi pituus lyhyessä kuvauksessa.',
	'cfg_link_max_tag_len' => 'Suurin tagin pituus',
	'cfg_link_max_url_len' => 'maksimi URL pituus',
	'cfg_link_min_descr2_len' => 'Pienin pitkän kuvauksen pituus',
	'cfg_link_min_descr_len' => 'Pienin Lyhyen kuvauksen. pituus',
	'cfg_link_min_level' => 'Vähimmäistaso lisätä linkki',
	'cfg_link_per_page' => 'linkkejä per sivu',
	'cfg_link_tag_min_level' => 'Vähimmäistaso lisätä tag',
	'cfg_link_vote_max' => 'maksimi äänestys pisteet',
	'cfg_link_vote_min' => 'pienin mahdollinen äänestys pisteet',
	'cfg_link_guests_unread' => 'Kesto linkki ilmestyy uusi vieraille',
	
	# Info`s
//	'pi_links' => '',
	'info_tag' => 'Määritä vähintään yksi Tag. Erilliset Tunnisteet pilkulla. Kokeile käyttää olemassa olevia tageja:',
	'info_newlinks' => 'sinulle on %s uutta linkkiä.',
	'info_search_exceed' => 'Haku ylitti tulos rajan %s.',

	# Titles
	'ft_add' => 'Lisää Linkki',
	'ft_edit' => 'Muokkaa Linkkiäsi',
	'ft_search' => 'Etsi linkkejä',
	'pt_links' => 'Kaikki linkit',
	'pt_linksec' => '%s Linkit',
	'pt_new_links' => 'uude linkit',
	'mt_links' => GWF_SITENAME.', Linkki, Lista, kaikki Linkti',
	'md_links' => 'Kaikki linkiit sivulla '.GWF_SITENAME.'.',
	'mt_linksec' => GWF_SITENAME.', Linkki, Lista, Linkit %s',
	'md_linksec' => '%s linkkiä sivulla '.GWF_SITENAME.'.',

	# Errors
	'err_gid' => 'Käyttäjä ryhmä ei kelpaa.',
	'err_score' => 'Virheelliset arvo pisteet.',
	'err_no_tag' => 'Ilmoitathan ainakin yhden tagin.',
	'err_tag' => 'Tagi %s ei kelvannut ja se poistettiin. The tag has to be %s - %s bytes.',
	'err_url' => 'Sivun URL ei kelpaa.',
	'err_url_dup' => 'URL onjo listattu tänne.',
	'err_url_down' => 'URL ei ole etsittävissä.',
	'err_url_long' => 'Sinun URL on liian pitkä. Maksimi %s bittiä.',
	'err_descr1_short' => 'Sinun kuvaus on liian lyhyt. Minimi %s bittiä.',
	'err_descr1_long' => 'Kuvauksesi on liian pitkä. Maksimi %s bittiä.',
	'err_descr2_short' => 'Sinun yksityiskohtainen kuvaus on liian lyhyt. Minimi %s bittiä.',
	'err_descr2_long' => 'yksityis koihtainen kuvaus on liian pitkä. Maximi %s bittiä.',
	'err_link' => 'Linkkiä ei löytynyt.',
	'err_add_perm' => 'Et saa lisätä linkkiä.',
	'err_edit_perm' => 'Et saa muokata tätä linkkiä.',
	'err_view_perm' => 'Et voi nähdä tätä linkkiä.',
	'err_add_tags' => 'Sinun ei sallita lisäävän tageja.',
	'err_score_tag' => 'sinun käyttäjälevel(%s) ei ole tarpeeksi suuri jotta voisit lisätä toisen tagin. tarttettu Level: %s.',
	'err_score_link' => 'sinun käyttäjälevel(%s) ei ole taerpeeksi suuri jotta voisit lisätä uuden linkin. Needed Level: %s.',
	'err_approved' => 'Linkki on jo hyväksytty. Käyttäkää henkilöstön osa ryhtymään toimiin.',
	'err_token' => 'Merkki ei kelpaa.',

	# Messages
//	'msg_redirecting' => 'Sinut ohjataan %s.',
	'msg_added' => 'Linkkisi on lisätty tietokantaan.',
	'msg_added_mod' => 'linkkisi on lisätty tietokantaan mutta, moderaattorin pitää tutkia se ensin.',
	'msg_edited' => 'Linkkiä on muokattu.',
	'msg_approved' => 'linkki on hyväksytty ja se on nyt näkyvillä.',
	'msg_deleted' => 'Linkki on poistettu.',
	'msg_counted_visit' => 'Sinun clickaus on nyt laskettu.',
	'msg_marked_all_read' => 'Kaikki linkit merkitty luetuiksi.',
	'msg_fav_no' => 'Linkki on poistettu suosikkilsitalta.',
	'msg_fav_yes' => 'linkki lisätty suosikkilistaan.',

	# Table Headers
	'th_link_score' => 'Pisteet',
	'th_link_gid' => 'Ryhmä',
	'th_link_tags' => 'tagit',
	'th_link_href' => 'HREF ',
	'th_link_descr' => 'Kuvaus',
	'th_link_descr2' => 'Yksityiskohtainen kuvaus',
	'th_link_options&1' => 'tahmainen?',
	'th_link_options&2' => 'kohtuullisesti?',
	'th_link_options&4' => 'ei näytetä käyttäjänimeä?',
	'th_link_options&8' => 'Näytetään vain jäsenille?',
	'th_link_options&16' => 'onko tämä linkki yksityinen?',
	'th_link_id' => 'ID ',
	'th_showtext' => 'Linkki',
	'th_favs' => 'Suosikkeihin',
	'th_link_clicks' => 'Käynnit',
	'th_vs_avg' => 'keskiarvo',
	'th_vs_sum' => 'summa',
	'th_vs_count' => 'Äänet',
	'th_vote' => 'Äänestä',
	'th_link_date' => 'Päivämäärä',
	'th_user_name' => 'käyttäjänimi',

	# Tooltips
	'tt_link_gid' => 'Rajoita Linkki käyttäjäryhmään (tai jätä tyhjäksi)',
	'tt_link_score' => 'Määritä vähimmäis käyttäjä Level (0-NNNN)',
	'tt_link_href' => 'Lähetä täydellinen URL, joka alkaa http://',

	# Buttons
	'btn_add' => 'lisää Linkki',
	'btn_delete' => 'poista Linkki',
	'btn_edit' => 'Muokkaa linkkiä',
	'btn_search' => 'haku',
	'btn_preview' => 'Ennakkoesitys',
	'btn_new_links' => 'Uusia linkkejä',
	'btn_mark_read' => 'merkkaa kaikki luetuksi',
	'btn_favorite' => 'Merkkaa suosikki linkiksi',
	'btn_un_favorite' => 'poista suosikki merkintö linkistä',
	'btn_search_adv' => 'Laajennettu haku',

	# Staff EMail
	'mail_subj' => GWF_SITENAME.': uusi Linkki',
	'mail_body' =>
		'Hyvä henkilöstö,'.PHP_EOL.
		PHP_EOL.
		'There has been posted a new Link from a guest that needs moderation:'.PHP_EOL.
		PHP_EOL.
		'Description: %s'.PHP_EOL.
		'Detailed D.: %s'.PHP_EOL.
		'HREF / URL : %s'.PHP_EOL.
		PHP_EOL.
		'You can either: '.PHP_EOL.
		'1) Approve this link by visiting %s'.PHP_EOL.
		'Or:'.PHP_EOL.
		'2) Delete this link by visiting %s'.PHP_EOL.
		PHP_EOL.
		'Kind Regards,'.PHP_EOL.
		'The '.GWF_SITENAME.' Script'.PHP_EOL,
		
	# v2.01 (SEO)
	'pt_search' => 'Haku linkit',
	'md_search' => 'haku linkit sivulla '.GWF_SITENAME.' website.',
	'mt_search' => 'Hae,'.GWF_SITENAME.',Links',
		
	# v2.02 (permitted)
	'permtext_in_mod' => 'Tämä linkki on moderatiossa',
	'permtext_score' => 'Tarvitset käyttäjä levelin %s nähdäksesi tämän linkin',
	'permtext_member' => 'tämä linkki on vain käyttäjille',
	'permtext_group' => 'sinun pitää olla %s ryhmässä nähdäksesi linkin',
	'cfg_show_permitted' => 'Näytä kiellettyjen linkkejä syy?',
		
);

?>