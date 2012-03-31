<?php
/**
 * Display a default table from a GDO object.
 * @author gizmore
 */
final class GWF_TableGDO
{
	public static function display(GWF_Module $module, GDO $gdo, $user, $sortURL, $conditions='', $ipp=25, $pageURL=false, $joins=NULL)
	{
		$fields = $gdo->getSortableFields($user);

		$headers = self::getGDOHeaders2($module, $gdo, $user, $sortURL);

		$nItems = $gdo->countRows($conditions);
		$nPages = GWF_PageMenu::getPagecount($ipp, $nItems);
		$page = Common::clamp(intval(Common::getGet('page', 1)), 1, $nPages);

		$orderby = self::getMultiOrderBy($gdo, $user);

		$from = GWF_PageMenu::getFrom($page, $ipp);

		$i = 0;
		$data = array();
		if (false === ($result = $gdo->select('*', $conditions, $orderby, $joins, $ipp, $from)))
		{
			echo GWF_HTML::err(ERR_DATABASE, __FILE__, __LINE__);
			return false;
		}

		while (false !== ($row = $gdo->fetch($result, GDO::ARRAY_O)))
		{
			$row instanceof GWF_Sortable;
			$data[$i] = array();
			foreach ($fields as $field)
			{
				$data[$i][] = $row->displayColumn($module, $user, $field);
			}
			$i++;
		}

		$gdo->free($result);

		if ($pageURL === false)
		{
			$pageURL = '';
		}
		elseif ($pageURL === true)
		{
			$pageURL = str_replace(array('%BY%', '%DIR%'), array(urlencode(Common::getGet('by')), urlencode(Common::getGet('dir'))), $sortURL);
			$pageURL .= '&page=%PAGE%';
		}
		$pagemenu = $pageURL === '' ? '' : GWF_PageMenu::display($page, $nPages, $pageURL);

		return
			$pagemenu.
			self::display2($headers, $data).
			$pagemenu;
	}

	public static function display2(array $headers, array $data, $sortURL='', $raw_head='', $raw_body='')
	{
		$tVars = array(
			'headers' => $headers,
			'data' => $data,
			'raw_head' => $raw_head,
			'raw_body' => $raw_body,
		);
		return GWF_Template::templatePHPMain('table2.php', $tVars);
	}

	public static function getGDOHeaders2(GWF_Module $module, GWF_Sortable $gdo, $user, $sortURL)
	{
		# Possible fields...
		$fields = $gdo->getSortableFields($user);

		# Gather the current selected sorting
		$curBy = explode(',', Common::getGet('by', ''));
		$curDir = explode(',', Common::getGet('dir', ''));
		$cur = array();
		foreach ($curBy as $i => $cby)
		{
			if (preg_match('/^[a-zA-Z_]+&?[0-9]*$/', $cby) !== 1) {
				continue;
			}
			if (!(in_array($cby, $fields, true))) {
				continue;
			}
//			if (false === ($cby = $gdo->getWhitelistedBy($cby, false))) {
//				continue;
//			}
			$cd = isset($curDir[$i]) ? $curDir[$i] : 'ASC';
			$cd = GDO::getWhitelistedDirS($cd, 'ASC');
			$cur[$cby] = $cd;
		}

		$headers = array();
		foreach ($fields as $field)
		{
			$curV = array_key_exists($field, $cur) ? $cur[$field] : '';
			$headers[] = array(
				$module->lang('th_'.$field),
				$curV === 'ASC' ? self::getTHeadURL($sortURL, $cur, $field, 'ASC', $field) : self::getTHeadURL($sortURL, $cur, $field, 'ASC'),
				$curV === 'DESC' ? self::getTHeadURL($sortURL, $cur, $field, 'DESC', $field) : self::getTHeadURL($sortURL, $cur, $field, 'DESC'),
				$curV === 'ASC',
				$curV === 'DESC',
				$curV === '',
			);
		}
		return $headers;
	}

	private static function getTHeadURL($sortURL, array $current, $by, $dir, $exclude=false)
	{
		if ($exclude === $by && isset($current[$by])) {
			$current = array();
		}
		$current[$by] = $dir;
		unset($current[$exclude]);
//		if (count($current) === 0) {
//			$current[$by] = $dir;
//		}

		return str_replace(array('%BY%', '%DIR%'), array( urlencode(implode(',', array_keys($current))), urlencode(implode(',', array_values($current)))), $sortURL );
	}

	private static function getMultiOrderBy(GDO $gdo, $user)
	{
		$fields = $gdo->getSortableFields($user);

		# Gather the current selected sorting
		$curBy = explode(',', Common::getGetString('by', ''));
		$curDir = explode(',', Common::getGetString('dir', ''));
		$back = '';
		foreach ($curBy as $i => $cby)
		{
			if (in_array($cby, $fields, true))
			{
				$cd = isset($curDir[$i]) ? $curDir[$i] : 'ASC';
				$cd = GDO::getWhitelistedDirS($cd, 'ASC');
				$back .= sprintf(',`%s` %s', $cby, $cd);
			}
		}
		return $back === '' ? '1' : substr($back, 1);
	}
}
