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
			$this->outputScore($this->_module, $username);
		}
		if (false !== ($username = Common::getGet('link'))) {
			$this->outputLink($this->_module, $username, trim(Common::getGet('email')));
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
		
		require_once GWF_CORE_PATH.'module/WeChall/WC_RegAt.php';
		require_once GWF_CORE_PATH.'module/WeChall/WC_ChallSolved.php';
		
		$score = WC_Challenge::getScoreForUser($user);
		$maxscore = WC_Challenge::getMaxScore();
		$challs_solved = WC_ChallSolved::getChallsSolvedForUser($user);
		$challcount = WC_Challenge::getChallCount();
		$usercount = GDO::table('GWF_User')->countRows();
		$rank = WC_RegAt::calcExactRank($user);
		die(sprintf('%d:%s:%s:%s:%s:%s', $rank, $score, $maxscore, $challs_solved, $challcount, $usercount));
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