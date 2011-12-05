<?php

$lang = array(
## SCOREVOTE ##

	# votebuttons.php
	'alt_button' => 'Äänestä %s',
	'title_button' => 'Äänestä %s',

	# Errors
	'err_votescore' => 'Äänestyspöytää ei löytynyt tuolle kohteelle.',
	'err_score' => 'Äänestystuloksesi ei ole pätevä.',
	'err_expired' => 'Tuon kohteen äänestysaika on umpeutunut.',
	'err_disabled' => 'Tuon kohteen äänestys on tällä hetkellä pois käytöstä.',
	'err_vote_ip' => 'Tätä kohdetta on jo äänestetty IP-osoitteestasi.',
	'err_no_guest' => 'Vieraat eivät saa äänestää tätä kohdetta.',
	'err_title' => 'Otsikon pituuden tulee olla %s - %s merkkiä.',
	'err_options' => 'Äänestysvaihtoehtosi %s on/ovat virheellisiä eivätkä luultavasti pituudeltaan %s - %s merkkiä.',
	'err_no_options' => 'Et määrittänyt mitään vaihtoehtoja.',

	# Messages
	'msg_voted' => 'Ääni rekisteröity.',

## POLLS ##

	'poll_votes' => '%s ääntä',
	'votes' => 'äänet',
	'voted' => 'äänestetty',
	'vmview_never' => 'Ei koskaan',
	'vmview_voted' => 'Äänestyksen jälkeen',
	'vmview_allways' => 'Aina',

	'th_date' => 'Päiväys',
	'th_votes' => 'Äänet',
	'th_title' => 'Otsikko',
	'th_multi' => 'Salli useita valintoja?',
	'th_option' => 'Vaihtoehto %s',
	'th_guests' => 'Salli vieraiden äänestää?',
	'th_mvview' => 'Näytä tulokset',
	'th_vm_public' => 'Näytä sivupalkissa?',
	'th_enabled' => 'Käytössä?',
	'th_top_answ' => 'Parhaat vastaukset',

	'th_vm_gid' => 'Rajaa ryhmälle',		
	'th_vm_level' => 'Rajaa tason perusteella',

	'ft_edit' => 'Muokkaa äänestystäsi',
	'ft_add_poll' => 'Jatka jotakin äänestystäsi',
	'ft_create' => 'Luo uusi äänestys',

	'btn_edit' => 'Muokkaa',
	'btn_vote' => 'Äänestä',
	'btn_add_opt' => 'Lisää vaihtoehto',
	'btn_rem_opts' => 'Poista kaikki vaihtoehdot',
	'btn_create' => 'Luo äänestys',

	'err_multiview' => 'Tämän äänestyksen katsomislippu (view flag) on virheellinen.',
	'err_poll' => 'Tuntematon äänestys.',
	'err_global_poll' => 'Sinulla ei ole oikeuksia luoda globaalia äänestystä.',
	'err_option_empty' => 'Vaihtoehto %s on tyhjä.',
	'err_option_twice' => 'Vaihtoehto %s esiintyy useita kertoja.',
	'err_no_options' => 'Unohdit asettaa vaihtoehdon äänestyksellesi.',
	'err_no_multi' => 'Voit valita vain yhden asetuksen.',
	'err_poll_off' => 'Tämä äänestys on tällä hetkellä pois pääktä.',
	
	'msg_poll_edit' => 'Äänestystäsi on onnistuneesti muokattu.',
	'msg_mvote_added' => 'Äänestyksesi on onnistuneesti lisätty.',

	# v2.01 Staff
	'th_vs_id' => 'ID ',
	'th_vs_name' => 'Nimi',
	'th_vs_expire_date' => 'Vanhentuu',
	'th_vs_min' => 'Min',
	'th_vs_max' => 'Max',
	'th_vs_avg' => 'Keskiarvo',
	'th_vs_sum' => 'Summa',
	'th_vs_count' => 'Laskuri',

	# v2.02
	'th_reverse' => 'Reversible?',
	'err_irreversible' => 'You have already voted this item and the votes for this item are not reversible.',
	'err_pollname_taken' => 'This pollname is already taken.',
);

?>
