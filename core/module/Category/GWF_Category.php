<?php
final class GWF_Category extends GWF_Tree
{
	const KEY_LENGTH = 64;
	public function getColumnPrefix() { return 'cat_'; }
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'category'; }
	public function getColumnDefines()
	{
		return array_merge(parent::getColumnDefines(), 
			array(
				'cat_group' => array(GDO::INDEX|GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', self::KEY_LENGTH),
// 				'translations' => array(GDO::GDO_ARRAY, GDO::NOT_NULL, array('GWF_CategoryTranslation', 'cl_langid', 'cl_catid', 'cat_tree_id'), array('cats')),
				'trans' => array(GDO::JOIN, true, array('GWF_CategoryTranslation', 'cat_tree_id', 'cl_catid')),
			));
	}
//	public function getColumnDefines()
//	{
//		return array(
////			'cat_id' => array(GDO::AUTO_INCREMENT),
////			'cat_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, true, self::KEY_LENGTH),
////			'cat_pid' => array(GDO::UINT|GDO::INDEX, 0),
////			'cat_group' => array(GDO::INDEX|GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, '', self::KEY_LENGTH),
////			'translations' => array(GDO::PR_ARRAY, 0 , array('GWF_CategoryTranslation', 'catid', 'catid'), 'langid'),
//		);
//	}
//	public function getID() { return $this->getVar('cat_id'); }
//	public function getKey() { return $this->getVar('cat_name'); }
//	public function getPID() { return $this->getVar('cat_pid'); }
	
	public function getGroup() { return $this->getVar('cat_group'); }
	
	public static function getAllCategoriesCached($orderby='cat_tree_key ASC', $group='')
	{
		static $cats;
		if (false === isset($cats))
		{
			$cats = self::getAllCategories($orderby);
		}
		return $cats;
	}
	
	public static function getAllCategories($orderby='cat_tree_key ASC', $group='')
	{
		$where = $group === '' ? '' : "cat_group='".self::escape($group)."'";
//		return self::table(__CLASS__)->selectObjects('*', $where, $orderby);
		return self::table(__CLASS__)->selectAll('*', $where, $orderby, array('trans'), -1, -1, GDO::ARRAY_O);
	}
	
	/**
	 * @param $key string
	 * @return GWF_Category
	 */
	public static function getByKey($key)
	{
		return self::table(__CLASS__)->getBy('cat_tree_key', $key);
	}
	
	/**
	 * @param $id int
	 * @return GWF_Category
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	public function loadTranslations()
	{
		$this->setVar('translations', $this->loadTranslationsB());
	}
	
	public function loadTranslationsB()
	{
		return GDO::table('GWF_CategoryTranslation')->selectArrayMap('cl_langid, cl_translation', 'cl_catid='.$this->getID());
	}
	
	public function getTranslations()
	{
		return $this->gdo_data['translations'];
	}
	
	public function getTranslation($langid)
	{
		return isset($this->gdo_data['translations'][$langid]['cl_translation']) ? $this->gdo_data['translations'][$langid]['cl_translation'] : false;
	}
	
	public static function keyExists($key)
	{
		return self::getByKey($key) !== false;
	}
	
	public function saveTranslation($langid, $text)
	{
		$catid = $this->getID();
		$langid = (int) $langid;
		$text = (string) $text;
		
		$trans = self::table('GWF_CategoryTranslation');
		if (false === ($t = $trans->getRow($catid, $langid))) {
			$t = new GWF_CategoryTranslation(array(
				'cl_catid' => $catid,
				'cl_langid' => $langid,
				'cl_translation' => $text,
			));
		} else {
			$t->setVar('cl_translation', $text);
		}
		
		if (false === $t->replace()) {
			return false;
		}
		
		$this->gdo_data['translations'][$langid] = array(
			'cl_catid' => $catid,
			'cl_langid' => $langid,
			'cl_translation' => $text
		);
		return true;
	}

	public static function isValidKey($key)
	{
		$key = (string) $key;
		$len = self::KEY_LENGTH;
		return preg_match('/^[a-zA-Z0-9_]{1,'.$len.'}$/D', $key) === 1;
	}
	
//	public function getGDOInput($key, $value)
//	{
//		$key = GWF_HTML::display($key);
//		if ($value === '' || $value <= 0) {
//			$value = false;
//		} else {
//			$value = (int) $value;
//		} 
//		
//		if (false === ($cats = self::getAllCategoriesCached('catid', 'DESC'))) {
//			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
//		}
//		
//		$back = sprintf('<select name="%s">', $key);
//		
//		$sel = $value === false ? ' selected="selected"' : '';
//		$back .= sprintf('<option value="0"%s>%s</option>', $sel, GWF_HTML::lang('sel_category'));
//		
//		
//		$langid = GWF_Language::getCurrentID();
//		
//		foreach ($cats as $cat)
//		{
//			$catid = $cat->getID();
//			$text = $cat->getTranslation($langid);
//			$sel = $value === $catid ? ' selected="selected"' : '';
//			$back .= sprintf('<option value="%s"%s>%s</option>', $catid, $sel, $text);
//		}
//		
//		$back .= '</select>';
//		return $back;
//	}
	
	public static function categoryExists($catid)
	{
		return self::getByID($catid) !== false;
	}
	
	public function getEditHREF()
	{
		return sprintf('%scategory/edit/%d-%s', GWF_WEB_ROOT, $this->getID(), $this->getKey());
	}
	
}

?>
