<?php
final class SR_AIView implements ArrayAccess
{
	private $player; # Owner of the view
	private $object; # Can be anything
	private $type; # Hold the classname / type of object.
	private $childs; # All the vars!
	
	public function __construct(SR_Player $player, $object)
	{
		$this->player = $player;
		$this->object = $object;
		$this->type = get_class($object);
//		$this->createView($object);
	}
	
//	private function createView($object)
//	{
//		if (is_array($object))
//		{
//			$this->vars = $object;
//		}
//		else switch (get_class($object))
//		{
//			default:
//				$this->vars = array();
//		}
//	}
	
	public function offsetExists(mixed $offset): bool
	{
		if (isset($this->childs[$offset]))
		{
			return true;
		}

		$array = $players->find($object, $offset);
		if ($array === NULL)
		{
			return false;
		}
		
		return true;
	}
	
	public function offsetGet(mixed $offset): mixed
	{
		
		return $this->vars[$offset];
	}
	
	public function offsetSet(mixed $offset, mixed $value): void
	{
		$this->vars[$offset] = $value;
	}
	
	public function offsetUnset(mixed $offset): void
	{
		unset($this->vars[$offset]);
	}
}
?>
