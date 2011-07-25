<?php

/**
 * GWF_Navigation is an extension for Module PageBuilder.
 * It creates a HTML Navigation for PageBuilder-sites or even for an other select.
 *
 * @author spaceone
 */
final class GWF_Navigation extends GDO
{
	public function __construct($pagebuilder=true, $data=false) 
	{
		if(true !== $pagebuilder)
		{
			parent::__construct();
		} 
		else 
		{
			parent::__construct($data);
		}
		
	}
	public function getColumnDefines()
	{		
		return array(
//			'page_id' => array(GDO::AUTO_INCREMENT),
			'page_otherid' => array(GDO::UINT|GDO::INDEX, 0),
			'page_lang' => array(GDO::UINT|GDO::INDEX, 0),
//			'page_author' => array(GDO::UINT, 0),
//			'page_author_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'page_groups' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
//			'page_create_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
//			'page_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
//			'page_time' => array(GDO::UINT, GDO::NOT_NULL),
			'page_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_cat' => array(GDO::UINT, 0),
//			'page_meta_tags' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_meta_desc' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
//			'page_content' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
//			'page_views' => array(GDO::UINT, 0),
			'page_options' => array(GDO::UINT|GDO::INDEX, 0),
			
//			'ID' => array(GDO::AUTO_INCREMENT),
			'name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 30),
			'title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 50),
			'short' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 20),
			'side' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 8),
			'TID' => array(GDO::UINT, GDO::NOT_NULL, 11),
			'parent_id' => array(GDO::UINT, GDO::NOT_NULL, 11),
			'position' => array(GDO::INT, GDO::NOT_NULL, 11),
			'display_to' => array(GDO::INT, GDO::NOT_NULL, 2),
			'is_visible' => array(GDO::TINYINT, GDO::NOT_NULL, 1),
		);
	}
	public function PBSelect() 
	{
		$cattable = GDO::table('GWF_Category');
		
		$where = "page_cat!=0 AND page_options&".GWF_PAGE::VISIBLE." AND page_options&".GWF_PAGE::ENABLED;
		$pagetable = GDO::table('GWF_Page')->selectAll('page_title as name, page_meta_desc as title, page_url as link, page_cat as cat', $where);
		
		$pages = array();
		foreach($pagetable as $page)
		{
			$pages[$page['cat']] = $page;
		}
		$subcats = array();
		foreach($pages as $cat => $v)
		{
			if ($cattable->select('cat_tree_pid', 'cat_tree_key='.$cat) !=  0) {
				$subcats[$cat] = $v;
				unset($pages[$cat]);
			}
		}
	}
	
	public function display($foo, $tpl='_navigation.tpl') 
	{
		
		
		$tVars = array(
			''
		);
		
		return GWF_Template::template($tpl, $tVars);
	}
	
}
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
			'page_id' => array(GDO::AUTO_INCREMENT),
			'page_otherid' => array(GDO::UINT|GDO::INDEX, 0),
			'page_lang' => array(GDO::UINT|GDO::INDEX, 0),
			'page_author' => array(GDO::UINT, 0),
			'page_author_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 63),
			'page_groups' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'page_create_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'page_date' => array(GDO::DATE|GDO::INDEX, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'page_time' => array(GDO::UINT, GDO::NOT_NULL),
			'page_url' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_cat' => array(GDO::UINT, 0),
			'page_meta_tags' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_meta_desc' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_content' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'page_views' => array(GDO::UINT, 0),
			'page_options' => array(GDO::UINT|GDO::INDEX, 0),
			
			'ID' => array(GDO::AUTO_INCREMENT),
			'name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, 30),
			'title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NULL, 50),
			'short' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 20),
			'side' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 8),
			'TID' => array(GDO::UINT, GDO::NOT_NULL, 11),
			'parent_id' => array(GDO::UINT, GDO::NOT_NULL, 11),
			'position' => array(GDO::INT, GDO::NOT_NULL, 11),
			'display_to' => array(GDO::INT, GDO::NOT_NULL, 2),
			'is_visible' => array(GDO::TINYINT, GDO::NOT_NULL, 1),
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
			. ">" . $content . "</a>".PHP_EOL . ($h2 ? '</h2>' : '' );
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

		list($secs, $cats, $subs, $seclinks, $catlinks, $sublinks) = self::sql();
		
		foreach(self::sql() as $k => $v)
		{
			${$k} = $v;
		}
		
		$ret = '';
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

	return $ret;
	}

}
?>
Example TPL

foreach($secs as $sec) 
		{
			self::liste('sec', $sec['short'], 1) . 
			self::link('index.php?sec='.$sec['short'].'#'.self::$idprefix.$sec['short'], $sec['name'], '', 2, true) .
			"<ul>" // NO INPUT, wouldnt make sense :D ?
foreach($seclinks as $seclink) 
{
if($seclink['parent_id'] === $sec['ID']) {
	
					self::liste('sec_link', '', 3) . 
					self::link('index.php?sec=' . $sec['short'] . '&amp;site=' . $seclink['short'], $seclink['name'], $seclink['title'], 4) .
					self::tab(3) . "</li>" // END
{/if}
{/foreach}
foreach($cats as $cat) 
			{
if($cat['parent_id'] === $sec['ID']) {

					self::liste('cat', $sec['short'] . '_' . $cat['short'], 3) .
							self::link('index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '#nav_' . $sec['short'] . '_' . $cat['short'], $cat['name'], '', 4 ,false ,'h2') . 
							self::tab(4) . "<ul>" // NO INPUT ?

foreach($catlinks as $catlink) 
{
if($catlink['parent_id'] === $cat['ID']) {

							self::liste('cat_link' ,'', 5) . 
									self::link('/index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;site=' . $catlink['short'], $catlink['name'], '',6) .
									self::tab(5) . '</li>' . "" // END
{/if}
{/foreach}

foreach($subs as $sub) 
{
if($sub['parent_id'] === $cat['ID']) {
					
							self::liste("subcat",$sec['short'] . '_' . $cat['short'] . '_' . $sub['short'], 5) .
									self::link('/index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] .'#nav_' . $sec['short'] . '_' . $cat['short'] /*. '_' . $sub['short'] */ , $sub['name'], '', 6) .
									self::tab(6) . "<ul>" //END
					
foreach($sublinks as $sublink) 
{
								if($sublink['parent_id'] == $sub['ID']) {

									self::liste('subcat_link', '', 7) .
											self::link('index.php?sec=' . $sec['short'] . '&amp;cat=' . $cat['short'] . '&amp;subcat=' . $sub['short'] . '&amp;site=' . $sublink['short'], $sublink['name'], '', 8) .
											self::tab(7) . "</li>" //END
{/if}
{/foreach}

						</ul>
					</li>
{/if}
{/foreach}
				</ul>
			</li>
{/if}
{/foreach} 
		</ul> // NO INPUT ?
	</li>
	{/foreach}
{/foreach}

