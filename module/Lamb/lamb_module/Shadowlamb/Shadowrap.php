<?php
final class Shadowrap
{
	private static $instance;
	public static function instance(SR_Player $player) { self::$instance->setPlayer($player); return self::$instance; }
	public static function init() { self::$instance = new self(); }
	private $player;
	public function setPlayer(SR_Player $player) { $this->player = $player; }
	public function reply($message)
	{
		if ($this->player->isOptionEnabled(SR_Player::WWW_OUT)) {
			$this->player->message($message);
		} else {
			Lamb::instance()->reply($message);
		}
	}
}
?>