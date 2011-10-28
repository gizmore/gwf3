<?php
$lang = array(

	'alt_flag' => '%1$s',

	# Page Info
	'pi_invited' => 'Sait kutsun <a href="%3$s">liity %1$ss käyttäjäryhmä &quot;%2$s&quot;</a>.<br/><br/><br/>tai <a href="%4$s">klikkaa tästä huvikseen</a>.',

	# Avatar Gallery
	'pt_avatars' => 'Avatari Galleria.',
	'pi_avatars' => ''.GWF_SITENAME.' avatari galleria.',
	'mt_avatars' => GWF_SITENAME.', Avatari, Galleria',
	'md_avatars' => 'Käyttäjän avatari galleria '.GWF_SITENAME,

	# Table Headers 
	'th_name' => 'Ryhmän nimi',
	'th_join' => 'Kuinka liityn',
	'th_view' => 'Näkyvyys',
	'th_user_name' => 'Käyttäjänimi',
	'th_user_level' => 'Taso',
	'th_user_email' => 'EMail',
	'th_user_regdate' => 'Rekisteröinti-päivä',
	'th_user_birthdate' => 'Syntymäaika',
	'th_user_lastactivity' => 'Viimeksi aktiivinen',
	'th_group_name' => 'Ryhmän nimi',
	'th_group_memberc' => 'Jäsenet',
	'th_group_founder' => 'Tekijä',

	# Form Titles
	'ft_edit' => 'Muokkaa käyttäjäryhmää',
	'ft_create' => 'Tee uusi käyttäjäryhmä',
	'ft_invite' => 'Kutsu joku ryhmääsi',

	# Buttons
	'btn_kick' => 'Potki käyttäjä',
	'btn_edit' => 'Muokkaa ryhmää',
	'btn_delete' => 'Poista ryhmä',
	'btn_create' => 'Tee ryhmä',
	'btn_invite' => 'Kutsu käyttäjä',
	'btn_accept' => 'Hyväksy jäsen',
	'btn_gallery' => 'Avatari Galleria',
	'btn_search' => 'Etsi käyttäjä',
	'btn_part' => 'Osa',
	'btn_add_group' => 'Tee ryhmä',

	# Errors
	'err_perm' => 'Sinulla ei ole oikeutta tehdä ryhmää.',
	'err_join' => 'Liittyminen on virheellinen.',
	'err_view' => 'Katsominen on virheellinen.',
	'err_name' => 'Ryhmän nimi on virheellinen. Sen pitää olla %1$s -> %2$s merkkiä pitkä ja alkaa kirjaimella.',
	'err_group_exists' => 'Sinulla on jo käyttäjäryhmä.',
	'err_group' => 'Sinulla ei ole käyttäjäryhmää.',
	'err_kick_leader' => 'Et voi potkia tekijää.',
	'err_kick' => 'Käyttäjä %1$s ei ole ryhmässä.',
	'err_unk_group' => 'Ryhmä on tuntematon.',
	'err_no_join' => 'Et voi itse liittyä ryhmään.',
	'err_join_twice' => 'Olet jo valmiiksi tässä ryhmässä.',
	'err_request_twice' => 'Lähetit jo kutsun tähän käyttäjäryhmään',
	'err_not_invited' => 'Et ole saanut kutsua tähän ryhmään.',

	# Messages
	'msg_created' => 'Käyttäjäryhmä tehty.',
	'msg_edited' => 'Käyttäjäryhmä muokattu.',
	'msg_kicked' => '%1$s potkittu.',
	'msg_joined' => 'Lisäsit käyttäjän &quot;%1$s&quot;.',
	'msg_requested' => 'Halusit liittyä &quot;%1$s&quot;.',
	'msg_accepted' => 'Käyttäjä %1$s on nyt jäsen käyttäjäryhmän &quot;%2$s&quot;.',
	'msg_invited' => 'Sinä kutsuit %1$s ryhmääsi.',
	'msg_refused' => 'Postit kutsun ryhmääsi käyttäjältä &quot;%1$s&quot;.',

	# Selects
	'sel_join_type' => 'Miten käyttäjät liittyvät ryhmääsi?',
	'sel_join_1' => 'Ryhmä on täysi',
	'sel_join_2' => 'Kutsulla',
	'sel_join_4' => 'Moderoitu lista',
	'sel_join_8' => 'Klikka ja liity',
	'sel_join_16' => 'Skriptin kautta',
	'sel_view_type' => 'Valitse ryhmän näkyvyys',
	'sel_view_'.(0x100) => 'Julkinen',
	'sel_view_'.(0x200) => 'Vain '.GWF_SITENAME.' jäsenille',
	'sel_view_'.(0x400) => 'Vain ryhmän jäsenille',
	'sel_view_'.(0x800) => 'Skriptin kautta',

	# Admin
	'cfg_ug_level' => 'Taso vaadittu ryhmään',
	'cfg_ug_maxlen' => 'Max-pituus ryhmälle',
	'cfg_ug_minlen' => 'Min-pituus ryhmälle',
//	'cfg_ug_bid' => 'Alokas palsta',

	# EMails
	'mail_subj_req' => GWF_SITENAME.': %1$s haluaa liittyä ryhmääsi',
	'mail_body_req' =>
		'Dear %1$s,'.PHP_EOL.
		PHP_EOL.
		'%2$s haluaisi liittyä ryhmääsi &quot;%3$s&quot;.'.PHP_EOL.
		'Hyväksyäksesi tämän klikkaa linkkiä alempana:'.PHP_EOL.
		PHP_EOL.
		'%4$s',
		
		
	# V2.01 finish + your groups
	'cfg_ug_menu' => 'Näytä valikossa',
	'cfg_ug_submenu' => 'Näytä pikkuvalikossa',
	'cfg_ug_ax' => 'Num avatareja x-axis',	
	'cfg_ug_ay' => 'Num avatareja y-axis',	
	'cfg_ug_grp_per_usr' => 'Max ryhmiä per käyttäjä',	
	'cfg_ug_ipp' => 'Tietoa per sivu',	
	'cfg_ug_lvl_per_grp' => 'Taso ryhmä',
	'cfg_ug_submenugroup' => 'Nimi alivalikolle',

	# V2.02 finish2
	'btn_groups' => 'Käyttäjäryhmät',
		
	# V2.03 finish3
	'btn_users' => 'Käyttäjät',
		
	# v2.04
	'invite_title' => 'Kutsu %1$s',
	'invite_message' =>
		'Hei %1$s,'.PHP_EOL.
		PHP_EOL.
		'%2$s juuri lisäsi kutsun käyttäjäryhmään \'%3$s\'.'.PHP_EOL.
		'Liittyäksesi ryhmään vieraile sivulla: %4$s'.PHP_EOL.
		PHP_EOL.
		'Jos et halua liittyä ryhmään niin voit tehdä jotain muuta järkevää josta en minä tiiä: %5$s',
		
	# v2.05 (Jinx Edition)
	'err_not_in_group' => 'Käyttäjä %1$s ei ole ryhmässä.',
	'btn_unco' => 'Co-johtaja',
	'btn_co' => 'Ei Co-johtaja',
	'btn_unhide' => 'Piilota',
	'btn_hide' => 'Näytä',
	'btn_unmod' => 'Moderaattori',
	'btn_mod' => 'Ei Moderaattori',
	'msg_ugf_2_0' => 'Käyttäjä %1$s ei ole Co-johtaja enää.',
	'msg_ugf_2_1' => 'Käyttäjä %1$s on nyt Co-johtaja.',
	'msg_ugf_4_0' => 'Käyttäjä %1$s ei ole Moderaattori enää.',
	'msg_ugf_4_1' => 'Käyttäjä %1$s on nyt Moderaattori.',
	'msg_ugf_8_0' => 'Käyttäjä %1$s on nyt näkyvien käyttäjien listalla.',
	'msg_ugf_8_1' => 'Käyttäjä nimeltä %1$s On nyt piilotettujen jäsenten listalla.',
	'th_vis_grp' => 'Aina listaa ryhmät',
	'th_vis_mem' => 'Aina listaa jäsenet',
	'tt_vis_grp' => 'Jos tämä vaihtoehto on käytössä, ryhmä on aina näkyvissä ryhmäluettelon.',
	'tt_vis_mem' => 'Jos tämä vaihtoehto on käytössä, päävalikko on aina käytettävissä. Huomaa, että voit piilottaa käyttäjien erikseen.',

	# v2.06 (delete usergroup BAAL)
	'ft_del_group' => 'Do you really want to delete the usergroup %1$s?',
	'th_del_groupname' => 'Retype groupname',
	'tt_del_groupname' => 'Please type the name of the group to confirm.',
	'btn_del_group' => 'Yes, I want to delete the usergroup %1$s!',
	'msg_del_group' => 'The usergroup %1$s has been deleted. %3$s permissions have been revoked.',
		
	# v2.07 (Adv Search)
	'btn_adv_search' => 'Advanced Search',
	'ft_search_adv' => 'Advanced Usersearch',
	'th_country' => 'Country',
	'th_icq' => 'ICQ',
	'th_msn' => 'MSN',
	'th_jabber' => 'Jabber',
	'th_skype' => 'Skype',
	'th_yahoo' => 'Yahoo',
	'th_aim' => 'AIM',
	'th_language' => 'Language',			
	'th_hasmail' => 'EMail',
	'th_haswww' => 'Website',
	'th_gender' => 'Gender',
	'err_minlevel' => 'Your specified minimum level is invalid.',
);
?>