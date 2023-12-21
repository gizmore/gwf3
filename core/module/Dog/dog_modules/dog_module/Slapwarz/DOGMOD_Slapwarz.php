<?php
/**
 * @author gizmore
 */
final class DOGMOD_Slapwarz extends Dog_Module
{
// 	const SLAP_REMAIN_MALUS = 5;
// 	const SLAP_TIMEOUT = GWF_Time::ONE_DAY;
	const TOP5_COUNT = 10;
	private $last_slapper = false;
	private $last_target = false;
	
	##############
	### Config ###
	##############
	public function getOptions()
	{
		return array(
			'timeout' => 'c,o,s,1d',
			'remainmalus' => 'c,o,i,5',
			'slapsperplayer' => 'c,o,i,0',
			'perplayermalus' => 'c,o,i,25',
		);
	}
	private function getTimeout() { return GWF_TimeConvert::humanToSeconds($this->getConfig('timeout', 'c')); }
	private function getRemainMalus() { return $this->getConfig('remainmalus', 'c'); }
	private function getSlapsPerPlayer() { return $this->getConfig('slapsperplayer', 'c'); }
	private function getPerPlayerMalus() { return $this->getConfig('perplayermalus', 'c'); }
	############
	### Slap ###
	############
	/**
	 * Get the target user by username shortcut.
	 * @param Dog_Server $server
	 * @param string $user_name
	 * @param string $chan_name
	 * @return Dog_User
	 */
	private function getTarget(Dog_Server $server, $user_name, $chan_name)
	{
		if (false === ($target = Dog::getChannel()->getUserByAbbrev($user_name)))
		{
			return false;
		}
		return $target;
	}
	
