<?php

final class SF_Navigation extends GDO
{
	const VISIBLE = 0x01;

	const LINK = 0x02;
//	const NOLINK = 0x04;

	const SIDE_LEFT = 0x10;
	const SIDE_RIGHT = 0x20;
	const SIDE_OTHER = 0x40;

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

	public static function link($href, $content, $title='', $tab=0, $h2=false, $class='') 
	{
		return sprintf(self::tab($tab).'%s<a href="%s"%s%s>%s</a>%s'.PHP_EOL,
			($h2 ? '<h2>' : '' ),
			GWF_WEB_ROOT.'index.php?'.$href,
			(!empty($class) ? ' class="'.$class.'"' : ''),
			(!empty($title) ? ' title="'.$title.'"' : ''),
			$content,
			($h2 ? '</h2>' : '' )
		);
	}
	
	public static function fetchAll($where, $orderby='') 
	{
		return GDO::table(__CLASS__)->selectAll('*', sprintf('options & %s = %s AND %s', self::VISIBLE, self::VISIBLE, $where), $orderby);
	}
	public static function sql_secs($side)
	{
		return self::fetchAll(sprintf('parent_id = 0 AND options & %s = %s', $side, $side), 'position');
	}
	public static function sql_cats($pid)
	{
		return self::fetchAll(sprintf('parent_id = %s AND options & %s != %s', $pid, self::LINK, self::LINK), 'position');
#		return self::fetchAll(sprintf('parent_id = %s AND options & %s = %s ', $pid, self::NOLINK, self::NOLINK), 'position');
	}
	public static function sql_links($pid)
	{
		return self::fetchAll(sprintf('parent_id = %s AND options & %s = %s', $pid, self::LINK, self::LINK), 'position');
	}
	public static function display_navigation($side) 
	{
		$secs = self::sql_secs($side);
		$ret = '';
		foreach($secs as $sec)
		{
			$ret .= self::liste('sec', $sec['short'], 1) . 
					self::link('sec='.$sec['short'].'#'.self::$idprefix.$sec['short'], $sec['name'], '', 2, true) .
					"<ul>".PHP_EOL;

			$seclinks = self::sql_links($sec['ID']);
			foreach($seclinks as $seclink) 
			{
				$ret .= self::liste('sec_link', '', 3) . 
						self::link('sec=' . $sec['short'] . '&amp;site=' . $seclink['short'], $seclink['name'], $seclink['title'], 4) .
						self::tab(3) . "</li>".PHP_EOL ;
			}
			$cats = self::sql_cats($sec['ID']);
			foreach($cats as $cat) 
			{
				$ret .= self::liste('cat', $sec['short'] . '_' . $cat['short'], 3) .
						self::link('sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '#nav_' . $sec['short'] . '_' . $cat['short'], $cat['name'], '', 4 ,false ,'h2') . 
						self::tab(4) . "<ul>".PHP_EOL;

				$catlinks = self::sql_links($cat['ID']);
				foreach($catlinks as $catlink) 
				{
					$ret .= self::liste('cat_link' ,'', 5) . 
							self::link('sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;site=' . $catlink['short'], $catlink['name'], '',6) .
							self::tab(5) . '</li>' . "".PHP_EOL ;
				}

				$subs = self::sql_cats($cat['ID']);
				foreach($subs as $sub) 
				{
					$ret .= self::liste("subcat",$sec['short'] . '_' . $cat['short'] . '_' . $sub['short'], 5) .
							self::link('sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] .'#nav_' . $sec['short'] . '_' . $cat['short'] /*. '_' . $sub['short'] */ , $sub['name'], '', 6) .
							self::tab(6) . "<ul>".PHP_EOL ;

					$sublinks = self::sql_links($sub['ID']);
					foreach($sublinks as $sublink) 
					{
						$ret .= self::liste('subcat_link', '', 7) .
								self::link('sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] . '&amp;site=' . $sublink['short'], $sublink['name'], '', 8) .
								self::tab(7) . "</li>".PHP_EOL ;
					}
					$ret .= self::tab(6) . "</ul>".PHP_EOL . 
							self::tab(5) . "</li>".PHP_EOL;
				}
				$ret .= self::tab(4) . "</ul>".PHP_EOL;
				$ret .= self::tab(3) . "</li>".PHP_EOL;
			}
		$ret .= self::tab(2) ."</ul>".PHP_EOL;
		$ret .= self::tab(1) ."</li>".PHP_EOL;
		}

		return $ret;
	}

}

?>