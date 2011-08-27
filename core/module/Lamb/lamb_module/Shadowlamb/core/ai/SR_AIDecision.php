<?php
/**
 * A decision made by the AI logic.
 * @author somerandomnick
 */
final class SR_AIDecision
{
	private $command;
	private $preference;
	
	public function __construct($command, $preference=1.0)
	{
		$this->command = $command;
		$this->setPreference($preference);
	}
	
	public function getCommand()
	{
		return $this->command;
	}
	
	public function getPreference()
	{
		return $this->preference;
	}
	
	public function setPreference($preference)
	{
		$this->preference = Common::clamp($preference, 0);
	}
	
	################
	### Sort ASC ###
	################
	/**
	 * Sort decisions by preference, ascending.
	 * @param array $decisions
	 * @return array
	 */
	public static function sortDecisions(array &$decisions)
	{
		usort($decisions, array(__CLASS__, 'sort'));
		return $decisions;
	}
	
	/**
	 * Remove all items from array that are not a decision.
	 * @param array $args
	 * @return array
	 */
	public static function filterDecisions(array &$args)
	{
		foreach ($args as $i => $arg)
		{
			if (!($arg instanceof SR_AIDecision))
			{
				Lamb_Log::logDebug('filterDecisions argument is not a decision.');
				GWF_Debug::backtrace('filterDecisions argument is not a decision.', $args);
				unset($args[$i]);
			}
		}
		return $args;
	}
	
	
	public static function sort($a, $b)
	{
		return $a->getPreference() - $b->getPreference();
//		return ( ($a instanceof SR_AIDecision) && ($b instanceof SR_AIDecision) )
//			? $a->getPreference() - $b->getPreference()
//			: -1;
	}
}
?>