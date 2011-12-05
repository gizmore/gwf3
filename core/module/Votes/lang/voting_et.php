<?php

$lang = array(
## SCOREVOTE ##

	# votebuttons.php
	'alt_button' => 'Hääleta %s',
	'title_button' => 'Hääleta %s',

	# Errors
	'err_votescore' => 'Hääletuslauda ei leitud.',
	'err_score' => 'Sinu hääletatud skoor ei ole lubatud.',
	'err_expired' => 'Hääled on aegunud.',
	'err_disabled' => 'Hääled on ajutiselt eemaldatud.',
	'err_vote_ip' => 'Sinu IP-lt on juba hääletatud.',
	'err_no_guest' => 'Külalistel pole lubatud hääletada.',
	'err_title' => 'Sinu pealkiri peab olema %s ja %s tähe vahel.',
	'err_options' => 'Sinu Polli seaded %s on vigased jailmselt ei ole  %s kuni %s tähtede vahel.',
	'err_no_options' => 'Sa ei täpsustanud seadeid.',

	# Messages
	'msg_voted' => 'Hääl registreeritud.',

## POLLS ##

	'poll_votes' => '%s Hääled',
	'votes' => 'hääled',
	'voted' => 'hääletatud',
	'vmview_never' => 'Ei iial',
	'vmview_voted' => 'Peale häält',
	'vmview_allways' => 'Alati',

	'th_date' => 'Kuupäev',
	'th_votes' => 'Hääled',
	'th_title' => 'Pealkiri',
	'th_multi' => 'Luba arvukaid valikuid?',
	'th_option' => 'Seade %s',
	'th_guests' => 'Luba külaliste hääli?',
	'th_mvview' => 'Näita tulemust',
	'th_vm_public' => 'Näita sideribal?',
	'th_enabled' => 'Lubatud?',
	'th_top_answ' => 'Enim vastuseid',

	'th_vm_gid' => 'Piira grupi järgi',		
	'th_vm_level' => 'Piira taseme järgi',

	'ft_edit' => 'Muuda oma polli',
	'ft_add_poll' => 'Loovuta üks oma pollidest',
	'ft_create' => 'Loo uus poll',

	'btn_edit' => 'Muuda',
	'btn_vote' => 'Hääleta',
	'btn_add_opt' => 'Lisa valik',
	'btn_rem_opts' => 'Eemalda kõik valikud',
	'btn_create' => 'Loo poll',

	'err_multiview' => 'Vaatamise-lipp on vigane sellel pollil.',
	'err_poll' => 'Poll on tundmatu.',
	'err_global_poll' => 'Sul pole lube lisada globaalset polli.',
	'err_option_empty' => 'Variant %s on tühi.',
	'err_option_twice' => 'Variant %s ilmub mitmeid kordi.',
	'err_no_options' => 'Unustasid täpsustada valikuid oma pollis.',
	'err_no_multi' => 'Tohid valida ainult ühe variandi.',
	'err_poll_off' => 'See poll on ajutiselt eemaldatud.',
	
	'msg_poll_edit' => 'Sinu poll on muudetud edukalt.',
	'msg_mvote_added' => 'Sinu poll on edukalt lisatud.',

	# v2.01 Staff
	'th_vs_id' => 'ID',
	'th_vs_name' => 'Name',
	'th_vs_expire_date' => 'Expires',
	'th_vs_min' => 'Min',
	'th_vs_max' => 'Max',
	'th_vs_avg' => 'Avg',
	'th_vs_sum' => 'Sum',
	'th_vs_count' => 'Count',

	# v2.02
	'th_reverse' => 'Reversible?',
	'err_irreversible' => 'You have already voted this item and the votes for this item are not reversible.',
	'err_pollname_taken' => 'This pollname is already taken.',
);

?>