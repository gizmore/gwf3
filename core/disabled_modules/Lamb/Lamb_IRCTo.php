<?php
/**
 * This is www2irc wrapper
 * @author gizmore
 */
final class Lamb_IRCTo extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_irc_to'; }
	public function getColumnDefines()
	{
		return array(
			'lit_pid' => array(GDO::UINT, GDO::NOT_NULL),
			'lit_message' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S)
		);
	}
	
	public static function pushMessage($pid, $message)
	{
		return self::table(__CLASS__)->insertAssoc(array(
			'lit_pid' => $pid,
			'lit_message' => $message,
		), false);
	}
}
?>