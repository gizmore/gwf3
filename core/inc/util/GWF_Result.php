<?php
/**
 * Result message.
 * @author Kender
 */
final class GWF_Result
{
	private $message;
	private $is_error;

	public function __construct($message, $is_error)
	{
		$this->message = $message;
		$this->is_error = $is_error;
	}

	public function isError()
	{
		return $this->is_error === true;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function display($title='Error')
	{
		if ($this->is_error)
		{
			return GWF_HTML::error($title, $this->message);
		}
		else
		{
			return GWF_HTML::message($title, $this->message);
		}
	}
}
