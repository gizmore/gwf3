<?php
/**
 * Stolen from noother´s irc bot; Nimda3
 * https://github.com/noother/Nimda3/blob/master/libs/libInternet.php
 * @author noother
 */
final class GWF_YouTube
{
	static function youtubeID($string) {
		if(
				preg_match('#youtube\.com/.*?(?:(?:(?:\?|&)v=)|(?:\#(?:./){4}))([a-zA-Z0-9_-]{11})#', $string, $arr) ||
				preg_match('#youtu\.be/([a-zA-Z0-9_-]{11})#', $string, $arr)
		) {
			return $arr[1];
		} else {
			return false;
		}
	}

	static function getYoutubeData($youtube_id) {
		if(empty($youtube_id)) return false;

		$html = GWF_HTTP::getFromURL('http://gdata.youtube.com/feeds/api/videos/'.$youtube_id);
		$xml = simplexml_load_string($html);
		if($xml === false) return false;

		$data = array();

		$media = $xml->children('http://search.yahoo.com/mrss/');
		$data['title'] = (string)$media->group->title;
		$data['description'] = (string)$media->group->description;
		$data['category'] = (string)$media->group->category;
		$data['keywords'] = explode(', ',$media->group->keywords);
		$data['link'] = (string)$media->group->player->attributes()->url;
		$data['duration'] = (int)$media->children('http://gdata.youtube.com/schemas/2007')->duration->attributes()->seconds;
		$data['thumbnails'] = array();
		foreach($media->group->thumbnail as $thumbnail) {
			array_push (
					$data['thumbnails'], array (
							'url' => (string)$thumbnail->attributes()->url,
							'width' => (int)$thumbnail->attributes()->width,
							'height' => (int)$thumbnail->attributes()->height
					)
			);
		}

		$data['published'] = strtotime($xml->published);
		$data['author'] = (string)$xml->author->name;

		$gd = $xml->children('http://schemas.google.com/g/2005')->rating->attributes();
		$data['rating'] = (float)$gd->average;
		$data['num_raters'] = (int)$gd->numRaters;

		$data['views'] = (int)$xml->children('http://gdata.youtube.com/schemas/2007')->statistics->attributes()->viewCount;

		return $data;
	}

}

