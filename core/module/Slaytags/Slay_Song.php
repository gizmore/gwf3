<?php
final class Slay_Song extends GDO
{
	private $votes = NULL;
	
	const HAS_DOWNLOAD = 0x01;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'slay_song'; }
	public function getOptionsName() { return 'ss_options'; }
	public function getColumnDefines()
	{
		return array(
			'ss_id' => array(GDO::AUTO_INCREMENT),
			'ss_rko_id' => array(GDO::UINT|GDO::INDEX, 0),
			'ss_c64_id' => array(GDO::UINT|GDO::INDEX, 0),
			'ss_slay_id' => array(GDO::UINT|GDO::INDEX, 0),
		
			'ss_title' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'ss_artist' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
			'ss_composer' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I), # SID composer
		
			'ss_lyrics' => array(GDO::INT|GDO::TINY|GDO::UNSIGNED|GDO::INDEX, 0),
			'ss_taggers' => array(GDO::INT|GDO::MEDIUM|GDO::UNSIGNED|GDO::INDEX, 0),
			'ss_duration' => array(GDO::INT|GDO::MEDIUM|GDO::UNSIGNED|GDO::INDEX, 0),
			'ss_played' => array(GDO::UINT, 0),
			'ss_options' => array(GDO::UINT|GDO::INDEX, 0),
			'ss_last_played' => array(GDO::DATE, GDO::NOT_NULL, GWF_Date::LEN_SECOND),
			'ss_tag_cache' => array(GDO::TEXT|GDO::ASCII|GDO::CASE_I),
			'ss_r64_vote' => array(GDO::INT|GDO::TINY|GDO::INDEX, 0),
			'ss_sid_path' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_I),
		
			# JOINS
			'tags' => array(GDO::JOIN, GDO::NULL, array('Slay_SongTag', 'sst_sid', 'ss_id')),
			'lyrics' => array(GDO::JOIN, GDO::NULL, array('Slay_Lyrics', 'ssl_sid', 'ss_id')),
			'tagvotes' => array(GDO::JOIN, GDO::NULL, array('Slay_TagVote', 'stv_sid', 'ss_id')),
			'searchtag' => array(GDO::JOIN, GDO::NULL, array('Slay_SongTag', 'sst_sid', 'ss_id', 'sst_tid', Common::getGetInt('searchtag', '0'))),
		);
	}
	
	public function isTagged() { return $this->getVar('ss_taggers') > 0; }
	public function isRKO() { return $this->getVar('ss_rko_id') > 0; }
	public function isPlaying() { return Slay_PNow::isPlaying($this); }
	public function hasLyrics() { return $this->getVar('ss_lyrics') > 0; }
	public function getTags() { return Slay_Tag::getTags($this); }
	public function displayDuration() { return GWF_Time::humanDuration($this->getVar('ss_duration')); }
	public function hrefTag() { return GWF_WEB_ROOT.'index.php?mo=Slaytags&me=Tag&stid='.$this->getID(); }
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=Slaytags&me=EditSong&stid='.$this->getID(); }
	public function hrefLyrics() { return GWF_WEB_ROOT.'index.php?mo=Slaytags&me=AddLyrics&stid='.$this->getID(); }
	public function hrefShowLyrics() { return GWF_WEB_ROOT.'index.php?mo=Slaytags&me=ShowLyrics&stid='.$this->getID(); }
	public function hrefRKO()
	{
		if (0 === ($kw_id = $this->getInt('ss_rko_id')))
		{
			return false;
		}
		
		return htmlspecialchars(sprintf('http://remix.kwed.org/download.php/%d/%s%%20-%%20%s.mp3', $kw_id, $this->urlencode('ss_artist'), $this->urlencode('ss_title')));	
		
	}
	public function displayDownloadButton(Module_Slaytags $module)
	{
		if (false === ($href = $this->hrefRKO()))
		{
			return '';
		}
		return sprintf('<a class="gwf_button" href="%s" title="%s"><span class="gwf_btn_generic">%s</span></a> ', $href, $module->lang('dl_from_rko'), 'D');
	}
	public function displaySIDButton(Module_Slaytags $module)
	{
		if (NULL === ($sid_path = $this->getVar('ss_sid_path')))
		{
			return '';
		}
		
		return sprintf('');
	}
	
	/**
	 * Get a song by id.
	 * @param int $id
	 * @return Slay_Song
	 */
	public static function getByID($id)
	{
		return self::table(__CLASS__)->getRow($id);
	}
	
	/**
	 * Get a song by slay-id.
	 * @param int $slay_id
	 * @return Slay_Song
	 */
	public static function getBySlayID($slay_id)
	{
		return self::table(__CLASS__)->getBy('ss_slay_id', $slay_id);
	}
	
	/**
	 * Get a song by artist and title.
	 * @param string $artist
	 * @param string $title
	 * @return Slay_Song
	 */
	public static function getByArtistTitle($artist, $title)
	{
		$title = GDO::escape($title);
		$artist = GDO::escape($artist);
		return self::table(__CLASS__)->selectFirstObject('*', "ss_title='$title' AND ss_artist='$artist'");
	}
	
	
	public function getVote($tag)
	{
		$this->loadVotes();
		return isset($this->votes[$tag]) ? $this->votes[$tag]['sst_count'] : 0;
	}
	
	public function getVotePercent($tag, $precision=2)
	{
		if (0 == ($taggers = $this->getVar('ss_taggers')))
		{
			return '0.'.str_repeat('0', $precision);
		}
		return sprintf('%.0'.$precision.'f', $this->getVote($tag)/$this->getVar('ss_taggers')*100);
	}
	
	private function loadVotes()
	{
		if (!is_array($this->votes))
		{
			$this->votes = Slay_SongTag::getVotes($this);
		}
	}
	
	public function computeTags()
	{
		$taggers = Slay_TagVote::countTaggers($this);
		
		if (false === $this->saveVar('ss_taggers', $taggers))
		{
			return false;
		}
		
		if (false === Slay_SongTag::computeVotes($this, $taggers))
		{
			return false;
		}
		
		$this->votes = NULL;
		
		return true;
	}
	
	public function updateLyricsCount()
	{
		$this->saveVar('ss_lyrics', Slay_Lyrics::getLyricsCount($this));
	}	
}
?>