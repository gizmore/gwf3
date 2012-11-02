<?php
final class GWF_GDPoint
{
	public $x, $y, $r=1;
	
	public function __construct($x, $y, $r)
	{
		$this->x = $x;
		$this->y = $y;
		$this->r = $r;
	}
}
?>
