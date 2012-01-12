<?php
final class WeChall_Ajax extends GWF_Method
{
	public function execute()
	{
		$letter = strtolower(Common::getGetString('letter'));
		if (!preg_match('/^[a-z]{1}$/D', $letter)) {
			return '';
		}
		$db = gdo_db();
		$users = GWF_TABLE_PREFIX.'user';
		$query = "SELECT user_name FROM $users WHERE user_name LIKE '$letter%' ORDER BY user_name ASC";
		if (false === ($result = $db->queryRead($query))) {
			return '';
		}
		$back = array();
		while (false !== ($row = $db->fetchRow($result)))
		{
			$back[] = $row[0];
		}
		$db->free($result);
		return '('.json_encode($back).');';
	}
}
?>