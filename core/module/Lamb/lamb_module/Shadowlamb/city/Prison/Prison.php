<?php
final class Prison extends SR_Dungeon
{
	public function getCityLocation() { return 'Delaware_Prison'; }
	public function getArriveText() { return 'You enter the prison.'; }
	public function getImportNPCS() { return array('Seattle_BlackOp'); }
	
}
?>
