<?php
final class Lamb_SlapItem extends GDO
{
	public static $TYPES = array('adverb', 'verb', 'adjective', 'item');
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_slap_item'; }
	public function getColumnDefines()
	{
		return array(
			'lsi_id' => array(GDO::AUTO_INCREMENT),
			'lsi_type' => array(GDO::ENUM, GDO::NOT_NULL, self::$TYPES),
			'lsi_name' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
		
			'lsi_damage' => array(GDO::INT, GDO::NOT_NULL),
			
			# Stats
			'lsi_count_a' => array(GDO::UINT, 0), // attack 
			'lsi_count_as' => array(GDO::UINT, 0),// attack with score
		);
	}
	public function getID() { return $this->getVar('lsi_id'); }
	
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getBy('lsi_id', $id);
	}
	
	public static function getSlapRow($type, $name, $damage)
	{
		$type = self::escape($type);
		$name = self::escape($name);
		$damage = (int) $damage;
		if (false === ($row = self::table(__CLASS__)->selectFirstObject('*', "lsi_type='$type' AND lsi_name='$name'"))) {
			return false;
		}
		if ($damage !== $row->getVar('lsi_damage')) {
			$row->saveVar('lsi_damage', $damage);
		}
		return $row;
	}
	
	public static function createSlapRow($type, $name, $damage)
	{
		$row = new self(array(
			'lsi_id' => 0,
			'lsi_type' => $type,
			'lsi_name' => $name,
			'lsi_damage' => $damage,
			'lsi_count_a' => 0,
			'lsi_count_as' => 0,
		));
		if (false === ($row->insert())) {
			return false;
		}
		return $row;
	}
	
	/**
	 * @param enum $type
	 * @param string $name
	 * @param int $damage
	 * @return Lamb_SlapItem
	 */
	public static function getOrCreate($type, $name, $damage)
	{
		if (false !== ($row = self::getSlapRow($type, $name, $damage))) {
			return $row;
		}
		return self::createSlapRow($type, $name, $damage);
	}
}
?>