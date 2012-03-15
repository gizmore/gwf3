<?php
/**
 * All Entries for navigations.
 * @decide delete GWF_NaviPage, replace by GWF_Page
 * @author spaceone
 */
final class GWF_Navigation extends GDO
{
	const ENABLED = 0x01; // VISIBLE ?
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'navigation'; }
	public function getOptionsName() { return 'navi_options'; }
	public function getColumnDefines()
	{
		require_once GWF_CORE_PATH.'module/PageBuilder/GWF_Page.php';		
		return array(
			'navi_id' => array(GDO::AUTO_INCREMENT),
			'navi_nid' => array(GDO::UINT, GDO::NOT_NULL), # => navis_id
			'navi_pbid' => array(GDO::UINT, GDO::NOT_NULL), # => page_id
			'navi_position' => array(GDO::INT|GDO::INDEX, GDO::NOT_NULL), # '-1' ?
			'navi_options' => array(GDO::UINT, self::ENABLED),
			'navi_pbvars' => array(GDO::JOIN, GDO::NULL, array('GWF_Page', 'navi_pbid', 'page_id')), # pagebuilder vars
			'navi_vars' => array(GDO::JOIN, GDO::NULL, array('GWF_NaviPage', 'navi_pbid', 'page_id')), # page vars without PB e.g. for PageMenu
		);
	}
	
	public function getID() { return $this->getVar('navi_id'); }
	public function getNID() { return $this->getVar('navi_nid'); }
	public function getPBID() { return $this->getVar('navi_pbid'); }
	public function getPosition() { return $this->getVar('navi_position'); }

	public function isVisible() { return $this->isOptionEnabled(self::ENABLED); }

	public function hrefDelete() { return GWF_WEB_ROOT.'navigation/edit/delete/'.$this->getID(); }
	public function hrefHide($nid) { return sprintf(GWF_WEB_ROOT.'navigation/edit/%s/hide/%s', $nid, $this->getID()); }
	public function hrefShow($nid) { return sprintf(GWF_WEB_ROOT.'navigation/edit/%s/show/%s', $nid, $this->getID()); }
	public function hrefUp($nid) { return sprintf(GWF_WEB_ROOT.'navigation/edit/%s/up/%s', $nid, $this->getID()); }
	public function hrefDown($nid) { return sprintf(GWF_WEB_ROOT.'navigation/edit/%s/down/%s', $nid, $this->getID()); }
	public function hrefPageEdit() { return ''; }

	public function displayTitle() { return $this->display('page_title'); }
	public function displayURL() { return $this->display('page_url'); }
	public function displayDescr() { return $this->display('page_meta_desc'); }
	
	/**
	 * Get the parent navigations for this navigation.
	 * @return GWF_Navigations
	 */
	public function getNavigations() { return GWF_Navigations::getByID($this->getNID()); }

	/**
	 * get a single Navigation by it's id
	 * @param int $nid
	 * @return GWF_Navigation
	 * @todo test if PB site exists
	 * @todo cleanup (joins on GWF_Navigations?)
	 */
	public static function getNavigation($nid)
	{
		$cols = 't.*, page_id, page_url, page_title, page_lang, page_cat, page_meta_desc, page_views, page_groups, page_options';

		$pb = GWF_Navigations::getByID($nid)->isnotPB() ? 'navi_vars' : 'navi_pbvars';
		
		return self::table(__CLASS__)->selectAll($cols, "navi_nid={$nid}", 'navi_position', array($pb), '-1', '-1', GDO::ARRAY_O);
	}
	/**
	 * Delete a Navigation and all GWF_NaviPage Entries
	 * @param int $nid
	 * @param boolean $pb is a PageBuilder Navigation?
	 * @return boolean
	 */
	public static function onDelete($nid, $pb=false)
	{
		$t = self::table(__CLASS__);
		if($pb)
		{
			$success = true;
			$ids = $t->selectAll('navi_pbid', "navi_nid = '{$nid}'");
			# TODO: only if count(*) where nid = $nid == 1
			foreach ($ids as $id)
			{
				if (false === GWF_NaviPage::onDelete($id['navi_pbid']))
				{
					$success = false;
				}
			}
		}
		return GDO::table(__CLASS__)->deleteWhere("navi_nid = '{$nid}'");
	}

	/**
	 * get a Navigation Row/Entry by ID
	 * @param int $id
	 * @return GWF_Navigation
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	/**
	 * Get all Navigationentries by it's nid name
	 * @param string $name
	 * @return GWF_Navigation
	 */
	public static function getByName($name)
	{
		$nid = GWF_Navigations::getIdByName($name);
		return self::getNavigation($nid);
	}	
}
