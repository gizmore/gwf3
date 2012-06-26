<?php
/**
 * Guess a code language by pattern
 * @author spaceone
 * @author byte
 */
final class GWF_GuessCodeLang
{
	public static $langs = array(
		'perl' => array(
			array('/^#!\/usr\/bin\/(?:env )?perl\s.*/i', 6),
			array('/\s*use\s+?\w*?\:*?:*?\w*?;*?/i', 4),
			array('/.*\ssub\s.*/i', 2),
			array('/.*\suntil\s.*/i', 2),
			array('/.*\sunless\s.*/i', 2),
			array('/.*\slast\s.*/i', 2),
			array('/.*\snext\s.*/i', 2),
			array('/.*\sredo\s.*/i', 3),
		),
		'php' => array(
			array('/^#!\/usr\/bin\/(?:env )?php/', 6),
			array('/^<\?php/i', 6),
			array('/strrpos/i', 4),
			array('/while/i', 1),
			array('/print/i', 1),
			array('/\$/i', 1),
			array('/echo/i', 4),
			array('/(?:require|include)(?:\(?|_once)/', 6),
			array('/GWF_/', 10), # muhaha
		),
		'prolog' => array(
			array('/\s*%(.)*\n/', 1),
			array('/[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*\./i', 2),
			array('/\s*[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*:-[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*(%.*\n)?/i', 4),
		),
		'html4strict' => array(
			array('/^<!DOCTYPE html/', 6),
			array('/<html>/', 6),
			array('/<body>/', 6),
			array('/<a href/', 6),
			array('/<(?:table|meta|link|head|div|script|from|h[1-6])/', 4),
			array('/<(?:br|p) ?\/?>/', 4),
			array('/ (?:class|id)="/', 4),
		),
		'java' => array(
			array('/^import java/', 6),
			array('/^import /', 4),
			array('/public static void/', 2),
			array('/class/', 2),
			array('/implements/', 2),
			array('/extends/', 2),
			array('/interface/', 2),
		),
		'c' => array(
			array('/^#include\s+(<|")/i', 6),
			array('/^#define\s+/i', 6),
		),
		'DiffFileFormat' => array(
			array('/^(\+|\-){3}/', 6),
			array('/^[\+\- ]/', 4),
			array('/^=+$/', 3),
			array('/^@@ \-[0-9]+,[0-9]+ \+[0-9]+,[0-9]+ @@/', 6),
			array('/^Index: /', 2),
			array('/\(Revision [0-9] \)/', 2),
		),
		'python' => array(
			array('/^#!\/usr\/bin\/(?:env )?python/', 6),
			array('/^from [a-zA-Z]+ import/', 6),
			array('/^import /', 4),
			array('/"""/', 4),
			array("/'''/", 4),
		),
	);

	/**
	 * Guess a Language
	 * Can be used for geshi
	 * @return string language name
	 */
	public static function guessLanguage($sourcecode)
	{
		$max_score = 5;
		$language = 'text';

		foreach (self::$langs as $lang => $patterns)
		{
			$score = 0;
			foreach ($patterns as $data)
			{
				list($pattern, $points) = $data;

				if (preg_match_all($pattern, $sourcecode, $matches))
				{
					$score += count($matches[0]) * $points;
				}
				if ($score > $max_score)
				{
					$max_score = $score;
					$language = $lang;
		    	}
		    }
		}
		return $language;
	}
}
