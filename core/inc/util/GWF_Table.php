<?php
/**
 * HTML tables featuring alternation, different types of server side sorting.
 * @author gizmore
 */
final class GWF_Table
{
	public static function start($class='', $id='') { $cl = $class === '' ? '' : " class=\"$class\""; $id = $id === '' ? '' : " id=\"$id\""; return '<div class="gwf_table"><table'.$cl.$id.'>'.PHP_EOL; }
	public static function end() { return '</table></div>'.PHP_EOL; }

	public static function rowStart($flip=true, $class='', $id='', $style='')
	{
		static $odd = 0;
		if ($flip)
		{
			$odd = 1 - $odd;
			$class .= $odd === 0 ? ' gwf_even' : ' gwf_odd';
		}
		$id = $id === '' ? '' : ' id="'.$id.'"';
		$class = $class === '' ? '' : ' class="'.$class.'"';
		$style = $style === '' ? '' : ' style="'.$style.'"';
		return sprintf('<tr%s%s%s>', $id, $class, $style).PHP_EOL;
	}
	public static function rowEnd() { return '</tr>'.PHP_EOL; }

	public static function column($text='', $class='', $colspan=1)
	{
		$colspan = $colspan === 1 ? '' : " colspan=\"{$colspan}\"";
		$class = $class === '' ? '' : ' class="'.$class.'"';
		return sprintf('<td%s%s>%s</td>', $class, $colspan, $text);
	}

	/**
	 * Simple one column sorting.
	 * @param array $headers
	 * @param string $sortURL The URL template
	 * @param string $default orderby
	 * @param string $defdir orderdir
	 * @param string $by custom $_GET['by'] name
	 * @param string $dir custom $_GET['dir'] name
	 * @param unknown_type $raw
	 * @return string 'html'
	 */
	public static function displayHeaders1(array $headers=array(), $sortURL=NULL, $default='', $defdir='ASC', $by='by', $dir='dir', $raw='')
	{
		$sel = Common::getGetString($by, $default);

		$back = '<thead>'.PHP_EOL;
		$back .= $raw;

		$back .= '<tr>'.PHP_EOL;
		foreach ($headers as $h)
		{
			$back .= '<th>'.PHP_EOL;
			if (!is_array($h) || !isset($h[0]) || $h[0]==='') {
				$back .= '</th>'.PHP_EOL;
				continue;
			}

			$sort = isset($h[1]) ? $h[1] : '';
			if ($sort === '') {
				$back .= $h[0];
				$back .= '</th>'.PHP_EOL;
				continue; # can not sort field;
			}

			else
			{
				$is_sel = $sel === $h[1];
				$selhtml = $is_sel ? ' class="th_sel"' : '';
				$ddir = isset($h[2]) ? $h[2] : $defdir;
				$seldir = Common::getGet($dir, $defdir);
				if ($is_sel) {
					$ddir = self::flipOrderDir($seldir);
				}
				$href = str_replace(array('%BY%','%DIR%'), array($h[1], $ddir), $sortURL);
				$back .= sprintf('<a rel="nofollow" href="%s"%s>%s</a>', htmlspecialchars($href), $selhtml, htmlspecialchars($h[0]));
				$back .= '</th>'.PHP_EOL;
				continue;
			}


		}
		$back .= '</tr>'.PHP_EOL;
		$back .= '</thead>'.PHP_EOL;
		return $back;
	}

	/**
	 * Display a multisort header. These rarely make sense, only on overlapping values. (School notes would be an example)
	 * @param array $headers
	 * @param string $sortURL The URL template
	 * @param string $default orderby
	 * @param string $defdir orderdir
	 * @param string $by custom $_GET['by'] name
	 * @param string $dir custom $_GET['dir'] name
	 * @param unknown_type $raw
	 * @return string 'html'
	 */
	public static function displayHeaders2(array $headers, $sortURL=NULL, $default='', $defdir='ASC', $by='by', $dir='dir', $raw='')
	{
		$tVars = array(
			'headers' => self::getHeaders2($headers, $sortURL, $by, $dir),
			'raw' => $raw,
		);
		return GWF_Template::templateMain('thead.tpl', $tVars);
	}

	private static function getHeaders2(array $headers, $sortURL='', $key_by='by', $key_dir='dir')
	{
		$sortURL = htmlspecialchars($sortURL);

		$allowed = array();
		foreach ($headers as $header)
		{
			if (isset($header[1]))
			{
				$allowed[] = $header[1];
			}
		}

		# Gather the current selected sorting
		$curBy = explode(',', Common::getGet($key_by, ''));
		$curDir = explode(',', Common::getGet($key_dir, ''));
		$cur = array();
		foreach ($curBy as $i => $cby)
		{
			if (!(in_array($cby, $allowed, true)))
			{
				continue;
			}

			$cd = isset($curDir[$i]) ? $curDir[$i] : 'ASC';
			$cd = GDO::getWhitelistedDirS($cd, 'ASC');
			$cur[$cby] = $cd;
		}

		$back = array();
		foreach ($headers as $header)
		{
			if (isset($header[1]) && $sortURL !== '')
			{
				if($header[1]===false) {
					continue;
				}
				$curV = array_key_exists($header[1], $cur) ? $cur[$header[1]] : '';
				$back[] = array(
					$header[0],
					$curV === 'ASC' ? self::getTHeadURL($sortURL, $cur, $header[1], 'ASC', $header[1]) : self::getTHeadURL($sortURL, $cur, $header[1], 'ASC'),
					$curV === 'DESC' ? self::getTHeadURL($sortURL, $cur, $header[1], 'DESC', $header[1]) : self::getTHeadURL($sortURL, $cur, $header[1], 'DESC'),
					$curV === 'ASC',
					$curV === 'DESC',
					$curV === '',
				);
			}
			else
			{
				$back[] = array(
					isset($header[0]) ? $header[0] : '',
					false,
				);
			}
		}
		return $back;
	}

	/**
	 * Return a sort-url.
	 */
	private static function getTHeadURL($sortURL, array $current, $by, $dir, $exclude=false)
	{
		if ($exclude === $by && isset($current[$by]))
		{
			$current = array();
		}
		$current[$by] = $dir;
		unset($current[$exclude]);
		return str_replace(array('%BY%', '%DIR%'), array( urlencode(implode(',', array_keys($current))), urlencode(implode(',', array_values($current)))), $sortURL );
	}

	/**
	 * Flip the order direction.
	 * @param string $dir
	 * @return 'ASC'|'DESC'
	 */
	private static function flipOrderDir($dir='ASC')
	{
		return strtoupper($dir) === 'ASC' ? 'DESC' : 'ASC';
	}


}

