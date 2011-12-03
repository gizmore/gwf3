<?php

final class SF_Navigation extends GDO
{
	const VISIBLE = 0x01;
	
	const SECTIONS = 0x02;
	const CATEGORIES = 0x04;
	const SUBCATS = 0x08;
	const LINKS = 0x10;
	
	const SECLINK = 0x20;
	const CATLINK = 0x40;
	const SUBLINK = 0x80;
	
	const SIDE_LEFT = 0x100;
	const SIDE_RIGHT = 0x200;
	const SIDE_OTHER = 0x400;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'SF_Navigation'; }
	public function getColumnDefines()
	{		
		return array(
			'ID' => array(GDO::AUTO_INCREMENT),
			'parent_id' => array(GDO::UINT, GDO::NOT_NULL, 11),
			'name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 30),
			'title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 50),
			'short' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 20),
			'side' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 8), //delete
			'TID' => array(GDO::UINT, GDO::NOT_NULL, 11), //delete
			'display_to' => array(GDO::INT, GDO::NOT_NULL, 2), //delete
			'is_visible' => array(GDO::TINYINT, GDO::NOT_NULL, 1), //delete
			'parent_id' => array(GDO::UINT, GDO::NOT_NULL, 11),
			'position' => array(GDO::INT, GDO::NOT_NULL, 11),
			'options' => array(GDO::UINT, self::VISIBLE),
		);
	}
	public function getOptionsName() { return 'options'; }
	private static function tab($num) { return str_repeat("\t", $num); }
	private static $idprefix = 'nav_';
	public static function liste($class = '', $id = '', $tab = 0)
	{
		return sprintf('%s<li%s%s>'.PHP_EOL,
			self::tab($tab),
			(!empty($class) ? ' class="'.$class.'"' : ''),
			(!empty($id) ? ' id="'. self::$idprefix .$id.'"' : '')
		);
	}

	public static function link($href, $content, $title='', $class='') 
	{
		return sprintf('<a href="%s"%s%s>%s</a>', 
			GWF_WEB_ROOT.$href,
			(!empty($class) ? ' class="'.$class.'"' : ''),
			(!empty($title) ? ' title="'.$title.'"' : ''),
			$content
		);
	}
	
	public static function fetchAll($where, $orderby='') 
	{
		return GDO::table(__CLASS__)->selectAll('*', 'options & '.self::VISIBLE. ' = '.self::VISIBLE, $orderby);
	}
	public static function sql_secs($side)
	{
		switch ($side)
		{
			case 'left': 
				$side = self::SIDE_LEFT;
				break;
			case 'right': 
				$side = self::SIDE_RIGHT;
				break;
			case 'other':
			default:
				$side = self::SIDE_OTHER;
				break;
		}
#		return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', $side, $side, self::SECTIONS, self::SECTIONS), 'position');
		return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', $side, $side, self::SECTIONS, self::SECTIONS), 'position');
	}
	public static function sql_cats($secid)
	{
#		return self::fetchAll(sprintf('parent_id = %s', $secid),'parent_id, position');
		return self::fetchAll(sprintf('parent_id = %s AND options & %s = %s ', $secid, self::CATEGORIES, self::CATEGORIES), 'parent_id, position');
	}
	public static function sql_subs($catid)
	{
#		return self::fetchAll(sprintf('parent_id = %s', $catid), 'parent_id, position');
		return self::fetchAll(sprintf('parent_id = %s AND options & %s = %s ', $catid, self::SUBCATS, self::SUBCATS), 'parent_id, position');
	}
	public static function sql_seclinks($secid)
	{
#			return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', $secid, self::LINKS, self::LINKS, self::SIDE_SEC, self::SIDE_SEC), 'parent_id, position');
			return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', $secid, self::LINKS, self::LINKS, self::SIDE_SEC, self::SIDE_SEC), 'parent_id, position');
	}
	public static function sql_catlinks($catid)
	{
#		return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', self::LINKS, self::LINKS, self::SIDE_CAT, self::SIDE_CAT), 'parent_id, position');
		return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', self::LINKS, self::LINKS, self::SIDE_CAT, self::SIDE_CAT), 'parent_id, position');
	}
	public static function sql_sublinks($subid)
	{
#		return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', self::LINKS, self::LINKS, self::SIDE_SUB, self::SIDE_SUB), 'parent_id, position');
		return self::fetchAll(sprintf('options & %s = %s AND options & %s = %s', self::LINKS, self::LINKS, self::SIDE_SUB, self::SIDE_SUB), 'parent_id, position');
	}
	public static function display_navigation($side) 
	{
		$secs = self::sql_secs($side);
		$ret = '';
		foreach($secs as $sec)
		{
			$ret .= self::liste('sec', $sec['short'], 1) . 
					self::link('index.php?sec='.$sec['short'].'#'.self::$idprefix.$sec['short'], $sec['name'], '', 2, true) .
					"<ul>".PHP_EOL;

			$seclinks = self::sql_seclinks($sec['ID']);
			foreach($seclinks as $seclink) 
			{
				$ret .= self::liste('sec_link', '', 3) . 
						self::link('index.php?sec=' . $sec['short'] . '&amp;site=' . $seclink['short'], $seclink['name'], $seclink['title'], 4) .
						self::tab(3) . "</li>".PHP_EOL ;
			}
			$cats = self::sql_cats($sec['ID']);
			foreach($cats as $cat) 
			{
				$ret .= self::liste('cat', $sec['short'] . '_' . $cat['short'], 3) .
						self::link('index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '#nav_' . $sec['short'] . '_' . $cat['short'], $cat['name'], '', 4 ,false ,'h2') . 
						self::tab(4) . "<ul>".PHP_EOL;

				$catlinks = self::sql_catlinks($cat['ID']);
				foreach($catlinks as $catlink) 
				{
					$ret .= self::liste('cat_link' ,'', 5) . 
							self::link('/index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;site=' . $catlink['short'], $catlink['name'], '',6) .
							self::tab(5) . '</li>' . "".PHP_EOL ;
				}

				$subs = self::sql_subs($cat['ID']);
				foreach($subs as $sub) 
				{
					$ret .= self::liste("subcat",$sec['short'] . '_' . $cat['short'] . '_' . $sub['short'], 5) .
							self::link('/index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] .'#nav_' . $sec['short'] . '_' . $cat['short'] /*. '_' . $sub['short'] */ , $sub['name'], '', 6) .
							self::tab(6) . "<ul>".PHP_EOL ;

					$sublinks = self::sql_sublinks($sub['ID']);
					foreach($sublinks as $sublink) 
					{
						$ret .= self::liste('subcat_link', '', 7) .
								self::link('index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] . '&amp;site=' . $sublink['short'], $sublink['name'], '', 8) .
								self::tab(7) . "</li>".PHP_EOL ;
					}
					$ret .= self::tab(6) . "</ul>".PHP_EOL . 
							self::tab(5) . "</li>".PHP_EOL;
				}
				$ret .= self::tab(4) . "</ul>".PHP_EOL;
				$ret .= self::tab(3) . "</li>".PHP_EOL;
			}
		} 
		$ret .= self::tab(2) ."</ul>".PHP_EOL;
		$ret .= self::tab(1) ."</li>".PHP_EOL;

		return $ret;
	}

}

?>