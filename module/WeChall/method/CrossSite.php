<?php
/**
 * WeChall integrating WeChall Scripts.
 * This is the scoreurl and linkurl integration.
 * @author gizmore
 */
final class WeChall_CrossSite extends GWF_Method
{
	public function execute(GWF_Module $module)
	{
		if (false !== ($username = Common::getGet('score'))) {
			$this->outputScore($module, $username);
		}
		if (false !== ($username = Common::getGet('link'))) {
			$this->outputLink($module, $username, trim(Common::getGet('email')));
		}
	}
	
	private function outputScore(Module_WeChall $module, $username)
	{
		if (false === ($user = GWF_User::getByName($username))) {
			die('Unknown User');
		}
		
		if (false === ($site = WC_Site::getWeChall())) {
			die('Unknown Site');
		}
		
		require_once 'module/WeChall/WC_RegAt.php';
		
		$score = WC_Challenge::getScoreForUser($user);
		$maxscore = WC_Challenge::getMaxScore();
		
		$challcount = WC_Challenge::getChallCount();
		$usercount = GDO::table('GWF_User')->countRows();
		$rank = WC_RegAt::calcExactRank($user);
		die(sprintf('%d:%s:%s:%s:%s', $rank, $score, $maxscore, $challcount, $usercount));
	}
	
	private function outputLink(Module_WeChall $module, $username, $email)
	{
		if (false === ($user = GWF_User::getByName($username))) {
			die('0');
		}
		if ($user->getValidMail() !== $email) {
			die('0');
		}
		die('1');
	}
}

?>