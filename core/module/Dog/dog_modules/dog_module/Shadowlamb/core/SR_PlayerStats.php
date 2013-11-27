<?php
final class SR_PlayerStats extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'sr4_player_stats'; }
	public function getColumnDefines()
	{
		return array(
			'sr4ps_pid' => array(GDO::UINT|GDO::PRIMARY_KEY),
			# Items
			'sr4ps_i_looted' => array(GDO::UINT, 0),
			'sr4ps_i_sold' => array(GDO::UINT, 0),
			'sr4ps_i_bought' => array(GDO::UINT, 0),
			'sr4ps_i_dropped' => array(GDO::UINT, 0),
			'sr4ps_i_given' => array(GDO::UINT, 0),
			'sr4ps_i_received' => array(GDO::UINT, 0),
			# Nuyen
			'sr4ps_ny_loot' => array(GDO::UINT, 0),
			'sr4ps_ny_spent' => array(GDO::UINT, 0),
			'sr4ps_ny_income' => array(GDO::UINT, 0),
			'sr4ps_ny_given' => array(GDO::UINT, 0),
			'sr4ps_ny_received' => array(GDO::UINT, 0),
			# Kills
			'sr4ps_kill_mob' => array(GDO::UINT, 0),
			'sr4ps_kill_npc' => array(GDO::UINT, 0),
			'sr4ps_kill_human' => array(GDO::UINT, 0),
			'sr4ps_kill_runner' => array(GDO::UINT, 0),
		);
	}
	
	public static function getOrCreateStats(SR_Player $player)
	{
		if (false === ($stats = self::table(__CLASS__)->getBy('sr4ps_pid', $player->getID())))
		{
			return self::createStats($player);
		}
		return $stats;
	}
	
	public static function createStats(SR_Player $player)
	{
		$stats = new self(array(
			'sr4ps_pid' => $player->getID(),
			# Items
			'sr4ps_i_looted' => 0,
			'sr4ps_i_sold' => 0,
			'sr4ps_i_bought' => 0,
			'sr4ps_i_dropped' => 0,
			'sr4ps_i_given' => 0,
			'sr4ps_i_received' => 0,
			# Nuyen
			'sr4ps_ny_loot' => 0,
			'sr4ps_ny_spent' => 0,
			'sr4ps_ny_income' => 0,
			'sr4ps_ny_given' => 0,
			'sr4ps_ny_received' => 0,
			# Kills
			'sr4ps_kill_mob' => 0,
			'sr4ps_kill_npc' => 0,
			'sr4ps_kill_human' => 0,
			'sr4ps_kill_runner' => 0,
		));
		
		if (false === ($stats->replace()))
		{
			return false;
		}
		
		return $stats;
	}
	
	public static function onKill(SR_Player $killer, SR_Player $victim)
	{
		if (!$killer->isHuman())
		{
			return true;
		}
		if ($victim instanceof SR_HireNPC)
		{
			$column = 'npc';
		}
		elseif ($victim instanceof SR_NPC)
		{
			$column = 'mob';
		}
		else
		{
			if ($victim->isRunner())
			{
				$column = 'runner';
			}
			else
			{
				$column = 'human';
			}
		}
		
		if (false === ($stats = self::getOrCreateStats($killer)))
		{
			return false;
		}

		return $stats->increase('sr4ps_kill_'.$column, 1);
	}
}
?>
