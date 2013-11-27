<?php
final class DOGMOD_NickServMe extends Dog_Module
{
// 	public function event_001()
// 	{
// 		$serv = Dog::getServer();
// 		$nick = $serv->getNick()->getName();
// 		$conn = $serv->getConnection();
// 	}
	
	public function on_nickserv_Xa()
	{
		$argv = $this->argv();
		$argc = count($argv);
		
		if ($argc === 0)
		{
			return $this->showHelp('nickserv');
		}
		
		switch ($argv[0])
		{
			
		}
		
	}
	
}
?>
