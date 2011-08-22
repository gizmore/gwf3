<?php
function module_PageBuilder_monthly()
{
	require_once GWF_CORE_PATH.'module/PageBuilder/GWF_Page.php';
	$enabled = GWF_Page::ENABLED;
	$langid = GWF_Language::getCurrentID();
	$db = gdo_db();
	$t = GWF_TABLE_PREFIX.'page';
	$query = "SELECT IFNULL(p2.page_otherid,p1.page_otherid), IFNULL(p2.page_title,p1.page_title), IFNULL(p2.page_url,p1.page_url), IFNULL(p2.page_date,p1.page_date) FROM $t p1 LEFT JOIN $t p2 ON p1.page_otherid=p2.page_otherid AND p2.page_lang={$langid} WHERE p1.page_lang=0 ORDER BY 4 DESC";
	
	if (false === ($result = $db->queryRead($query))) {
		return '';
	}
	
	$first = NULL;
	$tree = array();
	while (false !== ($page = $db->fetchRow($result))) {
		if ($first === NULL) {
			$first = $page;
		}
		monthlyAddTree($tree, $page);
	}
	
	$db->free($result);
	
	if (count($tree) === 0) {
		return '';
	}
	
//	$first = $pages[key($pages)];
	$currdate = $first[3];
	list($y,$m,$d) = monthlySplit($currdate);
	$cy = $y;
	$cm = $m;
	$cd = $d;
	
//	$tree = monthlyGetTree($pages);
	
	$back = '<div class="gwf_pb_monthly fr">'.PHP_EOL;
	foreach ($tree as $year => $y2)
	{
		$c = count($y2);
		$back .= "<ol id=\"_pby{$year}\"><li>{$year}({$c})</li>\n";
		foreach ($y2 as $m1 => $m2)
		{
			$c = count($m2);
			$month = GWF_HTML::lang('M'.($m1+0));
			$back .= "<li>{$year} {$month} ({$c})<ol>\n";
			foreach ($m2 as $page)
			{
				$url = htmlspecialchars(GWF_WEB_ROOT.$page[2]);
				$title = htmlspecialchars($page[1]);
				$back .= "<li><a href=\"{$url}\" title=\"{$title}\">{$title}</a></li>\n";
			}
			$back .= "</ol></li>\n";
		}
		$back .= "</ol>\n";
	}
	$back .= '</div>'.PHP_EOL;
	return $back;
	echo $back;
	return;
}

//function monthlyGetTree(array $pages)
//{
//	$tree = array();
//	foreach ($pages as $page)
//	{
//		monthlyAddTree($tree, $page);
//	}
//	return $tree;
//}

function monthlyAddTree(array &$tree, array $page)
{
	list($y,$m,$d) = monthlySplit($page[3]);
	if (!isset($tree[$y])) { $tree[$y] = array(); }
	if (!isset($tree[$y][$m])) { $tree[$y][$m] = array(); }
	$tree[$y][$m][] = $page;
}

function monthlySplit($date)
{
	return
		array(
			substr($date, 0, 4),
			substr($date, 4, 2),
			substr($date, 6, 2),
		);
}
?>