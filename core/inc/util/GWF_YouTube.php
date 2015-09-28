<?php
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
		if(!defined('GWF_GOOGLE_API_KEY')) return false;

		$json = GWF_HTTP::getFromURL('https://www.googleapis.com/youtube/v3/videos?id='.$youtube_id.'&part=snippet,contentDetails,statistics&key='.constant('GWF_GOOGLE_API_KEY'));
		$ytdata = json_decode($json,true);
		if($ytdata === NULL) return false;

		if(!array_key_exists('items',$ytdata) || count($ytdata['items']) !== 1) return false;
		$video = $ytdata['items'][0];

		if(!array_key_exists('snippet',$video)) return false;
		if(!array_key_exists('contentDetails',$video)) return false;
		if(!array_key_exists('statistics',$video)) return false;

		$data = array();

		$data['title'] = $video['snippet']['title'];
		$duration = $video['contentDetails']['duration'];
		$duration = str_replace(array('P','D','T','H','M','S'),array('','d','','h','i','s'),$duration);
		$data['duration'] = GWF_TimeConvert::humanToSeconds($duration);
		$data['views'] = $video['statistics']['viewCount'];
		$data['likes'] = $video['statistics']['likeCount'];
		$data['dislikes'] = $video['statistics']['dislikeCount'];

		return $data;
	}

}

