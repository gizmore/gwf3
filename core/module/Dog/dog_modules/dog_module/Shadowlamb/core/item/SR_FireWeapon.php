<?php
require_once 'SR_Weapon.php';

abstract class SR_FireWeapon extends SR_Weapon
{
	public abstract function getAmmoName();
	public abstract function getReloadTime();
	public function isLoaded() { return $this->getAmmo() >= $this->getBulletsPerShot(); }
	public function isFullyLoaded() { return $this->getAmmo() >= $this->getBulletsMax(); }
	public function getItemRange() { return 20.0; }
	public function getItemEquipTime() { return $this->getItemUsetime(); }
	public function getItemUnequipTime() { return 25; }
	
	public function getItemModifiersW(SR_Player $player)
	{
//		$fir = Common::clamp($player->get('firearms')); # (fir),
//		$sub = Common::clamp($player->get($this->getItemSubType())); # (pis,sho,smg,hmg)
//		$nin = Common::clamp($player->get('ninja')); # (nin)
		$fir = $player->get('firearms');
		$sub = $player->get($this->getItemSubType());
//		$nin = $player->get('ninja');
		return array(
			'attack' =>  3.2 + round($fir*2.5 + $sub*1.5, 1), # 4.0
			'min_dmg' => 0.6 + round($fir*0.2 + $sub*0.4, 1), # 0.6
			'max_dmg' => 1.8 + round($fir*1.0 + $sub*1.0, 1), # 1.8
//			'attack' =>  round($fir*2.0 + $sub*1.0 + $nin*0.2, 1), # 3.2
//			'min_dmg' => round($fir*0.1 + $sub*0.2 + $nin*0.1, 1), # 0.4
//			'max_dmg' => round($fir*0.1 + $sub*0.8 + $nin*0.1, 1), # 1.0
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
			$player->msg('5205');
// 			$player->message('You are out of ammo!');
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
			$player->msg('1156');
// 			$player->message('Your weapon is already loaded.');
			return false;
		}
		
//		Dog_Log::debug(sprintf('%s reloads his %s: Nee'))
		
		$ammo->useAmount($player, $put);
		$this->increase('sr4it_ammo', $put);

		if ($p->isFighting())
		{
			$ep = $p->getEnemyParty();
			$busy = $player->busy(round($this->getReloadTime()+rand(0, 10)));
			$p->ntice('5206', array($player->getName(), $put, $this->getName(), $busy));
			$ep->ntice('5206', array($player->getName(), $put, $this->getName(), $busy));
			
// 			$message = sprintf(' load(s) %d bullet(s) into his %s. %s', $put, $this->getItemName(), Shadowfunc::displayBusy($busy));
//			$message = sprintf(' load(s) %d bullet(s) into his %s. %s busy.', $put, $this->getItemName(), $player->busy(round($this->getReloadTime()+rand(0, 10))));
// 			$p->message($player, $message);
// 			$p->getEnemyParty()->message($player, $message);
		}
		else
		{
// 			$message = sprintf('You load %d bullet(s) into your %s.', $put, $this->getItemName());
// 			$bot = Shadowrap::instance($player);
// 			$bot->rply('5207', array($put, $this->getName()));
			$player->msg('5207', array($put, $this->getName()));
// 			$bot->reply($message);
		}
		
		
		return true;
	}
	
	
	public function onAttack(SR_Player $player, $arg)
	{
		if (!$this->isLoaded())
		{
			$this->onReload($player);
			return true;
		}
		
		if (false === $this->onAttackB($player, $arg, 'farm'))
		{
			return false;
		}
		
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
	
	public function getItemModifiersW(SR_Player $player)
	{
//		$fir = Common::clamp($player->get('firearms'));
//		$sub = Common::clamp($player->get('bows'));
//		$nin = Common::clamp($player->get('ninja'));
		$fir = $player->get('firearms');
		$sub = $player->get('bows');
		$nin = $player->get('ninja');
		return array(
			'attack' =>  3.2 + round($fir*1.5 + $sub*1.5 + $nin*0.2, 1), # 3.2
			'min_dmg' => 0.4 + round($fir*0.1 + $sub*0.1 + $nin*0.2, 1), # 0.4
			'max_dmg' => 2.0 + round($fir*0.6 + $sub*0.7 + $nin*0.7, 1), # 2.0
//			'attack' =>  round($fir*1.0 + $sub*2.0 + $nin*1.0, 1), # 3.2
//			'min_dmg' => round($fir*0.1 + $sub*0.2 + $nin*0.2, 1), # 0.5
//			'max_dmg' => round($fir*0.1 + $sub*0.8 + $nin*0.2, 1), # 1.1
		);
	}
	
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