	public function on_slap_Pc()
	{
		$message = $this->msgarg();
		if ($message === '')
		{
			return $this->showHelp('slap');
		}
		
		$channel = Dog::getChannel();
		$origin = $channel->getName();
		
		require $this->getPath().'slaps.php';
		
		$server = Dog::getServer();
		$user = Dog::getUser();

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
		
		# Check if a non record slap
		$fake = false;
		if (false === ($target = $this->getTarget($server, $target_name, $origin)))
		{
			$fake = true;
		}
		elseif (true !== ($remain = Dog_SlapHistory::maySlap($user->getID(), $target->getID(), $this->getTimeout())))
		{
			$fake = true;
		}
		elseif (true !== ($toomuch = Dog_SlapHistory::maySlapMore($user->getID(), $this->getTimeout(), $this->getSlapsPerPlayer())))
		{
			$fake = true;
		}
		
		if ($target instanceof Dog_User)
		{
			$target_name = Dog::softhyphe($target->getName());
		}
		
		$message = sprintf('%s %s %s %s with %s %s.', $user->getVar('user_name'), $adverb, $verb, $target_name, $adjective, $item);
		

		# Insert slap
		if ($fake === true)
		{
			if (false === Dog_SlapHistory::slapTimeout($adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item))
			{
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
			if (isset($remain) && $remain !== true)
			{
				$malus = $this->getRemainMalus();
				Dog_SlapUser::removePoints($user->getID(), $malus);
				$message .= sprintf(' (%s remaining, Lost %d points).', GWF_Time::humanDuration($remain), $malus);
			}
			elseif (isset($toomuch) && $toomuch !== true)
			{
				$malus = $this->getPerPlayerMalus();
				Dog_SlapUser::removePoints($user->getID(), $malus);
				$message .= sprintf(' (more than %d slaps within %s. Lost %d points).', $this->getSlapsPerPlayer(), GWF_Time::humanDuration($this->getTimeout()), $malus);
			}
		}
		else
		{
			if (false === Dog_SlapHistory::slap($user, $target, $adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item, $damage)) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
			$message .= ' ('.$damage.' damage).';
		}
		
		$server->reply($message);
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
	public function on_slapinfo_Pb()
// 	private function onInfo(Dog_User $user, $message)
	{
		$message = $this->msgarg();
		$table = GDO::table('Dog_SlapItem');
		if (is_numeric($message)) {
			$item = $table->getRow($message);
		} else {
			$item = $table->getBy('lsi_name', $message);
		}
		if ($item === false) {
			return $this->reply('The item seems unknown. Try slapinfo <itemid|itemname>');
		}
		$dmg = $item->getVar('lsi_damage');
		$cnt_a = $item->getVar('lsi_count_a');
		$cnt_as = $item->getVar('lsi_count_as');
		$out = sprintf('%s is of type %s. Damage: %s. This item has been used %s times (%s / %s).', $item->getVar('lsi_name'), $item->getVar('lsi_type'), $dmg, $cnt_a+$cnt_as, $cnt_as, $cnt_a);
		$this->reply($out);
	}
	
	public function on_slapstats_Pb()
// 	private function onStats(Dog_User $user, Dog_Server $server, $message)
	{
		$user = Dog::getUser();
		$server = Dog::getServer();
		$message = $this->msgarg();
		if ($message === '') {
			$user2 = $user;
		}
		elseif (false === ($user2 = $server->getUserByName($message)))
		{
			return 'This user is unknown';
		}
		
		$db = gdo_db();
		$userid = $user2->getVar('user_id');
		$lsh = GWF_TABLE_PREFIX.'dog_slap_history';
		$lsu = GWF_TABLE_PREFIX.'dog_slap_user';
		
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
		
		$out = sprintf('%s has slapped other people %d times. Total damage caused: %d(%.02f in avg). The user got slapped %d times. Total damage taken: %d(%.02f in avg).%s This sums up to %d points.',
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
		
		$this->reply($out);
	}
	
	public function on_slaptop5_Pb()
	{
		$this->reply($this->onTop5(Dog::getUser(), $this->msgarg()));
	}
	
	private function onTop5(Dog_User $user, $message)
	{
		$args = explode(' ', $message);
		switch ($args[0])
		{
			case 'damage':
				return $this->onTop5DamageBest(isset($args[1])?$args[1]:1);
			case 'dealt':
				return $this->onTop5Dealt('lsh_slapper', 'dealt');
			case 'taken':
				return 'Not implemented yet';
//				return $this->onTop5Count('lsh_target', 'taken');
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
	
	private function onTop5DamageBest($rank)
	{
		$db = gdo_db();
		$user = GWF_TABLE_PREFIX.'dog_users';
		$user2 = GWF_TABLE_PREFIX.'dog_users';
		$lsh = GWF_TABLE_PREFIX.'dog_slap_history';
		$limit = GDO::getLimit(1, Common::clamp(((int)$rank)-1, 0));
		$query = "SELECT u.user_name slapper, u2.user_name target, s.* FROM $lsh s JOIN $user u ON u.user_id=lsh_slapper JOIN $user2 u2 ON u2.user_id=lsh_target ORDER BY lsh_damage DESC $limit";
		
		echo $query.PHP_EOL;
		if (false === ($row = $db->queryFirst($query)))
		{
			return 'No database record found.'.PHP_EOL;
		}
		
		$adverb = Dog_SlapItem::getByID($row['lsh_adverb']);
		$verb = Dog_SlapItem::getByID($row['lsh_verb']);
		$adjective = Dog_SlapItem::getByID($row['lsh_adjective']);
		$item = Dog_SlapItem::getByID($row['lsh_item']);
		
		$date = $row['lsh_date'];
		
		return sprintf('BestSlap #%d: %s %s %s %s with %s %s. This dealt %d damage and happened on %s, %s ago.',
				$rank, $row['slapper'], $adverb->getVar('lsi_name'), $verb->getVar('lsi_name'), $row['target'],
				$adjective->getVar('lsi_name'), $item->getVar('lsi_name'), $row['lsh_damage'],
				GWF_Time::displayDate($date), GWF_Time::displayAge($date));
	}
	
	private function onTop5Dealt($column, $text)
	{
		$db = gdo_db();
		$user = GWF_TABLE_PREFIX.'dog_users';
		$lsh = GWF_TABLE_PREFIX.'dog_slap_history';
		$limit = self::TOP5_COUNT;
		$query = "SELECT u.user_name, SUM(lsh_damage) sum FROM $lsh s JOIN $user u ON u.user_id=$column GROUP BY $column ORDER BY sum DESC LIMIT $limit";
		
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
		$user = GWF_TABLE_PREFIX.'dog_users';
		$lsh = GWF_TABLE_PREFIX.'dog_slap_history';
		$limit = self::TOP5_COUNT;
		$query = "SELECT u.user_name, COUNT(*) cnt FROM $lsh s JOIN $user u ON u.user_id=$column GROUP BY $column ORDER BY cnt DESC LIMIT $limit";
		
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
