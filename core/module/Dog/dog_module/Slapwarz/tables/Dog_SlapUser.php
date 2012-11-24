<?php
final class Dog_SlapUser extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_slap_user'; }
	public function getColumnDefines()
	{
		return array(
			'slapu_uid' => array(GDO::UINT|GDO::PRIMARY_KEY, GDO::NOT_NULL),
			'slapu_malus' => array(GDO::UINT, 0),
			'slapu_malus_c' => array(GDO::UINT, 0),
		);
	}
	
	public static function removePoints($userid, $points)
	{
		if (false === ($row = GDO::table(__CLASS__)->getRow($userid))) {
			$row = new self(array(
				'slapu_uid' => $userid,
				'slapu_malus' => $points,
				'slapu_malus_c' => 1,
			));
			return $row->insert();
		}
		if (false === $row->increase('slapu_malus', $points))
		{
			return false;
		}
		if (false === $row->increase('slapu_malus_c', 1))
		{
			return false;
		}
		return true;
	}
}
?>
