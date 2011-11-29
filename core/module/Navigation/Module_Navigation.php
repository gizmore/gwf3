<?php
/**
 * This module can build HTML-Navigations.
 * All GWF modules can entry in one PageMenu-Navigation.
 * You can build your own Navigations from Pagebuilder sites.
 * @todo let PageBuilder add pages on pagecreation
 * @todo meShow: add CSS for each navigation, select template
 * @todo (sub)Navigation overviewpage
 * @todo WeChall: Overview page for challenges
 * @todo extending GWF_Tree
 * @todo lock a navigation, protect before modifying
 * @todo title translation
 * @todo copy navigation
 * @todo Method: LinkParser for Links like CMS/(<sec>.*)/(<cat>.*)/link
 * @TODO: policy and module settings for the PageMenu Order... Maybe in this module
 * @decide allow to edit PageMenu? only copy it for editing? only do it via modulecars?
// TODO: gwf_buttons actions: edit, delete, show, hide, up, down (left, right?), visible, hidden, add
// TODO: convert FormY to smarty
 * @author spaceone
 * @since 01.11.2011
 * @version 0.06
 */
final class Module_Navigation extends GWF_Module
{
	public function getVersion() { return 0.06; }
	public function getClasses() { return array('GWF_Navigation', 'GWF_Navigations', 'GWF_NaviPage'); }
	public function onLoadLanguage() { return $this->loadLanguage('lang/navigation'); }
	public function getOptionalDependencies() { return array('PageBuilder'); }
//	public function getDependencies() { return array(); }	//PageBuilder here?, Category, GWF_Tree?
	public function onInstall($dropTable) 
	{
		require_once GWF_CORE_PATH.'module/Navigation/GWF_NaviInstall.php';
		$ret = GWF_NaviInstall::onInstall($this, $dropTable);
		
		if(false !== ($foo = $this->installPageMenu(self::debugPM())))
		{
			Common::var_dump($foo);
		}
		return $ret;
	}
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }

	public static function debugPM()
	{
		return array(
			array(
				'page_url' => '/foo',
				'page_title' => 'foo',
				'page_lang' => '0',
				'page_cat' => '',#$module->getPMCat(), 
				'page_meta_desc' => 'foofoo', 
				'page_views' => '0',
				'page_options' => GWF_Page::ENABLED,
			),
			false,
			array(
				'page_url' => '/bar',
				'page_title' => 'bar',
				'page_lang' => '0',
				'page_cat' => '',#$module->getPMCat(), 
				'page_meta_desc' => 'barbar', 
				'page_views' => '0',
				'page_options' => GWF_Page::ENABLED,
			),
		);
	}
	
	public function cfgLockedPageMenu() { return $this->getModuleVarBool('lockedPM'); }

	public function canModerate()
	{
		return false === ($user = GWF_Session::getUser()) ? false : $user->isStaff();
	}
	/**
	 * Install the PageMenu for all Modules.
	 * @param array $pmdata = a GWF_NaviPage Row
	 * @return false|String
	 * @todo navi_pbid bug
	 * @decide static? Cannot lock the navi then?!
	 */
	public function installPageMenu(array $pmdata)
	{
		# PageMenu editing has been disabled?
//		if(false === GWF_Navigations::getByID('1')->isOptionEnabled(GWF_Navigations::LOCKED))
		if($this->cfgLockedPageMenu())
		{
			return $this->error('ERR_LOCKED');
		}
		
		# Are there PageMenu entries?
		if(0 === count($pmdata))
		{
			return false;
		}
		
		# Create Instances
		$navigation = GDO::table('GWF_Navigation');
		$pagevars = GDO::table('GWF_NaviPage');
		
		if(false === ($navigations = GWF_Navigations::getByName('PageMenu')) )
		{
			# There is no PageMenu yet
			$navigations = GDO::table('GWF_Navigations');
		}

		# remove old entries
		if(false === ($pbids = $navigation->selectAll('navi_pbid', 'navi_nid = 1')) || false === $navigation->deleteWhere('navi_nid = 1'))
		{
			return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__)); 
		}

		foreach($pbids as $id)
		{
			if(false === $pagevars->deleteWhere("page_id = {$id['navi_pbid']}"))
			{
				return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__)); 
			}
		}
		
		# insert new entries
		$i = 0;
		foreach($pmdata as $pbvars)
		{
			if(!is_array($pbvars)) {
				continue;
			}
			$navi2 = array(
				'navi_id' => ++$i,
				'navi_nid' => '1', # the GWF_Navigations PageMenu navi_id
				'navi_pbid' => $i, //$pbvars['page_id'] → both wont work because auto_increment_IDs
				'navi_position' => $i,
				'navi_options' => GWF_Navigation::VISIBLE,
			);
			# add page_id to the page_vars // other direction? // add page_cat page_views page_options?
			$array1 = array('page_id' => $i, 'page_views' => 0); # replacements
			$array3 = array('page_cat' => '', 'page_options' => GWF_Page::ENABLED); # overwritable
			//$pbvars = array_merge($pbvars, array());
			$pbvars = $array3 + $pbvars + $array1;
			if(false === $pagevars->insertAssoc($pbvars) || false === $navigation->insertAssoc($navi2)) 
			{
				return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		# The PageMenu row for GWF_Navigations
		$pm = array(
			'navis_id' => '1',
			'navis_name' => 'PageMenu',
			'navis_pid' => '0', # dont have parent Navigation
//			'navi_position' => '0'
//			'navis_gid' => '', # create groupid for PageMenuNavigation?
			'navis_count' => $i,
			'navis_options' => GWF_Navigations::ENABLED|GWF_Navigations::NONPBSITE,
		);
		
		# Replace the GWF_Navigations PageMenu row
		if(false === $navigations->insertAssoc($pm))
		{
				return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__)); 
		}
		
		# everything is okay
		return false;
	}
}
