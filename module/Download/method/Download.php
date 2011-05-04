<?php
/**
 * WyMY5sx21JH0
 * @author gizmore
 *
 */
final class Download_Download extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return
			'RewriteRule ^download/(\d+)/[^/]+$ index.php?mo=Download&me=Download&id=$1'.PHP_EOL.
			'RewriteRule ^download/(\d+)/[^/]+/([a-zA-Z0-9]+)$ index.php?mo=Download&me=Download&id=$1&token=$2'.PHP_EOL;
	}

	public function execute(GWF_Module $module)
	{
		$module instanceof Module_Download;
		
		if (false === ($dl = GWF_Download::getByID(Common::getGet('id')))) {
			return $module->error('err_dlid');
		}
		
		$user = GWF_Session::getUser();
		
		if (false !== ($error = $module->mayDownload($user, $dl))) {
			return $error;
		}
		
		if (false !== Common::getPost('dl_token')) {
			return $this->onDownloadByToken($module, $dl, Common::getPost('token'));
		}
		
		if (false !== Common::getPost('on_order_2_x')) {
			return $this->onOrder($module, $dl);
		}
		
		if (false !== ($token = Common::getGet('token'))) {
			return $this->templateOnDownload($module, $dl, $token);
		}
		
		if ($dl->isPaidContent() && !GWF_DownloadToken::checkUser($module, $dl, $user)) {
			return $this->templatePay($module, $dl);
		}
		
		return $this->templateOnDownload($module, $dl);
	}
	
	public function templateOnDownload(GWF_Module $module, GWF_Download $dl, $token=false)
	{
		# submit this file pls
		$path = $dl->getDownloadPath();
		
		if (!is_file($path)||!is_readable($path)) {
			return GWF_HTML::err('ERR_FILE_NOT_FOUND', array( $path));
		}
		
		$user = GWF_User::getStaticOrGuest();
		if ($dl->isPaidContent())
		{
			if ( (false === GWF_DownloadToken::checkUser($module, $dl, $user)) && (false === GWF_DownloadToken::checkToken($module, $dl, $user, $token)) ) {
				return GWF_HTML::err('ERR_NO_PERMISSION');
			}
		}
		
		GWF_Hook::call(GWF_Hook::DOWNLOAD, $user, array($dl));
		
		# Downloaded one more time
		$dl->increase('dl_count', 1);
		
		$realpath = $dl->getCustomDownloadPath();
		
		# http header
		$mime = $dl->getVar('dl_mime'); # currently i am looking for pecl filetype?
		$mime = 'application/octet-stream'; # not sure about...
		header("Content-Type: $mime"); # about ... mime
//		$name = $dl->getVar('dl_filename'); # filename is sane. No " is allowed in filename.
		$name = $dl->getCustomDownloadName();
		header("Content-Disposition: attachment; filename=\"$name\""); # drop attachment?
		$size = filesize($realpath);
		header("Content-Length: $size");
		
		# Print file and die
		echo file_get_contents($realpath);
		die(0);
	}
	
	private function templatePay(GWF_Module $module, GWF_Download $dl)
	{
		if (false === ($mod_pay = GWF_Module::getModule('Payment'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'Payment'));
		}
		
		$user = GWF_User::getStaticOrGuest();
		$form = $this->getTokenForm($module, $dl);
		
		$tVars = array(
			'form' => $form->templateX($module->lang('ft_token')),
			'order' => Module_Payment::displayOrderS($module, $dl, $user),
		);
		
		return $module->templatePHP('paid_content.php', $tVars);
	}
	
	private function getTokenForm(GWF_Module $module, GWF_Download $dl)
	{
		$data = array(
			'name'=> array(GWF_Form::SSTRING, $dl->getVar('dl_filename', ''), $module->lang('th_dl_filename')),
			'token' => array(GWF_Form::STRING, '', $module->lang('th_token'), GWF_DownloadToken::TOKEN_LEN ),
			'dl_token' => array(GWF_Form::SUBMIT, $module->lang('btn_download')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onOrder(GWF_Module $module, GWF_Download $dl)
	{
		// Check for Payment, as it`s not a required dependency.
		if (false === ($mod_pay = GWF_Module::getModule('Payment'))) {
			return GWF_HTML::err('ERR_MODULE_MISSING', array( 'Payment'));
		}
		
		$user = GWF_User::getStaticOrGuest();
		$paysite = Common::getPost('paysite', 'xx');
		
		$dl->setVar('your_token', GWF_DownloadToken::generateToken());
		
		return Module_Payment::displayOrder2S($module, $dl, $user, $paysite);
	}
	

	private $dl = false;
	private $user = false;
	public function validate_token(Module_Download $m, $arg)
	{
		$this->user = GWF_Session::getUser();
		if (GWF_DownloadToken::checkToken($m, $this->dl, $this->user, $arg))
		{
			return false;
		}
		return $m->lang('err_token');
	}
	
	private function onDownloadByToken(GWF_Module $module, GWF_Download $dl, $token)
	{
		$this->dl = $dl;
		$form = $this->getTokenForm($module, $dl);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$module->requestMethodB('List');
		}
		return $this->templateOnDownload($module, $dl, $token);
	}
}
?>