<?php
final class Slay_Response
{
	private $data;
	public function __construct(array $data)
	{
		$this->data = $data;
	}
	
	public function getNow() { return $this->data['now']; }
	
}
?>