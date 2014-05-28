<?php
/**
 * Show a nifty html menu for multi page tables
 */
final class GWF_PageMenu
{
	/**
	 * return the query value for LIMIT N,From clause from page number and rowsPerPage.
	 * @param $page
	 * @param $rowsPerPage
	 * @return int from LIMIT
	 */
	public static function getFrom($page, $rowsPerPage)
	{
		$back = ((int)$page-1) * $rowsPerPage;
		return Common::clamp($back, 0);
	}
	
	/**
	 * Return the page number for a position.
	 * @param int $pos
	 * @param int $ipp
	 * @return int
	 */
	public static function getPageForPos($pos, $ipp)
	{
		return (int)((($pos-1)/((int)$ipp)) + 1);
	}
	
	public static function getPageFor(GDO $gdo, $condition, $orderby, $ipp, $joins=NULL)
	{
		return self::getPageForPos($gdo->selectVar('COUNT(*)', $condition, $orderby, $joins), $ipp);
	}
	
	/**
	 * return number of pages for items per page and itemcount. 
	 * @param $itemsPerPage
	 * @param $numItems
	 * @return int
	 */
	public static function getPagecount($itemsPerPage, $numItems)
	{
		return max(array(intval((($numItems-1) / $itemsPerPage)+1), 1));
	}
	
	/**
	 * Show a pagemenu.
	 * Href substitutes %PAGE%.
	 * Example: $href=/foo/by/current/dir/page-%PAGE%
	 * @param $page int current page
	 * @param $nPages int total pages
	 * @param $href string replace href
	 * @param $npm int num links for extreme large pagemenu
	 * @return string HTML
	 */
	public static function display($page, $nPages, $href, $npm=8)
	{
		$page = abs((int)$page);
		if ($nPages < 2) { return ''; }
		$pages = array();
		$pages[1] = " href=\"".self::replaceHref($href, 1)."\"";
		$start = $page - $npm;
		if ($start > 2) {
			$pages[2] = false;
		}
		elseif ($start < 1) {
			$start = 1;
		}
		for ($i = $start; $i < $page; $i++)
		{
			$pages[$i] = " href=\"".self::replaceHref($href, $i)."\"";
		}
		
		$end = $page + $npm;
		if ($end > $nPages) {
			$end = $nPages;
		}

		for ($i = $page+1; $i <= $end; $i++)
		{
			$pages[$i] = " href=\"".self::replaceHref($href, $i)."\"";
		}
		if ($end+1 < $nPages) {
			$pages[$nPages-1] = false;
		}
		
		$pages[$nPages] = " href=\"".self::replaceHref($href, $nPages)."\"";

		if ($page !== false) {
			$pages[$page] = '';
		}
		
		ksort($pages);
		
		$tVars = array(
			"pagelinks" => $pages,
		);
		
		return GWF_Template::templateMain('menu_page.tpl', $tVars);
	}
	
	private static function replaceHref($href, $page)
	{
		return str_replace("%PAGE%", $page, $href);
	}
	
	/**
	 * Show a Latin Alphabet menu. A-Z, All, Num. Default is All
	 * @param $letter
	 * @param $href
	 * @return unknown_type
	 */
	public static function displayLetterMenu($letter, $href, $default='All')
	{
		$href = (string) $href;
		static $whitelist = array(
			'All', 'Num',
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
		);
		
		if (!in_array($letter, $whitelist, true)) {
			$letter = $default;
		}
		
		$back = '';
		foreach ($whitelist as $l)
		{
			if ($l === $letter) {
				$href2 = '';
			} else {
				$href2 = ' href="'.$href.'"';
			}
			$back[$l] = self::replaceLetterHREF($href2, $l);
		}
		
		$tVars = array(
			'letters' => $back,
			'selected' => $letter,
		);
		
		return GWF_Template::templateMain('letter_menu.tpl', $tVars);
	}
	
	private static function replaceLetterHREF($href, $letter)
	{
		return str_replace('%LETTER%', $letter, $href);
	}
	
	#####################
	### Prev and Next ###
	#####################
	public static function prevPage($page, $nPages, $pagemenuHREF)
	{
		if ($page < 2) {
			return '';
		}
		return sprintf('<a href="%s">%s</a>', self::replaceHref($pagemenuHREF, $page-1), GWF_HTML::lang('pagemenu_prev'));
	}
	
	public static function nextPage($page, $nPages, $pagemenuHREF)
	{
		if ($page >= $nPages) {
			return '';
		}
		return sprintf('<a href="%s">%s</a>', self::replaceHref($pagemenuHREF, $page+1), GWF_HTML::lang('pagemenu_next'));
	}
	
}
