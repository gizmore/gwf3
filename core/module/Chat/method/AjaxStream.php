<?php

final class Chat_AjaxStream extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^gwf_chat.php$ core/module/Chat/gwf_chat.php'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'gwf_chat.php',
						'page_title' => GWF_SITENAME.' Chat',
						'page_meta_desc' => 'The chat of '.GWF_SITENAME,
				),
		);
	}
	
	public function execute()
	{
		return $this->stream();
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
			GWF_ChatOnline::setSessOnline($this->module);
//			GWF_Session::updateLastActivity();
			
			$page = $this->module->getAjaxUpdates($times);
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