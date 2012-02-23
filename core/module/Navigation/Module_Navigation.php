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
 * @todo: gwf_buttons actions: edit, delete, show, hide, up, down (left, right?), visible, hidden, add
 * @todo: convert FormY to smarty
 * @todo: A module file is mostly 20 lines not 300
 * @todo: Make general menu editing module?
 * @todo caching into html files
 * @todo possibility to add an unique ID
 * @author spaceone
 * @since 01.11.2011
 * @version 0.06
 */
final class Module_Navigation extends GWF_Module
{
	public function getVersion() { return 0.06; }
	public function getClasses()
	{
		require_once GWF_CORE_PATH.'module/PageBuilder/GWF_Page.php';
		require_once GWF_CORE_PATH.'module/Category/GWF_Category.php';
		return array('GWF_Navigation', 'GWF_Navigations', 'GWF_NaviPage');
	}
	public function onLoadLanguage() { return $this->loadLanguage('lang/navigation'); }
	public function getOptionalDependencies() { return array('PageBuilder'); }
//	public function getDependencies() { return array(); }	//PageBuilder here?, Category, GWF_Tree?
	public function onInstall($dropTable) 
	{
		require_once GWF_CORE_PATH.'module/Navigation/GWF_NaviInstall.php';
		$ret = GWF_NaviInstall::onInstall($this, $dropTable);
		
	//	if(false !== ($foo = $this->installPageMenu(self::debugPM())))
	//	{
	//		var_dump($foo);
	//	}
		return $ret;
	}
	public function getAdminSectionURL() { return $this->getMethodURL('Admin'); }

	public static function debugPM()
	{
		return array('foomodule' => array(
			array(
				'page_url' => '/foo',
				'page_title' => 'foo',
				'page_lang' => '0',
				'page_cat' => '', 
				'page_meta_desc' => 'foofoo', 
				'page_views' => '0',
				'page_options' => GWF_Page::ENABLED,
			),
			false,
			array(
				'page_url' => '/bar',
				'page_title' => 'bar',
				'page_lang' => '0',
				'page_cat' => '', 
				'page_meta_desc' => 'barbar', 
				'page_views' => '0',
				'page_options' => GWF_Page::ENABLED,
			),
		));
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

		$categories = array();
		
		if(false === ($categories['Modules'] = GWF_Category::getByKey('Modules')))
		{
			# TODO: Create GWF_Category: Modules
		}

		# insert new entries
		$count = 0;
		foreach($pmdata as $modulename => $pbmodule)
		{
			#TODO: create GWF_Category for each module
			$catid = 0;
			
			#TODO: create GWF_Navigations for each Module
			$nid = '1';
			
			$i = 0;

			if (is_array($pbmodule))
			foreach($pbmodule as $methodname => $pbvars)
			{
				#TODO: Create Category for each Method?
				
				#TODO: create GWF_Navigations for each Method

				if(false === is_array($pbvars) || false === isset($pbvars['page_url']) || false === isset($pbvars['page_title']))
				{
					continue; # required entries does not exists
				}
				unset($pbvars['page_id']);

				# entries that need to exist
				$overwritable = array(
					'page_cat' => $catid,
					'page_views' => '0',
					'page_meta_desc' => '',
					'page_options' => GWF_Page::ENABLED
				);
				$pbvars = array_merge($overwritable, $pbvars);

				if(false === $pagevars->insertAssoc($pbvars)) 
				{
					return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__));
				}

				if(false === ($pb = $pagevars->selectFirst('page_id', "page_url='".$pbvars['page_url']."'")))
				{
					return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__));
				}
				$pbid = $pb['page_id']; # Check: No such page, impossible

				$navi = array(
					//'navi_id' => ++$i, # AUTO INCREMENT
					'navi_nid' => $nid, # the GWF_Navigations PageMenu navi_id
					'navi_pbid' => $pbid,
					'navi_position' => ++$i,
					'navi_options' => GWF_Navigation::ENABLED,
				);
				if(false === $navigation->insertAssoc($navi))
				{
					return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__));
				}
			}
			
			$count++;
			
			
			# The Module row for GWF_Navigations
			$pm = array(
				'navis_id' => $i, # TODO: Overwrite old Navi (getByName) #AUTO INCREMENT
				'navis_name' => $modulename,
				'navis_pid' => '1', # PageMenu ID
// 				'navi_position' => $i, ## TODO: $count ?
	//			'navis_gid' => '', # create groupid for PageMenuNavigation?
				'navis_count' => $count,
				'navis_options' => GWF_Navigations::ENABLED|GWF_Navigations::NONPBSITE,
			);

			# Replace the GWF_Navigations PageMenu row
			if(false === $navigations->insertAssoc($pm))
			{
					return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__)); 
			}
			
		}
		
		# The PageMenu row for GWF_Navigations
		$pm = array(
			'navis_id' => '1',
			'navis_name' => 'PageMenu',
			'navis_pid' => '0', # dont have parent Navigation
//			'navi_position' => '0',
//			'navis_gid' => '', # create groupid for PageMenuNavigation?
			'navis_count' => $count,
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
