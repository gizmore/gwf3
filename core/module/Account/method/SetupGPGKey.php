<?php
final class Account_SetupGPGKey extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false === ($user = GWF_User::getByID(Common::getGet('userid'))))
		{
			return GWF_HTML::err('ERR_UNKNOWN_USER');
		}
		
		$tmpfile = 'extra/temp/gpg/'.$user->getVar('user_id');
		if ( (!is_file($tmpfile)) || (!is_readable($tmpfile)) ) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $tmpfile));
		}
		
		if (false === ($file_content = file_get_contents($tmpfile))) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $tmpfile));
		}
		
		if (false === unlink($tmpfile)) {
			return GWF_HTML::err('ERR_WRITE_FILE', array( $tmpfile));
		}
		
		if (false === ($fingerprint = GWF_PublicKey::grabFingerprint($file_content))) {
			return $this->_module->error('err_gpg_key');
		}
		
		if (Common::getGet('token') !== $fingerprint) {
			return $this->_module->error('err_gpg_token');
		}
		
		if (false === (GWF_PublicKey::updateKey($user->getID(), $file_content))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		if (false === ($user->saveOption(GWF_User::EMAIL_GPG, true))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return $this->_module->message('msg_setup_gpg');
	}
}
?>