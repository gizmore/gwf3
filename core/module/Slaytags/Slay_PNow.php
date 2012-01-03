<?php
final class Slay_PNow
{
	const URL = 'http://www.slayradio.org/ajax/gateway/playing/now';
	const NP_KEY = 'slay_np';
	const NP_NEXT_KEY = 'slay_npt';
	const NP_LOCK_KEY = 'slay_lock';
	
	const LIVE_ERROR = 'Live Show!';
	const LIVE_TIMEOUT = 180;
	
	public static function getNowPlaying(Module_Slaytags $module)
	{
		# Only once on fresh install!
		if (false === ($stid = GWF_Settings::getSetting(self::NP_KEY, false)))
		{
			return self::querySlay($module);
		}

		# Live show?
		if ($stid === '0')
		{
			if (self::timedOut())
			{
				echo "Timed out<br/>\n";
				return self::querySlay($module);
			}
			else
			{
				return self::dummySong($module, self::LIVE_ERROR, self::getTimeLeft());
			}
		}
		
		# DB Error should not happen
		if (false === ($np = Slay_Song::getByID($stid)))
		{
			return self::querySlay($module); # Simply query again
		}
		 
		if (self::timedOut())
		{
			Slay_PlayHistory::insertPlayed($np, self::getEndTime());
			return self::querySlay($module);
		}
		
		return $np;
	}
	
	public static function requestSlay(Module_Slaytags $module)
	{
		if (false === ($page = GWF_HTTP::getFromURL(self::URL)))
		{
			return false;
		}
		
		if (false === ($data = json_decode($page, true)))
		{
			return false;
		}
		
		return $data;
	}

	public static function querySlayLiveshow(Module_Slaytags $module, $url)
	{
//		if (false === ($data = self::requestSlay($module)))
//		{
//			return self::dummySong($module);
//		}
		return self::dummySong($module, self::LIVE_ERROR, self::LIVE_TIMEOUT);
	}
	
	public static function querySlay(Module_Slaytags $module)
	{
		if (false === ($data = self::requestSlay($module)))
		{
			return self::dummySong($module);
		}
		
//		var_dump($data);
//		$data = new Slay_Response($data);
		
		if ( (isset($data['live'])) && ($data['live']) )
		{
			return self::querySlayLiveshow($module, $data['redirect_url']);
		}
		
		$now = (int) $data['now'];
		$started = (int) $data['started'];
		$ending = (int) $data['ending'];
		$left = $ending - $now;
		$duration = $ending - $started;
		
		$si = $data['slay_info'];
		$slay_id = $si['songID'];
		$artist = $si['artist'];
		$title = $si['title'];
		$album = $si['album'];
		$composer = $si['SID_composer'];
		$sid_path = isset($si['url_SID']) ? $si['url_SID'] : NULL;
		
		$rko_id = 0;
		$rko_vote = 0;
		if (isset($data['rko_info']))
		{
			$ri = $data['rko_info'];
			$rko_id = $ri['rko_ID'];
			$rko_vote = $ri['r64_vote'];
			$sid_path = isset($ri['SID_path']) ? $ri['SID_path'] : $sid_path;
		}
		
		$sid_path = $sid_path === NULL ? NULL : Common::substrFrom($sid_path, '?sid_tune=', $sid_path);
		
		
		if (false === ($song = Slay_Song::getBySlayID($slay_id)))
		{
			if (false === ($song = Slay_Song::getByArtistTitle($artist, $title)))
			{
				$options = 0;
				$options |= $rko_id > 0 ? Slay_Song::HAS_DOWNLOAD : 0;
				
				$song = new Slay_Song(array(
					'ss_id' => 0,
					'ss_rko_id' => $rko_id,
					'ss_c64_id' => 0,
					'ss_slay_id' => $slay_id,
				
					'ss_title' => $title,
					'ss_artist' => $artist,
					'ss_composer' => $composer,
				
					'ss_taggers' => 0,
					'ss_lyrics' => 0,
					'ss_duration' => $duration,
					'ss_played' => 0,
					'ss_options' => $options,
					'ss_last_played' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
					'ss_tag_cache' => NULL,
					'ss_r64_vote' => $rko_vote,
					'ss_sid_path' => $sid_path,
				));
				if (false === $song->insert())
				{
					return self::dummySong($module);
				}
			}
		}
		
		$song->increase('ss_played', 1);
		
		GWF_Settings::setSetting(self::NP_KEY, $song->getID());
		GWF_Settings::setSetting(self::NP_NEXT_KEY, time()+$left+1);
		
		return $song;
	}
	
	public static function timedOut()
	{
		return self::getEndTime() <= time();
	}
	
	public static function getTimeLeft()
	{
		return self::getEndTime() - time();
	}
	
	public static function getEndTime()
	{
		return GWF_Settings::getSetting(self::NP_NEXT_KEY, time());
	}
	
	public static function isPlaying(Slay_Song $song)
	{
		return GWF_Settings::getSetting(self::NP_KEY) === $song->getID();
	}
	
	public static function dummySong(Module_Slaytags $module, $error='GWFv3 ERROR', $timeout=60)
	{
		GWF_Settings::setSetting(self::NP_KEY, '0');
		GWF_Settings::setSetting(self::NP_NEXT_KEY, time()+$timeout);
		
		return new Slay_Song(array(
			'ss_id' => -1,
			'ss_rko_id' => -1,
			'ss_c64_id' => -1,
			'ss_slay_id' => -1,
			'ss_title' => $error,
			'ss_artist' => $error,
			'ss_composer' => $error,
			'ss_lyrics' => 0,
			'ss_taggers' => 0,
			'ss_duration' => $timeout,
			'ss_played' => 0,
			'ss_options' => 0,
			'ss_last_played' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
			'ss_tag_cache' => NULL,
			'ss_r64_vote' => -1,
			'ss_sid_path' => NULL,
		));
	}
}
?>