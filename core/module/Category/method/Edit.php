<?php

final class Category_Edit extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	private static $cat = false;
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^category/edit/([0-9]+)/? index.php?mo=Category&me=Edit&catid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		if (false === ($cat = GWF_Category::getByID(Common::getGet('catid')))) {
			return $module->error('err_cat');
		}
		
		self::$cat = $cat;
		
		if (false !== (Common::getPost('edit'))) {
			return $this->onEdit($module, $cat).$this->templateEdit($module, $cat);
		}
		
		return $this->templateEdit($module, $cat);
	}
	
	public function getForm(Module_Category $module, GWF_Category $cat)
	{
//		static $form = true;
//		if ($form === true)
//		{
			$data = array(
				'catid' => array(GWF_Form::SSTRING, $cat->getID(), $module->lang('th_catid')),
				'group' => array(GWF_Form::STRING, $cat->getGroup(), $module->lang('th_group')),
				'key' => array(GWF_Form::STRING, $cat->getKey(), $module->lang('th_key')),
				'div1' => array(GWF_Form::DIVIDER),
			);
			$data += $this->getFormLangs($module, $cat);
			$data['div2'] = array(GWF_Form::DIVIDER);
			$data['new_trans'] = array(GWF_Form::HEADLINE, '', $module->lang('th_new_trans'));
			$data['langid'] = array(GWF_Form::SELECT, GWF_LangSelect::single(1, 'langid'), $module->lang('th_langid'));
			$data['newtrans'] = array(GWF_Form::STRING, '', $module->lang('th_trans'));
			$data['edit'] = array(GWF_Form::SUBMIT, $module->lang('btn_edit'), '');
			$form = new GWF_Form($this, $data);
//		}
		return $form;
	}
	
	private function getFormLangs(Module_Category $module, GWF_Category $cat)
	{
		$back = array();
		$trans = $cat->getVar('translations');
//		var_dump($trans);
		foreach ($trans as $key => $value)
		{
			$getkey = sprintf('trans[%s]', $value['langid']);
			$lang = GWF_Language::getByID($value['langid']);
			$back[$getkey] = array(GWF_Form::STRING, $value['translation'], $lang->getNativeName());
		}
		return $back;
	}
	
	public function templateEdit(Module_Category $module, GWF_Category $cat)
	{
		$form = $this->getForm($module, $cat);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_edit', array( $cat->display('cat_tree_key')))),
			'cat' => $cat,
		);
		return $module->templatePHP('edit.php', $tVars);
	}
	
	public function validate_key(Module_Category $module, $key)
	{
		if (self::$cat->getKey() !== $key)
		{
			if (GWF_Category::keyExists($key)) {
				return $module->lang('err_dup_key');
			}
			elseif (!GWF_Category::isValidKey($key)) {
				return $module->lang('err_invalid_key');
			}
		}
		return false;
	}

	public function validate_langid(Module_Category $module, $langid)
	{
		if (!GWF_LangSelect::isValidLanguage($langid, true)) {
			$_POST['langid'] = 0;
			return $module->error('err_invalid_langid');
		}
		
		if (self::$cat->getTranslation($langid) !== false) {
			$_POST['langid'] = 0;
			return $module->lang('err_dup_langid');
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
	
	public function onEdit(Module_Category $module, GWF_Category $cat)
	{
		$keyOld = $cat->getKey();
		$form = $this->getForm($module, $cat);
		if (false !== ($error = $form->validate($module))) {
			return $error;
		}

//		if ('' !== ($error = $form->validateVars($module, array('key', 'langid')))) {
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
			$back .= $module->message('msg_trans_added', array(GWF_Language::displayNativeByID($langid), GWF_HTML::display($keyOld), GWF_HTML::display($trans)));
		}
		
		// change key!
		$keyNew = $form->getVar('key');
		if ($keyOld !== $keyNew)
		{
			$cat->saveVar('key', $keyNew);
			$back .= $module->message('msg_new_key', array(GWF_HTML::display($keyOld), GWF_HTML::display($keyNew)));
		}
		
		if (!isset($_POST['trans']) || !is_array($_POST['trans'])) {
			$_POST['trans'] = array();
		}
		
//		var_dump($_POST);
		// update translation
		foreach ($_POST['trans'] as $langid => $textNew)
		{
			$textOld = $cat->getTranslation($langid);
			if ($textNew !== $textOld) {
				if (false === $cat->saveTranslation($langid, $textNew)) {
					return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__));
				}
				
				$back .= $module->message('msg_trans_changed', array(GWF_Language::displayNativeByID($langid), GWF_HTML::display($textNew)));
			}
//			var_dump($langid);
//			var_dump($textNew);
//			var_dump($textOld);
		}
		
		return $back;
	}
}

?>