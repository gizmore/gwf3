<?php
require_once 'Lamb_SlapHistory.php';
require_once 'Lamb_SlapItem.php';
require_once 'Lamb_SlapStats.php';
require_once 'Lamb_SlapUser.php';
/**
 * @author gizmore
 */
final class LambModule_Slapwarz extends Lamb_Module
{
	const SLAP_REMAIN_MALUS = 5;
	const SLAP_TIMEOUT = GWF_Time::ONE_DAY;
	const TOP5_COUNT = 10;
	private $last_slapper = false;
	private $last_target = false;
	
	################
	### Triggers ###
	################
	public function onInstall()
	{
		GDO::table('Lamb_SlapHistory')->createTable();
		GDO::table('Lamb_SlapItem')->createTable();
		GDO::table('Lamb_SlapUser')->createTable();
		GDO::table('Lamb_SlapStats')->createTable();
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('slap', 'slapinfo', 'slapstats', 'slaptop5');
			default: return array();
		}
	}
	
	public function getHelp()
	{
		return array(
			'slap' => 'Usage: %CMD% [nickname]. Slap your target!',
			'slapinfo' => 'Usage: %CMD% <itemname|itemid>.',
			'slapstats' => 'Usage: %CMD% <nickname>.',
			'slaptop5' => 'Usage: %CMD% <dealt,taken,cmds,used>',
		);
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		switch ($command)
		{
			case 'slap': $this->onSlap($server, $user, $from, $origin, $message); return;
			
			case 'slapinfo': $out = $this->onInfo($user, $message); break;
			case 'slapstats': $out = $this->onStats($user, $server, $message); break;
			case 'slaptop5': $out = $this->onTop5($user, $message); break;
		}
		$server->reply($origin, $out);
	}
	
	############
	### Slap ###
	############
	private function getTarget(Lamb_Server $server, $user_name, $channel_name)
	{
		if (false === ($target = $server->getUserByNickAndChannel($user_name, $channel_name))) {
			return false;
		}
		return $target;
	}
	
	private function onSlap(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if ($message === '')
		{
			return $this->getHelpText('slap');
		}
		
		require Lamb::DIR.'lamb_module/Slapwarz/slaps.php';

		$damage = 10000;
		list($adverb, $dmg_adv) = $this->getRandomItem($slaps['adverbs']);
		$damage = $this->applyDamage($damage, $dmg_adv);
		list($verb, $dmg_verb) = $this->getRandomItem($slaps['verbs']);
		$damage = $this->applyDamage($damage, $dmg_verb);
		list($adjective, $dmg_adj) = $this->getRandomItem($slaps['adjectives']);
		$damage = $this->applyDamage($damage, $dmg_adj);
		list($item, $dmg_item) = $this->getRandomItem($slaps['items']);
		$damage = $this->applyDamage($damage, $dmg_item);
		$damage = round($damage);
		
		$target_name = Common::substrUntil($message, ' ');
		
		$message = sprintf('%s %s %s %s with %s %s.', $user->getVar('lusr_name'), $adverb, $verb, $target_name, $adjective, $item);
		
		# Check if a non record slap
		$fake = false;
		if (false === ($target = $this->getTarget($server, $target_name, $origin))) {
			$fake = true;
		}
		elseif (true !== ($remain = Lamb_SlapHistory::maySlap($user->getID(), $target->getID()))) {
			$fake = true;
		}

		# Insert slap
		if ($fake === true)
		{
			if (false === Lamb_SlapHistory::slapTimeout($adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item)) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
			if (isset($remain)) {
				Lamb_SlapUser::removePoints($user->getID(), self::SLAP_REMAIN_MALUS);
				$message .= sprintf(' (%s remaining, Lost %d points).', GWF_Time::humanDuration($remain), self::SLAP_REMAIN_MALUS);
			}
		}
		else
		{
			if (false === Lamb_SlapHistory::slap($user, $target, $adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item, $damage)) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
			$message .= ' ('.$damage.' damage).';
		}
		
		$server->sendPrivmsg($origin, $message);
		
		return $message;
	}
	
	private function getRandomItem(array &$array)
	{
		shuffle($array);
		return $array[rand(0, count($array)-1)];
	}
	
	private function applyDamage($damage, $dmg)
	{
		$back = $damage * (($dmg - 10) / 100);
		return $back; 
	}
	
	#############
	### Stats ###
	#############
	private function onInfo(Lamb_User $user, $message)
	{
		$table = GDO::table('Lamb_SlapItem');
		if (is_numeric($message)) {
			$item = $table->getRow($message);
		} else {
			$item = $table->getBy('lsi_name', $message);
		}
		if ($item === false) {
			return sprintf('The item seems unknown. Try %sslapinfo <itemid|itemname>', LAMB_TRIGGER);
		}
		$dmg = $item->getVar('lsi_damage');
		$cnt_a = $item->getVar('lsi_count_a');
		$cnt_as = $item->getVar('lsi_count_as');
		return sprintf('%s is of type %s. Damage: %s. This item has been used %s times (%s / %s).', $item->getVar('lsi_name'), $item->getVar('lsi_type'), $dmg, $cnt_a+$cnt_as, $cnt_as, $cnt_a);
	}
	
	private function onStats(Lamb_User $user, Lamb_Server $server, $message)
	{
		if ($message === '') {
			$user2 = $user;
		}
		elseif (false === ($user2 = $server->getUser($message))) {
			return 'This user is unknown';
		}
		
		$db = gdo_db();
		$userid = $user2->getVar('lusr_id');
		$lsh = GWF_TABLE_PREFIX.'lamb_slap_history';
		$lsu = GWF_TABLE_PREFIX.'lamb_slap_user';
		
		$query = "SELECT COUNT(*) c , SUM(lsh_damage) sum, slapu_malus malus, slapu_malus_c malus_c FROM $lsh LEFT JOIN $lsu ON slapu_uid=$userid WHERE lsh_slapper=$userid";
		if (false === ($result = $db->queryFirst($query))) {
			return 'This user has no stats yet.';
		}
		$count1 = $result['c'];
		$dmg_deal = $result['sum'];
		$malus = $result['malus'];
		$malus_c = $result['malus_c'];
//		list($count1, $dmg_deal, $malus, $malus_c) = $result;
		
		$query = "SELECT COUNT(*) c, SUM(lsh_damage) sum FROM $lsh WHERE lsh_target=$userid";
		if (false === ($result = $db->queryFirst($query))) {
			return 'This user has no stats yet.';
		}
		$count2 = $result['c'];
		$dmg_take = $result['sum'];
//		list($count2, $dmg_take) = $result;
		
//		$count3 = $count1 - $count2;
		$score = $dmg_deal - $dmg_take;
		$score -= $malus;
		
		if ($malus_c > 0) {
			$malusmsg = sprintf(' %d Remainslaps (-%d points).', $malus_c, $malus);
		} else {
			$malusmsg = '';
		}
		
		return sprintf('%s has slapped other people %d times. Total damage caused: %d(%.02f in avg). The user got slapped %d times. Total damage taken: %d(%.02f in avg).%s This sums up to %d points.',
			$user2->getName(),
			$count1,
			$dmg_deal,
			$count1 == 0 ? 0 : $dmg_deal/$count1,
			$count2,
			$dmg_take,
			$count2 == 0 ? 0 : $dmg_take/$count2,
			$malusmsg,
			$score
		);
	}
	
	private function onTop5(Lamb_User $user, $message)
	{
		switch ($message)
		{
			case 'damage': case 'dealt':
				return $this->onTop5Damage('lsh_slapper', 'dealt');
			case 'taken':
				return $this->onTop5Damage('lsh_target', 'taken');
			case 'slaps':
				return $this->onTop5Count('lsh_slapper', 'slaps');
			case 'backslaps':
				return $this->onTop5Count('lsh_target', 'backslaps');
			case 'used': 
				return 'Missing function: slaptop5 for items used.';
			default:
				return 'Try .slaptop5 damage|dealt|taken|slaps|backslaps|used';
		}
	}
	
	private function onTop5Damage($column, $text)
	{
		$db = gdo_db();
		$user = GWF_TABLE_PREFIX.'lamb_user';
		$lsh = GWF_TABLE_PREFIX.'lamb_slap_history';
		$limit = self::TOP5_COUNT;
		$query = "SELECT u.lusr_name, SUM(lsh_damage) sum FROM $lsh s JOIN $user u ON u.lusr_id=$column GROUP BY $column ORDER BY sum DESC LIMIT $limit";
		
		if (false === ($result = $db->queryRead($query))) {
			return 'Database error in: '.__METHOD__.PHP_EOL;
		}
		
		$back = '';
		while (false !== ($row = $db->fetchRow($result)))
		{
			list($nick, $dmg) = $row;
			$back .= sprintf(', %s(%s)', $nick, $dmg);
		}
		
		$db->free($result);
		
		return $back === '' ? 'There are no records.' : sprintf('Highest damage %s: %s.', $text, substr($back, 2)); 
	}

	private function onTop5Count($column, $text)
	{
		$db = gdo_db();
		$user = GWF_TABLE_PREFIX.'lamb_user';
		$lsh = GWF_TABLE_PREFIX.'lamb_slap_history';
		$limit = self::TOP5_COUNT;
		$query = "SELECT u.lusr_name, COUNT(*) cnt FROM $lsh s JOIN $user u ON u.lusr_id=$column GROUP BY $column ORDER BY cnt DESC LIMIT $limit";
		
		if (false === ($result = $db->queryRead($query))) {
			return 'Database error in: '.__METHOD__.PHP_EOL;
		}
		
		$back = '';
		while (false !== ($row = $db->fetchRow($result)))
		{
			list($nick, $count) = $row;
			$back .= sprintf(', %s(%s)', $nick, $count);
		}
		
		$db->free($result);
		return $back === '' ? 'There are no records.' : sprintf('Number of %s: %s.', $text, substr($back, 2)); 
	}
}
?>