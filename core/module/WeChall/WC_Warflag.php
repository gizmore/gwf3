<?php
final class WC_Warflag extends GDO
{
	public static $STATUS = array('blueprint', 'alpha', 'beta', 'up', 'down', 'dead');
	
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'wc_warflag'; }
	public function getColumnDefines()
	{
		return array(
			'wf_id' => array(GDO::AUTO_INCREMENT),
			'wf_wbid' => array(GDO::UINT|GDO::INDEX),
				
			'wf_order' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'wf_cat' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::INDEX, '', 32, /*WC_SiteCats::MAX_LEN*/),
			'wf_score' => array(GDO::UINT|GDO::INDEX, 1),

			'wf_title' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NOT_NULL, 64),
			'wf_url' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NULL, 255),
			'wf_authors' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NULL, 255),
			'wf_status' => array(GDO::ENUM, 'up', self::$STATUS),

			'wf_login' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NULL, 255),
			'wf_flag' => array(GDO::VARCHAR|GDO::UTF8|GDO::CASE_S, GDO::NULL, 255),
			'wf_flag_enc' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NULL, GWF_Password::SHA1LEN),

			'wf_created_at' => array(GDO::DATE, GDO::NOT_NULL, 14),
			'wf_last_solved_at' => array(GDO::DATE, GDO::NULL, 14),
			'wf_last_solved_by' => array(GDO::UINT, GDO::NULL),
				
			# Join
			'warbox' => array(GDO::JOIN, GDO::NULL, array('WC_Warbox', 'wb_id', 'wf_wbid')),
			'solver' => array(GDO::JOIN, GDO::NULL, array('GWF_User', 'user_id', 'wf_last_solved_by')),
		);
	}
	
	public function hrefEdit() { return GWF_WEB_ROOT.'index.php?mo=WeChall&me=Warflags&edit=1&wbid='.$this->getVar('wf_wbid'); }
	
	public function getTitle() { return $this->getVar('wf_title'); }
	
	public function displayCat() { return $this->display('wf_cat'); }
	
	public function getURL()
	{
		if (NULL !== ($url = $this->getVar('wf_url')))
		{
			return $url;
		}
		return $this->getVar('wb_weburl');
	}
	
	public function getWarbox()
	{
		return new WC_Warbox($this->gdo_data);
	}
	
	public static function getByID($id)
	{
		return self::table(__CLASS__)->selectFirstObject('*', sprintf('wf_id=%d',$id), '', '', array('warbox', 'solver'));
	}
	
	public static function getByWarbox(WC_Warbox $warbox, $orderby='')
	{
		return self::table(__CLASS__)->selectAll('*', 'wf_wbid='.$warbox->getID(), $orderby, array('warbox', 'solver'), -1, -1, GDO::ARRAY_O);
	}
	
	public static function getForBoxAndUser(WC_Warbox $box, GWF_User $user, $orderby='')
	{
		$joins = array(
			'warbox',
			array('WC_Warflags', 'wf_wfid', 'wf_id', 'wf_uid', $user->getID()),
		);
		return self::table('WC_Warflag')->selectAll('*', "wf_wbid={$box->getID()}", $orderby, $joins, -1, -1, GDO::ARRAY_O);
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
	
}
?>
