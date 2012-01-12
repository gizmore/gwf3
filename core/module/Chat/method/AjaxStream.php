<?php

final class Chat_AjaxStream extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^gwf_chat.php$ core/module/Chat/gwf_chat.php'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->stream($this->_module);
	}
	
	private function stream()
	{
		set_time_limit(0);
		$t = time();
		$times = array($t,$t,$t,$t);
//		$msgtable = new GWF_ChatMsg(false);
		$channel = '';
		
		while (true)
		{
			GWF_ChatOnline::setSessOnline($this->_module);
//			GWF_Session::updateLastActivity();
			
			$page = $this->_module->getAjaxUpdates($times);
			# --- Anything happened?
			if ($page !== '')
			{
				GWF_Javascript::newSection();
				echo $page;
				GWF_Javascript::endSection();
			}

			usleep(999950);
		}
	}
}

?>