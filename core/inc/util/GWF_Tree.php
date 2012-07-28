<?php
/**
 * Abstract Tree class stolen from http://articles.sitepoint.com/article/hierarchical-data-database/3
 * @author gizmore
 */
abstract class GWF_Tree extends GDO
{
	public abstract function getColumnPrefix();# { return 'tree_'; }

	###########
	### GDO ###
	###########
	public function getColumnDefines()
	{
		$pre = $this->getColumnPrefix();
		return array(
			$pre.'tree_id' => array(GDO::AUTO_INCREMENT),
			$pre.'tree_key' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, GDO::NOT_NULL, 255),
			$pre.'tree_pid' => array(GDO::UINT|GDO::INDEX),
			$pre.'tree_left' => array(GDO::UINT|GDO::INDEX),
			$pre.'tree_right' => array(GDO::UINT|GDO::INDEX),
		);
	}
	public function getIDColumn() { return $this->getColumnPrefix().'tree_id'; }
	public function getID() { return $this->getVar($this->getIDColumn()); }
	public function getKeyColumn() { return $this->getColumnPrefix().'tree_key'; }
	public function getKey() { return $this->getVar($this->getKeyColumn()); }
	public function getLeftColumn() { return $this->getColumnPrefix().'tree_left'; }
	public function getLeft() { return $this->getVar($this->getLeftColumn()); }
	public function getRightColumn() { return $this->getColumnPrefix().'tree_right'; }
	public function getRight() { return $this->getVar($this->getRightColumn()); }
	public function getParentColumn() { return $this->getColumnPrefix().'tree_pid'; }
	public function getParentID() { return $this->getVar($this->getParentColumn()); }

	public function getTree()
	{
		$pre = $this->getColumnPrefix();
		$left = $pre.'tree_left';
		$l = $this->getLeft();
		$r = $this->getRight();
		return $this->selectAll("{$pre}tree_id, {$pre}tree_name", "$left BETWEEN $l AND $r", "$left ASC");

	}

//	public function insertTreeItem($name, $pid=0)
//	{
//		
//	}

	public function rebuildFullTree()
	{
		return $this->rebuildTree(0, 0);
	}

	private function rebuildTree($parent, $left)
	{
// 		$parent = (int)$parent;
// 		$left = (int)$left;
		$right = $left + 1;

		$p = $this->getParentColumn();
		$idc = $this->getIDColumn();

		$result = $this->selectColumn($idc, "$p=$parent");
		foreach ($result as $id)
		{
			$right = $this->rebuildTree($id, $right);
		}

		$l = $this->getLeftColumn();
		$r = $this->getRightColumn();
		$this->update("$l=$left, $r=$right", "$idc=$parent");

		return $right+1;  
	}
}
