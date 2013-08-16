<?php
final class Dog_SlapHistory extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_slap_history'; }
	public function getColumnDefines()
	{
		return array(
//			'lsh_slapper' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('Dog_User', 'lsh_slapper')),
//			'lsh_target' => array(GDO::OBJECT|GDO::INDEX, GDO::NOT_NULL, array('Dog_User', 'lsh_target')),

			'lsh_id' => array(GDO::AUTO_INCREMENT),
			'lsh_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
		
			'lsh_slapper' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lsh_target' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
		
			'lsh_adverb' => array(GDO::UINT, GDO::NOT_NULL),
			'lsh_verb' => array(GDO::UINT, GDO::NOT_NULL),
			'lsh_adjective' => array(GDO::UINT, GDO::NOT_NULL),
			'lsh_item' => array(GDO::UINT, GDO::NOT_NULL),
		
			'lsh_damage' => array(GDO::INT, GDO::NOT_NULL),
		);
	}
	public function getID() { return $this->getVar('lsh_id'); }
	
	public static function maySlap($slapper_id, $target_id, $timeout)
	{
		$slapper_id = (int) $slapper_id;
		$target_id = (int) $target_id;
		
		# No row yet
		if (false === ($row = self::table(__CLASS__)->selectFirstObject('*', "lsh_slapper=$slapper_id AND lsh_target=$target_id", 'lsh_date DESC')))
		{
			return true;
		}
		
		$last_date = $row->getVar('lsh_date');
		$time = GWF_Time::getTimestamp($last_date);
		$remain = $time + $timeout - time();
		if ($remain > 0)
		{
			return $remain;
		}
		
		return true;
	}
	
	public static function maySlapMore($slapper_id, $timeout, $allowed)
	{
		echo "maySlapMore($slapper_id, $timeout, $allowed\n";
		$slapper_id = (int) $slapper_id;
		$timeout = GWF_Time::getDate(14, time()-$timeout);
		echo "maySlapMore($slapper_id, $timeout, $allowed\n";
		
		# Config says true
		if ($allowed <= 0)
		{
			return true;
		}
		
		# No row yet
		if (false === ($count = self::table(__CLASS__)->selectVar('COUNT(*)', "lsh_slapper=$slapper_id AND lsh_date>'$timeout'")))
		{
			return true;
		}
		echo "maySlapMore($slapper_id, $timeout, $allowed) COUNT == $count\n";
		
		# Rows left?
		return $count < $allowed;
	}
	
	public static function slapTimeout($adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item)
	{
		return self::slapB(0, 0, $adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item, 0);
	}
	
	public static function slap(Dog_User $user, Dog_User $target, $adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item, $total_damage)
	{
		return self::slapB($user->getID(), $target->getID(), $adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item, $total_damage);
	}
	
	private static function slapB($userid, $targetid, $adverb, $dmg_adv, $verb, $dmg_verb, $adjective, $dmg_adj, $item, $dmg_item, $total_damage)
	{
//		echo "userid $userid slaps $targetid\n";
		
		if (false === ($adverb = Dog_SlapItem::getOrCreate('adverb', $adverb, $dmg_adv))) {
			return false;
		}
		if (false === ($verb = Dog_SlapItem::getOrCreate('verb', $verb, $dmg_verb))) {
			return false;
		}
		if (false === ($adjective = Dog_SlapItem::getOrCreate('adjective', $adjective, $dmg_adj))) {
			return false;
		}
		if (false === ($item = Dog_SlapItem::getOrCreate('item', $item, $dmg_item))) {
			return false;
		}
		
		if (false === self::table(__CLASS__)->insertAssoc(array(
			'lsh_id' => 0,
			'lsh_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'lsh_slapper' => $userid,
			'lsh_target' => $targetid,
			'lsh_adverb' => $adverb->getID(),
			'lsh_verb' => $verb->getID(),
			'lsh_adjective' => $adjective->getID(),
			'lsh_item' => $item->getID(),
			'lsh_damage' => $total_damage,
		))) {
			return false;
		}
		
		$fake_slap = ($userid == 0 || $targetid == 0);
		
		if (!$fake_slap)
		{
			Dog_SlapStats::increaseStats($userid, $adverb->getID(), 1);
			Dog_SlapStats::increaseStats($userid, $verb->getID(), 1);
			Dog_SlapStats::increaseStats($userid, $adjective->getID(), 1);
			Dog_SlapStats::increaseStats($userid, $item->getID(), 1);
		}
		
		$column = $fake_slap ? 'lsi_count_a' : 'lsi_count_as';
		
		if (false === $adverb->increase($column, 1))
		{
			return false;
		}
		if (false === $verb->increase($column, 1))
		{
			return false;
		}
		if (false === $adjective->increase($column, 1))
		{
			return false;
		}
		if (false === $item->increase($column, 1))
		{
			return false;
		}
		
		return true;
	}
}
?>
