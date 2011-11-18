<?php
/**
 * Special command for Exi client to retrieve some game settings.
 * @author gizmore
 */
final class Shadowcmd_ehlo extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		# You can tell me more values that are needed.
		$data = array(
			'version' => '3.04',
			'x_ini' => SR_Party::X_COORD_INI,
			'x_inc' => SR_Party::X_COORD_INC,
			'y_max' => SR_Player::MAX_RANGE,
			'max_members' => SR_Party::MAX_MEMBERS+1, # (+1 hireling)
		);
		
		# You can tell me any other output format.
		$out = self::toExidousFormat($data);
	
		# Output to Exi client :)
		return $player->message($out);
	}
	
	/**
	 * Simple name value pairs.
	 * @param array $data
	 * @return string
	 */
	private static function toExidousFormat(array $data)
	{
		$out = '';
		foreach ($data as $key => $value)
		{
			$out .= sprintf(',%s=%s', $key, $value);
		}
		return substr($out, 1);
	}
}
?>