<?php
/**
 * Add a category.
 * @author gizmore
 */
final class Category_Add extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^category/add/?$ index.php?mo=Category&me=Add'.PHP_EOL;
//		return $this->getHTAccessMethod($module);
	}
	
	public function execute(GWF_Module $module)
	{
		if (false !== (Common::getPost('add'))) {
			return $this->onAdd($module);
		}
		return $this->templateAdd($module);
	}
	
	private function getForm(Module_Category $module)
	{
		$data = array(
			'key' => array(GWF_Form::STRING, '', $module->lang('th_key'), GWF_Category::KEY_LENGTH),
			'group' => array(GWF_Form::STRING, '', $module->lang('th_group'), GWF_Category::KEY_LENGTH),
			'add' => array(GWF_Form::SUBMIT, $module->lang('btn_add'), ''),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAdd(Module_Category $module)
	{
		$form = $this->getForm($module);
		$tVars = array(
			'form' => $form->templateY($module->lang('ft_add')),
		);
		return $module->templatePHP('add.php', $tVars);
	}
	
	public function validate_key(Module_Category $module, $key)
	{
		$key = (string) $key;
		if (($key === '') || (strlen($key) > GWF_Category::KEY_LENGTH)) {
			return $module->lang('err_invalid_key', array( GWF_Category::KEY_LENGTH));
		}
		if (GWF_Category::keyExists($key)) {
			return $module->lang('err_dup_key');
		}
		return false;
	}

	public function validate_group(Module_Category $module, $key)
	{
		return false;
	}
	
	private function onAdd(Module_Category $module)
	{
		$form = $this->getForm($module);
		if (false !== ($errors = $form->validate($module))) {
			return $errors.$this->templateAdd($module);
		}
		$cat = new GWF_Category(array(
			'cat_tree_id' => 0,
			'cat_tree_key' => $form->getVar('key'),
			'cat_tree_pid' => 0,
			'cat_tree_left' => 0,
			'cat_tree_right' => 0,
			'cat_group' => $form->getVar('group'),
		));
		if (false === ($cat->insert())) {
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd($module);
		}
		
		$cat->rebuildFullTree();
		
		return $module->message('msg_added');
	}
}

?>