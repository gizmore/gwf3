<?php
final class WeChall_Warflags extends GWF_Method
{
	/**
	 * @var GWF_User
	 */
	private $user;
	/**
	 * @var WC_Warbox
	 */
	private $warbox;
	/**
	 * @var WC_Warflag
	 */
	private $flag;
	
	public function execute()
	{
		if (false === ($this->user = GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_SiteAdmin');
		
		if (false === ($this->warbox = WC_Warbox::getByID(Common::getGetString('wbid'))))
		{
			return WC_HTML::error('err_warbox');
		}
		
		if (!$this->warbox->hasEditPermission($this->user))
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		
		if (isset($_GET['edit']))
		{
			if (false === ($this->flag = WC_Warflag::getByID(Common::getGetString('edit'))))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			if (isset($_POST['edit']))
			{
				return $this->onEdit();
			}
			else
			{
				return $this->templateEdit();
			}
		}
		
		if (isset($_POST['add']))
		{
			return $this->onAdd();
		}
		if (isset($_GET['add']))
		{
			return $this->templateAdd();
		}
		
		return $this->templateOverview();
	}
	
	##################
	### Validators ###
	##################
	public function validate_wf_cat(Module_WeChall $m, $arg)
	{
		if ( ($arg === '') || (WC_SiteCats::isValidCatName($arg)) )
		{
			return false;
		}
		unset($_POST['wf_cat']);
		return $m->lang('err_wf_cat');
	}
	
	public function validate_wf_score(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'wf_score', $arg, 0, 1000000, true); }
	public function validate_wf_title(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'wf_title', $arg, 0, 64, false); }
	public function validate_wf_authors(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'wf_authors', $arg, 0, 255, false); }
	public function validate_wf_status(Module_WeChall $m, $arg) { return in_array($arg, WC_Warflag::$STATUS) ? false : $m->lang('err_wf_status'); }
	public function validate_wf_created_at(Module_WeChall $m, $arg) { return GWF_Validator::validateDate($m, 'wf_created_at', $arg, 8, false); }
	public function validate_wf_login(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'wf_login', $arg, 0, 255, false); }
	public function validate_wf_url(Module_WeChall $m, $arg) { return GWF_Validator::validateURL($m, 'wf_url', $arg, true, false); }
	public function validate_password(Module_WeChall $m, $arg)
	{
		if ($arg === '' && isset($_GET['edit']))
		{
			return false;
		}
		return GWF_Validator::validateString($m, 'password', $arg, 1, 255, false);
	}
	
	################
	### Overview ###
	################
	private function templateOverview()
	{
		$tVars = array(
			'flags' => WC_Warflag::getByWarbox($this->warbox),
			'href_add' => $this->hrefAdd(),
		);
		return $this->module->templatePHP('warflags.php', $tVars);
	}
	
	private function hrefAdd()
	{
		return $this->getMethodHREF('&add=1&wbid='.$this->warbox->getID());
	}
	
	#############
	### Enums ###
	#############
	private function getCatEnums()
	{
		$this->module->includeClass('WC_SiteCats');
		$back = array();
		$back[] = array('', 'Unknown');
		foreach (WC_SiteCats::getAllCats() as $cat)
		{
			$back[] = array($cat, $cat);
		}
		return $back;
	}
	
	private function getStatusEnums()
	{
		$back = array();
		foreach (WC_Warflag::$STATUS as $status)
		{
			$back[] = array($status, $status);
		}
		return $back;
	}
	
	###########
	### Add ###
	###########
	private function formAdd()
	{
		$data = array(
			'wf_cat' => array(GWF_Form::ENUM, '', $this->l('th_wf_cat'), '', $this->getCatEnums()),
			'wf_score' => array(GWF_Form::INT, 1, $this->l('th_wf_score')),
			'wf_title' => array(GWF_Form::STRING, '', $this->l('th_wf_title')),
			'wf_url' => array(GWF_Form::STRING, '', $this->l('th_wf_url')),
			'wf_authors' => array(GWF_Form::STRING, '', $this->l('th_wf_authors')),
			'wf_status' => array(GWF_Form::ENUM, 'up', $this->l('th_wf_status'), '', $this->getStatusEnums()),
			'wf_created_at' => array(GWF_Form::DATE, GWF_Time::getDate(8), $this->l('th_wf_created_at'), '', 8),
			'div' => array(GWF_Form::DIVIDER),
			'wf_login' => array(GWF_Form::STRING, '', $this->l('th_wf_login')),
			'password' => array(GWF_Form::STRING, '', $this->l('th_wf_flag')),
			'add' => array(GWF_Form::SUBMIT, $this->l('btn_add_flag')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAdd()
	{
		$form = $this->formAdd();
		$tVars = array(
			'form_add' => $form->templateY($this->l('ft_add_flag')),
			'href_add' => $this->hrefAdd(),
			'flags' => WC_Warflag::getByWarbox($this->warbox),
		);
		return $this->module->templatePHP('warflags.php', $tVars);
	}
	
	private function onAdd()
	{
		$form = $this->formAdd();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateAdd();
		}
		
		$f = $form->getVar('password');
		
		$flag_enc = WC_Warflag::hashPassword($f);
		
		$flag = new WC_Warflag(array(
			'wf_id' => '0',
			'wf_wbid' => $this->warbox->getID(),
			'wf_order' => WC_Warflag::getNextOrder($this->warbox),
			'wf_cat' => $form->getVar('wf_cat'),
			'wf_score' => $form->getVar('wf_score'),
			'wf_title' => $form->getVar('wf_title'),
			'wf_authors' => $form->getVar('wf_authors'),
			'wf_status' => $form->getVar('wf_status'),
			'wf_login' => $form->getVar('wf_login'),
			'wf_flag_enc' => $flag_enc,
			'wf_created_at' => $form->getVar('wf_created_at'),
			'wf_last_solved_at' => NULL,
			'wf_last_solved_by' => NULL,
		));
		
		if (!$flag->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateOverview();
		}
		
		$this->warbox->increase('wb_challs');
		$this->warbox->increase('wb_flags');
		
		$this->warbox->recalcTotalscore();
		
		$this->warbox->getSite()->recalcSite();
		
		return $this->module->message('msg_add_flag').$this->templateOverview();
	}
	
	############
	### Edit ###
	############
	private function formEdit()
	{
		$plain = $this->flag->getVar('wf_flag');
		$enc = $this->flag->getVar('wf_flag_enc') !== NULL;
		$data = array(
			'wf_cat' => array(GWF_Form::ENUM, $this->flag->getVar('wf_cat'), $this->l('th_wf_cat'), '', $this->getCatEnums()),
			'wf_score' => array(GWF_Form::INT, $this->flag->getVar('wf_score'), $this->l('th_wf_score')),
			'wf_title' => array(GWF_Form::STRING, $this->flag->getVar('wf_title'), $this->l('th_wf_title')),
			'wf_url' => array(GWF_Form::STRING, $this->flag->getVar('wf_url'), $this->l('th_wf_url')),
			'wf_authors' => array(GWF_Form::STRING, $this->flag->getVar('wf_authors'), $this->l('th_wf_authors')),
			'wf_status' => array(GWF_Form::ENUM, $this->flag->getVar('wf_status'), $this->l('th_wf_status'), '', $this->getStatusEnums()),
			'wf_created_at' => array(GWF_Form::DATE, $this->flag->getVar('wf_created_at'), $this->l('th_wf_created_at'), '', 8),
			'div' => array(GWF_Form::DIVIDER),
			'wf_login' => array(GWF_Form::STRING, $this->flag->getVar('wf_login'), $this->l('th_wf_login')),
			'password' => array(GWF_Form::STRING, $enc?$plain:'', $this->l('th_wf_flag')),
			'edit' => array(GWF_Form::SUBMIT, $this->l('btn_edit_flag')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateEdit()
	{
		$form = $this->formEdit();
		$tVars = array(
			'form_edit' => $form->templateY($this->l('ft_edit_flag')),
			'flags' => WC_Warflag::getByWarbox($this->warbox),
			'href_add' => $this->hrefAdd(),
		);
		return $this->module->templatePHP('warflags.php', $tVars);
	}
	
	private function onEdit()
	{
		$form = $this->formEdit();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateEdit();
		}
		
		$data = array(
			'wf_cat' => $form->getVar('wf_cat'),
			'wf_title' => $form->getVar('wf_title'),
			'wf_login' => $form->getVar('wf_login'),
			'wf_status' => $form->getVar('wf_status'),
			'wf_score' => $form->getVar('wf_score'),
			'wf_authors' => $form->getVar('wf_authors'),
			'wf_created_at' => $form->getVar('wf_created_at'),
		);
		$f = $form->getVar('password');
		$enc = isset($_POST['enc']);
		if ($f !== '')
		{
			$data['wf_flag_enc'] = WC_Warflag::hashPassword($f);
		}
		
		if (!$this->flag->saveVars($data))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateOverview();
		}

		$this->warbox->recalcTotalscore();
		
		$this->warbox->getSite()->recalcSite();
		
		return $this->module->message('msg_edit_flag').$this->templateOverview();
	}
}
?>
