<?php
/**
 * Main PM Functionality / Navigation
 * @author gizmore
 */
final class PM_Overview extends GWF_Method
{
	##################
	### GWF_Method ###
	##################
	public function getHTAccess()
	{
		return
			'RewriteRule ^pm$ index.php?mo=PM&me=Overview&by=pm_date&dir=DESC&page=1'.PHP_EOL.
			'RewriteRule ^pm/folder/(\d+)/[^/]+/by/page-([0-9]+)$ index.php?mo=PM&me=Overview&folder=$1&page=$2'.PHP_EOL.
			'RewriteRule ^pm/folder/(\d+)/[^/]+/by/([^/]+)/([ADESC,]{0,})/page-([0-9]+)$ index.php?mo=PM&me=Overview&folder=$1&by=$2&dir=$3&page=$4'.PHP_EOL.
			'RewriteRule ^pm/folders/(\d+)/[^/]+/by/([^/]+)/([ADESC,]{0,})/page-([0-9]+)$ index.php?mo=PM&me=Overview&folder=$1&fby=$2&fdir=$3&fpage=$4'.PHP_EOL;
	}
	
	public function getPageMenuLinks()
	{
		return array(
			array(
				'page_url' => 'pm',
				'page_title' => 'PM Overview',
				'page_meta_desc' => 'Overview for your PMs',
			),
		);
	}
	
	public function execute()
	{
		GWF_Website::addJavascript(GWF_WEB_ROOT.'js/module/PM/gwf_pm.js');
		
		if (false === ($user = GWF_Session::getUser()))
		{
			return $this->templateGuests();
		}
		
		if (false !== ($error = $this->sanitize()))
		{
			return $error;
		}
		
		$back = '';
		if (isset($_POST['newfolder']))
		{
			$back = $this->onCreateFolder();
		}
		elseif (isset($_POST['delete']))
		{
			$back = $this->onDelete();
		}
		elseif (isset($_POST['move']))
		{
			$back = $this->onMove();
		}
		
		return $back.$this->templateOverview();
	}
	
	/**
	 * @var GWF_PMFolder
	 */
	private $folder;
	
