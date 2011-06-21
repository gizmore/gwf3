<?php

final class SF_Navigation extends GDO
{
	const SECTIONS = 1;
	const CATEGORIES = 2;
	const SUBCATS = 3;
	const LINKS = 4;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'SF_Navigation'; }
	public function getColumnDefines()
	{		
		return array(
			'ID' => array(GDO::AUTO_INCREMENT),
			'name' => array(GDO::VARCHAR, GDO::NULL, 30),
			'title' => array(GDO::VARCHAR, GDO::NULL, 50),
			'short' => array(GDO::VARCHAR, GDO::NOT_NULL, 20),
			'side' => array(GDO::VARCHAR, GDO::NOT_NULL, 8),
			'TID' => array(GDO::INT, GDO::NOT_NULL, 11),
			'parent_id' => array(GDO::INT, GDO::NOT_NULL, 11),
			'position' => array(GDO::INT, GDO::NOT_NULL, 11),
			'display_to' => array(GDO::INT, GDO::NOT_NULL, 2),
			'is_visible' => array(GDO::INT, GDO::NOT_NULL, 1),
		);
	}
	private static function tab($num) { return str_repeat("\t", $num); }
	private static $idprefix = 'nav_';
	public static function liste($class = '', $id = '', $tab = 0) {
		return 
			self::tab($tab) . '<li' . 
			(!empty($class) ? ' class="'.$class.'"' : '') .
			(!empty($id) ? ' id="'. self::$idprefix .$id.'"' : '')
			. ">".PHP_EOL;
	}
	public static function link($href, $content, $title='', $tab = 0, $h2 = false, $class='') {
		return 
			self::tab($tab) . 
			(true === $h2 ? '<h2>' : '' ) .
			'<a href="'.GWF_WEB_ROOT.$href.'"' .
			(!empty($class) ? ' class="'.$class.'"' : '') .
			(!empty($title) ? ' title="'.$title.'"' : '')
			. ">".PHP_EOL . $content . "</a>".PHP_EOL . ($h2 ? '</h2>' : '' );
	}
	public static function fetchAll($where, $orderby) {
		return GDO::table(__CLASS__)->selectAll('*', $where, $orderby);
	}
	public static function sql() {
		$permission = 0; 
		return array(
			'secs' => self::fetchAll("TID = '".self::SECTIONS."' AND is_visible = '1' AND display_to >= '{$permission}'", 'position'),
			'cats' => self::fetchAll("TID = '".self::CATEGORIES."' AND is_visible = '1' AND display_to >= '{$permission}'", "parent_id, position"),
			'subs' => self::fetchAll("TID = '".self::SUBCATS."' AND is_visible = '1' AND display_to >= '{$permission}'", "parent_id, position"),
			'seclinks' => self::fetchAll("TID = '".self::LINKS."' AND is_visible = '1' AND display_to >= '{$permission}' AND side = 'SEC'", "parent_id, position"),
			'catlinks' => self::fetchAll("TID = '".self::LINKS."' AND is_visible = '1' AND display_to >= '{$permission}'AND side = 'CAT'", "parent_id, position"),
			'sublinks' => self::fetchAll("TID = '".self::LINKS."' AND is_visible = '1' AND display_to >= '{$permission}' AND side = 'SUB'", "parent_id, position")
		);
	}
	public static function display_navigation($side) {
		$res = self::sql();
		$secs = $res['secs'];
		$cats = $res['cats'];
		$subs = $res['subs'];
		$seclinks = $res['seclinks'];
		$catlinks = $res['catlinks'];
		$sublinks = $res['sublinks'];

		$ret = '<ol class="navi">' .PHP_EOL;
		foreach($secs as $sec) if($sec['side'] == $side)
		{

			$ret .= self::liste('sec', $sec['short'], 1) . 
					self::link('index.php?sec='.$sec['short'].'#'.self::$idprefix.$sec['short'], $sec['name'], '', 2, true) .
					"<ul>".PHP_EOL; // NO INPUT, wouldnt make sense :D ?

			foreach($seclinks as $seclink) 
			{
				if($seclink['parent_id'] === $sec['ID']) {
			
					$ret .= self::liste('sec_link', '', 3) . 
							self::link('index.php?sec=' . $sec['short'] . '&amp;site=' . $seclink['short'], $seclink['name'], $seclink['title'], 4) .
							self::tab(3) . "</li>".PHP_EOL ; // END
				}
			}
			foreach($cats as $cat) 
			{
				if($cat['parent_id'] === $sec['ID']) {

					$ret .= self::liste('cat', $sec['short'] . '_' . $cat['short'], 3) .
							self::link('index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '#nav_' . $sec['short'] . '_' . $cat['short'], $cat['name'], '', 4 ,false ,'h2') . 
							self::tab(4) . "<ul>".PHP_EOL; // NO INPUT ?

					foreach($catlinks as $catlink) 
					{
						if($catlink['parent_id'] === $cat['ID']) {

							$ret .= self::liste('cat_link' ,'', 5) . 
									self::link('/index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;site=' . $catlink['short'], $catlink['name'], '',6) .
									self::tab(5) . '</li>' . "".PHP_EOL ; // END
						}
					}

					foreach($subs as $sub) 
					{
						if($sub['parent_id'] === $cat['ID']) {
					
							$ret .= self::liste("subcat",$sec['short'] . '_' . $cat['short'] . '_' . $sub['short'], 5) .
									self::link('/index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] .'#nav_' . $sec['short'] . '_' . $cat['short'] /*. '_' . $sub['short'] */ , $sub['name'], '', 6) .
									self::tab(6) . "<ul>".PHP_EOL ; //END
					
							foreach($sublinks as $sublink) 
							{
								if($sublink['parent_id'] == $sub['ID']) {

									$ret .= self::liste('subcat_link', '', 7) .
											self::link('index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] . '&amp;site=' . $sublink['short'], $sublink['name'], '', 8) .
											self::tab(7) . "</li>".PHP_EOL ; //END
								}
							}

							$ret .= self::tab(6) . "</ul>".PHP_EOL . 
									self::tab(5) . "</li>".PHP_EOL;
						}
					}
					$ret .= self::tab(4) . "</ul>".PHP_EOL; // NO INPUT ?
					$ret .= self::tab(3) . "</li>".PHP_EOL;
				}
			} 
			$ret .= self::tab(2) ."</ul>".PHP_EOL; // NO INPUT ?
			$ret .= self::tab(1) ."</li>".PHP_EOL;
		}
		$ret .= '</ol>'.PHP_EOL;

	return $ret;
	}

}

?>