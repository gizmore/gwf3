<?php
/**
 * Edit a category and it's translations.
 * @author gizmore
 */
final class Category_Edit extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	private static $cat = false;
	
	public function getHTAccess()
	{
		return 'RewriteRule ^category/edit/([0-9]+)/? index.php?mo=Category&me=Edit&catid=$1'.PHP_EOL;
	}
	
	public function execute()
	{
		if (false === ($cat = GWF_Category::getByID(Common::getGet('catid'))))
		{
			return $this->module->error('err_cat');
		}
		
		$cat->loadTranslations();
		
		self::$cat = $cat;
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($cat).$this->templateEdit($cat);
		}
		
		return $this->templateEdit($cat);
	}
	
	public function getForm(GWF_Category $cat)
	{
//		static $form = true;
//		if ($form === true)
//		{
			$data = array(
				'catid' => array(GWF_Form::SSTRING, $cat->getID(), $this->module->lang('th_catid')),
				'group' => array(GWF_Form::STRING, $cat->getGroup(), $this->module->lang('th_group')),
				'key' => array(GWF_Form::STRING, $cat->getKey(), $this->module->lang('th_key')),
				'parent' => array(GWF_Form::SELECT, $this->getParentSelect($cat), $this->module->lang('th_parent')),
				'div1' => array(GWF_Form::DIVIDER),
			);
			$data += $this->getFormLangs($cat);
			$data['div2'] = array(GWF_Form::DIVIDER);
			$data['new_trans'] = array(GWF_Form::HEADLINE, '', $this->module->lang('th_new_trans'));
			$data['langid'] = array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'langid'), $this->module->lang('th_langid'));
			$data['newtrans'] = array(GWF_Form::STRING, '', $this->module->lang('th_trans'));
			$data['edit'] = array(GWF_Form::SUBMIT, $this->module->lang('btn_edit'), '');
			$form = new GWF_Form($this, $data);
//		}
		return $form;
	}
	
	private function getParentSelect(GWF_Category $cat)
	{
		$id = $cat->getID();
		$group = $cat->getEscaped('cat_group');
		
		$data = array(array('0', $this->module->lang('sel_parent')));
		$table = GDO::table('GWF_Category');
		if (false !== ($result = $table->select('cat_tree_id, cat_tree_key', "cat_group='$group' AND cat_tree_id != $id")))
		{
			while (false !== ($row = $table->fetch($result, GDO::ARRAY_N)))
			{
				$data[] = $row;
			}
			$table->free($result);
		}
		return GWF_Select::display('parent', $data, Common::getPostString('parent', $cat->getParentID()));
	}
	
	private function getFormLangs(GWF_Category $cat)
	{
		$back = array();
		$trans = $cat->getTranslations();
		foreach ($trans as $key => $value)
		{
			$getkey = sprintf('trans[%s]', $value['cl_langid']);
			$lang = GWF_Language::getByID($value['cl_langid']);
			$back[$getkey] = array(GWF_Form::STRING, $value['cl_translation'], $lang->getVar('lang_name'));
		}
		return $back;
	}
	
	public function templateEdit(GWF_Category $cat)
	{
		$form = $this->getForm($cat);
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_edit', array( $cat->display('cat_tree_key')))),
			'cat' => $cat,
		);
		return $this->module->templatePHP('edit.php', $tVars);
	}
	
	public function validate_trans(Module_Category $module, $key)
	{
		return false;
	}

	public function validate_key(Module_Category $module, $key)
	{
		if (self::$cat->getKey() !== $key)
		{
			if (GWF_Category::keyExists($key)) {
				return $this->module->lang('err_dup_key');
			}
			elseif (!GWF_Category::isValidKey($key)) {
				return $this->module->lang('err_invalid_key');
			}
		}
		return false;
	}

	public function validate_langid(Module_Category $module, $langid)
	{
		if (!GWF_LangSelect::isValidLanguage($langid, true)) {
			$_POST['langid'] = 0;
			return $this->module->lang('err_invalid_langid');
		}
		
		if (self::$cat->getTranslation($langid) !== false) {
			$_POST['langid'] = 0;
			return $this->module->lang('err_dup_langid');
		}
		
		return false;
	}
	
	public function validate_newtrans(Module_Category $module, $s)
	{
		return false;
	}
	
	public function validate_group(Module_Category $module, $g)
	{
		return false;
	}
	
	public function validate_parent(Module_Category $module, $p)
	{
		if ($p === '0')
		{
			return false;
		}
		
		if ( ($p === self::$cat->getID()) || (false === ($cat = GWF_Category::getByID($p))) || ($cat->getGroup() !== self::$cat->getGroup()) )
		{
			return $this->module->lang('err_parent');
		}
		
		return false;
	}
	
	
	public function onEdit(GWF_Category $cat)
	{
		$keyOld = $cat->getKey();
		$form = $this->getForm($cat);
		if (false !== ($error = $form->validate($this->module))) {
			return $error;
		}

//		if ('' !== ($error = $form->validateVars(array('key', 'langid')))) {
//			return $error;
//		}
		
		// new translation
		$back = '';
		if (0 !== ($langid = (int)Common::getPost('langid', 0)))
		{
		
			$trans = Common::getPost('newtrans');
			if (false === $cat->saveTranslation($langid, $trans)) {
				return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
			}
			$back .= $this->module->message('msg_trans_added', array(GWF_Language::getByID($langid)->display('lang_name'), GWF_HTML::display($keyOld), GWF_HTML::display($trans)));
		}
		
		// change key!
		$keyNew = $form->getVar('key');
		if ($keyOld !== $keyNew)
		{
			$cat->saveVar('key', $keyNew);
			$back .= $this->module->message('msg_new_key', array(GWF_HTML::display($keyOld), GWF_HTML::display($keyNew)));
		}
		
		# Change tree
		$parent = $form->getVar('parent', '0');
		$oldpar = $cat->getParentID();
		if ($oldpar !== $parent)
		{
			if (!$cat->saveVar('cat_tree_pid', $parent))
			{
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
			else
			{
				$cat->rebuildFullTree();
				$back .= $this->module->message('msg_new_parent');
			}
		}
		
		if (!isset($_POST['trans']) || !is_array($_POST['trans']))
		{
			$_POST['trans'] = array();
		}
		# update translation
		foreach ($_POST['trans'] as $langid => $textNew)
		{
			$textOld = $cat->getTranslation($langid);
			if ($textNew !== $textOld) {
				if (false === $cat->saveTranslation($langid, $textNew))
				{
					return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
				}
				$langname = GWF_Language::getByID($langid)->display('lang_name');
				$back .= $this->module->message('msg_trans_changed', array($langname, GWF_HTML::display($textNew)));
			}
		}
		
		return $back;
	}
}

?>