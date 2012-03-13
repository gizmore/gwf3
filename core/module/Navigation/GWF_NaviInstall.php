<?php
/**
 * Install the Navigation module
 * Install PageMenu
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

	public static function PageMenuExists()
	{
		$t = GDO::table('GWF_Navigations');
		return 1 === $t->countRows('navis_name=\'PageMenu\'');
	}

	/**
	 * Parse all Module-pagemenu entries into valid format
	 * @author spaceone
	 * @return array accociative array
	 */
	public static function parseModules(array $modules)
	{
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
	 * Create a PageMenu-GWF_Category
	 * @return int ID
	 */
	public static function createPageMenuCategory()
	{
		require_once GWF_CORE_PATH.'module/Category/Module_Category.php';
		# TODO: get module...
		# TODO: isEnabled
		if(false === ($cat = GWF_Category::getByKey('PageMenu')))
		{
			# TODO: Create GWF_Category: PageMenu
			return 0;
		}
		return $cat->getId();
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
	 * @param array $pmarray = array of GWF_NaviPage Rows
	 * @todo GWF_Exception
	 * @todo navi_pbid bug
	 * @todo encapsulate
	 * 	remove old pagemenu: recursive in GWF_Navigations
	 * 	possibility to merge old PageMenu?
	 * @return true|string|GWF_Exception # TODO
	 */
	public static function installPageMenu2(array $pmarray)
	{
		# Are there PageMenu entries?
		if (0 === count($pmarray))
		{
			return true;
		}
		
		# Create Instances
		$navigation = GDO::table('GWF_Navigation');
		$pagevars = GDO::table('GWF_NaviPage');
		
		if (false === ($navigations = GWF_Navigations::getByName('PageMenu')))
		{
			# There is no PageMenu yet
			$navigations = GDO::table('GWF_Navigations');
		}
		else
		{
			# recursive remove old PageMenu
			# TODO: merging possibility?
			if (false === GWF_Navigations::deleteNavigation('PageMenu'))
			{
				return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__)); 
			}
		}

		# The PageMenu row for GWF_Navigations
		$pm = array(
		//	'navis_id' => '1', # AUTO INCREMENT
			'navis_name' => 'PageMenu',
			'navis_pid' => '0', # dont have parent Navigation
		//	'navi_position' => '0',
		//	'navis_gid' => '', # create groupid for PageMenuNavigation?
		//	'navis_count' => 0, # default
			'navis_options' => GWF_Navigations::ENABLED|GWF_Navigations::NONPBSITE,
		);

		# Insert the new GWF_Navigations PageMenu row
		if(false === $navigations->insertAssoc($pm))
		{
			return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__));
		}

		$pmid = 1; # TODO: get the PageMenu ID
		$catid = createPageMenuCategory();
		$count = 0;

		foreach ($pmarray as $modulename => $pbmodule)
		{
			# The $modulename-Module row for GWF_Navigations
			$pm = array(
			//	'navis_id' => '0', # AUTO INCREMENT
				'navis_name' => $modulename,
				'navis_pid' => $pmid, # parent-id: PageMenu ID
 			//	'navis_position' => $count, # currently not existent # TODO: get old value
			//	'navis_gid' => '', # create groupid for PageMenuNavigation?
			//	'navis_count' => $count, # set later
				'navis_options' => GWF_Navigations::ENABLED|GWF_Navigations::NONPBSITE,
			);

			# Insert the GWF_Navigations $modulename row
			if(false === $navigations->insertAssoc($pm))
			{
				return GWF_HTML::error('ERR_DATABASE', array(__FILE__, __LINE__));
				# continue ?
			}

			$modulecount = 0;
			$count++; # increase count because module have been added
			$nid = '1'; # TODO: get $modulename-Navigation ID

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

			if ($modulecount === 0)
			{
				# TODO: remove the $modulename-Navigation
			}
			else
			{
				$navigations->set("navis_count = '{$modulecount}'", "navis_name='{$modulename}'");
			}
		}
		$navigations->set("navis_count = '{$count}'", 'navis_name=\'PageMenu\'');
		
		return true;
	}
	
}
