<?php
/**
 * Class to push WeChall notifications to the notification server
 * @author dloser
 */
class WC_PushNotification extends GWF_PushNotification
{
	public static function pushUserScoreUpdate(GWF_User $user, WC_Site $site, $old_score, $new_score)
	{
		// prevent notifications for users that want privacy
		$data = $user->getUserData();
		if (isset($data['WC_HIDE_SCORE']) || isset($data['WC_HIDE_RANK']) || isset($data['WC_NO_XSS']))
		{
			return;
		}

		$notification = array(
			'type' => 'user.score.update',
			'user_name' => $user->displayUsername(),
			'site_name' => $site->getSiteName(),
			'old_score' => intval($old_score),
			'new_score' => intval($new_score),
			'max_site_score' => intval($site->getOnsiteScore()),
			);

		self::push($notification);
	}
}
