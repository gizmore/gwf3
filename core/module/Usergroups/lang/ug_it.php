<?php
$lang = array(

	'alt_flag' => '%s ',

	# Page Info
	'pi_invited' => 'L\'utente %s la <a href="%s">invita nel suo gruppo &quot;%s&quot;</a>.<br/><br/><br/><a href="%s">Clicca qui per rifiutare l\'invito</a>.',

	# Avatar Gallery
	'pt_avatars' => 'Galleria degli Avatar.',
	'pi_avatars' => 'La galleria degli avatar di '.GWF_SITENAME,
	'mt_avatars' => GWF_SITENAME.', Avatar, Galleria',
	'md_avatars' => 'Galleria avatar dell\'utente su '.GWF_SITENAME,

	# Table Headers 
	'th_name' => 'Nome del gruppo',
	'th_join' => 'Come unirsi',
	'th_view' => 'Visibilità',
	'th_user_name' => 'Nome Utente',
	'th_user_level' => 'Livello',
	'th_user_email' => 'E-Mail',
	'th_user_regdate' => 'Data di registrazione',
	'th_user_birthdate' => 'Data di nascita',
	'th_user_lastactivity' => 'Ultima attività',
	'th_group_name' => 'Nome del gruppo',
	'th_group_memberc' => 'Membri',
	'th_group_founder' => 'Fondatore',

	# Form Titles
	'ft_edit' => 'Modifica il gruppo utente',
	'ft_create' => 'Crea nuovo gruppo utente',
	'ft_invite' => 'Invita un utente nel gruppo',

	# Buttons
	'btn_kick' => 'Rimuovi utente',
	'btn_edit' => 'Modifica gruppo',
	'btn_delete' => 'Rimuovi gruppo',
	'btn_create' => 'Crea gruppo',
	'btn_invite' => 'Invita utente',
	'btn_accept' => 'Accetta come membro',
	'btn_gallery' => 'Galleria degli avatar',
	'btn_search' => 'Cerca utente',
	'btn_part' => 'Lascia gruppo',
	'btn_add_group' => 'Crea gruppo',

	# Errors
	'err_perm' => 'Non ha il permesso di creare un gruppo.',
	'err_join' => 'L\'opzione Unisciti è invalida.',
	'err_view' => 'L\'opzione Visualizza è invalida.',
	'err_name' => 'Il nome del gruppo è invalido. La lunghezza deve essere compresa tra %s e %s caratteri e deve iniziare con una lettera.',
	'err_group_exists' => 'Ha già un gruppo utente.',
	'err_group' => 'Non ha un gruppo utente.',
	'err_kick_leader' => 'Non può rimuovere il fondatore del gruppo.',
	'err_kick' => 'L\'utente %s non è nel gruppo.',
	'err_unk_group' => 'Il gruppo è sconosciuto.',
	'err_no_join' => 'Non può unirsi al gruppo da solo.',
	'err_join_twice' => 'Lei è già nel gruppo.',
	'err_request_twice' => 'Ha già inviato una richiesta di ammissione a questo gruppo.',
	'err_not_invited' => 'Non è stato invitato in questo gruppo.',

	# Messages
	'msg_created' => 'Il gruppo utenti è stato creato.',
	'msg_edited' => 'Il gruppo utenti è stato modificato.',
	'msg_kicked' => '%s è stato rimosso dal gruppo.',
	'msg_joined' => 'Lei si è unito al gruppo &quot;%s&quot;.',
	'msg_requested' => 'Ha richiesto di unirsi a &quot;%s&quot;.',
	'msg_accepted' => 'L\'utente %s è ora membro del gruppo &quot;%s&quot;.',
	'msg_invited' => 'Ha invitato %s ad unirsi al gruppo.',
	'msg_refused' => 'Ha rifiutato di unirsi al gruppo &quot;%s&quot;.',

	# Selects
	'sel_join_type' => 'Come possono gli utenti unirsi al gruppo?',
	'sel_join_1' => 'Il gruppo è pieno',
	'sel_join_2' => 'Su invito',
	'sel_join_4' => 'Tramite lista di moderazione',
	'sel_join_8' => 'Clicca ed unisciti',
	'sel_join_16' => 'Pieno (invito tramite script)',
	'sel_view_type' => 'Seleziona la visibilità del gruppo',
	'sel_view_'.(0x100) => 'Forum pubblico',
	'sel_view_'.(0x200) => 'Solo membri di '.GWF_SITENAME,
	'sel_view_'.(0x400) => 'Solo membri di questo gruppo',
	'sel_view_'.(0x800) => 'Tramite script',

	# Admin
	'cfg_ug_level' => 'Livello utente necessario per creare un gruppo',
	'cfg_ug_maxlen' => 'Lunghezza massima gruppo utente',
	'cfg_ug_minlen' => 'Lunghezza minimagruppo utente',
//	'cfg_ug_bid' => 'Parent Board for Usergroup',

	# EMails
	'mail_subj_req' => GWF_SITENAME.': %s vuole unirsi al gruppo %s',
	'mail_body_req' =>
		'Caro %s,'.PHP_EOL.
		PHP_EOL.
		'%s vorrebbe unirsi al gruppo &quot;%s&quot;.'.PHP_EOL.
		'Per accettare questa richiesta, visiti il link sottostante:'.PHP_EOL.
		PHP_EOL.
		'%s',
		
		
	# V2.01 finish + your groups
	'cfg_ug_menu' => 'Mostra nel menù',
	'cfg_ug_submenu' => 'Mostra nel sottomenù',
	'cfg_ug_ax' => 'Numero di avatar per riga',	
	'cfg_ug_ay' => 'Numero di avatar per colonna',	
	'cfg_ug_grp_per_usr' => 'Numero massimo gruppo per utente',	
	'cfg_ug_ipp' => 'Elementi per pagina',	
	'cfg_ug_lvl_per_grp' => 'Livello per unirsi al gruppo',
	'cfg_ug_submenugroup' => 'Nome del sottomenù',

	# V2.02 finish2
	'btn_groups' => 'Gruppo utente',
		
	# V2.03 finish3
	'btn_users' => 'Utenti',
		
	# v2.04
	'invite_title' => 'Invito per %s',
	'invite_message' =>
		'Salve %s,'.PHP_EOL.
		PHP_EOL.
		'%s l\'ha appena invitata nel suo gruppo \'%s\'.'.PHP_EOL.
		'Per unirsi al suo gruppo, può visitare questo link: %s'.PHP_EOL.
		PHP_EOL.
		'Se non vuole unirsi al gruppo, può tranquillamente ignorare questo PM, o rifiutare la richiesta visitando questo link: %s',
		
	# v2.05 (Jinx Edition)
	'err_not_in_group' => 'L\'utente %s non è in questo gruppo.',
	'btn_unco' => 'Co-Leader ',
	'btn_co' => 'Non Co-Leader',
	'btn_unhide' => 'Nascondi',
	'btn_hide' => 'Mostra',
	'btn_unmod' => 'Moderatore',
	'btn_mod' => 'No Moderatore',
	'msg_ugf_2_0' => 'L\'utente %s non è più Co-Leader.',
	'msg_ugf_2_1' => 'L\'utente %s è ora Co-Leader.',
	'msg_ugf_4_0' => 'L\'utente %s non è più un moderatore.',
	'msg_ugf_4_1' => 'L\'utente %s è ora un moderatore.',
	'msg_ugf_8_0' => 'L\'utente %s è visibile nella lista utenti.',
	'msg_ugf_8_1' => 'L\'utente %s è nascosto nella lista utenti.',
	'th_vis_grp' => 'Mostra sempre gruppo',
	'th_vis_mem' => 'Mostra sempre membri',
	'tt_vis_grp' => 'Se questa opzione è attivata, il gruppo sarà sempre visibile nella lista dei gruppi.',
	'tt_vis_mem' => 'Se questa opzione è attivata, la lista dei membri è sempre accessibile. Nota: può nascondere gli utenti singolarmente.',
		
	# v2.06 (delete usergroup BAAL)
	'ft_del_group' => 'Vuole davvero cancellare questo gruppo %s?',
	'th_del_groupname' => 'Ridigiti il nome del gruppo',
	'tt_del_groupname' => 'Ridigiti il nome del gruppo per procedere con la cancellazione.',
	'btn_del_group' => 'Si, voglio cancellare il gruppo %s!',
	'msg_del_group' => 'Il gruppo utente %s è stato cancellato. %s permessi sono stati revocati.',
		
	# v2.07 (Adv Search)
	'btn_adv_search' => 'Ricerca avanzata',
	'ft_search_adv' => 'Ricerca utenti avanzata',
	'th_country' => 'Nazione',
	'th_icq' => 'ICQ ',
	'th_msn' => 'MSN ',
	'th_jabber' => 'Jabber ',
	'th_skype' => 'Skype ',
	'th_yahoo' => 'Yahoo ',
	'th_aim' => 'AIM ',
	'th_language' => 'Lingua',			
	'th_hasmail' => 'E-Mail',
	'th_haswww' => 'Sito Web',
	'th_gender' => 'Sesso',
	'err_minlevel' => 'Il livello minimo specificato è invalido.',
		
);
?>