<?php
class Lamb_Server{const BNC_MODE=1;}

$lamb_conf = GWF_PATH.'core/module/Lamb/lamb_bin/Lamb_Config.php';
require_once $lamb_conf;

$db = gdo_db();

$drop_tables = array(
'lamb3_country',
'lamb3_langmap',
'lamb3_language',
		
'lamb3_acc_rm',
'lamb3_accchange',
'lamb3_addr',
'lamb3_ban',
'lamb3_browser',
'lamb3_category',
'lamb3_catlang',
'lamb3_chatmsg',
'lamb3_chatonline',
'lamb3_forumattach',
'lamb3_forumboard',
'lamb3_forumopt',
'lamb3_forumpost',
'lamb3_forumposthistory',
'lamb3_forumsubscr',
'lamb3_forumthread',
'lamb3_forumwatch',
'lamb3_gpg',
'lamb3_group',
'lamb3_guestbook',
'lamb3_guestbook_entry',
'lamb3_ip2country',
'lamb3_iplog_guest',
'lamb3_iplog_member',
'lamb3_langfile',
'lamb3_links',
'lamb3_links_favorite',
'lamb3_links_tag',
'lamb3_links_tagmap',
'lamb3_login_history',
'lamb3_loginfail',
'lamb3_module',
'lamb3_modulevar',
'lamb3_news',
'lamb3_newsletter',
'lamb3_newstrans',
'lamb3_os',
'lamb3_pm',
'lamb3_pm_folder',
'lamb3_pm_ignore',
'lamb3_pm_options',
'lamb3_profile',
'lamb3_profile_links',
'lamb3_quotes',
'lamb3_session',
'lamb3_shoutbox',
'lamb3_ssy_business',
'lamb3_ssy_customer',
'lamb3_ssy_form',
'lamb3_ssy_ug36u',
'lamb3_ssy_ug36u_b',
'lamb3_ssy_user',
'lamb3_ug_invite',
'lamb3_user',
'lamb3_user_avatar_g',
'lamb3_useractivation',
'lamb3_usergroup',
'lamb3_vote_multi',
'lamb3_vote_multi_opt',
'lamb3_vote_multi_row',
'lamb3_vote_score',
'lamb3_vote_score_row',
'lamb3_vs_client',
'lamb3_vs_client_order',
'lamb3_vs_files',
'lamb3_vs_log',
'lamb3_wc_api_block',
'lamb3_wc_chall',
'lamb3_wc_chall_crackcha',
'lamb3_wc_chall_reg_glob',
'lamb3_wc_chall_solved',
'lamb3_wc_first_link',
'lamb3_wc_freeze',
'lamb3_wc_master',
'lamb3_wc_math_chall',
'lamb3_wc_passmap',
'lamb3_wc_regat',
'lamb3_wc_site',
'lamb3_wc_site_admin',
'lamb3_wc_site_favs',
'lamb3_wc_site_history',
'lamb3_wc_sitecat',
'lamb3_wc_solution_block',
'lamb3_wc_user_history2',

'lamb3_lamb_pg',
'lamb3_lamb_channel_peak',
'lamb3_lamb_irc_from',
'lamb3_lamb_irc_to',
'lamb3_lamb_link',
'lamb3_lamb_news',
'lamb3_lamb_newsfeed',
'lamb3_lamb_quit_join',
'lamb3_lamb_quit_join_c',
'lamb3_lamb_tell',
);

