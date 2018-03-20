<?php
/**
 * Very similiar to WC_HistoryUser2.
 * Show latest regat activity.  
 * @author gizmore
 */
final class WeChall_API_Upstream extends GWF_Method
{
	public function execute()
	{
		if (false === ($time = Common::getGetInt('time', false)))
		{
			http_response_code(405);
			die('The mandatory parameter \'time\' is not set. Try \'&time=0\'.');
		}
		if (false === ($lastid = Common::getGetInt('lastid', false)))
		{
			http_response_code(405);
			die('The mandatory parameter \'lastid\' is not set. Try \'&lastid=0\'.');
		}
		
		$limit = Common::clamp(Common::getGetInt('limit', 10), 1, 100);
		
		$conditions = "userhist_date>=$time AND regat_options&4=0";
		$users = GWF_TABLE_PREFIX.'user';
		$sites = GWF_TABLE_PREFIX.'wc_site';
		$regat = GWF_TABLE_PREFIX.'wc_regat';
		$histo = GWF_TABLE_PREFIX.'wc_user_history2';
		$query =
		"SELECT userhist_date, userhist_uid, userhist_sid, userhist_type, user_name, site_name, site_classname,".
		" userhist_onsiterank, userhist_onsitescore, site_maxscore, userhist_rank, ".
		" userhist_totalscore, userhist_gain_score, regat_options, regat_onsitescore, ".
		" (SELECT userhist_onsitescore FROM $histo h2 WHERE h2.userhist_uid=h1.userhist_uid AND h2.userhist_sid=h1.userhist_sid AND h2.userhist_date < h1.userhist_date ORDER BY h2.userhist_date DESC LIMIT 1) AS onsite_score_before, ".
		" (SELECT userhist_onsiterank FROM $histo h2 WHERE h2.userhist_uid=h1.userhist_uid AND h2.userhist_sid=h1.userhist_sid AND h2.userhist_date < h1.userhist_date ORDER BY h2.userhist_date DESC LIMIT 1) AS onsite_rank_before, ".
		" (SELECT userhist_rank FROM $histo h2 WHERE h2.userhist_uid=h1.userhist_uid AND h2.userhist_sid=h1.userhist_sid AND h2.userhist_date < h1.userhist_date ORDER BY h2.userhist_date DESC LIMIT 1) AS global_rank_before, ".
		" ((SELECT COUNT(*) FROM $users u2 WHERE u2.user_level>u.user_level AND u2.user_options&0x10000000=0) + 1) as global_rank ".
		"FROM $histo AS h1 ".
// 		"INNER JOIN $histo h2 ON h2.userhist_uid=h1.userhist_uid AND h2.userhist_sid=h1.userhist_sid AND h2.userhist_date < h1.userhist_date ".
		"INNER JOIN $users u ON u.user_id=userhist_uid ".
		"INNER JOIN $sites ON site_id=userhist_sid ".
		"INNER JOIN $regat ON regat_uid=userhist_uid AND regat_sid=userhist_sid ".
		"WHERE $conditions ".
		"ORDER BY userhist_date DESC ".
		"LIMIT $limit";
		if (false === ($result = gdo_db()->queryRead($query)))
		{
			http_response_code(405);
			return GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
// 		die($query);
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		$regats = GDO::table('WC_RegAt');
		$json = array(
			'result' => array(),
			'time' => null,
			'lastid' => null,
		);
		$foundSid = false;
		while ($regat = $regats->fetch($result, GDO::ARRAY_O))
		{
			$t = (int)$regat->getVar('userhist_date');
			
			if ($t === $time)
			{
				$sid = (int)$regat->getVar('userhist_sid');
				$foundSid = $sid === $lastid ? true : $foundSid;
				if ($foundSid)
				{
					continue;
				}
			}
			
			$afterTotal = (int)$regat->getVar('userhist_totalscore');
			$gainTotal = (int)$regat->getVar('userhist_gain_score');
			$beforeTotal = $afterTotal- $gainTotal;
			
			$maxscore = (int)$regat->getVar('site_maxscore');
			
			$beforePercent = (int)$beforeTotal / $maxscore;
			$afterPercent = (int)$afterTotal / $maxscore;
			
			$beforeSite = (int)$regat->getVar('onsite_score_before');
			$afterSite = (int)$regat->getVar('regat_onsitescore');
			
			$beforeSiteRank = (int)$regat->getVar('onsite_rank_before');
			$afterSiteRank = (int)$regat->getVar('userhist_onsiterank');
			
			$beforeGlobalRank = (int)$regat->getVar('global_rank_before');
			$afterGlobalRank = (int)$regat->getVar('userhist_rank');
			
			$json['result'][] = array(
				'username' => $regat->getVar('user_name'),
// 				'globalrank' => (int)$regat->getVar('global_rank'),
				'type' => $regat->getVar('userhist_type'),
				'datetime' => (int)$regat->getVar('userhist_date'),
				'sitename' => $regat->getVar('site_name'),
// 				'siterank' => (int)$regat->getVar('userhist_onsiterank'),
// 				'sitescore' => (int)$regat->getVar('userhist_onsitescore'),
				'siteclass' => $regat->getVar('site_classname'),
				'before' => array(
					'scoreTotal' => $beforeTotal,
					'scoreOnsite' => $beforeSite,
					'percentTotal' => round($beforePercent, 6),
					'percentOnsite' => round($beforeSite/$maxscore, 6),
					'onsiteRank' => $beforeSiteRank,
					'globalRank' => $beforeGlobalRank,
				),
				'after' => array(
					'scoreTotal' => $afterTotal,
					'scoreOnsite' => $afterSite,
					'percentTotal' => round($afterPercent, 6),
					'percentOnsite' => round($afterSite/$maxscore, 6),
					'onsiteRank' => $afterSiteRank,
					'globalRank' => $afterGlobalRank,
				),
				'gain' => array(
					'scoreTotal' => $gainTotal,
					'scoreOnsite' => $afterSite - $beforeSite,
					'percentTotal' => $beforeTotal != 0 ? round(($afterTotal/$beforeTotal-1.00)*100, 6) : 0,
					'percentOnsite' => round(($afterSite - $beforeSite)/$maxscore, 6),
					'onsiteRank' => -($afterSiteRank - $beforeSiteRank),
					'globalRank' => -($afterGlobalRank - $beforeGlobalRank),
				),
			);
			if ($json['time'] === null)
			{
				$json['time'] = $t;
				$json['lastid'] = (int)$regat->getVar('userhist_sid');
			}
		}

		# Output
		$json['result'] = $json['result'];
		$out = json_encode($json);
		header('Content-Type: application/json; charset=UTF-8');
		echo $out;
		die();
	}
}
