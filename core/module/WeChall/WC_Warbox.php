<?php
final class WC_Warbox extends GDO
{
	public static $STATUS = array('up', 'down', 'dead');
	
	const WARBOX = 0x01;
	const MULTI_SOLVE = 0x02;
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warbox'; }
	public function getOptionsName() { return 'wb_options'; }
	public function getColumnDefines()
	{
		return array(
			'wb_id' => array(GDO::AUTO_INCREMENT),
			'wb_sid' => array(GDO::UINT, GDO::NOT_NULL),

			'wb_name' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I|GDO::UNIQUE, '', 31),
			'wb_levels' => array(GDO::MEDIUMINT, -1),
			'wb_port' => array(GDO::UMEDIUMINT, 113),
			'wb_host' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 255),
			'wb_user' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_I, '',  63),
			'wb_pass' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, '',  63),
			'wb_weburl' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'wb_ip' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_I, '',  63),
			'wb_whitelist' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'wb_blacklist' => array(GDO::TEXT|GDO::UTF8|GDO::CASE_S),
			'wb_launched_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_DAY),
				
			'wb_created_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'wb_updated_at' => array(GDO::DATE, GDO::NULL, GWF_Date::LEN_SECOND),
			'wb_status' => array(GDO::ENUM, 'up', self::$STATUS),
				
			'wb_options' => array(GDO::UINT, 0),
				
			# JOIN
			'sites' => array(GDO::JOIN, GDO::NULL, array('WC_Site', 'site_id', 'wb_sid')),
			'flags' => array(GDO::JOIN, GDO::NULL, array('WC_Warflag', 'wb_id', 'wf_wbid')),
		);
	}
	
	public function getID() { return $this->getVar('wb_id'); }
	public function getSite() { return new WCSite_WARBOX($this->gdo_data); }
	public function getSiteID() { return $this->getVar('wb_sid'); }
	public function hrefEdit() { return sprintf('index.php?mo=WeChall&me=Warboxes&siteid=%s&edit=%s', $this->getSiteID(), $this->getID()); }
	public function isWarbox() { return $this->isOptionEnabled(self::WARBOX); }
	public function isMultisolve() { return $this->isOptionEnabled(self::MULTI_SOLVE); }
	
	public function getStatus() { return $this->getVar('wb_status'); }
	public function isUp() { return $this->getStatus() === 'up'; }
	public function isDown() { return $this->getStatus() === 'down'; }
	public function isDead() { return $this->getStatus() === 'dead'; }
	
	public function hasWarFlags()
	{
		return WC_Warflag::getChallCount($this) > 0;
	}
	
	public function hrefFlags()
	{
		return GWF_WEB_ROOT.'index.php?mo=WeChall&me=Warsolve&boxid='.$this->getID();
	}
		
	public function displayLink()
	{
		if ('' === ($url = $this->getVar('wb_weburl')))
		{
			return $this->display('wb_host');
		}
		return GWF_HTML::anchor($url, $this->getVar('wb_host'));
	}
	
	public function displayLevels()
	{
		if (0 > ($levels = $this->getVar('wb_levels')))
		{
			return '??';
		}
		return $levels;
	}
	
	public function hasEditPermission($user)
	{
		if ($user === false)
		{
			return false;
		}
		$user instanceof GWF_User;
		if ($user->isAdmin())
		{
			return true;
		}
		$this->module->includeClass('WC_SiteAdmin');
		return WC_SiteAdmin::isSiteAdmin($user->getID(), $this->getSiteID());
	}
	
	public function parseFlagStats(GWF_User $user, &$stats)
	{
		$this->setVar('wb_levels', '0');
		
		$flags = WC_Warflag::getForBoxAndUser($this, $user);
		if (count($flags) > 0)
		{
			$score = 0;
			$challs = 0;
			$maxscore = 0;
			foreach ($flags as $flag)
			{
				$flag instanceof WC_Warflag;
				
				if ($flag->getVar('wf_solved_at') !== NULL)
				{
					$score += $flag->getVar('wf_score');
					$challs++;
				}
				
				$maxscore += $flag->getVar('wf_score');
			}
			
			# Remember challcount
			$this->setVar('wb_levels', count($flags));
			
			# Save usercount?
			if ($this->getSite()->isNoV1())
			{
			}
			
			// score, rank, challssolved, maxscore, usercount, challcount
			$stats[0] += $score;
// 			$stats[1]; RANK
			$stats[2] += $challs;
			$stats[3] += $maxscore;
// 			$stats[4]; USERCOUNT
			$stats[5] += count($flags);
		}
		
	}
	
	public function parseWarboxStats(GWF_User $user, &$stats)
	{
		$warchalls = WC_Warchall::getForBoxAndUser($this, $user);
		if (count($warchalls) > 0)
		{
			$score = 0;
			$challs = 0;
			$maxscore = 0;
			foreach ($warchalls as $chall)
			{
				$chall instanceof WC_Warchall;
			
				if ($chall->getVar('wc_solved_at') !== NULL)
				{
					$score += $chall->getVar('wc_score');
					$challs++;
				}
			
				$maxscore += $chall->getVar('wc_score');
			}
			
			# Save challcount
			$this->setVar('wb_levels', $this->getVar('wb_levels') + count($warchalls));
			
			# Save usercount?
			if ($this->getSite()->isNoV1())
			{
			}
			
			// score, rank, challssolved, maxscore, usercount, challcount
			$stats[0] += $score;
// 			$stats[1]; RANK
			$stats[2] += $challs;
			$stats[3] += $maxscore;
// 			$stats[4]; USERCOUNT
			$stats[5] += count($warchalls);
			
		}
		
		# BAH!
		$levels = $this->getVar('wb_levels'); # Get Cache
		$this->setVar('wb_levels', '-2'); # Invalidate cache -.-
		$this->saveVar('wb_levels', $levels); # Save!
	}
	
	public function isBlacklisted($level)
	{
		return $this->isListed('wb_blacklist', $level);
	}
	
	public function isWhitelisted($level)
	{
		return $this->isListed('wb_whitelist', $level);
	}
	
	public function isListed($list, $level)
	{
		if ('' !== ($list = $this->getVar($list)))
		{
			foreach (explode(',', $list) as $pattern)
			{
				if (preg_match('/^'.$pattern.'$/D', $level))
				{
					return true;
				}
			}
		}
		return false;
	}
	
	public static function getByID($id)
	{
		return self::table(__CLASS__)->selectFirstObject('*', sprintf('wb_id=%d', $id), '', '', array('sites'));
	}
	
	public static function getByIDs($id, $siteid)
	{
		$where = sprintf('wb_id=%d AND wb_sid=%d', $id, $siteid);
		return self::table(__CLASS__)->selectFirstObject('*', $where, '', '', array('sites'));
	}
	
	public static function getBoxes(WC_Site $site)
	{
		return self::getAllBoxes('wb_sid='.$site->getID());
	}
	
	public static function getAllBoxes($where='', $orderby='')
	{
		return self::table(__CLASS__)->selectAll('*', $where, $orderby, array('sites'), -1, -1, GDO::ARRAY_O);
	}
	
	public static function getByIP($ip)
	{
		$ip = self::escape($ip);
		return self::getAllBoxes("wb_ip='$ip'", 'wb_port ASC');
	}

	public static function getByIPAndPort($ip, $port)
	{
		$ip = self::escape($ip);
		$port = self::escape($port);
		return self::getAllBoxes("wb_ip='$ip' AND wb_port='$port'");
	}
}
?>
