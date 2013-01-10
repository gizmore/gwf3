<?php
final class Category_Tree extends GWF_Method
{
	public function getUserGroups() { return array(GWF_Group::STAFF, GWF_Group::ADMIN); }
	
	public function execute()
	{
		return $this->templateTree();
	}
	
	private function templateTree()
	{
		$table = GDO::table('GWF_Category');
		
		$group = 'news';
		$egroup = $table->escape($group);
		
		$tVars = array(
			'group' => $group,
			'cats' => $table->selectAll('cat_tree_id id, cat_tree_key `key`, cat_tree_pid pid, cat_tree_left `left`, cat_tree_right `right`', "cat_group='$egroup'", 'cat_tree_pid asc', NULL, -1, -1, GDO::ARRAY_A),
		);
		return $this->module->templatePHP('tree.php', $tVars);
	}
}
?>
