<?php
final class Lamb_Account extends GWF_Method
{
	private $lamb_user;
	private $sr_player;
	private $sr_players;
	
	public function isLoginRequired() { return true; }

	public function execute()
	{
		$this->_module->initShadowlamb();
		
		if (false !== ($error = $this->initPlayers($this->_module))) {
			return $error;
		}
		
		$back = '';
		
		if (false !== Common::getPost('link_player')) {
			$back = $this->onLink($this->_module);
		}
		elseif (false !== Common::getPost('create_player')) {
			$back = $this->onCreate($this->_module);
		}
		
		return $back.$this->templateAccounts($this->_module);
	}
	
	private function initPlayers()
	{
		$userid = GWF_Session::getUserID();
		if (false === ($this->sr_players = GDO::table('Lamb_Players')->selectObjects('*', "ll_uid=$userid"))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		return false;
	}
	
	private function formLink()
	{
		$data = array(
			'player_name' => array(GWF_Form::STRING, '', $this->_module->lang('th_player_name'), $this->_module->lang('tt_player_name')),
			'player_pass' => array(GWF_Form::PASSWORD, '', $this->_module->lang('th_player_pass'), $this->_module->lang('tt_player_pass')),
			'link_player' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_link_account')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function formCreate()
	{
		$user = GWF_Session::getUser();
		$default_name = $user->getVar('user_name');
		$data = array(
			'create_player_name' => array(GWF_Form::STRING, $default_name, $this->_module->lang('th_player_name'), $this->_module->lang('tt_player_name')),
			'create_player_pass' => array(GWF_Form::PASSWORD, '', $this->_module->lang('th_player_pass'), $this->_module->lang('tt_player_pass')),
			'create_player' => array(GWF_Form::SUBMIT, $this->_module->lang('btn_create_account')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAccounts()
	{
		$formLink = $this->formLink($this->_module);
		$formCreate = $this->formCreate($this->_module);
		$tVars = array(
			'form_link' => $formLink->templateX($this->_module->lang('ft_link')),
			'form_create' => $formCreate->templateX(),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Lamb&me=Account&by=%BY%&dir=%DIR%',
			'chars' => $this->sr_players,
		);
		return $this->_module->templatePHP('account.php', $tVars);
	}
	
	public function validate_create_player_name(Module_Lamb $m, $arg)
	{
		if (false !== (Lamb_User::getWWWUser($arg))) {
			return $m->lang('err_already_created'); 
		}
		return false;
	}
	
	public function validate_create_player_pass(Module_Lamb $m, $arg)
	{
		return false;
	}
	
	public function validate_player_name(Module_Lamb $m, $arg)
	{
		if (false === ($this->sr_player = SR_Player::getByLongName($arg))) {
			return $m->lang('err_unknown_char');
		}
		
		if (Lamb_Players::isLinked($this->sr_player->getID())) {
			return $m->lang('err_char_already_linked');
		}
		
		return false;
	}
	
	public function validate_player_pass(Module_Lamb $m, $arg)
	{
		if ($this->sr_player === false) {
			return false;
		}
		$lamb_user = $this->sr_player->getUser();
		if (!$lamb_user->isRegistered()) {
			return $m->lang('err_char_not_regged');
		}
		
		if ($lamb_user->getVar('lusr_password') !== md5($arg)) {
			return $m->lang('err_char_wrong_pass');
		}
		
		return false;
	}
	
	private function onLink()
	{
		$form = $this->formLink($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}

		if (false === Lamb_Players::link($this->sr_player->getID(), GWF_Session::getUserID(), $this->sr_player->getVar('sr4pl_uid'))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $this->_module->message('msg_char_linked');
	}

	private function onCreate()
	{
		$form = $this->formCreate($this->_module);
		if (false !== ($error = $form->validate($this->_module))) {
			return $error;
		}
		
		$username = Common::getPost('create_player_name');
		
		$lamb_user = new Lamb_User(array(
			'lusr_id' => 0,
			'lusr_name' => $username,
			'lusr_sid' => 0,
			'lusr_options' => 0,
			'lusr_last_message' => '',
			'lusr_last_channel' => '',
			'lusr_password' => md5(Common::getPostString('create_player_pass')),
			'lusr_timestamp' => 0,
			'lusr_hostname' => '',
			'lusr_ip' => GWF_IP6::getIP(GWF_IP6::BIN_32_128),
		));
		
		if (false === $lamb_user->insert()) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		if (false === ($this->sr_player = SR_Player::createHumanB($lamb_user->getID(), $username))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		if (false === Lamb_Players::link($this->sr_player->getID(), GWF_Session::getUserID(), $lamb_user->getID())) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $this->_module->message('msg_char_created');
	}
}
?>
