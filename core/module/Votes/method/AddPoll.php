<?php

final class Votes_AddPoll extends GWF_Method
{
	const SESS_OPTIONS = 'GWF_VM_OPT';

	public function getHTAccess()
	{
		return 'RewriteRule ^poll/add$ index.php?mo=Votes&me=AddPoll'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false !== Common::getPost('add_opt')) {
			return $this->onAddOption($this->_module).$this->templateAddPoll($this->_module);
		}
		if (false !== Common::getPost('rem_opts')) {
			return $this->onRemOptions($this->_module).$this->templateAddPoll($this->_module);
		}
		if (false !== Common::getPost('create')) {
			return $this->onAddPoll($this->_module);
		}
		
		return $this->templateAddPoll($this->_module);
	}
	
	public function getForm()
	{
		$data = array(
			'opt' => array(GWF_Form::VALIDATOR),
		);
		$buttons = array(
			'add_opt' => $this->_module->lang('btn_add_opt'),
			'rem_opts' => $this->_module->lang('btn_rem_opts'),
			'create' => $this->_module->lang('btn_create'),
		);
		
		$data['title'] = array(GWF_Form::STRING, '', $this->_module->lang('th_title'));
		$data['reverse'] = array(GWF_Form::CHECKBOX, true, $this->_module->lang('th_reverse'));
		$data['multi'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_multi'));
		$data['guests'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_guests'));
		if (Module_Votes::mayAddGlobalPoll(GWF_Session::getUser())) {
			$data['public'] = array(GWF_Form::CHECKBOX, false, $this->_module->lang('th_vm_public'));
		}
		$data['view'] = array(GWF_Form::SELECT, GWF_VoteMulti::getViewSelect($this->_module, 'view', intval(Common::getPost('view', GWF_VoteMulti::SHOW_RESULT_VOTED))), $this->_module->lang('th_mvview'));
		$data['gid'] = array(GWF_Form::SELECT, GWF_GroupSelect::single('gid', Common::getPostString('gid', '0')), $this->_module->lang('th_vm_gid'));
		$data['level'] = array(GWF_Form::INT, '0', $this->_module->lang('th_vm_level'));
		
		$i = 1;
		foreach (GWF_Session::getOrDefault(self::SESS_OPTIONS, array()) as $item)
		{
			$data['opt['.$i.']'] = array(GWF_Form::STRING, $item, $this->_module->lang('th_option', array( $i)));
			$i++;
		}
		
		
		$data['cmds'] = array(GWF_Form::SUBMITS, $buttons);
		
		
		return new GWF_Form($this, $data);
	}
	
	public function templateAddPoll()
	{
		$form = $this->getForm($this->_module);
		$tVars = array(
			'form' => $form->templateY($this->_module->lang('ft_create')),
		);
		return $this->_module->template('add_poll.tpl', $tVars);
	}
	
	public function onAddOption(Module_Votes $module, $add_new=true)
	{
		$options = GWF_Session::getOrDefault(self::SESS_OPTIONS, array());
		$posted = Common::getPostArray('opt', array());
		$i = 0;
		foreach ($options as $i => $option)
		{
//			$i = $i+1;
			$options[$i] = isset($posted[$i]) ? $posted[$i] : '';
		}
		
		if ($add_new === true)
		{
			$i++;# = (string)($i+1);
			$options[$i] = '';
		}

		GWF_Session::set(self::SESS_OPTIONS, $options);
		
		return '';
	}
	
	public function onRemOptions()
	{
		GWF_Session::set(self::SESS_OPTIONS, array());
		return '';
	}
	
//	public function onCreate()
//	{
//		$form = $this->getForm($this->_module);
//		if (false !== ($errors = $form->validate($this->_module))) {
//			return $errors.$this->templateCreate($this->_module);
//		}
//		
//		$opts = Common::getPost('opt', array());
//		
//		if (count($opts) < 1) {
//			return $this->_module->error('err_no_options');
//		}
//		
//		foreach ($opts as $i => $opt)
//		{
//			$option = new GWF_VoteMultiOpt(array(
//				'vmo_id' => 0,
//				'vmo_vmid' => $vmid,
//				'vmo_text' => $opt,
//				'vmo_value' => $i,
//				'vmo_avg' => array(GDO::INT, GDO::NOT_NULL),
//				'vmo_votes' => array(GDO::UINT, 0),
//			));
//		}
//		
//		return $this->_module->message('msg_mvote_added');
//	}
	
	##################
	### Validators ###
	##################
	public function validate_title(Module_Votes $m, $arg) { return GWF_Validator::validateString($m, 'title', $arg, $m->cfgMinTitleLen(), $m->cfgMaxTitleLen(), false); }

	private $checked_opt = false;
	public function validate_opt(Module_Votes $module, $arg)
	{
		if ($this->checked_opt) {
			return false;
		}
		$this->checked_opt = true;
		$opts = Common::getPostArray('opt', array());
		$post = array();
		$min = $this->_module->cfgMinOptionLen();
		$max = $this->_module->cfgMaxOptionLen();
		
		$err = '';
		foreach ($opts as $i => $op)
		{
			$op = trim($op);
			
			$i = (int)$i;
			
//			# XSS/SQLI escape! 
//			if (!is_numeric($i)) { $i = GWF_HTML::display($i); }
			
			$len = GWF_String::strlen($op);
			if ($len < $min || $len > $max)
			{
				$err .= ', '.$i;
			}
			
			$post[$i] = $op;
//			$_POST['opt'][$i] = $op;
		}
		
		$_POST['opt'] = $post;
		
		$this->onAddOption($this->_module, false);
		
		if ($err === '') {
			return false;
		}
		return $this->_module->lang('err_options', array( substr($err, 2)), $min, $max);
	}
	
	public function validate_view(Module_Votes $m, $arg) { return GWF_VoteMulti::isValidViewFlag(($arg)) ? false : $m->lang('err_multiview'); }
	public function validate_gid(Module_Votes $m, $arg) { return GWF_Validator::validateGroupID($m, 'gid', $arg, false, true); }
	public function validate_level(Module_Votes $m, $arg) { return GWF_Validator::validateInt($m, 'level', $arg, 0, PHP_INT_MAX, '0'); }
	
	private function onAddPoll()
	{
		$form = $this->getForm($this->_module);
		if (false !== ($errors = $form->validate($this->_module))) {
			return $errors.$this->templateAddPoll($this->_module);
		}
		
		$opts = Common::getPostArray('opt', array());
		if (count($opts) === 0) {
			return $this->_module->error('err_no_options').$this->templateAddPoll($this->_module);
		}
		
		$user = GWF_Session::getUser();
		$name = GWF_VoteMulti::createPollName(GWF_Session::getUser());
		$title = $form->getVar('title');
		$gid = $form->getVar('gid');
		$level = $form->getVar('level');
		$reverse = isset($_POST['reverse']);
		$is_multi = isset($_POST['multi']);
		$guest_votes = isset($_POST['guests']);
		$is_public = isset($_POST['public']);
		$result = (int)$form->getVar('view');
		if ($is_public && !$this->_module->mayAddGlobalPoll($user)) {
			return $this->_module->error('err_global_poll').$this->templateAddPoll($this->_module);
		}
		
		GWF_Session::remove(self::SESS_OPTIONS);
		
		return Module_Votes::installPollTable($user, $name, $title, $opts, $gid, $level, $is_multi, $guest_votes, $is_public, $result, $reverse);
	}
	
}

?>
