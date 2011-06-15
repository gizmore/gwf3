<?php
final class Lamb_Ajax extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false === ($player_id = GWF_Session::getOrDefault('SL4_PID', false))) {
			return 'NO PLAYER SELECTED';
		}
		
		$cmd = Common::getGetString('cmd');
		
		switch ($cmd)
		{
			case 'send': return $this->sendMessage($module, $player_id);
			case 'peek': return $this->peekMessages($module, $player_id);
		}
		
		$module->initShadowlamb();
		if (false === ($player = SR_Player::getByID($player_id))) {
			return 'PLAYER GONE!';
		}
		
		switch ($cmd)
		{
			
			case 'i': return $this->getInventory($module, $player);
			case 'q': return $this->getEquipment($module, $player);
			case 's': return $this->getStats($module, $player);
			case 'p': return $this->getParty($module, $player);
			case 'c': return $this->getCommands($module, $player);
			case 'kp': return $this->getLocations($module, $player);
			case 'kw': return $this->getWords($module, $player);
			case 'cy': return $this->getCyberware($module, $player);
			
			case 'item': return $this->getItem($module, $player);
			case 'sitem': return $this->getStoreItem($module, $player);
			
			default: return 'UNKNOWN COMMAND!';
		}
	}
	
	private function sendMessage(Module_Lamb $module, $pid)
	{
		require_once 'module/Lamb/Lamb_IRCTo.php';
		if ('' !== ($msg = Common::getGetString('send', ''))) {
			if (false === Lamb_IRCTo::pushMessage($pid, $msg)) {
				return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
			}
		}
		return '';
	}
	
	private function peekMessages(Module_Lamb $module, $pid)
	{
		require_once 'module/Lamb/Lamb_IRCFrom.php';
		$table = GDO::table('Lamb_IRCFrom');
		if (false === ($result = $table->selectAll('lif_message, lif_options', "lif_pid=$pid", 'lif_time ASC'))) {
			return '';
		}
		$table->deleteWhere("lif_pid=$pid");
		return json_encode($result);
	}
	
	public function getItem(Module_Lamb $module, SR_Player $player)
	{
		$itemname = Common::getGetString('item');
		if (false === ($item = $player->getItem($itemname))) {
			return 'Unknown Item';
		}
		$tVars = array(
			'item' => $item,
			'player' => $player,
			'img' => GWF_WEB_ROOT.'tpl/lamb/slimg/item/'.$item->getName().'.png',
		);
		return $module->template('item.php', NULL, $tVars);
	}
	
	public function getStoreItem(Module_Lamb $module, SR_Player $player)
	{
		$itemname = Common::getGetString('item');
		if (false === ($item = SR_Item::getItem($itemname))) {
			return 'Unknown Item';
		}
		$tVars = array(
			'item' => $item,
			'player' => $player,
			'img' => GWF_WEB_ROOT.'tpl/lamb/slimg/item/'.$item->getName().'.png',
		);
		return $module->template('store_item.php', NULL, $tVars);
	}
	
	public function getCommands(Module_Lamb $module, $player)
	{
		$blacklist = array('we','gmstats','helo','help','s','a','sk','q','p','i','cy','ef','ex','kp','ks','kw','qu','sd','pm','gm','gmi','gml','start','reset','enable','disable','redmond','c','ny','ka','hp','mp','le','kick','ban','unban','drop','give','part','l','r','eq','uq','u','sp','rl','j');
		$back = '';
		if ($player === false) {
			return $back;
		}
		$player instanceof SR_Player;
		foreach (Shadowcmd::getCurrentCommands($player) as $cmd)
		{
			if (!in_array($cmd, $blacklist, true))
			{
				$back .= sprintf('<img src="%stpl/lamb/slimg/cmd/%s.png" alt="%s" title="%s" width="32" height="32" onclick="return sl4ClickCommand(\'%s\')" />', GWF_WEB_ROOT, $cmd, $cmd, $cmd, $cmd);
			}
		}
		return $back;
	}
	
	public function getLocations(Module_Lamb $module, $player)
	{
		if ($player === false) {
			return '';
		}
		$player instanceof SR_Player;
		$places = Shadowfunc::getKnownPlaces($player, $player->getParty()->getCity());
		if ($places === false) {
			return '';
		}

		$back = '';
		foreach (explode(',', $places) as $place)
		{
			$place = trim($place);
			$place = explode('-', $place);
			$back .= sprintf('<img src="%stpl/lamb/slimg/location/%s.png" width="32" height="32" title="%s" alt="%s" onclick="return sl4ClickLocation(%s);" />', GWF_WEB_ROOT, $place[1], $place[1], $place[1], $place[0]);
		}
		return $back;
	}
	
	public function getInventory(Module_Lamb $module, $player)
	{
		$back = '<p>Inventory</p>';
		if ($player === false) {
			return $back;
		}
		$player instanceof SR_Player;
		
		$inv = $player->getInventorySorted();
		
		foreach ($inv as $name => $data)
		{
			$count = $data[0] > 1 ? sprintf('(%s)', $data[0]) : '';
			$back .= sprintf('<div>%s%s</div>', $name, $count);
		}
		
		return $back;
	}

	public function getCyberware(Module_Lamb $module, $player)
	{
		$back = '<p>Cyberware</p>';
		if ($player === false) {
			return $back;
		}
		$player instanceof SR_Player;
		foreach ($player->getCyberware() as $item)
		{
			$back .= sprintf('<div>%s</div>', $item->getItemName());
		}
		return $back;
	}
	
	public function getEquipment(Module_Lamb $module, $player)
	{
		if ($player === false) {
			return '';
		} $player instanceof SR_Player;
		
		$eq = $player->getAllEquipment(true);
		$tVars = array(
			'equipment' => $eq,
		);
		return $module->template('equipment.php', NULL, $tVars);
	}
	
	public function getStats(Module_Lamb $module, $player)
	{
		if ($player === false) {
			return '';
		} $player instanceof SR_Player;
		$tVars = array(
			'player' => $player,
		);
		return $module->template('stats.php', NULL, $tVars);
	}
	
	public function getParty(Module_Lamb $module, $player)
	{
		if ($player === false) {
			return '';
		} $player instanceof SR_Player;
		$tVars = array(
			'player' => $player,
		);
		return $module->template('party.php', NULL, $tVars);
	}
	
	public function getWords(Module_Lamb $module, SR_Player $player)
	{
		if ('' === ($words = trim($player->getKnowledge('words'), ','))) {
			return array();
		}
		return json_encode(explode(',', $words));
	}
}
?>
