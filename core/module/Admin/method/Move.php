<?php

final class Admin_Move extends GWF_Method
{
	public function getUserGroups() { return GWF_Group::ADMIN; }
	
	private static $MOVE_UP = 1;
	private static $MOVE_DOWN = 2;
	private static $MOVE_FIRST = 3;
	private static $MOVE_LAST = 4;
		
	public static function sortByPriority(GWF_Module $a, GWF_Module $b)
	{
		return $a->getPriority() - $b->getPriority();
	}

	public function getHTAccess()
	{
		return sprintf('RewriteRule ^%s/move/(up|down|first|last)/([a-zA-Z]+)$ index.php?mo=Admin&me=Move&$1=now&modulename=$2'.PHP_EOL, Module_Admin::ADMIN_URL_NAME);
	}
	
	public function execute()
	{
		$gdo = new GWF_Module(false);
		$by = $gdo->getWhitelistedBy(Common::getGet('by', 'module_name'));
		$dir = $gdo->getWhitelistedDir(Common::getGet('dir', 'ASC'));
		
		return $this->onMove(Common::getGet('modulename'));
	}
	
	private function onMove($modulename)
	{
		$modules = GWF_Module::getModules();
		usort($modules, array(__CLASS__, 'sortByPriority'));
		
		$mode = $this->getMoveMode();
		
		if (false === ($current = GWF_Module::getModule($modulename))) {
			return $this->module->error('err_mod_not_installed');
		}
		
		$order = array(
			'first' => false,
			'prev' => false,
			'curr'=>  $current,
			'next' => false,
			'last' => false,
		);
		
		$curr = $current;
		$prev = $current;
		$realprev = false;
		$priority = 1;
		foreach ($modules as $m)
		{
			if ($order['first'] === false) {
				$order['first'] = $m;
			}	

			$prev = $curr;
			$curr = $m;
			
			if ($curr->getName() == $modulename) {
				$realprev = $prev;
			}
			if ($prev->getName() === $modulename) {
				$order['next'] = $m;
			}
			
			$m->saveVar('module_priority', $priority++);
		}
		
		$order['prev'] = $prev;
		$order['last'] = $curr;
		
		switch ($mode)
		{
			case self::$MOVE_UP:
				$exchange = $order['prev'];
				break;
			case self::$MOVE_DOWN:
				$exchange = $order['next'];
				break;
			case self::$MOVE_FIRST:
				$exchange = $order['first'];
				break;
			case self::$MOVE_LAST:
				$exchange = $order['last'];
				break;
			default: die('FUCKED UP!');
		}
		
		$this->switchPriority($current, $exchange);
		
		$_GET['by'] = 'module_priority';
		$_GET['dir'] = 'ASC';
		
		return $this->module->requestMethodB('Modules');
	}
	
	private function switchPriority(GWF_Module $current, GWF_Module $exchange)
	{
		$t = $current->getPriority();
		$current->saveVar('module_priority', $exchange->getPriority());
		$exchange->saveVar('module_priority', $t);
	}
	
	private function getMoveMode()
	{
		if (Common::getGet('up') !== false) {
			return self::$MOVE_UP;
		}
		elseif (Common::getGet('down') !== false) {
			return self::$MOVE_DOWN;
		}
		elseif (Common::getGet('first') !== false) {
			return self::$MOVE_FIRST;
		}
		elseif (Common::getGet('last') !== false) {
			return self::$MOVE_LAST;
		}
	}
}

?>
