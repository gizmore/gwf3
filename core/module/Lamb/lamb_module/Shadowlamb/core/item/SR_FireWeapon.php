<?php
abstract class SR_FireWeapon extends SR_Weapon
{
	public abstract function getAmmoName();
	public abstract function getReloadTime();
	public function isLoaded() { return $this->getAmmo() >= $this->getBulletsPerShot(); }
	
	public function getItemRange() { return 20.0; }
	
	public function getItemModifiersW(SR_Player $player)
	{
		$sub = Common::clamp($player->get($this->getItemSubType()), 0); # (pis,sho,smg,hmg,bow)
		$fir = Common::clamp($player->get('firearms')); # (fir),
		$nin = $sub === 'bows' ? Common::clamp($player->get('ninja')) : 0.0; # (bow++)
		return array(
			'attack' =>  round($fir*2.0 + $sub*1.0 + $nin*0.2, 1),
			'min_dmg' => round($fir*0.0 + $sub*0.2 + $nin*0.0, 1),
			'max_dmg' => round($fir*0.0 + $sub*0.8 + $nin*0.1, 1),
		);
	}
	
	public function displayRequirements(SR_Player $player)
	{
		return $this->displayRequireAmmo($player).parent::displayRequirements($player);
	}
	
	private function displayRequireAmmo(SR_Player $player)
	{
		$b = chr(2);
		return sprintf(" {$b}Ammo{$b}: %s, %s/%s bullets per shot.", $this->getAmmoName(), $this->getBulletsPerShot(), $this->getBulletsMax());
	}
	
	public function onReload(SR_Player $player)
	{
		if (false === ($ammo = $player->getItemByName($this->getAmmoName())))
		{
			$player->message('You are out of ammo!');
			$player->unequip($this);
			$player->modify();
			return true;
		}
		
		$p = $player->getParty();
		
		$now = $this->getAmmo();
		$max = $this->getBulletsMax();
		$avail = $ammo->getAmount();
		$put = Common::clamp($max-$now, 0, $avail);
		
		if ($put == 0)
		{
			$player->message('Your weapon is already loaded.');
			return false;
		}
		
//		Lamb_Log::logDebug(sprintf('%s reloads his %s: Nee'))
		
		$ammo->useAmount($player, $put);
		$this->increase('sr4it_ammo', $put);

		if ($p->isFighting())
		{
			$message = sprintf(' load(s) %d bullet(s) into his %s. %s busy.', $put, $this->getItemName(), $player->busy(round($this->getReloadTime()+rand(0, 10))));
			$p->message($player, $message);
//			$p->getEnemyParty()->message($player, $message);
		}
		else
		{
			$message = sprintf('You load %d bullet(s) into your %s.', $put, $this->getItemName());
			$bot = Shadowrap::instance($player);
			$bot->reply($message);
		}
		
		return true;
	}
	
	
	public function onAttack(SR_Player $player, $arg)
	{
		if (!$this->isLoaded()) {
			$this->onReload($player);
			return true;
		}
		
		if (false === $this->onAttackB($player, $arg, 'farm')) {
			return false;
		}
		$this->increase('sr4it_ammo', -$this->getBulletsPerShot());
		return true;
	}
}

/**
 * Bows should not require firearms.
 * @author gizmore
 */
abstract class SR_Bow extends SR_FireWeapon
{
	public function getAmmoName() { return 'Ammo_Arrow'; }
	public function getReloadTime() { return 7; }
	public function getBulletsMax() { return 1; }
	public function getBulletsPerShot() { return 1; }
	public function getItemSubType() { return 'bows'; }
	public function displayType() { return 'Bow'; }
	
}

abstract class SR_Pistol extends SR_FireWeapon
{
	public function getItemSubType() { return 'pistols'; }
	public function getBulletsPerShot() { return 1; }
	public function displayType() { return 'Pistol'; }
}

abstract class SR_Shotgun extends SR_FireWeapon
{
	public function getItemSubType() { return 'shotguns'; }
	public function getBulletsPerShot() { return 1; }
	public function displayType() { return 'Shotgun'; }
}

abstract class SR_SMG extends SR_FireWeapon
{
	public function getItemSubType() { return 'smgs'; }
	public function getBulletsPerShot() { return 3; }
	public function displayType() { return 'SMG'; }
}

abstract class SR_HMG extends SR_FireWeapon
{
	public function getItemSubType() { return 'hmgs'; }
	public function getBulletsPerShot() { return 5; }
	public function displayType() { return 'HMG'; }
}
?>
