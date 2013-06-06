<?php
require_once 'worker/Repo_Checkout.php';

/**
 * .repo checkout svn https://trac.gwf3.gizmore.org GWF3 <user> <pass>
 * @author gizmore
 */
final class DOGMOD_Repo extends Dog_Module
{
// 	public function on_repo_Pb()
// 	{
// 		$argv = $this->argv();
// 		if (count($argv) === 0)
// 		{
// 			return $this->showHelp('repo');
// 		}
// 		$cmd = array_shift($argv);
// 		switch ($cmd)
// 		{
// 			case 'co': case 'checkout': return $this->onCheckout($argv);
// // 			case 'help': return $this->onHelpB();
// // 			default:
// 		}
// 	}

	private function showRepoHelp($cmd)
	{
		$this->reply($cmd);
	}
	
	private function onCheckout(array $argv)
	{
		if (count($argv) < 3)
		{
			return $this->showRepoHelp('checkout');
		}
		
		$type = strtolower($argv[0]);
		if (!Dog_Repo::isValidType($type))
		{
			return $this->error('err_type');
		}
		
		$url = $argv[1];
		if ( (!GWF_Validator::isValidURL($url)) || (!GWF_HTTP::pageExists($url)) )
		{
// 			return $this->error('err_url');
		}
		
		$name = $argv[2];
		if (!Dog_Repo::isNameValid($name))
		{
			return $this->error('err_name_invalid');
		}
		
		if (Dog_Repo::repoExists($name, $url))
		{
			return $this->error('err_dup');
		}
		
		$user = NULL;
		$pass = NULL;
		
		if (isset($argv[3]))
		{
			$user = $argv[3];
			$pass = isset($argv[4]) ? $argv[4] : '';
		}

		$repo = new Dog_Repo(array(
			'repo_id' => '0',
			'repo_type' => $type,
			'repo_name' => $name,
			'repo_url' => $url,
			'repo_user' => $user,
			'repo_pass' => $pass,
			'repo_options' => '0',
		));
		
		if (!$repo->insert())
		{
			return $this->error('err_database');
		}
		
		$this->rply('msg_checking_out', array($name));

		$repo->checkout();
	}
	
}
