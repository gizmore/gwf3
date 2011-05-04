<?php
final class Lamb_PG extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_pg'; }
	public function getColumnDefines()
	{
		return array(
			'lpg_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'lpg_time' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
		);
	}
	
	public static function onKick(Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user, $message)
	{
		echo "PG: $message\n";
//		$server->sendPrivmsg($channel->getName(), $user->getName().': '.$message);
		$server->getConnection()->send(sprintf("KICK %s %s :%s", $channel->getName(), $user->getName(), $message));
		$event = new self(array(
			'lpg_uid' => $user->getID(),
			'lpg_time' => time(),
		));
		self::onBan($server, $channel, $user, $message);
	}

	private static function onBan(Lamb_Server $server, Lamb_Channel $channel, Lamb_User $user, $message)
	{
		$uid = $user->getID();
		$cut = time() - LambModule_PG::BAN_TIMEOUT;
		$count = self::table(__CLASS__)->countRows("lpg_uid=$uid AND lpg_time>$cut");
		if ($count < LambModule_PG::BAN_COUNT) {
			return;
		}
		
		echo "!!! BAN HIM NOW !!!\n";
	}
}
?>