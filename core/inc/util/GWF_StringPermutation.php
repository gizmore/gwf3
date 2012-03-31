<?php
final class GWF_StringPermutation extends GWF_Permutation
{
	private $string;
	public function __construct($s)
	{
		$this->string = $s;
		parent::__construct(strlen($s));
	}

	public function getNext()
	{
		$a = parent::getNext();
		$back = '';
		foreach ($a as $i)
		{
			$back .= $this->string{$i};
		}
		return $back;
	}
}