$rename_tables = array(
'lamb3_counter' => 'dog_counter',
'lamb3_settings' => 'dog_settings',
		
'lamb3_lamb_greetings' => 'dog_dog_greetings',
'lamb3_lamb_greetmsg' => 'dog_dog_greetmsg',
'lamb3_lamb_hangman' => 'dog_dog_hangman',
'lamb3_lamb_links' => 'dog_dog_links',
'lamb3_lamb_note' => 'dog_dog_note',
'lamb3_lamb_quotes' => 'dog_dog_quotes',
'lamb3_lamb_scum_history' => 'dog_dog_scum_history',
'lamb3_lamb_scum_stats' => 'dog_dog_scum_stats',
		
'lamb3_lamb_server' => 'dog_dog_servers',
		
'lamb3_lamb_slap_history' => 'dog_dog_slap_history',
'lamb3_lamb_slap_item' => 'dog_dog_slap_item',
'lamb3_lamb_slap_stats' => 'dog_dog_slap_stats',
'lamb3_lamb_slap_user' => 'dog_dog_slap_user',
		
'lamb3_lamb_user' => 'dog_dog_users',
'lamb3_lamb_channel' => 'dog_dog_channels',
		
'lamb3_sr4_bazar' => 'dog_sr4_bazar',
'lamb3_sr4_bazar_hist' => 'dog_sr4_bazar_hist',
'lamb3_sr4_bazar_shop' => 'dog_sr4_bazar_shop',
'lamb3_sr4_bounty' => 'dog_sr4_bounty',
'lamb3_sr4_bounty_hist' => 'dog_sr4_bounty_hist',
'lamb3_sr4_bounty_stats' => 'dog_sr4_bounty_stats',
'lamb3_sr4_clan' => 'dog_sr4_clan',
'lamb3_sr4_clan_bank' => 'dog_sr4_clan_bank',
'lamb3_sr4_clan_history' => 'dog_sr4_clan_history',
'lamb3_sr4_clan_members' => 'dog_sr4_clan_members',
'lamb3_sr4_clan_requests' => 'dog_sr4_clan_requests',
'lamb3_sr4_item' => 'dog_sr4_item',
'lamb3_sr4_killprotect' => 'dog_sr4_killprotect',
'lamb3_sr4_noshout' => 'dog_sr4_noshout',
'lamb3_sr4_party' => 'dog_sr4_party',
'lamb3_sr4_player' => 'dog_sr4_player',
'lamb3_sr4_player_stats' => 'dog_sr4_player_stats',
'lamb3_sr4_player_vars' => 'dog_sr4_player_vars',
'lamb3_sr4_quest' => 'dog_sr4_quest',
'lamb3_sr4_stats' => 'dog_sr4_stats',
'lamb3_sr4_tell' => 'dog_sr4_tell',
);

$drop_columns = array(
array('dog_dog_servers', 'serv_ip'),
array('dog_dog_servers', 'serv_maxusers'),
array('dog_dog_servers', 'serv_maxchannels'),
array('dog_dog_servers', 'serv_version'),
array('dog_dog_servers', 'serv_nicknames'),
array('dog_dog_servers', 'serv_password'),
array('dog_dog_servers', 'serv_channels'),
array('dog_dog_servers', 'serv_admins'),
array('dog_dog_servers', 'serv_flood_amt'),
array('dog_dog_users', 'lusr_last_message'),
array('dog_dog_users', 'lusr_last_channel'),
array('dog_dog_users', 'lusr_timestamp'),
array('dog_dog_users', 'lusr_hostname'),
array('dog_dog_users', 'lusr_ip'),
array('dog_dog_links', 'link_username'),
array('dog_dog_channels', 'chan_maxusers'),
array('dog_dog_channels', 'chan_ops'),
array('dog_dog_channels', 'chan_hops'),
array('dog_dog_channels', 'chan_voice'),
array('dog_dog_channels', 'chan_topic'),
);

require_once 'dog_module/Greetings/tables/Dog_Greeting.php';
require_once 'dog_module/Greetings/tables/Dog_GreetMsg.php';

$rename_columns = array(
array('Dog_Greeting', 'lagreet_uid', 'dogreet_uid'),
array('Dog_Greeting', 'lagreet_cid', 'dogreet_cid'),
array('Dog_GreetMsg', 'lgm_cid', 'dgm_cid'),
array('Dog_GreetMsg', 'lgm_msg', 'dgm_msg'),
array('Dog_GreetMsg', 'lgm_options', 'dgm_options'),
array('Dog_User', 'lusr_id', 'user_id'),
array('Dog_User', 'lusr_sid', 'user_sid'),
array('Dog_User', 'lusr_name', 'user_name'),
array('Dog_User', 'lusr_password', 'user_pass'),
array('Dog_User', 'lusr_lang', 'user_lang'),
array('Dog_User', 'lusr_options', 'user_options'),
);

foreach ($drop_tables as $table_name)
{
	echo "Dropping table $table_name\n";
	$db->queryWrite("DROP TABLE $table_name");
}

foreach ($rename_tables as $old_name => $new_name)
{
	echo "Renaming table $old_name to $new_name\n";
	$db->queryWrite("RENAME TABLE $old_name TO $new_name");
}

foreach ($drop_columns as $data)
{
	list($table_name, $column) = $data;
	echo "Dropping column $column in $table_name\n";
	$db->queryWrite("ALTER TABLE $table_name DROP COLUMN $column");
}

