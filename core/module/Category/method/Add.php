<?php
/**
 * Add a category.
 * @author gizmore
 */
final class Category_Add extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function getHTAccess()
	{
		return 'RewriteRule ^category/add/?$ index.php?mo=Category&me=Add'.PHP_EOL;
//		return $this->getHTAccessMethod();
	}
	
	public function getPageMenuLinks()
	{
		return array(
				array(
						'page_url' => 'category/add',
						'page_title' => 'Add Category',
						'page_meta_desc' => 'Add a new category',
				),
		);
	}
	
	public function execute()
	{
		if (false !== (Common::getPost('add'))) {
			return $this->onAdd();
		}
		return $this->templateAdd();
	}
	
	private function getForm()
	{
		$data = array(
			'key' => array(GWF_Form::STRING, '', $this->module->lang('th_key')),
			'group' => array(GWF_Form::STRING, '', $this->module->lang('th_group')),
			'add' => array(GWF_Form::SUBMIT, $this->module->lang('btn_add')),
		);
		return new GWF_Form($this, $data);
	}
	
	private function templateAdd()
	{
		$form = $this->getForm();
		$tVars = array(
			'form' => $form->templateY($this->module->lang('ft_add')),
		);
		return $this->module->template('add.tpl', $tVars);
	}
	
	public function validate_key(Module_Category $module, $key)
	{
		$key = (string) $key;
		if (($key === '') || (strlen($key) > GWF_Category::KEY_LENGTH)) {
			return $this->module->lang('err_invalid_key', array( GWF_Category::KEY_LENGTH));
		}
		if (GWF_Category::keyExists($key)) {
			return $this->module->lang('err_dup_key');
		}
		return false;
	}

	public function validate_group(Module_Category $module, $key)
	{
		return false;
	}
	
	private function onAdd()
	{
		$form = $this->getForm();
		if (false !== ($errors = $form->validate($this->module))) {
			return $errors.$this->templateAdd();
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
			return GWF_HTML::err('ERR_DATABASE', array( __FILE__, __LINE__)).$this->templateAdd();
		}
		
		$cat->rebuildFullTree();
		
		return $this->module->message('msg_added');
	}
}

?>
