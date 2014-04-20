<?php
final class Profile_POISWhitelist extends GWF_Method
{
	public function isLoginRequired() { return true; }
	
	public function execute()
	{
		$back = '';
		if (isset($_POST['add']))
		{
			$back .= $this->onAdd();
		}
		elseif (isset($_POST['delete']))
		{
			$back .= $this->onDelete();
		}
		elseif (isset($_POST['clear_white']))
		{
			$back .= $this->onClear(true, false);
		}
		elseif (isset($_POST['clear_pois']))
		{
			$back .= $this->onClear(false, true);
		}
		elseif (isset($_POST['save_settings']))
		{
			$back .= $this->onSaveSettings();
		}
		return $back.$this->templateWhitelist();
	}

	private function templateWhitelist()
	{
		$ipp = 20;
		$page = Common::getGetInt('page', 1);
		$userid = GWF_Session::getUserID();
		$where = "pw_uida=$userid";		
		$table = GDO::table('GWF_ProfilePOIWhitelist');
		$numItems = $table->countRows($where);
		$nPages = GWF_PageMenu::getPagecount($ipp, $numItems);
		$page = Common::clamp($page, 1, $nPages);
		$from = GWF_PageMenu::getFrom($page, $ipp);
		$by = Common::getGetString('by', 'pw_date');
		$dir = Common::getGetString('dir', 'ASC');
		$by = $table->getWhitelistedBy($by);
		$dir = $table->getWhitelistedDirS($dir);
		$pagehref = GWF_WEB_ROOT."index.php?mo=Profile&me=POISWhitelist&by=$by&dir=$dir&page=%PAGE%";
		$tVars = array(
			'form_add' => $this->formAdd(),
			'form_clear' => $this->formClear(),
			'form_settings' => $this->formSettings(),
			'table' => $table,
			'where' => $where,
			'by' => $by,
			'dir' => $dir,
			'ipp' => $ipp,
			'from' => $from,
			'form_action' => GWF_WEB_ROOT.'index.php?mo=Profile&me=POISWhitelist',
			'sort_url' => GWF_WEB_ROOT."index.php?mo=Profile&me=POISWhitelist&by=%BY%&dir=%DIR%&page=1",
			'page_menu' => GWF_PageMenu::display($page, $nPages, $pagehref),
		);
		$back = $this->module->templatePHP('whitelist.php', $tVars);
		return $back;
	}
	
	private function formAdd()
	{
		$data = array(
			'user_name' => array(GWF_Form::STRING, '', $this->l('th_user_name')),
			'add' => array(GWF_Form::SUBMIT, $this->l('btn_add_whitelist')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_user_name(Module_Profile $m, $arg)
	{
		if (!($this->user_to_add = GWF_User::getByName($arg)))
		{
			return GWF_HTML::lang('ERR_UNKNOWN_USER');
		}
		if ($this->user_to_add->getID() == GWF_Session::getUserID())
		{
			return $m->lang('err_self_whitelist');
		}
		return false;
	}
	private function onAdd()
	{
		$form = $this->formAdd();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		if (!GDO::table('GWF_ProfilePOIWhitelist')->insertAssoc(array(
			'pw_uida' => GWF_Session::getUserID(),
			'pw_uidb' => $this->user_to_add->getID(),
			'pw_date' => GWF_Time::getDate(),
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return $this->module->message('msg_white_added', $_POST['user_name']);
	}

	private function formClear()
	{
		$data = array(
			'clear_pois' => array(GWF_Form::SUBMIT, $this->l('btn_clear_pois')),
			'clear_white' => array(GWF_Form::SUBMIT, $this->l('btn_clear_white')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function onClear($white, $pois)
	{
		$form = $this->formClear();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		
		if ($white)
		{
			if (!GDO::table('GWF_ProfilePOIWhitelist')->deleteWhere("pw_uida=$userid"))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return $this->module->message('msg_white_cleared');
		}
		if ($pois)
		{
			if (!GDO::table('GWF_ProfilePOI')->deleteWhere("pp_uid=$userid"))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			return $this->module->message('msg_pois_cleared');
		}
	}
	
	private function onDelete()
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS()))
		{
			return $error;
		}
		if (isset($_POST['user']) && is_array($_POST['user']))
		{
			$to_delete = implode(',', array_keys($_POST['user']));
			if ($to_delete !== '')
			{
				$userid = GWF_Session::getUserID();
				$table = GDO::table('GWF_ProfilePOIWhitelist');
				if (!$table->deleteWhere("pw_uida=$userid AND pw_uidb IN ($to_delete)"))
				{
					return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
				}
				$numDeleted = $table->affectedRows();
				if ($numDeleted > 0)
				{
					return $this->module->message('msg_white_removed', array($numDeleted));
				}
			}
		}
		return '';
	}
	
	private function formSettings()
	{
		$profile = GWF_Profile::getProfile(GWF_Session::getUserID());
		$data = array(
			'use_white' => array(GWF_Form::CHECKBOX, $profile->isPOIWhitelisting(), $this->l('th_poi_white'), $this->l('tt_poi_white')),
			'save_settings' => array(GWF_Form::SUBMIT, $this->l('btn_edit')),
		);
		return new GWF_Form($this, $data);
		
	}
	
	private function onSaveSettings()
	{
		$form = $this->formSettings();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		$profile = GWF_Profile::getProfile(GWF_Session::getUserID());
		if (!$profile->saveOption(GWF_Profile::POI_WHITELIST, isset($_POST['use_white'])))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return $this->module->message('msg_edited');
	}
	
	
}