foreach ($rename_columns as $data)
{
	echo "Renaming column $table_name.$old_name to $new_name\n";
	list($table_name, $old_name, $new_name) = $data;
	$gdo = GDO::table($table_name);
	$table_name = $gdo->getTableName();
	$def = $gdo->getColumnDefines();
	$def = $def[$new_name];
	$db->changeColumn($table_name, $old_name, $new_name, $def);
}

$db->queryWrite('ALTER TABLE dog_dog_servers ADD COLUMN serv_port MEDIUMINT(5) UNSIGNED NOT NULL DEFAULT 6667');
if (!$db->queryWrite('ALTER TABLE dog_dog_servers ADD COLUMN serv_triggers VARCHAR(8) CHARACTER SET ASCII COLLATE ascii_bin')) DIE('2');
if (!$db->queryWrite('ALTER TABLE dog_dog_links ADD COLUMN link_uid INT(11) UNSIGNED NOT NULL DEFAULT 0')) DIE('3');
if (!$db->queryWrite('ALTER TABLE dog_dog_channels ADD COLUMN chan_pass VARCHAR(63) CHARACTER SET UTF8 COLLATE utf8_bin')) DIE('4');
if (!$db->queryWrite('ALTER TABLE dog_dog_channels ADD COLUMN chan_modes VARCHAR(63) CHARACTER SET ASCII COLLATE ascii_bin')) DIE('5');
if (!$db->queryWrite('ALTER TABLE dog_dog_channels ADD COLUMN chan_triggers VARCHAR(8) CHARACTER SET ASCII COLLATE ascii_bin')) DIE('6');

# Fix Server hosts
GDO::table('Dog_Server')->deleteWhere('serv_host=""');
GDO::table('Dog_Server')->update('serv_options='.Dog_Server::DEFAULT_OPTIONS);
$servers = GDO::table('Dog_Server');
foreach ($servers->selectAll('*', '', '', NULL, -1, -1, GDO::ARRAY_O) as $server)
{
	$server instanceof Dog_Server;
	$host = $server->getHost();
	$port = substr($host, strrpos($host, ':')+1);
	$host = substr($host, 0, strrpos($host, ':'));
	$prot = Common::substrUntil($host, '://');
	$ssl = $prot === 'ircs' ? true : false;
	$host = Common::substrFrom($host, '://', $host);
	$server->saveVars(array('serv_host'=>$host, 'serv_port' => $port));
	$server->saveOption(Dog_Server::SSL, $ssl);
}


# Copy Nicknames + passwords from config
global $LAMB_CFG;

$nicks = GDO::table('Dog_Nick');
$nicks->createTable(true);
GDO::table('Dog_Channel')->update('chan_options=0x02');

foreach ($LAMB_CFG['servers'] as $srv)
{
	$nickname = $srv['nickname'];
	$nickname = Common::substrUntil($nickname, ',', $nickname);
	$password = $srv['password'];
	if (false === ($server = Dog_Server::getByTLD(Common::getDomain($srv['host']))))
	{
		die('OUCH!');
	}
	$nicks->insertAssoc(array(
		'nick_sid' => $server->getID(),
		'nick_name' => $nickname,
		'nick_pass' => $password,
	));
	
	if (isset($srv['options']))
	{
		$server->saveOption(Dog_Server::BNC);
	}
	
	$co = Dog_Channel::DEFAULT_OPTIONS;
	foreach (explode(',', $srv['channels']) as $chan_name)
	{
		GDO::table('Dog_Channel')->update("chan_options=$co", "chan_sid={$server->getID()} AND chan_name='$chan_name'");
	}
}

foreach ($servers->selectAll('*', '', '', NULL, -1, -1, GDO::ARRAY_O) as $server)
{
	$server instanceof Dog_Server;
	if (false === $nicks->selectVar('1', 'nick_sid='.$server->getID()))
	{
		$nicks->insertAssoc(array(
			'nick_sid' => $server->getID(),
			'nick_name' => 'Lamb3',
			'nick_pass' => 'lamblamb',
		));
		$server->saveOption(Dog_Server::ACTIVE, false);
	}
}

// GDO::table('Dog_User')->update('user_options=0x01', "user_options&0x100");
GDO::table('Dog_User')->update('user_options=0x00');
GDO::table('DOG_User')->update('user_pass=NULL');

?>
