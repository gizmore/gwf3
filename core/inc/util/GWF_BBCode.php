<?php
require_once 'GWF_BBCodeItem.php';
/**
 * BBCode decoder. Stack-Code mostly stolen from "quickerUbb (c)2004 Roönaän"
 * Did a recode and cleanup :)
 * @author gizmore
 */
final class GWF_BBCode
{
	####################
	### Init Smileys ###
	####################
	private static $allowSmileys = false;
	private static $smileyPath = '';
	private static $smileys = array();
	private static $smileysReplace = array();
	public static function initSmileys(array $smileys, $path, $allowed)
	{
		self::$allowSmileys = $allowed;
		self::$smileyPath = $path;
		self::$smileys = $smileys;

		self::initSmileysB();
	}
	private static function initSmileysB()
	{
		static $init = true;

		if ($init === true)
		{
			foreach (self::$smileys as $txt => $data)
			{
				list($path, $alt) = $data;
				$alt = htmlspecialchars($alt, ENT_QUOTES);
				$src = GWF_WEB_ROOT.self::$smileyPath.$path;
	
				self::$smileysReplace[$txt] = sprintf('<img src="%s" title="%s" alt="%s" />', $src, $alt, $alt);
			}
			$init = false;
		}
	}

	public static function replaceSmileys($text)
	{
		return self::$allowSmileys ? str_replace(array_keys(self::$smileysReplace), array_values(self::$smileysReplace), $text): $text;
	}

	########################
	### Init Highlighter ###
	########################
	private static $highlight = array();
	public static function initHighlighter(array $highlight)
	{
		self::$highlight = $highlight;
	}
	public static function highlight($text)
	{
		foreach (self::$highlight as $hl)
		{
			if($hl !== '')
			{
				$hl = preg_quote($hl, '/');
				$text = preg_replace("/($hl)/i", '<span class="gwf_hl">$1</span>', $text);
			}
		}
		return $text;
	}

	####################
	### Decoder Main ###
	####################
	public static function decode($message)
	{
		$stack = $curr = new GWF_BBCodeItem();
		$t = '';
		$i = 0;
		$len = strlen($message);
		while($i < $len)
		{
			if ($message{$i} === '[')
			{
				if (false !== ($close_bracket = strpos($message, ']', $i)))
				{
					$read_len = $close_bracket - $i + 1;
					$full_tag = substr($message, $i, $read_len);
					$i += $read_len;
		
					list($tag, $params, $is_closing) = self::parseTag($curr, $full_tag);
		
					if ($tag === NULL)
					{
						$curr->addTextChild($full_tag);
					}
					elseif ($is_closing === true)
					{
						if (NULL === ($curr = $curr->close($tag))) {
							$curr = $stack;
						}
					}
					else
					{
						$new = new GWF_BBCodeItem();
						$new->setFullTag($full_tag);
						$new->setTag($tag);
						$new->setParams($params);
						$new->setParent($curr);
						$curr->addChild($new);
						$curr = $new;
					}
				}
				else {
					$curr->addTextChild(substr($message, $i));
					break;
				}
			}
			elseif (false === ($pos = strpos($message, '[', $i))) {
				$curr->addTextChild(substr($message, $i));
				break;
			}
			else {
				$read_len = $pos - $i;
				$curr->addTextChild(substr($message, $i, $read_len));
				$i += $read_len;
			}
		}

		return $stack->render();
	}

	private static function parseTag(GWF_BBCodeItem $item, $full_tag)
	{
		$full_tag = trim($full_tag, '[ ]');

		if ($full_tag === '') {
			return array(NULL, NULL, false);
		}

		if ($full_tag[0] === '/') {
			return array(substr($full_tag, 1), NULL, true);
		}


		# TODO: getTag() Optimize
		$pos_space = strpos($full_tag, ' ');
		$pos_equal = strpos($full_tag, '=');
		if ($pos_equal === false && $pos_space === false) {
			return array($full_tag, NULL, false);
		}
		if ($pos_space === false) {
			$pos_space = strlen($full_tag);
		}
		if ($pos_equal === false) {
			$pos_space = strlen($full_tag);
		}
		$pos = $pos_equal < $pos_space ? $pos_equal : $pos_space;
		$tag = substr($full_tag, 0, $pos);


		if (!method_exists($item, 'render_'.$tag)) {
			return array(NULL, NULL, false);
		}

		$params = NULL;
		foreach(explode(' ', $full_tag) as $arg)
		{
			if ('' === ($arg = trim($arg))) {
				continue;
			}
			$split = explode('=', $arg, 2);
			if (count($split) === 2)
			{
				if ($params === NULL) {
					$params = array();
				}
				$params[trim($split[0])] = trim($split[1]);
			}
		}
		return array($tag, $params, false);
	}
}
