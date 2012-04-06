<?php

final class GWF_VoteMultiRow extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'vote_multi_row'; }
	public function getColumnDefines()
	{
		return array(
			'vmr_vmid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'vmr_uid' => array(GDO::UINT|GDO::INDEX, GDO::NOT_NULL),
			'vmr_ip' => GWF_IP6::gdoDefine(GWF_IP_QUICK, GDO::NULL, GDO::INDEX),
			'vmr_time' => array(GDO::UINT, GDO::NOT_NULL),
			'vmr_choices' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 255), # vmo_id:vmo_id
			'vmr_vm' => array(GDO::JOIN, NULL, array('GWF_VoteMulti', 'vmr_vmid', 'vm_id')),
		);
	}
	
	public function getChoicesArray()
	{
		return explode(':', $this->getVar('vmr_choices'));
	}
	
	public static function getVoteRowUser($pollid, $userid)
	{
		$pollid = (int)$pollid;
		$userid = (int)$userid;
		return self::table(__CLASS__)->selectFirstObject('*', "vmr_vmid=$pollid AND vmr_uid=$userid");
	}
	
	public static function getVoteRowGuest($pollid, $ip)
	{
		$pollid = (int) $pollid;
		$ip = self::escape($ip);
		return self::table(__CLASS__)->selectFirstObject('*', "vmr_vmid=$pollid AND vmr_ip='$ip'");
	}
	
	public function hasVotedOption($n)
	{
		$choices = $this->getChoicesArray();
		return in_array("$n", $choices, true);
	}
	
	public static function hasVotedUser($pollid, $userid)
	{
		return self::getVoteRowUser($pollid, $userid) !== false;
	}

	public static function hasVotedGuest($pollid, $ip)
	{
		return self::getVoteRowGuest($pollid, $ip) !== false;
	}
}

?>