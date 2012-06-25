<?php

/**
 * @author spaceone
 * @author noother
 * @see https://github.com/noother/Nimda3/blob/master/plugins/user/Plugin_Translate.php
 */
class LambModule_Translate extends Lamb_Module
{
	public function getTriggers($priviledge, $showHidden=true)
	{
		$languages = array(
			'af', 'ar', 'az', 'be', 'bg', 'bn', 'ca', 'cs', 'cy', 'da', 'de', 'el', 'en', 'es',
			'et', 'eu', 'fa', 'fi', 'fr', 'ga', 'gl', 'gu', 'hi', 'hr', 'ht', 'hu', 'hy', 'id',
			'is', 'it', 'iw', 'ja', 'ka', 'kn', 'ko', 'la', 'lt', 'lv', 'mk', 'ms', 'mt', 'nl',
			'no', 'pl', 'pt', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr', 'sv', 'sw', 'ta', 'te', 'th',
			'tl', 'tr', 'uk', 'ur', 'vi', 'yi'
		);

		$pubtriggers = array('translate');
		
		if ($showHidden)
		{
			foreach($languages as $lang1)
			{
				foreach($languages as $lang2)
				{
					if($lang1 !== $lang2)
					{
						$pubtriggers[] = $lang1.'-'.$lang2;
					}
				}
				$pubtriggers[] = 'auto-'.$lang1;
			}
		}

		switch($priviledge)
		{
			case 'public':
				return $pubtriggers;
			default:
				return array();
		}
	}

	public function getHelp()
	{
		return array(
			'translate' => 'Translates some foreign language to the channel language.' .
			'There are also shortcuts available, like .en-de, .pl-ja, etc.',
		);
	}

	public static function googleTranslate($text, $from='auto', $to='de', $return_source_lang=false)
	{
		# TODO: Gizmore: will this block the whole lamb? => YES
		$html = GWF_HTTP::post('http://translate.google.com/', array(
			'sl' => $from,
			'tl' => $to,
			'js' => 'n',
			'hl' => 'en',
			'ie' => 'UTF-8',
			'text' => $text
		));

		if(!preg_match('#<span id=result_box .+?>(.+?)</div>#', $html, $arr)) return false;
		$translation = mb_convert_encoding(strip_tags($arr[1]), 'UTF-8', 'HTML-ENTITIES');

		if($return_source_lang)
		{
			if(!preg_match('#<div id=autotrans.+?<h3.+?>(.+?) to .+? translation</h3>#', $html, $arr))
				return false;
			return array('translation' => $translation, 'source_lang' => $arr[1]);
		}
		else
		{
			return $translation;
		}
	}

	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		if($command === 'translate')
		{
			$server->reply($origin, '');
			return;
		}

		list($sl, $tl) = explode('-', $command);

		if(false === ($translation = self::googleTranslate($message, $sl, $tl, $sl=='auto')))
		{
			$server->reply($origin, "\x02Something weird occurred \x02");
			return;
		}

		if($sl === 'auto')
		{
			$out = "\x02Translation from ".$translation['source_lang'].": \x02".$translation['translation'];
		}
		else
		{
			$out = "\x02Translation: \x02".$translation;
		}

		$server->reply($origin, $out);
	}
}
?>
