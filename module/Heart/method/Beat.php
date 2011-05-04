<?php
/** Show online sessions **/
final class Heart_Beat extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		$_GET['ajax'] = 1;
		$cut = time()-GWF_ONLINE_TIMEOUT;
		$user = new GWF_User();
		$table = GDO::table('GWF_Session');
		$profiles = '';
		if (false === ($result = $table->select('sess_user,user_name,user_options,user_level', "sess_time>=$cut", 'user_name ASC', array('sess_user')))) {
			return;
		}
	
		$guest = 0;
		$member = 0;
		$total = 0;
		
		$u_count = array();
		$u_users = array();
		while (false !== ($row = $table->fetch($result, GDO::ARRAY_A)))
		{
//			echo sprintf('%s: %08x<br/>', $row['user_name'], $row['user_options']);
			$total++;
			$uid = $row['sess_user'];
			if ($uid == 0) {
				$guest++;
				continue;
			}
			$member++;
			
			$user->setGDOData($row);
			if ($user->isOptionEnabled(GWF_User::HIDE_ONLINE)) {
				continue;
			}
			
			if (isset($u_count[$uid]))
			{
				$u_count[$uid]++;
			}
			else
			{
				$u_count[$uid] = 1;
				$u_users[$uid] = $user->displayProfileLink();
			}
		}
		$table->free($result);
		
		foreach ($u_count as $uid => $cnt)
		{
			$multi = $cnt > 1 ? "(x$cnt)" : '';
			$profiles .= ', '.$u_users[$uid].$multi;
		}
		
		$profiles = $profiles === '' ? '.' : ': '.substr($profiles, 2).'.';
		
		return sprintf('%s Online%s', $total, $profiles);
	}
}
?>