<?php
final class Shadowcmd_feel extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$argc = count($args);
		
		if ($argc === 0)
		{
			self::messagePartyFeelings($player);
		}
		elseif ($argc === 1)
		{
			if ($args[0] === '2')
			{
				self::DEBUGresetFeelings($player);
			}
			self::messagePlayerFeelings($player);
		}
		else
		{
			return self::showHelp($player);
		}
		
		return true;
	}
	
	private static function DEBUGresetFeelings(SR_Player $player)
	{
		echo "Resetting!\n";
		foreach (SR_Player::$FEELINGS as $field)
		{
			$player->saveBase($field, '10000');
		}
		$player->modify();
	}
	
	private static function messagePlayerFeelings(SR_Player $player)
	{
		$out = '';
		foreach (SR_Player::$FEELINGS as $field)
		{
			$out .= sprintf(", %s(%.02f%%)", $field, $player->get($field)/100);
		}
		$out = ltrim($out, ',; ');
		$player->msg('5313', array($out));
	}
	
	private static function messagePartyFeelings(SR_Player $player)
	{
		$party = $player->getParty();
		$enum = 1;
		$fmt = $player->lang('fmt_feel');
		$out = '';
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			$out .= vsprintf($fmt, self::argsForMember($member, $enum));
		}
		$player->msg('5312', array(ltrim($out, ',; ')));
	}
	
	private static function argsForMember(SR_Player $member, &$enum)
	{
		return array(
			$enum++,
			$member->displayName(),
			self::getFeel('food', $member, 'H'),
			self::getFeel('water', $member, 'T'),
			self::getFeel('sleepy', $member, 'S'),
			self::getFeel('cold', $member, 'C')
		);
	}
	
	private static function getFeel($field, SR_Player $member, $sign)
	{
		$FAL = false;
		// BG
		$wht = GWF_IRCUtil::WHITE;
		$blk = GWF_IRCUtil::BLACK;
		// FG
		$grn = GWF_IRCUtil::GREEN;
// 		$lgn = GWF_IRCUtil::LIGHT_GREEN;
		$blk = GWF_IRCUtil::BLACK;
		$ong = GWF_IRCUtil::ORANGE;
		$red = GWF_IRCUtil::RED;
		$bwn = GWF_IRCUtil::BROWN;
		
		$b  = array(1111,$FAL,1111,$FAL,$FAL,$FAL,1111,$FAL,1111,1111);
		$bg = array($wht,$wht,$wht,$wht,$wht,$wht,$wht,$wht,$wht,$wht);
		$fg = array($red,$red,$ong,$ong,$bwn,$bwn,$blk,$blk,$grn,$grn);
		
		$feel = min(round(($member->get($field)/10000 + 1.0) / 3.0 * 10), 9);
		return GWF_IRCUtil::boldcolor($sign.$feel, $b[$feel], $fg[$feel], $bg[$feel]);
	}
}
