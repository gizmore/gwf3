<?php

final class Hangman_Words extends GDO
{
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'lamb_hangman'; }
	public function getColumnDefines()
	{
		return array(
			'hangman_id' => array(GDO::AUTO_INCREMENT),
			'hangman_text' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
//			'hangman_rating' => array(GDO::INT, 0),
//			'hangman_date' => array(GDO::DATE, GDO::NOT_NULL, 14),
		);
	}

	public static function getByID($hang_id)
	{
		return self::table(__CLASS__)->getRow($hang_id);
	}

	public static function getRandomWord()
	{
		if (false === ($row = self::table(__CLASS__)->selectRandom('hangman_text', '', 1, NULL, GDO::ARRAY_N)))
		{
			return false;
		}
		
		if (count($row) === 0)
		{
			return false;
		}
		
		return $row[0][0];
	}

	public static function getByWord($hang_word)
	{
		$hang_word = GDO::escape($hang_word);
		return self::table(__CLASS__)->selectFirstObject('*', "hangman_text='$hang_word'");
	}

	public static function insertWord($hang_word)
	{
		$word = new self(array(
			'hangman_id' => 0,
			'hangman_text' => $hang_word,
		));
		if (false === $word->insert())
		{
			return false;
		}
		return $word;
	}
}
