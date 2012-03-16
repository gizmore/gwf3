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
			array('/#!\/usr\/bin\/perl\s.*/i', 6),
			array('/\s*use\s+?\w*?\:*?:*?\w*?;*?/i', 4),
			array('/.*\ssub\s.*/i', 2),
			array('/.*\suntil\s.*/i', 2),
			array('/.*\sunless\s.*/i', 2),
			array('/.*\slast\s.*/i', 2),
			array('/.*\snext\s.*/i', 2),
			array('/.*\sredo\s.*/i', 3),
			array('/#!\/usr\/bin\/perl\s.*/i', 6),
		),
		'php' => array(
			array('/<\?php/i', 6),
			array('/strrpos/i', 4),
			array('/while/i', 1),
			array('/print/i', 1),
			array('/\$/i', 1),
			array('/echo/i', 1),
		),
		'prolog' => array(
			array('/\s*%(.)*\n/', 1),
			array('/[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*\./i', 2),
			array('/\s*[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*:-[_a-z0-9\[\]]+\s*\(\s*[_a-z0-9\[\]]+\s*(,\s*[_a-z0-9\[\]]+\s*)*\)\s*(%.*\n)?/i', 4),
		),
		'html4strict' => array(
			array('/<html>/', 6),
			array('/<body>/', 6),
			array('/<a href/', 6),
			array('/<div/', 3),
			array('/<table/', 6),
			array('/<br/', 6),
		),
		'java' => array(
			array('/import java/', 6),
			array('/public static void/', 2),
			array('/class/', 2),
			array('/implements/', 2),
			array('/extends/', 2),
			array('/interface/', 2),
		),
		'c' => array(
			array('/#include\s+(<|")/i', 6),
			array('/#define\s+/i', 6),
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

		foreach ($langs as $lang => $data)
		{
			$score = 0;
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
		return $language;
	}
}
