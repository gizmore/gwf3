<?php
/**
 * Unlock an entry via email hashcode. No login required.
 * @author gizmore
 * @version 3.0
 * @since 3.0
 */
final class Guestbook_Unlock extends GWF_Method
{
	public function execute()
	{
		if (false === ($gb = GWF_Guestbook::getByID(Common::getGetString('gbid')))) {
			return $this->_module->error('err_gb');
		}
		
		if (false === ($gbm = GWF_GuestbookMSG::getByID(Common::getGetString('gbmid')))) {
			return $this->_module->error('err_gbm');
		}
		
		if ($gbm->getHashcode() !== Common::getGetString('gbmtoken')) {
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (isset($_GET['set_moderation']))
		{
			return $this->toggleModeration($gb, $gbm, Common::getGetString('set_moderation'));
		}
		
		return GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
	}
	
	private function toggleModeration(GWF_Guestbook $gb, GWF_GuestbookMSG $gbm, $state)
	{
		$state = $state > 0;
		if (false === $gbm->saveOption(GWF_GuestbookMSG::IN_MODERATION, $state)) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}

		return $this->_module->message('msg_gbm_mod_'.($state ? '1' : '0'));
		
	}
}
?>