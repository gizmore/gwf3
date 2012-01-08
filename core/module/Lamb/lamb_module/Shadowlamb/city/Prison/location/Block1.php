<?php
final class Prison_Block1 extends SR_Location
{
	const BAN_TIME = 300; # 5 min;
	const KEY_WRITE = '__SLC3_PW';
	const MSG_CHAPTER_III = 'gizmore is noob';
	
	public function getFoundPercentage() { return 100.00; }
	public function getNPCS(SR_Player $player) { return array('talk' => 'Prison_Prisoner'); }
	public function isPVP() { return true; }
	public function getAreaSize() { return 150; }
	public function getEnterText(SR_Player $player) { return 'You enter cell block 1.'; }
	public function getFoundText(SR_Player $player) { return 'You found cell block 1, whatever that means.'; }
	public function getCommands(SR_Player $player) { return array('read','write'); }
	
	public function isEnterAllowed(SR_Player $player) { return false; }
	public function isExitAllowed(SR_Player $player)
	{
		# Eek?
		if (false === ($user = $player->getUser()))
		{
			return false;
		}
		
		# Check idle time.
		$last = $user->getVar('lusr_timestamp');
		if (($last+self::BAN_TIME) > time())
		{
			return false;
		}
		
		return true;
	}
	
	public function onEnter(SR_Player $player)
	{
		$player->message('Seems like you are screwed.');
	}
	
	public function on_read(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		
		$table = GDO::table('SR_PlayerVar');
		$key = $table->escape(self::KEY_WRITE);
		if (false === ($result = $table->selectRandom('sr4pv_val', "sr4pv_key='{$key}'")))
		{
			return $bot->reply('The walls are clear and white. Very esthetic, even for a prison block.');
		}
		
		return $bot->reply(sprintf('You randomly read the prison walls: "%s"', $result['sr4pv_val']));
	}

	public function on_write(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ( (false === ($chalk = $player->getInvItemByName('Chalk', false)))
			 &&
			 (false === ($pen = $player->getInvItemByName('Pen', false)))
		)
		{
			$bot->reply('You don\'t have anything to write on the prison wall, chummer.');
			return false;
		}
		
		if (count($args) === 0)
		{
			$bot->reply('You succesfully wrote nothing on the wall ... does not look too bad, you think to yourself.');
			return false;
		}
		
		$key = self::KEY_WRITE;
		$message = implode(' ', $args);
		
		if (false === ($written = SR_PlayerVar::getVal($player, $key)))
		{
			$re = '';
		}
		else
		{
			$re = 'RE';
		}
		
		if ($message === self::MSG_CHAPTER_III)
		{
			$this->onChapterIIIDone($player);
		}
		
		if (false === SR_PlayerVar::setVal($player, $key, $message))
		{
			$bot->reply('DB ERROR 1');
			return false;
		}
		
		$bot->reply(sprintf('You successfully %swrote "%s" on the prison wall', $re, $message));
		return true;
	}
	
	private function onChapterIIIDone(SR_Player $player)
	{
		$player->message(sprintf('You accomplished Shadowlamb - Chapter III on wechall. Enter "%s" as your solution, without the quotes.', $this->getSolution($player)));
	}
	
	public function getSolution(SR_Player $player)
	{
		$pname = strtolower($player->getName());
		$hash = substr(md5(LAMB_PASSWORD2.md5($pname).LAMB_PASSWORD2), 2, 16);
		return sprintf('%s!%s!gunda', $pname, $hash);
	}
	
}
?>