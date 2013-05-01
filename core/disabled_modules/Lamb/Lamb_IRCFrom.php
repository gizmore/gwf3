<?php
/**
 * This is irc2www wrapper
 * @author gizmore
 */
final class Lamb_IRCFrom extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_irc_from'; }
	public function getColumnDefines()
	{
		return array(
			'lif_id' => array(GDO::AUTO_INCREMENT),
			'lif_pid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lif_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'lif_options' => array(GDO::UINT, 0),
			'lif_time' => array(GDO::TIME),
		);
	}
	
	public static function insertMessage($player_id, $message, $options)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'lif_id' => 0,
			'lif_pid' => $player_id,
			'lif_message' => $message,
			'lif_options' => $options,
			'lif_time' => time(),
		));
	}
}
?>