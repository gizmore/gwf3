<?php
/** 
 * WWWWrapper stuff 
 * @author gizmore
 */
final class Shadowrap
{
	private static $instance;
	public static function instance(SR_Player $player) { self::$instance->setPlayer($player); return self::$instance; }
	public static function init() { self::$instance = new self(); }
	
	private $player;
	public function setPlayer(SR_Player $player) { $this->player = $player; }
	
	public function reply($message)
	{
		if (true === $this->player->isOptionEnabled(SR_Player::WWW_OUT))
		{
			$this->player->message($message);
		}
		else
		{
			Lamb::instance()->reply($message);
// 			if (NULL === ($user = $this->player->getUser()))
// 			{
// 				echo "PLAYER HAS NO USER IN SHADOWRAP.\n";
// 			}
// 			elseif (false === ($server = $user->getServer()))
// 			{
// 				echo "USER HAS NO SERVER IN SHADOWRAP.\n";
// 			}
// 			else
// 			{
// 				# BAH
// 			}
		}
		
		return true;
	}
	
	public function rply($key, $args=NULL)
	{
		return self::reply(Shadowrun4::lang($key, $args));
	}

	/**
	  * Reply to the current origin and user, display as a table
	  * @todo Write a class that can display ascii art tables and stuff.
	  * @author digitalseraphim
	  * @since Shadowlamb 3.1
	  * @param array $table where each entry is 'row label' => array(values)
	  * @return true|false
	  */
	public function replyTable(array $table, $langkey='5044')
	{
		$maxRowLabelWidth = 0;
		$maxWidths = array(-1=>0);
		
		foreach($table as $key => $value)
		{
			$maxWidths[-1] = max($maxWidths[-1],strlen($key));
			foreach ($value as $k => $v)
			{
				$charcounts = count_chars($v,0);
				$vlen = strlen($v)-$charcounts[2];
				
				if(!array_key_exists($k,$maxWidths))
				{
					$maxWidths[$k] = $vlen;
				}
				else
				{
					$maxWidths[$k] = max($maxWidths[$k],$vlen);
				}
			}
		}
	
		foreach($table as $key => $value)
		{
			$s = sprintf('%-'.($maxWidths[-1]+1).'s',$key) ;
			foreach ($value as $k => $v)
			{
				$charcounts = count_chars($v,0);
				$s .= sprintf('| %-'.($maxWidths[$k]+1+$charcounts[2]).'s', $v);
			}
			$this->reply(Shadowrun4::lang($langkey, array($s)));
// 			$this->reply($s);
		}
	}
}
?>
