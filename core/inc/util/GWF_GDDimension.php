<?php
/**
 * An object that only holds size information.
 * @author gizmore
 */
final class GWF_GDDimension
{
	public $w, $h;
	
	public function __construct($w, $h)
	{
		$this->w = $w;
		$this->h = $h;
	}
}
?>
