<?php

final class GWF_UsergroupsInstall
{
	public static function onInstall(Module_Usergroups $module, $dropTable)
	{
		return GWF_ModuleLoader::installVars($module, array(
			'ug_level' => array('0', 'int', '0'),
			'ug_minlen' => array('3', 'int', '2', '12'), # DO NOT CHANGE BOUNDS!
			'ug_maxlen' => array('32', 'int', '12', '48'),
//			'ug_bid' => array('0', 'int', '0'),
			'ug_ipp' => array('25', 'int', '1', '500'),
			'ug_ax' => array('5', 'int', '1', '32'),
			'ug_ay' => array('5', 'int', '1', '32'),
			'ug_menu' => array('YES', 'bool'),
			'ug_submenu' => array('YES', 'bool'),
			'ug_submenugroup' => array('members', 'text', 0, GWF_Group::NAME_LEN),
			'ug_lvl_per_grp' => array('0', 'int', '0'),
			'ug_grp_per_usr' => array('1', 'int', '1'),
		));
//		self::installBoard($module, $dropTable);
	}

//	private static function installBoard(Module_Usergroups $module, $dropTable)
//	{
//		if (false === ($mod_forum = GWF_Module::getModule('Forum'))) {
//			return '';
//		}
//		$mod_forum->onInclude();
//		
//		if (false !== ($board = GWF_ForumBoard::getByTitle('Usergroups'))) {
//			$module->saveModuleVar('ug_bid', $board->getID());			
//		}
//		
//		$options = GWF_ForumBoard::GUEST_VIEW;
//		
//		if (false === ($board = GWF_ForumBoard::createBoard('Usergroups', 'Usergroup Forum Boards', 1, $options, 0))) {
//			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
//		}
//
//		$module->saveModuleVar('ug_bid', $board->getID());			
//		return '';
//	}
}

?>