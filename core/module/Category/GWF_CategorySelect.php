<?php
final class GWF_CategorySelect
{
	public static function single($name, $selected, $parent_id=0)
	{
		if (false === ($mod_cat = GWF_Module::loadModuleDB('Category', true, true)))
		{
			return GWF_HTML::err('ERR_MODULE_MISSING', array('Category'));
		}
		
		$langid = GWF_Language::getCurrentID();
		$data = array();
		$data[] = array('0', $mod_cat->lang('th_sel'));
		if (false !== ($cats = GWF_Category::getAllCategoriesCached()))
		{
			foreach ($cats as $cat)
			{
				$cat instanceof GWF_Category;
				$cat->loadTranslations();
				$trans = $cat->getTranslation($langid);
				$data[] = array($cat->getID(), false !== $trans ? $trans : $cat->getVar('cat_tree_key'));
			}
		}
		return GWF_Select::display($name, $data, $selected);
	}
	
	public static function validateCat($arg, $allowZero=true)
	{
		if ( ( ($arg == 0) && ($allowZero) ) || (GWF_Category::categoryExists($arg)) )
		{
			return false;
		}
		return GWF_Module::loadModuleDB('Cateogry', false, true)->lang('err_cat');
	}
}
?>