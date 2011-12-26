<?php
/**
 * 
 * @author spaceone
 */
abstract class SF_Function
{
	private $cmdA;
	public function __construct(array $cmdA)
	{
		$this->cmdA = $cmdA;
	}
	
	/**
	 * All options the function can have
	 * @example -h; --help
	 */
	public function getOptions() { return array(); }
	
	/**
	* A simple Option Parser
	*/
	protected final function parseArgs()
	{
		$args = $this->getOptions();
		$cmdA = $this->cmdA;
	}

	/**
	* return String
	*/
	public function execute() { GWF3::logDie(__CLASS__.': method execute have to be overwritten! '); }

	public function redirect($url) { header(sprintf('Location: http://%s', $_SERVER['SERVER_NAME'].GWF_WEB_ROOT.$url)); }

	/**
	* Is the Function a copy of another?
	* @todo rename
	* @return false|String
	*/
	public function isClone() { return false; }
}
