<?php

final class GWF_PMFolder extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'pm_folder'; }
	public function getColumnDefines()
	{
		return array(
			'pmf_id' => array(GDO::AUTO_INCREMENT),
			'pmf_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'pmf_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, true, 63),
			'pmf_count' => array(GDO::UINT, 0),
		);
	}
	public function getID() { return $this->getVar('pmf_id'); }
	public function isRealBox() { return $this->getID() > 2; }
	
	######################
	### Static Getters ###
	######################
	/**
	 * @param int $folderid
	 * @return GWF_PMFolder
	 */
	public static function getByID($folderid)
	{
		$folderid = (int)$folderid;
		switch($folderid)
		{
			case GWF_PM::INBOX: return self::getInBox();
			case GWF_PM::OUTBOX: return self::getOutBox();
			default: return self::table(__CLASS__)->selectFirstObject('*', "pmf_id=$folderid");
		}
	}
	
	public static function getByName($name, $user=true)
	{
		if ($user === true) { $user = GWF_Session::getUser(); }
		$uid = $user->getID();
		$name = GDO::escape($name);
		return self::table(__CLASS__)->selectFirst('1', "pmf_name='$name' AND pmf_uid=$uid") !== false;
	}
	
	public static function getFolders($userid, $orderby='pmf_name ASC')
	{
		return array_merge(
			GWF_PMFolder::getDefaultFolders(),
			GDO::table('GWF_PMFolder')->selectObjects('*', 'pmf_uid='.intval($userid), $orderby)
//			GDO::table('GWF_PMFolder')->select('pmf_uid='.intval($userid), $orderby)
		);
	}
	
	#############
	### HREFs ###
	#############
	public function getOverviewHREF()
	{
		return GWF_WEB_ROOT.sprintf('pm/folder/%d/%s/by/pm_date/DESC/page-1', $this->getID(), $this->urlencodeSEO('pmf_name'));
	}
	
	################
	### Creation ###
	################
	public static function fakeFolder($userid, $foldername)
	{
		return new self(array(
			'pmf_uid' => $userid,
			'pmf_name' => $foldername,
			'pmf_count' => 0,
		));
	}
	
	public static function insertFolder($userid, $foldername)
	{
		$folder = self::fakeFolder($userid, $foldername);
		if (false === $folder->insert()) {
			return false;
		}
		return $folder;
	}
	
	#######################
	### Default Folders ###
	#######################
	public static function getDefaultFolders()
	{
		$cache = true;
		
		if ($cache !== true) {
			return $cache;
		}
		$cache = array(
			self::getInBox(),
			self::getOutBox(),
		);
		return $cache;
	}
	
	public static function getInBox()
	{
		static $cache = true;
		if ($cache === true)
		{
			$uid = GWF_Session::getUserID();
			$inbox = GWF_PM::INBOX;
			$del = GWF_PM::OWNER_DELETED;
			$cache = new self(array(
				'pmf_id' => $inbox,
				'pmf_uid' => $uid,
				'pmf_name' => GWF_PM::INBOX_NAME,
				'pmf_count' => GDO::table('GWF_PM')->countRows("(pm_owner=$uid AND pm_folder=$inbox AND pm_options&$del=0)"),
			));
		}
		return $cache;
	}
	
	public static function getOutBox()
	{
		static $cache = true;
		if ($cache === true)
		{
			$uid = GWF_Session::getUserID();
			$outbox = GWF_PM::OUTBOX;
			$del = GWF_PM::OWNER_DELETED;
			$cache = new self(array(
				'pmf_id' => $outbox,
				'pmf_uid' => $uid,
				'pmf_name' => GWF_PM::OUTBOX_NAME,
				'pmf_count' => GDO::table('GWF_PM')->countRows("pm_owner=$uid AND pm_folder=$outbox AND pm_options&$del=0"),
			));
		}
		return $cache;
	}
	
	##############
	### Select ###
	##############
	public static function getSelectS(Module_PM $module, $selected='0', $name='folders')
	{
		return self::getSelect($module, GWF_Session::getUser(), $selected, $name);
	}
	
	public static function getSelect(Module_PM $module, GWF_User $user, $selected='0', $name='folders')
	{
		$folders = self::getFolders($user->getID());
		$back = sprintf('<select name="%s">', $name);
		$back .= sprintf('<option value="0"%s>%s</option>', GWF_HTML::selected($selected==='0'), $module->lang('sel_folder'));
		foreach ($folders as $folder)
		{
			$fid = $folder->getVar('pmf_id');
			$back .= sprintf('<option value="%s"%s>%s</option>', $fid, GWF_HTML::selected($selected===$fid), $folder->display('pmf_name'));
		}
		$back .= '</select>';
		return $back;
	}
	
	###########################
	### Repair Folder Count ###
	###########################
	/**
	 * Recount messages per folder.
	 * The default in/outbox is not important.
	 * @return unknown_type
	 */
	public static function repairFolderCount()
	{
		return self::table(__CLASS__)->update("pmf_count=(SELECT COUNT(*) FROM ".GWF_TABLE_PREFIX.'pm'." WHERE pm_to_folder=pmf_id OR pm_from_folder=pmf_id)");
	}
}

?>