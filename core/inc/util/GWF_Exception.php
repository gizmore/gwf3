<?php

final class GWF_Exception extends Exception
{
	const GENERAL = 0;

	public function __construct($message, $code=0)
	{
		return parent::__construct($message, $code);
	}

	public function __toString()
	{
		return sprintf('GWF_Exception:');
	}

	public static function throwException($code=0)
	{
		switch($code)
		{
			case self::GENERAL:
				throw new self('GWF3: General', $code);
				break;

			default: 
				break;
		}
	}
}
