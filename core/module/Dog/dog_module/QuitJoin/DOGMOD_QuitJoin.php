<?php
final class DOGMOD_QuitJoin extends Dog_Module
{
	public function getOptions()
	{
		return array(
			'noteworthy' => 's,s,i,60',
		);
	}
	
	public function event_quit()
	{
// 		Dog_QuitJoin::onQuit($this, Dog::getServer(), Dog::getUser(), $this->getConfig('noteworthy', 's'));
	}
	
	public function event_join()
	{
// 		Dog_QuitJoin::onJoin(Dog::getServer(), Dog::getChannel(), Dog::getUser());
	}
	
// 	private function onQuitJoin(Dog_Server $server, Dog_User $user, $from, $origin, $message)
// 	{
// 		if (false === ($channel = Dog::getChannel())) {
// 			//			if (false === ($record = Dog_QuitJoinChannel::getGlobalRecord())) {
// 			return 'I do not have any quitjoin records yet.';
// 			//			} else {
// 			//				return sprintf('The shortest join ever was from %s in %s on %s: %.02fs.', $record->displayUser(), $record->displayChannel(), $record->displayServer(), $record->displayTime());
// 			//			}
// 		}
	
// 		if (false === ($record = Dog_QuitJoinChannel::getChannelRecord($channel))) {
// 			return 'I do not have any quitjoin records for the '.$channel->getName().' channel yet.';
// 		} else {
// 			return sprintf('The shortest join ever on %s in %s was from %s: %.02fs.', $server->getDomain(), $channel->getName(), $record->displayUser(), $record->displayTime());
// 		}
// 	}
}
?>
