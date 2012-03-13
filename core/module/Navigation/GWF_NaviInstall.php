<?php
/**
 * Description of GWF_NaviInstall
 *
 * @author spaceone
 */
class GWF_NaviInstall
{
	public static function onInstall(Module_Navigation $module, $dropTable) 
	{
		return GWF_ModuleLoader::installVars($module, array(
			'lockedPM' => array('0', 'bool'),
		));
	}


	/**
	 * Parse all Module-pagemenu entries into valid format
	 * @author spaceone
	 * @return array accociative array
	 */
	public static function parseModules(array $modules)
	{
		$navigation = GWF_Module::loadModuleDB('Navigation', false, false, true);

		if ((false === $navigation) 
			|| (false === $navigation->isEnabled()) 
		//	|| (false === $navigation->cfgLockedPageMenu())
		)
		{
			return false; //Module Navigation not enabled or cannot be modified!
		}

		$pml = array();
		$c = 2; # page_url, page_title
		foreach ($modules as $module)
		{
			$module instanceof GWF_Module;

			if (false === $module->isEnabled()) {
				continue;
			}

			$name = $module->getName();
			$pml[$name] = array();

			$methods = GWF_ModuleLoader::getAllMethods($module);
			foreach ($methods as $method)
			{
				$mname = $method->getName();
				$pml[$name][$mname] = array();

				if(true === is_array($pmlinks = $method->getPageMenuLinks()))
				{
					foreach($pmlinks as $k => $a)
					{
						if(false === is_array($a) || count($a) < $c)
						{
							unset($pmlinks[$k]);
						}
						else
						{
							# set permissions, overwritable
							$groups = $method->getUserGroups();
							$groups = $groups ? implode(',', (array)$groups) : '';
							$pmlinks[$k] = array_merge(array('page_groups' => $groups), $a);
						}
					}
					$pml[$name][$mname] = $pmlinks;
				}
				# Method does not have PageMenu Links?
				if(true === empty($pml[$name][$mname]))
				{
					unset($pml[$name][$mname]);
				}
			}
			# Module does not have PageMenu Links?
			if(true === empty($pml[$name]))
			{
				unset($pml[$name]);
			}
		}
		return $pml;
	}
	
	/**
	 * Install the PageMenu for all Modules.
	 *
	 * @return #TODO
	 */
	public static function installPageMenu()
	{
		$pagemenulinks = self::parseModules(GWF_ModuleLoader::loadModulesFS());
		return self::installPageMenu2($pagemenulinks);
	}
	
	/**
	 * Install the PageMenu
	 * @param array $pmdata = array of GWF_NaviPage Rows
	 * @todo GWF_Exception
	 * @todo navi_pbid bug
	 * @todo encapsulate
	 * 	remove old pagemenu: recursive in GWF_Navigations
	 * 	possibility to merge old PageMenu?
	 * @return true|false|string|GWF_Exception # TODO
	 */
	public static function installPageMenu2(array $pmdata)
	{
		# Are there PageMenu entries?
		if(0 === count($pmdata))
		{
			return false; # TODO: return true?
		}
		
		# Create Instances
		$navigation = GDO::table('GWF_Navigation');
		$pagevars = GDO::table('GWF_NaviPage');
		
		if(false === ($navigations = GWF_Navigations::getByName('PageMenu')) ) # empty array??
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
		//	# DECIDE: create only a (one) PageMenu category?
		//	#TODO: create GWF_Category for each module
		//	$catid = 0;
			
			#TODO: create GWF_Navigations for each Module
			$nid = '1';
			
			$i = 0;

			# TODO: only check values here, dont insert
			if (is_array($pbmodule))
			foreach($pbmodule as $methodname => $pbvars)
			{
				#TODO: Create Category for each Method?

				$pbvars = $pbvars[0];
				if(false === is_array($pbvars) || false === isset($pbvars['page_url']) || false === isset($pbvars['page_title']))
				{
					unset($pbmodule[$methodname]);
					continue; # required entries does not exists
				}
				unset($pbvars['page_id']);

				# entries that need to exist
				$overwritable = array(
				//	'page_cat' => $catid,
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
					'navi_nid' => $nid, # the GWF_Navigations navis_id (pid of modulenavis)
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
		
		return true;
	}
	
}
