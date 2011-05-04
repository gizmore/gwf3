<?php
abstract class SR_FireWeapon extends SR_Weapon
{
	public abstract function getAmmoName();
	public abstract function getReloadTime();
	public abstract function getBulletsPerShot();
	public function isLoaded() { return $this->getAmmo() >= $this->getBulletsPerRound(); }
	
	public function getItemRange() { return 20.0; }
	
	public function getItemModifiersW(SR_Player $player)
	{
		$sub = $player->get($this->getItemSubType());
		return array(
			'attack' => $player->get('firearms') + $sub,
			'max_dmg' => round($sub*1.2, 1),
			'min_dmg' => round($sub/3, 1),
		);
	}
	
	public function onReload(SR_Player $player)
	{
		if (false === ($ammo = $player->getItemByName($this->getAmmoName()))) {
			$player->message('You are out of ammo!');
			$player->unequip($this);
			return true;
		}
		
		$p = $player->getParty();
		
		$now = $this->getAmmo();
		$max = $this->getBulletsMax();
		$avail = $ammo->getAmount();
		$put = Common::clamp($max-$now, 0, $avail);
		
//		Lamb_Log::log(sprintf('%s reloads his %s: Nee'))
		
		$ammo->useAmount($player, $put);
		$this->increase('sr4it_ammo', $put);

		$message = sprintf(' loads %d bullet(s) into his %s. %s busy.', $put, $this->getItemName(), $player->busy(round($this->getReloadTime())));
		if ($p->isFighting())
		{
			$p->getEnemyParty()->message($player, $message);
			$p->message($player, $message);
		}
		else
		{
			$p->notice('You'.$message);
		}
		
	}
	
	
	public function onAttack(SR_Player $player, $arg)
	{
		if (!$this->isLoaded()) {
			$this->onReload($player);
			return true;
		}
		$this->increase('sr4it_ammo', -$this->getBulletsPerShot());
		return $this->onAttackB($player, $arg, 'farm');
	}
}

abstract class SR_Bow extends SR_FireWeapon
{
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getReloadTime() { return 7; }
	public function getBulletsMax() { return 1; }
	public function getBulletsPerShot() { return 1; }
	public function getItemSubType() { return 'bows'; }
}
abstract class SR_Pistol extends SR_FireWeapon
{
	public function getItemSubType() { return 'pistols'; }
	public function getBulletsPerShot() { return 1; }
}
?>

