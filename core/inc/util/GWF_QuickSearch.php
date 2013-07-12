<?php
final class GWF_QuickSearch
{
	#####################
	### Simple Search ###
	#####################
	const MIN_LEN = 3;
	const MAX_LEN = 32;
	public static function errorSearchLength() { return GWF_HTML::err('ERR_SEARCH_TERM', array(self::MIN_LEN, self::MAX_LEN)); }

	const SEARCH_TYPE = 0x0f;
	const SEARCH_EMPTY = 1;
	const SEARCH_TERM = 2;
	const SEARCH_OR = 3;
	const SEARCH_AND = 4;
	const SEARCH_NEAR = 5;
	const SEARCH_BRACKET_OPEN = 6;
	const SEARCH_BRACKET_CLOSE = 7;
	const SEARCH_NOT = 0x18;


	/**
	 * Get a real basic quicksearch form.
	 * @param GWF_Module $module
	 * @param callback $caller Validator
	 * @param boolean $use_captcha
	 */
	public static function getQuickSearchForm(GWF_Module $module, $caller, $use_captcha=false)
	{
		$data = array(
			'term' => array(GWF_Form::STRING, Common::getRequest('term', ''), GWF_HTML::lang('term')),
			'qsearch' => array(GWF_Form::SUBMIT, GWF_HTML::lang('search')),
		);
		return new GWF_Form($caller, $data);
	}

	public static function getQuickSearchHighlights($term)
	{
		if (!is_string($term))
		{
			return '';
		}
		$term = trim(str_replace(array(',', '+'), ' ', $term));
		return preg_split('/ +/', $term);
	}


	public static function search(GDO $gdo, array $fields, $term, $orderby='', $limit=-1, $from=0, $where='')
	{
		$where = $where === '' ? '' : ' AND ('.$where.')';
		if (false === ($conditions = self::getQuickSearchConditions($gdo, $fields, $term)))
		{
			return array();
		}
		$where = $conditions.$where;
		return $gdo->selectObjects('*', $where, $orderby, $limit, $from);
	}

	/**
	 * Create a WHERE clause from fields and searchterm.
	 * This function does not sanitize the fields anymore!
	 * @param GDO $gdo
	 * @param array $fields
	 * @param string $term
	 * @return string the where clause
	 */
	public static function getQuickSearchConditions(GDO $gdo, array $fields, $term)
	{
		$term = trim($term);
		if (false === ($tokens = self::search_tokenize($term)))
		{
			GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__)));
			return false;
		}

		# Whitelist fields
// 		foreach ($fields as $field)
// 		{
// 			if (false === $gdo->getWhitelistedBy($field))
// 			{
// 				GWF_Website::addDefaultOutput(GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__)));
// 				return false;
// 			}
// 		}

		# Concat the Fields, (we are doing a full search anyway)
		$concat = 'CONCAT('.implode(', ":", ', $fields).')';

		$prev = array(self::SEARCH_EMPTY, '');
		$prevnot = false;
		$where = array();
		foreach ($tokens as $token)
		{
			$type = $token[0] & self::SEARCH_TYPE;
			$not = ($token[0] & self::SEARCH_NOT) > 0;
			$sql = $token[1];
			$setprev = true;
			switch($type)
			{
				case self::SEARCH_TERM:
					switch ($prev[0])
					{
						case self::SEARCH_BRACKET_CLOSE:
						case self::SEARCH_TERM:
//							break;
						default:
							$where[] = 'AND';
						case self::SEARCH_EMPTY:
							$not = $prevnot ? ' NOT' : '';
							$prevnot = false;
							$where[] = sprintf('%s%s LIKE \'%%%s%%\'', $concat, $not, $gdo->escape($sql));
							break;
					}
					break;
		
				case self::SEARCH_NEAR:
					echo "NEAR NOT SUPPORTED YET.";
					break;
		
				case self::SEARCH_BRACKET_OPEN:
// 					if ($prev[0] === self::SEARCH_TERM)
// 					{
// 						$where[] = 'AND';
// 					}
// 					$where[] = $sql;
					break;
		
				case self::SEARCH_BRACKET_CLOSE:
					break;
				case self::SEARCH_OR:
				case self::SEARCH_AND:
					$where[] = $sql;
					break;
		
				default:
					if ($token[0] === self::SEARCH_NOT)
					{
						$prevnot = true;
						$setprev = false;
					}
					break;
		
			}

			if ($setprev === true)
			{
				$prev = $token;
			}
		}

		$back = implode(' ', $where);
		return $back === '' ? '1' : $back;
	}

	private static function search_tokenize($term)
	{
		# Thx Geo
		$term = str_replace(array('%', '_'), array('\\%', '\\_'), $term);

		#Thx Geo
		$term = preg_replace('/\( *\)/', '', $term);

		$len = strlen($term);
		$back = array();
		$cur = '';
		$in_quote = false;
		$bracket = 0;
		for ($i = 0; $i < $len; $i++)
		{
			switch($term{$i})
			{
				case '"':
					$in_quote = !$in_quote;
					break;
		
				case ' ':
					if (!$in_quote)
					{
						if (false !== ($item = self::search_item($cur, $in_quote)))
						{
							$back[] = $item;
							$cur = '';
						}
					}
					else
					{
						$cur .= ' ';
					}
					break;
		
				case '(': $bracket += 2;
				case ')': $bracket -= 1;
					break;
	//				if ($cur !== ')' && $cur !== '(')
//					{
						if (false !== ($item = self::search_item($cur, $in_quote)))
						{
							$back[] = $item;
						}
	//				}
					if (false !== ($item = self::search_item($term{$i}, $in_quote)))
					{
						$back[] = $item;
					}
					$cur = '';
					break;
		
				default:
					$cur .= $term{$i};
					break;
			}
		}

		if (false !== ($item = self::search_item($cur, $in_quote)))
		{
			$back[] = $item;
		}

		if ( ($bracket !== 0) || ($in_quote === true) )
		{
			return false;
		}

		return $back;
	}

	private static function search_item($txt, $in_quotes)
	{
		if ($in_quotes)
		{
			return array(0, $txt);
		}

		switch (strtolower($txt))
		{
			case '':
				return false;
	
			case ')':
				return array(self::SEARCH_BRACKET_CLOSE, $txt);
	
			case '(':
				return array(self::SEARCH_BRACKET_OPEN, $txt);
	
// 			case 'not':
// 				return array(self::SEARCH_NOT, strtoupper($txt));
	
// 			case 'near':
// 				return array(self::SEARCH_NEAR, strtoupper($txt));
	
// 			case 'and':
// 				return array(self::SEARCH_AND, strtoupper($txt));
	
// 			case 'or':
// 				return array(self::SEARCH_OR, strtoupper($txt));
	
			default:
				return array(self::SEARCH_TERM, $txt);
		}
	}
}
