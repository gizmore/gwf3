<?php
final class PM_FolderAction extends GWF_Method
{
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'index.php?mo=PM&me=FolderAction',
						'page_title' => 'PM Folder Actions',
						'page_meta_desc' => 'Actions you can carry out in your PM folder',
				),
		);
	}
	
	public function execute()
	{
		$back = '';
		if (false !== (Common::getPost('delete_folder'))) {
			$back .= $this->onDeleteFolders();
		}

		return $back.$this->module->requestMethodB('Overview');
	}
	
	public function onDeleteFolder($folderid)
	{
		# Permission
		$folderid = (int) $folderid;
		$user = GWF_Session::getUser();
		if ( (false === ($folder = GWF_PMFolder::getByID($folderid)))
			|| ($folder->getVar('pmf_uid') !== $user->getID()) ) 
		{
			return $this->module->error('err_folder_perm');
		}

		# Delete PMs$result
		$count = 0;
		$pms = GDO::table('GWF_PM');
		$uid = $user->getVar('user_id');
		$fid = "$folderid";
		$del = GWF_PM::OWNER_DELETED;
		if (false === ($result = $pms->update("pm_options=pm_options|$del", "pm_owner=$uid AND pm_folder=$fid"))) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
		}
		$count += $pms->affectedRows($result);
//		$del = GWF_PM::FROM_DELETED;
//		if (false === $pms->update("pm_options=pm_options|$del", "pm_from=$uid AND pm_from_folder=$fid")) {
//			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
//		}
//		$count += $pms->affectedRows();
		
		
		if ($folderid > 2)
		{
			# Delete Folder
			if (false === $folder->delete()) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
		}

		# Done
		return $this->module->message('msg_folder_deleted', array($folder->display('pmf_name'), $count));
	}
	
	##
	private function onDeleteFolders()
	{
		if (false !== ($error = GWF_Form::validateCSRF_WeakS())) {
			return GWF_HTML::error('PM', $error, false);
		}
		
		$back = '';
		foreach (Common::getPostArray('folder', array()) as $folderid => $stub)
		{
			$back .= $this->onDeleteFolder($folderid);
		}
		return $back;
	}
}
?>