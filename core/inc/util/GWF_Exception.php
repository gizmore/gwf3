<?php
/**
 * @todo multiple message handling
 * @author spaceone
 */
final class GWF_Exception extends Exception
{
	const CORE = 1;
	const MODULES = 2;
	const GDO = 3;
	const SMARTY = 4;
	const LOG = 5;
	const MAIL = 6;

	private $msg = array();

	public function __construct($message='', $code=0)
	{
		if (false === is_array($message))
		{
			$this->msg[] = $message;
		}
		else
		{
			$this->appendMessage($message);
			$message = $message[0];
		}
		return parent::__construct($message, $code);
	}

	public function __toString()
	{
		return sprintf('GWF_Exception:');
	}

	/**
	 *
	 * @todo additional message
	 */
	public function _throw($message)
	{
		$this->appendMessage($message);
		throw $this;
	}

	public function appendMessage($message)
	{
		$this->msg = array_merge((array)$this->msg, (array)$message);
	}

	public function isError() { return $this->getCode() > 0; }

	public function display($title='Error')
	{
		if ($this->isError())
		{
			return GWF_HTML::error($title, (array)$this->msg);
		}
		else
		{
			return GWF_HTML::message($title, (array)$this->msg);
		}
	}

	/**
	 * 
	 * @deprecated ?
	 */
	public static function throwException($code=0)
	{
	}
}

