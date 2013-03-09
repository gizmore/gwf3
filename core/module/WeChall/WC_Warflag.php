<?php
final class WC_Warflag extends GDO
{
	const WARFLAG = 0x01;
	const WARCHALL = 0x02;
// 	const MULTISOVE = 0x04;
	
	public static $STATUS = array('blueprint', 'alpha', 'beta', 'up', 'down', 'dead');
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warflag'; }
	public function getOptionsName() { return 'wf_options'; }
	public function getColumnDefines()
	{
		return array(
			'wf_id' => array(GDO::AUTO_INCREMENT),
			'wf_wbid' => array(GDO::UINT|GDO::INDEX),
				
			'wf_order' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'wf_cat' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, '', 32, /*WC_SiteCats::MAX_LEN*/),
			'wf_score' => array(GDO::UINT|GDO::INDEX, 1),
			'wf_solvers' => array(GDO::UINT, 0),

			'wf_title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 64),
			'wf_url' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, '', 255),
			'wf_authors' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, '', 255),
			'wf_status' => array(GDO::ENUM, 'up', self::$STATUS),

			'wf_login' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, '', 255),
			'wf_flag_enc' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, GWF_Password::SHA1LEN),

			'wf_created_at' => array(GDO::DATE, GDO::NOT_NULL, 14),
			'wf_last_solved_at' => array(GDO::DATE, GDO::NULL, 14),
			'wf_last_solved_by' => array(GDO::UINT, GDO::NULL),
				
			'wf_options' => array(GDO::UINT, self::WARFLAG),
				
			# Join
			'warbox' => array(GDO::JOIN, GDO::NULL, array('WC_Warbox', 'wb_id', 'wf_wbid')),
			'site' => array(GDO::JOIN, GDO::NULL, array('WC_Site', 'wb_sid', 'site_id')),
// 			'solvers' => array(GDO::JOIN, GDO::NULL, array('WC_Warflags', 'wf_wfid', 'wf_id')),
			'solver' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'user_id', 'wf_last_solved_by')),
		);
	}
	
	public function isWarflag() { return $this->isOptionEnabled(self::WARFLAG); }
	public function isWarchall() { return $this->isOptionEnabled(self::WARCHALL); }
// 	public function isMultisolve() { return $this->isOptionEnabled(self::MULTISOVE); }
	
	public function hrefEdit() { return GWF_WEB_ROOT.sprintf('index.php?mo=WeChall&me=Warflags&edit=%s&wbid=%s', $this->getID(), $this->getVar('wf_wbid')); }
	public function hrefSolvers() { return GWF_WEB_ROOT.sprintf('%s-solvers-for-%s.html', $this->getID(), $this->urlencodeSEO('wf_title')); }
		
	public function getTitle() { return $this->getVar('wf_title'); }
	
	public function displayCat() { return $this->display('wf_cat'); }
	public function displayName() { return $this->display('wf_title'); }
	
	public function displayLastSolvedDate()
	{
		if (NULL === ($date = $this->getVar('wf_last_solved_at')))
		{
			return '';
		}
		return GWF_Time::displayDate($date);
	}
	
	public function displayLastSolvedBy()
	{
		if (NULL === ($username = $this->getVar('user_name')))
		{
			return '';
		}
		return GWF_User::displayProfileLinkS($username);
	}
	
	public function getLevelNum()
	{
		$back = Common::regex('/(\d+)/', $this->getTitle());
		return $back < 1 ? false : (int)$back;
	}
	
	public function getURL()
	{
		if ('' !== ($url = $this->getVar('wf_url')))
		{
			return $url;
		}
		return $this->getVar('wb_weburl');
	}
	
	public function getWarbox()
	{
		return new WC_Warbox($this->gdo_data);
	}
	
	public function setLastSolver(GWF_User $user)
	{
		return $this->saveVars(array(
			'wf_last_solved_at' => GWF_Time::getDate(),
			'wf_last_solved_by' => $user->getID(),
		));
	}
	
	public function recalcSolvers()
	{
		return $this->saveVar('wf_solvers', WC_Warflags::getSolvecount($this));
	}
	
	public static function getByID($id)
	{
		return self::table(__CLASS__)->selectFirstObject('*', sprintf('wf_id=%d',$id), '', '', array('warbox', 'solver', 'site'));
	}
	
	public static function getByWarbox(WC_Warbox $warbox, $orderby='')
	{
		return self::table(__CLASS__)->selectAll('*', 'wf_wbid='.$warbox->getID(), $orderby, array('warbox', 'solver', 'site'), -1, -1, GDO::ARRAY_O);
	}
	
	public static function getForBoxAndUser(WC_Warbox $box, GWF_User $user, $orderby='')
	{
		$joins = array(
			'warbox',
			'solver',
			array('WC_Warflags', 'wf_wfid', 'wf_id', 'wf_uid', $user->getID()),
		);
		return self::table(__CLASS__)->selectAll('*', "wf_wbid={$box->getID()}", $orderby, $joins, -1, -1, GDO::ARRAY_O);
	}
	
	public static function getMaxscore(WC_Warbox $warbox)
	{
		return self::table(__CLASS__)->selectVar('SUM(wf_score)', "wf_wbid={$warbox->getID()}");
	}
	
	public static function getChallCount(WC_Warbox $warbox)
	{
		return self::table(__CLASS__)->selectVar('COUNT(*)', "wf_wbid={$warbox->getID()}");
	}
	
	/**
	 * We use no salts here, so we can support sites where the level you work on is not clear. 
	 * @param string $password
	 * @return string
	 */
	public static function hashPassword($password)
	{
		$rounds = preg_match('/[0-9a-z]{40}/iD', $password) ? 10000 : 10001;
			
		for ($i = 0; $i < $rounds; $i++)
		{
			$password = sha1($password);
		}
		return $password;
	}
	
	public static function getTotalscore(WC_Warbox $box)
	{
		return self::table(__CLASS__)->selectVar('SUM(wf_score)', "wf_wbid={$box->getID()}");
	}
	
	public static function getNextOrder(WC_Warbox $box)
	{
		return self::table(__CLASS__)->selectVar('COUNT(*)', "wf_wbid={$box->getID()}") + 1;
	}
	
	public static function getWarchalls(WC_Warbox $box)
	{
		return self::table(__CLASS__)->selectAll('*', "wf_wbid={$box->getID()}", '', NULL, -1, -1, GDO::ARRAY_O);
	}
	
	public static function getWarchall(WC_Warbox $box, $level)
	{
		$boxid = $box->getID();
		$elevel = self::escape($level);
		if (false !== ($chall = self::table(__CLASS__)->selectFirstObject('*', "wf_wbid={$boxid} AND wf_title='$elevel'", '', '', NULL)))
		{
			return $chall;
		}
		$chall = new self(array(
			'wf_id' => '0',
			'wf_wbid' => $boxid,
			'wf_order' => self::getNextOrder($box),
			'wf_cat' => 'exploit',
			'wf_score' => '1',
			'wf_solvers' => '0',
			'wf_title' => $level,
			'wf_url' => '',
			'wf_authors' => '',
			'wf_status' => 'up',
			'wf_login' => '',
			'wf_flag_enc' => NULL,
			'wf_created_at' => GWF_Time::getDate(),
			'wf_last_solved_at' => NULL,
			'wf_last_solved_by' => NULL,
			'wf_options' => self::WARCHALL,
		));
		if (!$chall->replace())
		{
			return false;
		}
		return $chall;
	}
	
}
?>
