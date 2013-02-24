<?php
final class WeChall_Warboxes extends GWF_Method
{
	/**
	 * @var WC_Site
	 */
	private $site;
	
	public function execute()
	{
		if (false === ($this->user = GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		if (false === ($this->site = WC_Site::getByID_Class(Common::getGetString('siteid'))))
		{
			return $this->module->error('err_site');
		}
		
		if (!GWF_User::isInGroupS(GWF_Group::STAFF))
		{
			$this->module->includeClass('WC_SiteAdmin');
			if (!$this->site->isSiteAdmin($this->user))
			{
				return GWF_HTML::err('ERR_NO_PERMISSION');
			}
		}	
			
		$this->module->includeClass('WC_Warbox');
		
		# ADD
		if (isset($_POST['add']))
		{
			return $this->onAdd(); #.$this->templateOverview();
		}
		if (isset($_GET['add']))
		{
			return $this->templateAdd();
		}
		
		# EDIT
		if (false !== ($boxid = Common::getGetString('edit', false)))
		{
			if (false === ($box = WC_Warbox::getByIDs($boxid, $this->site->getID())))
			{
				return $this->module->error('err_site');
			}
		}
		if (isset($_POST['flags']))
		{
			GWF_Website::redirect($this->module->getMethodURL('Warflags', '&wbid='.$boxid));
		}
		if (isset($_POST['edit']))
		{
			return $this->onEdit($box);
		}
		if (isset($_GET['edit']))
		{
			return $this->templateEdit($box);
		}
		
		# OVERVIEW
		return $this->templateOverview();
	}
	
	##################
	### VALIDATORS ###
	##################
	
	public function validate_name(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'name', $arg, 1, 31, false, false); }
	public function validate_host(Module_WeChall $m, $arg)
	{
		if (!isset($_POST['warbox']))
		{
			return false;
		}
		if (false !== ($error = GWF_Validator::validateString($m, 'host', $arg, 0, 255, false, false)))
		{
			return $error;
		}
		elseif ($arg === gethostbyname($arg))
		{
			return $m->lang('err_warhost');
		}
		return false;
	}
	public function validate_port(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'port', $arg, 1, 1024, true); }
	public function validate_launch(Module_WeChall $m, $arg) { return GWF_Validator::validateDate($m, 'launch', $arg, 8, false); }
	public function validate_wlist(Module_WeChall $m, $arg) { return false; }
	public function validate_blist(Module_WeChall $m, $arg) { return false; }
	public function validate_url(Module_WeChall $m, $arg) { return false; }
	public function validate_user(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'user', $arg, 0, 63); }
	public function validate_pass(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'pass', $arg, 0, 63); }
	public function validate_status(Module_WeChall $m, $arg) { return in_array($arg, WC_Warbox::$STATUS) ? false : $m->lang('err_wb_status'); }
	################
	### OVERVIEW ###
	################
	private function templateOverview()
	{
		$tVars = array(
			'site' => $this->site,
			'boxes' => WC_Warbox::getBoxes($this->site),
			'href_add' => $this->getMethodHREF(sprintf('&siteid=%s&add=1', $this->site->getID())),
			'href_site' => $this->module->getMethodURL('SiteEdit', '&siteid='.$this->site->getID()),
			'href_descr' => $this->module->getMethodURL('SiteDescr', '&siteid='.$this->site->getID()),
		);
		return $this->module->templatePHP('site_edit_warboxes.php', $tVars);
	}
	
	###########
	### ADD ###
	###########
	private function formAdd()
	{
		$data = array(
			'name' => array(GWF_Form::STRING, '', $this->l('th_wb_name')),
			'url' => array(GWF_Form::STRING, '', $this->l('th_wb_url')),
			'host' => array(GWF_Form::STRING, '', $this->l('th_wb_host')),
			'port' => array(GWF_Form::INT, 113, $this->l('th_wb_port')),
			'user' => array(GWF_Form::STRING, '', $this->l('th_wb_user')),
			'pass' => array(GWF_Form::STRING, '', $this->l('th_wb_pass')),
			'wlist' => array(GWF_Form::STRING, 'level[0-9]+,root', $this->l('th_wb_wlist')),
			'blist' => array(GWF_Form::STRING, 'apache,www,nobody', $this->l('th_wb_blist')),
			'launch' => array(GWF_Form::DATE, '', $this->l('th_wb_launch'), '', 8),
			'status' => array(GWF_Form::ENUM, 'up', $this->l('th_wb_status'), '', $this->statusValues()),
			'warbox' => array(GWF_Form::CHECKBOX, true, $this->l('th_warbox')),
			'multi' => array(GWF_Form::CHECKBOX, false, $this->l('th_multisolve')),

			'add' => array(GWF_Form::SUBMIT, $this->l('btn_add_warbox')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function statusValues()
	{
		$data = array();
		foreach (WC_Warbox::$STATUS as $status)
		{
			$data[] = array($status, $this->module->lang('wb_'.$status));
		}
		return $data;
	}
	
	private function templateAdd()
	{
		$form = $this->formAdd();
		$tVars = array(
			'href_site' => $this->module->getMethodURL('SiteEdit', '&siteid='.$this->site->getID()),
			'href_descr' => $this->module->getMethodURL('SiteEdit', '&siteid='.$this->site->getID()),
			'href_boxes' => $this->module->getMethodURL('Warboxes', '&siteid='.$this->site->getID()),
			'form' => $form->templateY($this->l('ft_add_warbox')),
		);
		return $this->module->templatePHP('site_add_warbox.php', $tVars);
	}
	
	private function onAdd()
	{
		$form = $this->formAdd();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateAdd();
		}
		
		$now = GWF_Time::getDate(14);
		
		$options = 0;
		$options |= isset($_POST['warbox']) ? WC_Warbox::WARBOX : 0;
		$options |= isset($_POST['multi']) ? WC_Warbox::MULTI_SOLVE : 0;
		
		$box = new WC_Warbox(array(
			'wb_id' => '0',
			'wb_sid' => $this->site->getID(),
			
			'wb_name' => $form->getVar('name'),
			'wb_user' => $form->getVar('user'),
			'wb_pass' => $form->getVar('pass'),
			'wb_weburl' => $form->getVar('url'),
			'wb_port' => $form->getVar('port'),
			'wb_host' => $form->getVar('host'),
			'wb_ip' => gethostbyname($form->getVar('host')),
			'wb_whitelist' => $form->getVar('wlist'),
			'wb_blacklist' => $form->getVar('blist'),
			'wb_launched_at' => $form->getVar('launch'),
			'wb_status' => $form->getVar('status'),
			'wb_options' => $options,
				
			'wb_created_at' => $now,
			'wb_updated_at' => $now,
		));
		
		if (false === ($box->insert()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateAdd();
		}
		
		Module_WeChall::instance()->flushWarboxConfig();
		
		return $this->module->message('msg_warbox_added').$this->templateOverview();
	}
	
	
	############
	### EDIT ###
	############
	private function formEdit(WC_Warbox $box)
	{
		$data = array(
			'name' => array(GWF_Form::STRING, $box->getVar('wb_name'), $this->l('th_wb_name')),
			'url' => array(GWF_Form::STRING, $box->getVar('wb_weburl'), $this->l('th_wb_url')),
			'host' => array(GWF_Form::STRING, $box->getVar('wb_host'), $this->l('th_wb_host')),
			'port' => array(GWF_Form::INT, $box->getVar('wb_port'), $this->l('th_wb_port')),
			'user' => array(GWF_Form::STRING, $box->getVar('wb_user'), $this->l('th_wb_user')),
			'pass' => array(GWF_Form::STRING, $box->getVar('wb_pass'), $this->l('th_wb_pass')),
			'wlist' => array(GWF_Form::STRING, $box->getVar('wb_whitelist'), $this->l('th_wb_wlist')),
			'blist' => array(GWF_Form::STRING, $box->getVar('wb_blacklist'), $this->l('th_wb_blist')),
			'launch' => array(GWF_Form::DATE, $box->getVar('wb_launched_at'), $this->l('th_wb_launch'), '', 8),
			'status' => array(GWF_Form::ENUM, $box->getVar('wb_status'), $this->l('th_wb_status'), '', $this->statusValues()),
			'warbox' => array(GWF_Form::CHECKBOX, $box->isWarbox(), $this->l('th_warbox')),
			'multi' => array(GWF_Form::CHECKBOX, $box->isMultisolve(), $this->l('th_multisolve')),
			'buttons' => array(GWF_Form::SUBMITS, array(
				'edit' => $this->l('btn_edit_warbox'),
				'flags' => $this->l('btn_edit_warflags'),
			)),
			
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit(WC_Warbox $box)
	{
		$form = $this->formEdit($box);
		$tVars = array(
			'href_site' => $this->module->getMethodURL('SiteEdit', '&siteid='.$this->site->getID()),
			'href_descr' => $this->module->getMethodURL('SiteEdit', '&siteid='.$this->site->getID()),
			'href_boxes' => $this->module->getMethodURL('Warboxes', '&siteid='.$this->site->getID()),
			'form' => $form->templateY($this->l('ft_edit_warbox')),
		);
		return $this->module->templatePHP('site_add_warbox.php', $tVars);
	}
	
	private function formTest(WC_Warbox $box)
	{
		$data = array(
			'login' => array(GWF_Form::STRING, 'level4', $this->l('th_wb_test_login')),
			'test' => array(GWF_Form::SUBMIT, $this->l('btn_test_warbox_login')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onEdit(WC_Warbox $box)
	{
		$form = $this->formEdit($box);
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateEdit($box);
		}
		
		$options = 0;
		$options |= isset($_POST['warbox']) ? WC_Warbox::WARBOX : 0;
		$options |= isset($_POST['multi']) ? WC_Warbox::MULTI_SOLVE : 0;
		
		if (!$box->saveVars(array(
			'wb_name' => $form->getVar('name'),
			'wb_port' => $form->getVar('port'),
			'wb_host' => $form->getVar('host'),
			'wb_user' => $form->getVar('user'),
			'wb_pass' => $form->getVar('pass'),
			'wb_status' => $form->getVar('status'),
			'wb_weburl' => $form->getVar('url'),
			'wb_ip' => gethostbyname($form->getVar('host')),
			'wb_whitelist' => $form->getVar('wlist'),
			'wb_blacklist' => $form->getVar('blist'),
			'wb_launched_at' => $form->getVar('launch'),
			'wb_updated_at' => GWF_Time::getDate(14),
			'wb_options' => $options,
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateEdit($box);
		}
		
		Module_WeChall::instance()->flushWarboxConfig();
		
		return $this->module->message('msg_warbox_edited').$this->templateOverview();
	}
}
?>
