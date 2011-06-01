<?php
final class Module_Lamb extends GWF_Module
{
	private static $instance;
	/**
	 * @return Module_Lamb
	 */
	public static function instance() { return self::$instance; }
	
	##################
	### GWF_Module ###
	##################
	public function getVersion() { return 1.0; }
	public function onInstall($dropTable) { require_once 'module/Lamb/Lamb_Install.php'; return Lamb_Install::onInstall($this, $dropTable); }
	public function getClasses() { return array('Lamb_IRCFrom', 'Lamb_IRCTo', 'Lamb_Players'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/lamb'); }
	public function getDefaultPriority() { return 60; } # 50 is default
	public function getDefaultAutoLoad() { return true; }
	
	public function onStartup()
	{
		self::$instance = $this;
		$this->onLoadLanguage();
		GWF_Website::addCSS('tpl/lamb/css/lamb.css?v=1');
	}
	
	public static function accountButtons()
	{
		$m = self::$instance;
		return 
			GWF_Button::generic($m->lang('btn_link'), GWF_WEB_ROOT.'index.php?mo=Lamb&me=Account').
			GWF_Button::generic($m->lang('btn_play'), 'index.php?mo=Lamb&me=Client');
	}
	
	public static function initLamb()
	{
		require_once 'Lamb_Channel.php';
		require_once 'Lamb_IRC.php';
		require_once 'Lamb_Log.php';
		require_once 'Lamb_Module.php';
		require_once 'Lamb_Server.php';
		require_once 'Lamb_User.php';
		require_once 'Lamb.php';
	}
	
	public static function initShadowlamb()
	{
		static $inited = false;
		if ($inited === true) {
			return;
		}
		
		self::initLamb();
		require_once Lamb::DIR.'lamb_module/Shadowlamb/Shadowrun4.php';
		Shadowrun4::initCore(Lamb::DIR);
		Shadowrun4::initItems(Lamb::DIR);
		Shadowrun4::initCities(Lamb::DIR);
		Shadowrun4::initSpells(Lamb::DIR);
		Shadowrun4::initTimer();
		$inited = true;
	}
	
	public static function equipButton(SR_Item $item, SR_Player $player)
	{
		$name = $item->getItemName();
		return sprintf('<img src="%stemplate/lamb/slimg/cmd/eq.png" alt="Equip %s" title="Equip %s" width="32" height="32" onclick="sl4SendCommand(\'eq %s\')" />', GWF_WEB_ROOT, $name, $name, $name);
	}

	public static function unequipButton(SR_Item $item, SR_Player $player)
	{
		$name = $item->getItemName();
		return sprintf('<img src="%stemplate/lamb/slimg/cmd/uq.png" alt="Unequip %s" title="Unequip %s" width="32" height="32" onclick="sl4SendCommand(\'uq %s\')" />', GWF_WEB_ROOT, $name, $name, $name);
	}

	public static function useButton(SR_Item $item, SR_Player $player)
	{
		$name = $item->getItemName();
		$friend = $item->isItemFriendly() ? 1 : 0;
		$foe = $item->isItemOffensive() ? 1 : 0;
		$instant = $item instanceof SR_Consumable ? 1 : 0;
		return sprintf('<img src="%stemplate/lamb/slimg/cmd/u.png" alt="Use %s" title="Use %s" width="32" height="32" onclick="sl4UseItem(\'%s\', %d, %d, %d)" />', GWF_WEB_ROOT, $name, $name, $name, $friend, $foe, $instant);
	}

	public static function dropButton(SR_Item $item, SR_Player $player)
	{
		$name = $item->getItemName();
		return sprintf('<img src="%stemplate/lamb/slimg/cmd/drop.png" alt="Drop %s" title="Drop %s" width="32" height="32" onclick="sl4SendCommand(\'drop %s\')" />', GWF_WEB_ROOT, $name, $name, $name);
	}
	
	public static function buyButton(SR_Item $item, SR_Player $player)
	{
		$name = $item->getItemName();
		return sprintf('<img src="%stemplate/lamb/slimg/cmd/buy.png" alt="Buy %s" title="Buy %s" width="32" height="32" onclick="sl4SendCommand(\'buy %s\')" />', GWF_WEB_ROOT, $name, $name, $name);
	}
	
	public static function sellButton(SR_Item $item, SR_Player $player)
	{
		$name = $item->getItemName();
		return sprintf('<img src="%stemplate/lamb/slimg/cmd/sell.png" alt="Sell %s" title="Sell %s" width="32" height="32" onclick="sl4SendCommand(\'sell %s\')" />', GWF_WEB_ROOT, $name, $name, $name);
	}
	
	public static function displayEquipment($type, $equipment)
	{
		$itemname = isset($equipment[$type]) ? $equipment[$type]->getItemName() : '';
		return sprintf('<div id="sl4_%s">%s</div>', $type, $itemname);
	}
}
?>