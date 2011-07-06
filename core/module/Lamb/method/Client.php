<?php
final class Lamb_Client extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$module->initShadowlamb();
		
		$pid = intval(Common::getGet('pid', 0));
		$player = false;
		if ( (false === Lamb_Players::ownsPlayer(GWF_Session::getUserID(), $pid)) || (false === ($player = SR_Player::getByID($pid))) ) {
			$pid = 0;
		} else {
			GWF_Session::set('SL4_PID', $pid);
//			GWF_Website::includeJQuery();
			GWF_Website::addJavascriptInline("$(document).ready(function() { sl4Init($pid); } );");
			Lamb_IRCTo::pushMessage($pid, 'helo');
		}

		GWF_Website::addJavascript($module->getModuleFilePath('js/shadowlamb.js'));
		
		return $this->templateClient($module, $player);
	}
	
	private function templateClient(Module_Lamb $module, $player)
	{
		$ajax = $module->getMethod('Ajax');
		
		$tVars = array(
			'player' => $player,
			'select_account' => self::selectAccounts($module, $player->getID()),
			'inventory' => $ajax->getInventory($module, $player),
			'equipment' => $ajax->getEquipment($module, $player),
			'cyberware' => $ajax->getCyberware($module, $player),
			'commands' => $ajax->getCommands($module, $player),
			'stats' => $ajax->getStats($module, $player),
			'party' => $ajax->getParty($module, $player),
			'locations' => $ajax->getLocations($module, $player),
		);
		return $module->template('client.php', NULL, $tVars);
	}
	
	public function selectAccounts(Module_Lamb $module, $selected='0')
	{
		$userid = GWF_Session::getUserID();
		$table = GDO::table('Lamb_Players');
		if (false === ($result = $table->select('sr4pl_id,lusr_name,lusr_sid', "ll_uid={$userid}", '', array('ll_lid', 'll_pid'))))
		{
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}

		$onchange = 'sl4SwitchAccount(this.value);';
		$data = array(array('0', $module->lang('sel_account')));
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
			$data[] = array($row['sr4pl_id'], sprintf('%s{%s}', $row['lusr_name'], $row['lusr_sid']));
		}
		$table->free($result);
		
		return GWF_Select::display('account', $data, $selected, $onchange);
	}
}
?>