	private function sanitize()
	{
		if (false === ($this->folder = GWF_PMFolder::getByID(Common::getGet('folder', GWF_PM::INBOX))))
		{
			if (false === ($this->folder = GWF_PMFolder::getInBox()))
			{
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}
		
		$this->fid = $fid = $this->folder->getID();
		$uid = GWF_Session::getUserID();
		$del = GWF_PM::OWNER_DELETED;
		$conditions = "pm_owner={$uid} AND pm_folder={$fid} AND pm_options&{$del}=0";
		$pmTable = GDO::table('GWF_PM');
		$this->ipp = $this->module->cfgPMPerPage();
		$this->nItems = $pmTable->countRows($conditions);
		$this->nPages = GWF_PageMenu::getPagecount($this->ipp, $this->nItems);
		$this->page = Common::clamp(intval(Common::getGet('page')), 1, $this->nPages);
		$this->orderby = $pmTable->getMultiOrderby(Common::getGet('by'), Common::getGet('dir'));
		$this->pms = $pmTable->selectObjects('*', $conditions, $this->orderby, $this->ipp, GWF_PageMenu::getFrom($this->page, $this->ipp));
		return false;
	}
	
	##############
	### Guests ###
	##############
	private function templateGuests()
	{
		GWF_Website::setPageTitle($this->module->lang('pt_guest'));
		
		$tVars = array(
			'new_pm' => $this->getNewPMFormGuest(),
		);
		return $this->module->template('overview_guests.tpl', $tVars);
	}
	
	################
	### Sanitize ###
	################
	private function templateOverview()
	{
		GWF_Website::setPageTitle($this->module->lang('pt_pm'));
		
		$fname = $this->folder->urlencodeSEO('pmf_name');
		$hrefPage = GWF_WEB_ROOT.sprintf('pm/folder/%s/%s/by/%s/%s/page-%%PAGE%%', $this->fid, $fname, urlencode(Common::getGet('by')), urlencode(Common::getGet('dir')));
		$hrefSort = GWF_WEB_ROOT.'pm/folder/'.$this->fid.'/'.$fname.'/by/%BY%/%DIR%/page-1';
		
		$tVars = array(
			'folder' => $this->folder,
			'folders' => $this->folderTable(),
			'form_new_folder' => $this->getFormNewFolder()->templateX($this->module->lang('ft_new_folder')),
			'pms' => $this->pms,
			'pagemenu' => GWF_PageMenu::display($this->page, $this->nPages, $hrefPage),
			'sort_url' => $hrefSort,
			'new_pm' => $this->getNewPMForm(),
			'href_options' => $this->module->getOptionsHREF(),
			'href_search' => $this->module->getSearchHREF(),
			'folder_select' => GWF_PMFolder::getSelectS($this->module, Common::getRequest('folders', '0')),
			'form_action' => isset($_SERVER['REQUEST_URI']) ? GWF_HTML::display($_SERVER['REQUEST_URI']) : GWF_WEB_ROOT.'pm',
			'href_trashcan' => $this->module->getMethodURL('Trashcan&by=pm_date&dir=DESC'),
		);
		return $this->module->templatePHP('overview.php', $tVars);
	}

	public function folderTable()
	{
		$folders = GWF_PMFolder::getFolders(GWF_Session::getUserID());
		
		$uid = GWF_Session::getUserID();
		$conditions = "pmf_uid=$uid";
		$orderby = GDO::table('GWF_PMFolder')->getMultiOrderby(Common::getGet('fby', 'pmf_name'), Common::getGet('fdir'));
		$folders = array_merge(
			GWF_PMFolder::getDefaultFolders(),
			GDO::table('GWF_PMFolder')->selectObjects('*', $conditions, $orderby)
		);
		
		$tVars = array(
			'orderby' => $orderby,
			'folders' => $folders,
			'sort_url' => '',
			'folder_action' => $this->module->getMethodURL('FolderAction'),
		);
		return $this->module->templatePHP('folders.php', $tVars);
	}
	
	private function getFormNewFolder()
	{
		$data = array(
			'foldername' => array(GWF_Form::STRING, '', $this->module->lang('th_pmf_name')),
			'newfolder' => array(GWF_Form::SUBMIT, $this->module->lang('btn_new_folder')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function pmTable()
	{
		$uid = GWF_Session::getUserID();
		$fid = $this->folder->getID();
		$conditions = "(pm_from=$uid AND pm_from_folder=$fid) OR (pm_to=$uid AND pm_to_folder=$fid)";
		$sortURL = GWF_WEB_ROOT.'pm/folder/'.$fid.'/'.$this->folder->urlencodeSEO('pmf_name').'/by/%BY%/%DIR%/page-1';
		return GWF_Table::displayGDO2($this->module, GDO::table('GWF_PM'), GWF_Session::getUser(), $sortURL, $conditions, $this->module->cfgPMPerPage());
	}
	
	private function getNewPMForm()
	{
		$data = array(
			#'username_sel' => array(GWF_Form::SELECT, $this->getUsernameSelect($this->getCorrespondence(), 'username_sel')),
			'username' => array(GWF_Form::STRING, ''),
			'create' => array(GWF_Form::SUBMIT, $this->module->lang('btn_create')),
		);
		$form = new GWF_Form($this, $data);
		return $form->templateX($this->module->lang('ft_new_pm'), GWF_PM::getNewPMHref());
	}

	private function getNewPMFormGuest()
	{
		$data = array(
			'username_sel' => array(GWF_Form::SELECT, $this->getUsernameSelect($this->getUsernamesPPM(), 'username_sel')),
			'create' => array(GWF_Form::SUBMIT, $this->module->lang('btn_create')),
			'username' => array(GWF_Form::STRING, ''),
		);
		$form = new GWF_Form($this, $data);
		return $form->templateX($this->module->lang('ft_new_pm'), GWF_PM::getNewPMHref());
	}

	private function getCorrespondence()
	{
		if (false === ($user = GWF_Session::getUser()))
		{
			return array();
		}
		$uid = $user->getID();
		$back = array_merge(
			GDO::table('GWF_PM')->selectColumn('T_A.user_name', "pm_to=$uid OR pm_from=$uid", 'T_A.user_name ASC'),
			GDO::table('GWF_PM')->selectColumn('T_B.user_name', "pm_to=$uid OR pm_from=$uid", 'T_B.user_name ASC')
		);
		$uname = $user->getVar('user_name');
		if (false !== ($i = array_search($uname, $back)))
		{
			unset($back[$i]);
		}
		return $back;
	}
	
	private function getUsernamesPPM()
	{
		$ppm = GWF_PMOptions::ALLOW_GUEST_PM;
		return GDO::table('GWF_PMOptions')->selectColumn('user_name', "pmo_options&$ppm", "user_name DESC", array('pmo_user'));
	}

	private function getUsernameSelect(array $usernames, $name='username')
	{
		$back = sprintf('<select name="%s">', $name);
		$back .= sprintf('<option value="0">%s</option>', $this->module->lang('sel_username'));
		foreach ($usernames as $username)
		{
			$username = GWF_HTML::display($username);
			$back .= sprintf('<option value="%s">%s</option>', $username, $username);
		}
		$back .= '</select>';
		return $back;
	}
	
	##############
	### Delete ###
	##############
	private function onDelete()
	{
		$ids = Common::getPost('pm');
		if (!(is_array($ids)))
		{
			return ''; # Nothing to do
		}
		
		$user = GWF_Session::getUser();
		$count = 0;
		foreach ($ids as $id => $stub)
		{
			if (false === ($pm = GWF_PM::getByID($id)))
			{
				continue;
			}
			if (false === ($pm->canRead($user)))
			{
				continue;
			}
			if (false === $pm->markDeleted($user))
			{
				continue;
			}
			$count++;
		}
		
		$this->sanitize();
		
		return $this->module->message('msg_deleted', array($count));
	}
	
	##################
	### New Folder ###
	##################
	public function validate_foldername($m, $arg) { return $this->module->validate_foldername($arg); }
	public function onCreateFolder()
	{
		$form = $this->getFormNewFolder();
		if (false !== ($error = $form->validate($this->module)))
		{
			return $error;
		}
		
		$userid = GWF_Session::getUserID();
		
		$folders = GWF_PMFolder::getFolders($userid);
		if (count($folders) >= $this->module->cfgMaxFolders())
		{
			return $this->module->error('err_max_folders');
		}
		
		if (false === ($folder = GWF_PMFolder::insertFolder($userid, $form->getVar('foldername'))))
		{
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		
		return '';
	}
	
	############
	### Move ###
	############
	private function onMove($ids=NULL)
	{
		$ids = Common::getPost('pm');
		if (!(is_array($ids)))
		{
			return '';
		}
		
		$user = GWF_Session::getUser();
		
		if (false === ($folder = GWF_PMFolder::getByID(Common::getPost('folders'))))
		{
			return $this->module->error('err_folder');
		}
		
		if ($folder->getVar('pmf_uid') !== $user->getID())
		{
			return $this->module->error('err_folder');
		}
		
		$count = 0;
		foreach ($ids as $id => $stub)
		{
			if (false === ($pm = GWF_PM::getByID($id)))
			{
				continue;
			}
			if (false === ($pm->canRead($user)))
			{
				continue;
			}
			if (false === $pm->move($user, $folder))
			{
				continue;
			}
			$count++;
		}
		
		$this->sanitize();
		return $this->module->message('msg_moved', array($count));
	}
}

?>
