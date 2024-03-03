<?php

require_once('scramble.php');

final class CubeChallenge
{
	function __construct($chall)
	{
		$this->chall = $chall;
		$this->db = gdo_db();
		$this->level = $this->getLevel();
	}

	public static function onMove()
	{
		if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
		{
			$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/rubikcube/index.php', false);
		}
		$cube = new CubeChallenge($chall);
		$level = $cube->level;
		$msg = '';
		switch ($cube->level) {
			case -1:
			case 0:
				$msg .= $cube->level1();
				break;
			default:
				$msg .= $cube->level2();
		}
		if ($level !== $cube->level) {
			$msg .= $cube->_resetScript();
		}
		$moves = $cube->getMoves();
		if ($moves > 0) {
			$msg .= ' ' . $chall->lang('moves', $moves);
		}
		return $msg;
	}

	public function _resetScript()
	{
		return '<script>resetCube();</script>';
	}

	public function level1()
	{
		$cube = $this->getCube();
		if (!$cube) {
			$this->initCube();
			$this->setCube(self::createRandom(), 0);
			return $this->chall->lang('level1');
		}
		$msg = $this->doMove($cube);
		return $msg ? $msg : $this->chall->lang('level1');
	}

	public function level2()
	{
		$moves = 41 - $this->level;
		$cube = $this->getCube();
		if (!$cube) {
			$this->setCube(self::createRandom($moves), 0);
			return $this->chall->lang('level2', [$moves]);
		}
		if (false === ($msg = $this->doMove($cube, $moves))) {
			$this->resetCube();
			$this->setCube(self::createRandom($moves), 0);
			return $this->chall->lang('level2_moves', [$moves]) . $this->_resetScript();
		}
		return $msg ? $msg : $this->chall->lang('level2', [$moves]);
	}

	public function doMove($cube, $max=0)
	{
		$cube = new Cube($cube, $this->getMoves());
		if (isset($_GET['move']))
		{
			$cube->move((string)$_GET['move']);
			unset($_GET['move']);
			$this->setCube($cube->cube, $cube->getMoves());
		}
		if ($max && $cube->getMoves() > $max) {
			return false;
		}
		if ($cube->isSolved()) {
			return $this->nextLevel();
		}
	}

	public function nextLevel()
	{
		if ($this->level > 20) {
			return $this->solved();
		}
		$this->resetCube();
		$this->setLevel($this->level + 1);
		return $this->level2();
	}

	private function solved()
	{
		$this->chall->onChallengeSolved();
		$this->removeCube();
		return $this->chall->lang('congrats');
	}

	public function getLevel()
	{
		$sessid = GWF_Session::getSessSID();
		$query = "SELECT level FROM rubik WHERE sessid=$sessid";
		if (false === ($result = $this->db->queryFirst($query)))
		{
			return 0;
		}
		return $result['level'];
	}

	public function setLevel($level)
	{
		$sessid = GWF_Session::getSessSID();
		$query = "UPDATE rubik SET level=$level WHERE sessid=$sessid";
		if ($this->db->queryWrite($query)) {
			$this->level = $level;
			return true;
		}
		die('Failed setting level!');
		return false;
	}

	public function increaseMoves($by=1)
	{
		$sessid = GWF_Session::getSessSID();
		$query = "UPDATE rubik SET moves=moves+$by WHERE sessid=$sessid";
		return $this->db->queryWrite($query);
	}

	public function initCube()
	{
		$sessid = GWF_Session::getSessSID();
		$query = "REPLACE INTO rubik VALUES($sessid, '', 0, 0.00)";
		return $this->db->queryWrite($query);
	}

	public function resetCube()
	{
		return $this->setCube('', 0);
	}

	public function removeCube()
	{
		$sessid = GWF_Session::getSessSID();
		$query = "DELETE FROM rubik WHERE sessid=$sessid";
		return $this->db->queryWrite($query);
	}

	public function getMoves()
	{
		$sessid = GWF_Session::getSessSID();
		$query = "SELECT moves FROM rubik WHERE sessid=$sessid";
		if (false === ($result = $this->db->queryFirst($query)))
		{
			return -1;
		}
		return (int)$result['moves'];
	}

	public static function getCube()
	{
		$sessid = GWF_Session::getSessSID();
		$query = "SELECT cube FROM rubik WHERE sessid=$sessid";
		if (false === ($result = gdo_db()->queryFirst($query)))
		{
			return false;
		}
		return $result['cube'];
	}

	public function setCube($cube, $moves=0)
	{
		$sessid = GWF_Session::getSessSID();
		$query = "UPDATE rubik SET cube='$cube', moves=$moves WHERE sessid=$sessid";
		return $this->db->queryWrite($query);
	}

	public static function createRandom($moves=NULL)
	{
		$cube = new Cube(Cube::SOLVED_CUBE);
		if (!$moves || $moves % 2) {
			$cube->move(Scrambler::getScrambled());
		} else {
			$cube->move(Scrambler::requiresMoves($moves === 24 ? 24 : 20));
		}
		return $cube->cube;
	}

}

if (!defined('GWF_PAGE_TITLE')) {
	define('GWF_PAGE_TITLE', "Rubik's Cube");
	$_GET['ajax'] = '1';
	require_once 'cube.php';
	chdir('../../../');
	require_once('challenge/html_head.php');

	$message = CubeChallenge::onMove();
	printf('<noscript id="cubestring">%s</noscript>', CubeChallenge::getCube());
	if (is_string($message))
	{
		echo $message . "\n";
	}
}
