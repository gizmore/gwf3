<?php
abstract class SR_School extends SR_Store
{
	/**
	 * Get the courses for a school. array(array(field, price))
	 * @param SR_Player $player
	 */
	public abstract function getFields(SR_Player $player);

	public function getStoreItems(SR_Player $player) { return array(); }
	public function hasStoreItems(SR_Player $player) { return count($this->getStoreItems($player)) > 0; }
	
	public function getCommands(SR_Player $player)
	{
		if ($this->hasStoreItems($player))
		{
			return array('view', 'viewi', 'buy', 'steal', 'learn', 'courses');
		}
		else
		{
			return array('learn', 'courses');
		}
	}
	
	public function on_courses(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		$format = $player->lang('fmt_bazar_shops');
		$c = '';
		foreach ($this->getFields($player) as $data)
		{
			$price = Shadowfunc::calcBuyPrice($data[1], $player);
			$dp = Shadowfunc::displayNuyen($price);
			$c .= sprintf($format, $data[0], $dp);
// 			$c .= sprintf(', %s(%s)', $data[0], $price);
		}
		
		$c = $c === '' ? $player->lang('none') : substr($c, 2);
		return $bot->rply('5183', array($c));
// 		$bot->reply(sprintf('Available Courses: %s.', substr($c, 2)));
// 		return true;
	}

	public function on_learn(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if (count($args) !== 1) {
			$this->on_courses($player, array());
			return false;
		}
		
		foreach ($this->getFields($player) as $data)
		{
			if ($args[0] === $data[0])
			{
				$price = Shadowfunc::calcBuyPrice($data[1], $player);
				return $this->onLearn($player, $args[0], $price);
			}
		}

		$this->on_courses($player, array());
		return false;
	}
	
	private function onLearn(SR_Player $player, $field, $price)
	{
		$have = false;
		$type = 'skill';
		
		if (false !== ($spell = SR_Spell::getSpell($field)))
		{
			$type = 'spell';
			if ($spell->getBaseLevel($player) > -1)
			{
				$have = true;
			}
		}
		elseif ($player->getBase($field) > -1)
		{
			$have = true;
		}
		
		
		if ($type !== 'spell')
		{
			if ($player->getBase($field) < -1)
			{
				$player->msg('1145', array($field));
// 				$player->message(sprintf('Your character cannot learn %s.', $field));
				return false;
			}
		}
		
		
		if ($have === true)
		{
			$player->msg('1146', array($field));
// 			$player->message(sprintf('You already learned the %s %s.', $type, $field));
			return false;
		}
		
		if ($type === 'spell')
		{
			if (false !== ($error = $spell->checkRequirements($player)))
			{
				$player->msg('1147', array($error));
// 				$player->message(sprintf('You need %s to learn this spell.', $error));
				return false;
			}
		}
		
		$dp = Shadowfunc::displayNuyen($price);
		if (false === $player->pay($price))
		{
			$player->msg('1063', array($dp, $player->displayNuyen()));
// 			$player->message(sprintf('It cost %s to learn the %s %s, but you only have %s.', $dp, $type, $field, $player->displayNuyen()));
			return false;
		}
		
		if ($type === 'spell') {
			$player->levelupSpell($field, 1);
		} elseif ($type === 'skill') {
			$player->updateField($field, 0);
		} else {
			$player->message('Database error!');
			return Lamb_Log::logError(sprintf('Learned field "%s" is neither a skill nor a spell!', $field));
		}
	
		$player->modify();
		
		$player->msg('5184', array($dp, $field));
// 		$player->message(sprintf('You pay %s and learned the %s %s.', $dp, $type, $field));
		return true;
	}
}
?>
