<?php
final class Dog_Forum extends GDO
{
	const DELETED = 0x01;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'dog_forum'; }
	public function getOptionsName() { return 'df_options'; }
	public function getColumnDefines()
	{
		return array(
			'df_id' => array(GDO::AUTO_INCREMENT),
			'df_url' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 255),
 			'df_date' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'df_title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, GDO::NOT_NULL, 24),
			'df_last' => array(GDO::UINT, 0),
			'df_options' => array(GDO::UINT, 0),
		);
	}
	
	public function getID() { return $this->getVar('df_id'); }
	public function getURL() { return $this->getVar('df_url'); }
	public function getDate() { return $this->getVar('df_date'); }
	public function getTitle() { return $this->getVar('df_title'); }
	public function isDeleted() { return $this->isOptionEnabled(self::DELETED); }
	public function isEnabled() { return !$this->isDeleted(); }
	public function getTLD() { return GWF_HTTP::getDomain($this->getURL()); }
	public function getLast() { return $this->getVar('df_last'); }
	public function displayName() { return sprintf("%d-%s", $this->getID(), $this->getTLD()); }
	public function getReplacedURL($gwf_date, $limit) { return str_replace(array('%DATE%', '%LIMIT%'), array($gwf_date, $limit), $this->getURL()); }
	
	public static function getCache()
	{
		return self::table(__CLASS__)->selectAll('*', '', 'df_id', NULL, -1, -1, GDO::ARRAY_O);
	}
	
	public static function testBoard($url, $title)
	{
		$board = new self(array(
			'df_id' => '0',
			'df_url' => $url,
 			'df_date' => '20100101000000',
			'df_title' => $title,
			'df_last' => '0',
			'df_options' => 0.
		));
		
		if (false === ($entries = $board->fetchEntries('19700101000000', 1)))
		{
			return false;
		}
		
		return $board;
	}

	private function sendRequest($gwf_date, $limit)
	{
		GWF_HTTP::setTimeout(3);
		GWF_HTTP::setConnectTimeout(2);
		$content = GWF_HTTP::getFromURL($this->getReplacedUrl($this->getDate(), $limit));
		GWF_HTTP::setTimeout();
		GWF_HTTP::setConnectTimeout();
		return $content;
	}
	
	public static function unescape_csv_like($s)
	{
		return str_replace('\\:', ':', $s);
	}
	
	public function updateDatestamp(Dog_ForumEntry $entry)
	{
		return $this->saveVars(array(
 			'df_date' => $entry->getLastDate(),
			'df_last' => $entry->getThreadID(),
		));
	}
	
	public function fetchNewEntries($limit)
	{
		return $this->fetchEntries($this->getDate(), $limit);
	}
	
	public function fetchEntries($gwf_date, $limit)
	{
		if (false === ($content = $this->sendRequest($gwf_date, $limit)))
		{
			return false;
		}
		
		$entries = array();
		
		$lines = explode("\n", $content);
		foreach ($lines as $line)
		{
			if ('' === ($line = trim($line)))
			{
				continue;
			}
		
			$thedata = explode('::', $line);
			if (count($thedata) !== 6)
			{
				echo 'Invalid line in dog_wc_forum: '.$line.PHP_EOL;
				return false;
			}
		
			$thedata = array_map(array(__CLASS__, 'unescape_csv_like'), $thedata);
		
			# Fetch line
			list($threadid, $lastdate, $boardid, $url, $username, $title) = $thedata;
		
			if (!Common::isNumeric($threadid))
			{
				echo 'Invalid threadid in dog_wc_forum: '.$line.PHP_EOL;
				return false;
			}
			if (!GWF_Time::isValidDate($lastdate, false, 14))
			{
				echo 'Invalid date in dog_wc_forum: '.$line.PHP_EOL;
				return false;
			}

			if (!Common::isNumeric($boardid))
			{
				echo 'Invalid boardid in dog_wc_forum: '.$line.PHP_EOL;
				return false;
			}
			
			$entries[] = new Dog_ForumEntry($thedata);
		}
		
		if (count($entries) > 0)
		{
			$deleting = 1;
			foreach ($entries as $id => $entry)
			{
				$entry instanceof Dog_ForumEntry;
				
				if ($entry->getLastDate() === $this->getDate())
				{
					if ($deleting)
					{
						if ($entry->getThreadID() === $this->getLast())
						{
							$deleting = 0;
						}
						unset($entries[$id]);
					}
				}
			}
		}
		
		return array_values($entries);
	}
}
?>
