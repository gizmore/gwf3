<?php
final class Slaytags_Main extends GWF_Method
{
	public function execute()
	{
		require GWF_CORE_PATH.'module/Slaytags/Slay_PNow.php';
		return $this->templateMain();
	}
	
	private function templateMain()
	{
		$left = Slay_PNow::getTimeLeft();
		
		GWF_Website::addJavascriptOnload("slayInitRedirect(".($left+1).");");
		
		$tVars = array(
			'href_history' => $this->module->getMethodURL('History', '&page='.Slay_PlayHistory::getNumPages()),
			'history' => Slay_PlayHistory::getLastPlayed(1),
			'now' => Slay_PNow::getNowPlaying($this->module),
			'left' => $left,
//			'next' => Slay_Pnext::getNextPlaying(),
		);
		
		return $this->module->template('main.tpl', $tVars);
	}
}
?>