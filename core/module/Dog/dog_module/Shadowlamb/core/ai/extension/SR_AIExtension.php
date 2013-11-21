<?php
abstract class SR_AIExtension
{
	private $args = null;
	 
	public function __construct(array $args=null) { $this->args = $args; }
	public function getPriority() { return $this->getArg('priority', 50); }
	public function getArg($key, $default=null) { return isset($this->args[$key]) ? $this->args[$key] : $default; }

	##############
	### Static ###
	##############
	public static function merge(array $a, array $b)
	{
		return array_merge_recursive($a, $b);
	}
	
	public static function sort_priority_asc(SR_AIExtension $a, SR_AIExtension $b)
	{
		return $a->getPriority() - $b->getPriority();
	}
	
	public static function sort_extensions_desc(SR_AIExtension $a, SR_AIExtension $b)
	{
		return -self::sort_extensions_priority_asc($a, $b);
	}
	
	public static function generate(array $extensions_data)
	{
		$extensions = array();
		foreach ($extensions_data as $extension_name => $data)
		{
			if (Common::isNumeric($extension_name))
			{
				$extension_name = $data;
				$data = null;
			}
			
			$extensions[] = self::createExtension($extension_name, $data);
		
		}
		usort($extensions, array(__CLASS__, 'sort_priority_asc'));
		return $extensions;
	}
	
	private static function createExtension($extension_name, $data)
	{
		$classname = "SR_AI_{$extension_name}";
		return new $classname($data);
	}
	
	############
	### Util ###
	############
	public static function getHuman()
	{
		return Shadowcmd::$CURRENT_PLAYER;
	}
	
	public static function getPlayer($param)
	{
		return Shadowrun4::getPlayerByName($param);
	}
	
	public static function getInvItem(SR_RealNPC $npc, $param)
	{
		$name = preg_replace('/^\\d+x/', '', $param);
		return $npc->getInvItemByName($name);
	}
	
	public static function sortItems(SR_RealNPC $npc, array $items, $function_name, $min=0, $max=100000, $asc = -1)
	{
		$back = array();
		foreach ($items as $item)
		{
			$v = $npc->realnpcfunc($function_name, $item);
			if ($v >= $min && $v <= $max)
			{
				$back[] = $item;
			}
		}
		uasort($back, function($a, $b){
			$va = $npc->realnpcfunc($function_name, $a);
			$vb = $npc->realnpcfunc($function_name, $b);
			$a->setVar('urgengy', $va);
			return $va - $vb * $asc;
		});
		return $back;
	}
	
	public static function getUnwantedItems(SR_RealNPC $npc, $perc)
	{
		return self::sortedItems($npc, $npc->getInventorySorted(), 'needs_item');
	}
}
