<?php
final class GWF_GDRect
{
	public $w, $h, $x, $y;
	
	public function __construct($x=0, $y=0, $w=1, $h=1)
	{
		$this->x = $x;
		$this->y = $y;
		$this->w = $w;
		$this->h = $h;
	}
	
	public function getX2() { return $this->x + $this->w; }
	public function getY2() { return $this->y + $this->h; }
	

	/**
	 * ttfbbox returns an array with 8 elements representing four points.
	 * We return a rect from it (2 vectors).
	 * @param array $data from imagettfbox
	 * @see imagettfbox
	 * @return GWF_GDRect
	 */
	public static function fromTTFBox(array $data)
	{
		#67UL 45UR
		#01LL 23LR
		return new GWF_GDRect($data[6], $data[1], $data[4]-$data[6], $data[1]-$data[7]);
	}
	
	
	public function toString()
	{
		return sprintf('X: %s, Y:%s, W:%s, H:%s', $this->x, $this->y, $this->w, $this->h);
	}
	
}
?>