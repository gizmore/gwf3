<?php
/**
 * All Navigations
 * @author spaceone
 */
final class GWF_Navigations extends GDO
{
	const ENABLED = 0x01;
	const NONPBSITE = 0x02;
	const LOCKED = 0x04;
//	const SUBNAVI = 0x08; // needet / maybe usefull for select?

	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'navigations'; }
	public function getOptionsName() { return 'navis_options'; }
	public function getColumnDefines()
	{
		return array(
			'navis_id' => array(GDO::AUTO_INCREMENT),
			'navis_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::UNIQUE, GDO::NOT_NULL, 255), # navi_key
			'navis_pid' => array(GDO::UINT, GDO::NULL), # nested Navigations
//			'navis_position' => array(GDO::INT|GDO::INDEX, '0'), # if isSubNavi the position in the parent navigation//GDO::NULL ?
//			'navis_gid' => array(GDO::UINT, GDO::NULL), # allow moderate by groupid?
			'navis_count' => array(GDO::UINT, 0),
			'navis_options' => array(GDO::UINT, self::ENABLED),
		);
	}
	public function getID() { return $this->getVar('navis_id'); }
	public function getPID() { return $this->getVar('navis_pid'); }
	public function getName() { return $this->getVar('navis_name'); }
	public function getCount() { return $this->getVar('navis_count'); }
//	private function getGroups() 
//	{
//		$gids = explode(',', $this->getVar('navi_gid'));
//		foreach ($gids as $i => $gid) {
//			if ($gid === '' || $gid === '0') 
//			{
//				unset($gids[$i]);
//			}
//		}
//		return $gids;
//	}

//	/**
//	 * If you have navigation in navigation: get the sub Navigation
//	 * This must be replaced by GWF_Tree
//	 * @return false|array(GWF_Navigations)
//	 */
//	public function getSubNavigations()
//	{
//		$id = $this->getID();
//		$joins = NULL;
//		if($this->isSubNavi())
//		{
//			return self::table(__CLASS__)->selectAll('*', 'navis_pid = '.$id, 'navis_position', $joins, '-1', '-1', GDO::ARRAY_O);
//		}
//		return false;
//	}

	public function isEnabled() { return $this->isOptionEnabled(self::ENABLED); }
	public function isnotPB() { return $this->isOptionEnabled(self::NONPBSITE); }
//	public function isSubNavi() { return '0' !== $this->getVar('navi_pid'); }
//	//public function hasSubNavis() { return select count where navi_pid == id }

	public function displayName() { return $this->display('navis_name'); } // @deprecated?
//	public function displayGroups()
//	{
//		$groups = '';
//		foreach($this->getGroups() as $gid)
//		{
//			$g = GWF_Group::getByID($gid);
//			$groups .= $g->display('group_name').' ';
//		}
//		return $groups;
//	}

	public function hrefEdit() { return sprintf(GWF_WEB_ROOT.'navigation/edit/%s/%s',$this->getID(), $this->displayName()); }
	public function hrefDelete() { return GWF_WEB_ROOT.'navigation/admin/delete/'.$this->getID(); }
	public function hrefNew() { return GWF_WEB_ROOT.'navigation/admin/new'; }

	/**
	 * get All Navigations as an GWF_Navigations Object
	 * @return array
	 */
	public static function getNavigations()
	{
		return self::table(__CLASS__)->selectAll('*', '', '', NULL, '-1', '-1', GDO::ARRAY_O);
	}
	
	/**
	 * get a Navigations thread by name
	 * @param String $name
	 * @return GWF_Navigations
	 */
	public static function getByName($name)
	{
		return self::table(__CLASS__)->getBy('navis_name', $name, GDO::ARRAY_O);
	}
	/**
	 * Get a Navigations thread by ID.
	 * @param int $id
	 * @return GWF_Navigations
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}

	/**
	 * get a ID by Navigation Name
	 * @return int
	 */
	public static function getIdByName($name)
	{
		$id = self::table(__CLASS__)->selectFirst('navis_id', "navis_name='{$name}'");
		return (int)$id['navis_id'];
	}

	/**
	 * Recursive remove a Navigation
	 * @param string|int Name or id
	 * @return boolean
	 */
	public static function deleteNavigation($navi)
	{
		if (is_numeric($navi))
		{
			$nid = $navi;
			$navis = self::getByID($nid);
		}
		else
		{
			$navis = self::getByName($navi);
			$nid = $navis->getID();
		}

		if(false === GWF_Navigation::onDelete($nid, $navis->isnotPB()))
		{
			return false;
		}

		return self::getByID($nid)->delete();
	}
}
