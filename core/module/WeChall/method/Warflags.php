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

	private $csv_data = array();
	
	const CSV_COLUMNS = '#POS,Category,Score,title,url,authors,status(up|down),username(may be blank),password(plain or sha1),type(SSH|WEB)';

	public function execute()
	{
		if (false === ($this->user = GWF_Session::getUser()))
		{
			return GWF_HTML::err('ERR_LOGIN_REQUIRED');
		}
		
		$this->module->includeClass('WC_Warbox');
		$this->module->includeClass('WC_Warflag');
		$this->module->includeClass('WC_SiteAdmin');
		$this->module->includeClass('WC_SiteCats');
		$this->module->includeClass('sites/warbox/WCSite_WARBOX');
		
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
		
		if (isset($_POST['import']))
		{
			return $this->onCSVImport();
		}
		if (isset($_GET['export']))
		{
			return $this->onCSVExport();
		}
		
		if (isset($_GET['up']))
		{
			return $this->onUp().$this->templateOverview();
		}
		elseif (isset($_GET['down']))
		{
			return $this->onDown().$this->templateOverview();
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
	
	public function validate_pos(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'pos', $arg, 0, 1000, true); }
	public function validate_type(Module_WeChall $m, $arg) { $arg = strtoupper($arg); return ($arg === 'WEB') || ($arg === 'SSH') ? false : $m->lang('err_wf_type'); }
	public function validate_wf_score(Module_WeChall $m, $arg) { return GWF_Validator::validateInt($m, 'wf_score', $arg, 0, 1000000, true); }
	public function validate_wf_title(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'wf_title', $arg, 0, 64, false); }
	public function validate_wf_authors(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'wf_authors', $arg, 0, 255, false); }
	public function validate_wf_status(Module_WeChall $m, $arg) { return in_array($arg, WC_Warflag::$STATUS) ? false : $m->lang('err_wf_status'); }
	public function validate_wf_created_at(Module_WeChall $m, $arg) { return GWF_Validator::validateDate($m, 'wf_created_at', $arg, 8, false); }
	public function validate_wf_login(Module_WeChall $m, $arg) { return GWF_Validator::validateString($m, 'wf_login', $arg, 0, 255, false); }
	public function validate_wf_url(Module_WeChall $m, $arg) { return false; return GWF_Validator::validateURL($m, 'wf_url', $arg, true, false); }
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
		$form_csv = $this->formCSV();
		$tVars = array(
			'flags' => WC_Warflag::getByWarbox($this->warbox, 'wf_order ASC'),
			'form_csv' => $form_csv->templateY($this->l('ft_csv_import')),
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
			'wf_url' => $form->getVar('wf_url'),
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
		
		$site = $this->warbox->getSite();
		if ($site->isLinear())
		{
			$site->saveVar('site_maxscore', WC_Warflag::getTotalscoreForSite($site));
		}
		
		$this->warbox->increase('wb_challs');
		$this->warbox->increase('wb_flags');
		$this->warbox->recalcTotalscore();
		$site->recalcSite();
		
		return $this->module->message('msg_add_flag').$this->templateOverview();
	}
	
	############
	### Edit ###
	############
	private function formEdit()
	{
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
			'password' => array(GWF_Form::STRING,'', $this->l('th_wf_flag')),
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
			'wf_score' => $form->getVar('wf_score'),
			'wf_title' => $form->getVar('wf_title'),
			'wf_url' => $form->getVar('wf_url'),
			'wf_authors' => $form->getVar('wf_authors'),
			'wf_status' => $form->getVar('wf_status'),
			'wf_login' => $form->getVar('wf_login'),
			'wf_created_at' => $form->getVar('wf_created_at'),
		);
		$f = $form->getVar('password');
		if ($f !== '')
		{
			$data['wf_flag_enc'] = WC_Warflag::hashPassword($f);
		}
		
		if (!$this->flag->saveVars($data))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__)).$this->templateOverview();
		}

		$site = $this->warbox->getSite();
		if ($site->isLinear())
		{
			$site->saveVar('site_maxscore', WC_Warflag::getTotalscoreForSite($site));
		}
		$this->warbox->recalcTotalscore();
		
		$site->recalcSite();
		
		return $this->module->message('msg_edit_flag').$this->templateOverview();
	}
	
	##########
	### Up ###
	##########
	private function onUp()
	{
		if (false === ($flag = WC_Warflag::getByID(Common::getGetString('up'))))
		{
			return $this->module->error('err_warflag');
		}
		if ($flag->getVar('wf_wbid') !== $this->warbox->getID())
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		if (false === ($upper = $flag->getPrev()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$upid = $upper->getVar('wf_order');
		$doid = $flag->getVar('wf_order');
		
		$upper->saveVar('wf_order', $doid);
		$flag->saveVar('wf_order', $upid);

		return '';
	}
	
	private function onDown()
	{
		if (false === ($flag = WC_Warflag::getByID(Common::getGetString('down'))))
		{
			return $this->module->error('err_warflag');
		}
		if ($flag->getVar('wf_wbid') !== $this->warbox->getID())
		{
			return GWF_HTML::err('ERR_NO_PERMISSION');
		}
		if (false === ($lower = $flag->getNext()))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		$upid = $flag->getVar('wf_order');
		$doid = $lower->getVar('wf_order');
		
		$flag->saveVar('wf_order', $doid);
		$lower->saveVar('wf_order', $upid);

		return '';
	}
	
	##################
	### CSV Import ###
	##################
	private function formCSV()
	{
		$data = array(
			'pass_csvdata' => array(GWF_Form::MESSAGE_NOBB, self::CSV_COLUMNS.PHP_EOL, $this->l('th_csvdata')),
			'import' => array(GWF_Form::SUBMIT, $this->l('btn_import')),
		);
		return new GWF_Form($this, $data);
	}
	
	public function validate_pass_csvdata(Module_WeChall $m, $arg)
	{
		$rows = str_getcsv($arg, "\n");
		$line = 0;
		
		$colcount = count(explode(',', self::CSV_COLUMNS));
		
		foreach ($rows as $row)
		{
			$line++;
			$row = trim($row);
			if ( ($row === '') || ($row[0] === '#') )
			{
				continue;
			}
			$cols = str_getcsv($row);
			
			if (count($cols) !== $colcount)
			{
				return "Error in Line $line. Column count does not match!";
			}

			$i = 0;
			if (false !== ($err = $this->validate_pos($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_cat($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_score($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_title($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_url($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_authors($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_status($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_wf_login($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_password($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			if (false !== ($err = $this->validate_type($m, $cols[$i++])))
			{
				return "Error in Line $line: $err";
			}
			
			$this->csv_data[] = $cols;
		}
		
		return false;
	}
	
	
	private function onCSVImport()
	{
		$form = $this->formCSV();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error.$this->templateOverview();
		}

		$back = '';
		
		foreach ($this->csv_data as $row)
		{
			$back .= $this->onCSVRow($row);
		}

		$back .= GWF_HTML::message('Warflags', 'Warflags CSV Import finished.');

		return $back . $this->templateOverview();
	}
	
	private function onCSVRow(array $row)
	{
		if (false === ($flag = WC_Warflag::getByWarboxAndPos($this->warbox, $row[0])))
		{
			return $this->createFromCSV($row);
		}
		else
		{
			return $this->updateFromCSV($flag, $row);
		}
	}
	
	private function createFromCSV(array $row)
	{
		$flag = new WC_Warflag(array(
			'wf_id' => '0',
			'wf_wbid' => $this->warbox->getID(),
			'wf_order' => $row[0],
			'wf_cat' => $row[1],
			'wf_score' => $row[2],
			'wf_solvers' => '0',
			'wf_title' => $row[3],
			'wf_url' => $row[4],
			'wf_authors' => $row[5],
			'wf_status' => $row[6],
			'wf_login' => $row[7],
			'wf_flag_enc' => WC_Warflag::hashPassword($row[8]),
			'wf_created_at' => GWF_Time::getDate(),
			'wf_last_solved_at' => NULL,
			'wf_last_solved_by' => NULL,
			'wf_options' => $this->bitFromType($row),
		));
		if (!$flag->insert())
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		return '';
	}
	
	private function bitFromType(array $row)
	{
		$type = trim($row[9]);
		if (strtoupper($type) === 'SSH')
		{
			return WC_Warflag::WARCHALL;
		}
		if (strtoupper($type) === 'WEB')
		{
			return WC_Warflag::WARFLAG;
		}
		return 0;
	}
	
	private function updateFromCSV(WC_Warflag $flag, array $row)
	{
		$types = WC_Warflag::WARCHALL | WC_Warflag::WARFLAG;
		$options = $flag->getOptions();
		$options &= ~$types;
		$options |= $this->bitFromType($row);
		
		if (!$flag->saveVars(array(
			'wf_cat' => $row[1],
			'wf_score' => $row[2],
			'wf_title' => $row[3],
			'wf_url' => $row[4],
			'wf_authors' => $row[5],
			'wf_status' => $row[6],
			'wf_login' => $row[7],
#			'wf_flag_enc' => WC_Warflag::hashPassword($row[8]),
			'wf_options' => $options,
		)))
		{
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		if ($row[8] !== '')
		{
			if (!$flag->saveVar('wf_flag_enc', WC_Warflag::hashPassword($row[8])))
			{
				return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		return '';
	}
	
	##################
	### CSV Export ###
	##################
	private function onCSVExport()
	{
		GWF_Website::plaintext();
		
		$flags = WC_Warflag::getByWarbox($this->warbox, 'wf_order ASC');
		
		echo self::CSV_COLUMNS.PHP_EOL;

		foreach ($flags as $flag)
		{
			$flag instanceof WC_Warflag;
			$input = array(
				$flag->getVar('wf_order'),
				$flag->getVar('wf_cat'),
				$flag->getVar('wf_score'),
				$flag->getVar('wf_title'),
				$flag->getVar('wf_url'),
				$flag->getVar('wf_authors'),
				$flag->getVar('wf_status'),
				$flag->getVar('wf_login'),
				'',
				($flag->isWarchall() ? 'SSH':'WEB'),
			);
			echo GWF_Array::toCSV($input).PHP_EOL;
		}
		die(0);
	}
}
/*
#POS,Category,Score,title,url,authors,status(up|down),username(may be blank),password(plain or sha1),TYPE
1,Exploit,100,EasyPeasy1,http://google.de/?q=Easy1,Gizmore,up,,test1,WEB
2,Exploit,200,EasyPeasy2,http://google.de/?q=Easy2,Gizmore,up,,test2,WEB
3,Exploit,300,EasyPeasy3,http://google.de/?q=Easy3,Gizmore,up,,test3,WEB
4,Exploit,400,EasyPeasy4,http://google.de/?q=Easy4,Gizmore,up,,test4,WEB
5,Exploit,500,EasyPeasy5,http://google.de/?q=Easy5,Gizmore,up,,test5,WEB
*/
?>
