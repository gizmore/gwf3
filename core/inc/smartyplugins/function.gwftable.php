<?php
function smarty_function_gwftable($params, $template)
{
	$a = isset($params['action']) ? $params['action'] : '';
	switch($a)
	{
		case 'start': 
			$cl = isset($params['class']) ? " class=\"{$params['class']}\"" : '';
			$id = isset($params['id']) ? " id=\"{$params['id']}\"" : '';
			return sprintf('<div class="gwf_table"><table%s%s>'.PHP_EOL, $cl, $id);
		case 'end': return '</table></div>'.PHP_EOL;
		case 'rowStart':
			$cl = isset($params['class']) ? $params['class'] : '';
			$id = isset($params['id']) ? $params['id'] : '';
			$style = isset($params['style']) ? $params['style'] : '';
			return GWF_Table::rowStart(isset($params['flip']), $cl, $id, $style);
		case 'rowEnd': return '</tr>'.PHP_EOL;
		case 'column':
			$text = isset($params['text']) ? $params['text'] : '';
			$cl = isset($params['class']) ? $params['class'] : '';
			$colspan = isset($params['colspan']) ? (int)$params['colspan'] : 1;
			return GWF_Table::column($text, $cl, $colspan);
		case 'displayHeaders1': case 'displayHeaders2':
			$headers = isset($params['headers']) ? (array) $params['headers'] : array();
			$sortURL = isset($params['sortURL']) ? $params['sortURL'] : NULL;
			$default = isset($params['default']) ? $params['default'] : '';
			$defdir = isset($params['defdir']) ? $params['defdir'] : 'ASC';
			$by = isset($params['by']) ? $params['by'] : 'by';
			$dir = isset($params['dir']) ? $params['dir'] : 'dir';
			$raw = isset($params['raw']) ? $params['raw'] : '';
			if($a === 'displayHeaders1')
				return GWF_Table::displayHeaders1($headers, $sortURL, $default, $defdir, $by, $dir, $raw);
			else
				return GWF_Table::displayHeaders2($headers, $sortURL, $default, $defdir, $by, $dir, $raw);
		default: return '';
	}
}
