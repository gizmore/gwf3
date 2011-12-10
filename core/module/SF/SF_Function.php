<?php
/**
 * 
 * @author spaceone
 */
abstract class SF_Function
{
	public function __construct(array $cmdA)
	{
		;
	}
	
	/**
	 * All options the function can have
	 * @example -h; --help
	 */
	abstract function getOptions();
	
	public function parseArgs()
	{
		
	}

	abstract function execute();

}
