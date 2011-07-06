<?php
final class Lamb_Account extends GWF_Method
{
	private $lamb_user;
	private $sr_player;
	private $sr_players;
	
	public function isLoginRequired() { return true; }

	public function execute(GWF_Module $module)
	{
		$module instanceof Module_Lamb;
		$module->initShadowlamb();
		
		if (false !== ($error = $this->initPlayers($module))) {
			return $error;
		}
		
		$back = '';
		
		if (false !== Common::getPost('link_player')) {
			$back = $this->onLink($module);
		}
		elseif (false !== Common::getPost('create_player')) {
			$back = $this->onCreate($module);
		}
		
		return $back.$this->templateAccounts($module);
	}
	
	private function initPlayers()
	{
		$userid = GWF_Session::getUserID();
		if (false === ($this->sr_players = GDO::table('Lamb_Players')->selectObjects('*', "ll_uid=$userid"))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		return false;
	}
	
	private function formLink(Module_Lamb $module)
	{
		$data = array(
			'player_name' => array(GWF_Form::STRING, '', $module->lang('th_player_name'), $module->lang('tt_player_name')),
			'player_pass' => array(GWF_Form::PASSWORD, '', $module->lang('th_player_pass'), $module->lang('tt_player_pass')),
			'link_player' => array(GWF_Form::SUBMIT, $module->lang('btn_link_account')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function formCreate(Module_Lamb $module)
	{
		$user = GWF_Session::getUser();
		$default_name = $user->getVar('user_name');
		$data = array(
			'create_player_name' => array(GWF_Form::STRING, $default_name, $module->lang('th_player_name'), $module->lang('tt_player_name')),
			'create_player_pass' => array(GWF_Form::PASSWORD, '', $module->lang('th_player_pass'), $module->lang('tt_player_pass')),
			'create_player' => array(GWF_Form::SUBMIT, $module->lang('btn_create_account')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAccounts(Module_Lamb $module)
	{
		$formLink = $this->formLink($module);
		$formCreate = $this->formCreate($module);
		$tVars = array(
			'form_link' => $formLink->templateX($module->lang('ft_link')),
			'form_create' => $formCreate->templateX(),
			'sort_url' => GWF_WEB_ROOT.'index.php?mo=Lamb&me=Account&by=%BY%&dir=%DIR%',
			'chars' => $this->sr_players,
		);
		return $module->templatePHP('account.php', $tVars);
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
	
	private function onLink(Module_Lamb $module)
	{
		$form = $this->formLink($module);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}

		if (false === Lamb_Players::link($this->sr_player->getID(), GWF_Session::getUserID(), $this->sr_player->getVar('sr4pl_uid'))) {
			return GWF_HTML::err('ERR_DATABASE', __FILE__, __LINE__);
		}
		
		return $module->message('msg_char_linked');
	}

	private function onCreate(Module_Lamb $module)
	{
		$form = $this->formCreate($module);
		if (false !== ($error = $form->validate($module))) {
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
		
		return $module->message('msg_char_created');
	}
}
?>