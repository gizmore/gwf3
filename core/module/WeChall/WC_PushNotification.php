<?php
/**
 * Class to push WeChall notifications to the notification server
 * @author dloser
 */
class WC_PushNotification extends GWF_PushNotification
{
	public static function pushUserSiteUpdate(GWF_User $user, WC_Site $site, $before, $after)
	{
		// prevent notifications for users that want privacy
		$data = $user->getUserData();
		if (isset($data['WC_HIDE_SCORE']) || isset($data['WC_HIDE_RANK']) || isset($data['WC_NO_XSS']))
		{
			return;
		}

		$notification = array(
			'type' => 'user.site.update',
			'user_name' => $user->displayUsername(),
			'site_id' => $site->getSiteClassName(),
			'site_max_score' => intval($site->getOnsiteScore()),
			'wechall_max_score' => intval($site->getScore()),
			'after' => array(
				'site_score' => intval($after['site_score']),
				'wechall_site_rank' => intval($after['wechall_site_rank']),
				'wechall_site_score' => intval($after['wechall_site_score']),
				'wechall_rank' => intval($after['wechall_rank']),
				'wechall_score' => intval($after['wechall_score']),
				),
			);

		$has_before = $before !== NULL;
		if ($has_before)
		{
			$notification['before'] = array(
				'site_score' => intval($before['site_score']),
				'wechall_site_rank' => intval($before['wechall_site_rank']),
				'wechall_site_score' => intval($before['wechall_site_score']),
				'wechall_rank' => intval($before['wechall_rank']),
				'wechall_score' => intval($before['wechall_score']),
				);
		}

		$max_challs = intval($site->getChallCount());
		if ($max_challs > 0)
		{
			$notification['site_max_challs'] = $max_challs;
			if ($has_before && isset($before['site_challs']) && $before['site_challs'] >= 0)
			{
				$notification['before']['site_challs'] = intval($before['site_challs']);
			}
			if (isset($after['site_challs']) && $after['site_challs'] >= 0)
			{
				$notification['after']['site_challs'] = intval($after['site_challs']);
			}
		}

		if ($has_before && isset($before['site_rank']) && $before['site_rank'] > 0)
		{
			$notification['before']['site_rank'] = intval($before['site_rank']);
		}
		if (isset($after['site_rank']) && $after['site_rank'] > 0)
		{
			$notification['after']['site_rank'] = intval($after['site_rank']);
		}

		self::push($notification);
	}
}
