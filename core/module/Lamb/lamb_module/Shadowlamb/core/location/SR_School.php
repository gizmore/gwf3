<?php
abstract class SR_School extends SR_Store
{
	/**
	 * Get the courses for a school. array(array(field, price))
	 * @param SR_Player $player
	 */
	public abstract function getFields(SR_Player $player);

	public function getStoreItems(SR_Player $player) { return array(); }
	
	public function getCommands(SR_Player $player) { return array('learn', 'courses'); }
	
	public function on_courses(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		$c = '';
		foreach ($this->getFields($player) as $data)
		{
			$price = Shadowfunc::calcBuyPrice($data[1], $player);
			$dp = Shadowfunc::displayPrice($price);
			$c .= sprintf(', %s(%s)', $data[0], $price);
		}
		
		$bot->reply(sprintf('Available Courses: %s.', substr($c, 2)));
		return true;
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
		
		if (false !== ($spell = SR_Spell::getSpell($field))) {
			$type = 'spell';
			if ($spell->getBaseLevel($player) > -1) {
				$have = true;
			}
		}
		elseif ($player->getBase($field) > -1) {
			$have = true;
		}
		
		if ($have === true) {
			$player->message(sprintf('You already learned the %s %s.', $type, $field));
			return false;
		}
		
		if ($type === 'spell')
		{
			if (false !== ($error = $spell->checkRequirements($player))) {
				$player->message(sprintf('You need %s to learn this spell.', $error));
				return false;
			}
		}
		
		$dp = Shadowfunc::displayPrice($price);
		if (false === $player->pay($price)) {
			$player->message(sprintf('It cost %s to learn the %s %s, but you only have %s.', $dp, $type, $field, $player->displayNuyen()));
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
		$player->message(sprintf('You pay %s and learned the %s %s.', $dp, $type, $field));
		return true;
	}
}
?>