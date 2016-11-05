<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

final class TGC_Server implements MessageComponentInterface
{
	private $server;
	
	public function mainloop()
	{
		GWF_Log::logMessage("TGC_Server::mainloop()");
		$this->server->run();
	}
	
	###############
	### Ratchet ###
	###############
	public function onOpen(ConnectionInterface $conn) {
		GWF_Log::logCron(sprintf("TGC_Server::onOpen()"));
	}
	
	public function onMessage(ConnectionInterface $from, $msg) {
// 		GWF_Log::logCron(sprintf("TGC_Server::onMessage(): %s", $msg));
		if (strlen($msg) > 511) {
			$from->send('ERR:ERR_MSG_LENGTH_EXCEED:511');
			return;
		}
		$player = TGC_ServerUtil::getPlayerForMessage($msg);
		if ($player instanceof TGC_Player) {
			if (!$player->isConnected()) {
				$player->setConnectionInterface($from);
				$player->rehash();
			}
			TGC_Commands::execute($player, $msg);
		}
		else {
			echo $player;
			$from->send('ERR:'.$player);
		}
	}
	
	public function onClose(ConnectionInterface $conn) {
		GWF_Log::logCron(sprintf("TGC_Server::onClose()"));
		if ($player = TGC_ServerUtil::getPlayerForConnection($conn)) {
			TGC_Commands::disconnect($player);
		}
	}
	
	public function onError(ConnectionInterface $conn, \Exception $e) {
		GWF_Log::logCron(sprintf("TGC_Server::onError()"));
	}
	
	############
	### Init ###
	############
	public function initTamagochiServer()
	{
		GWF_Log::logMessage("TGC_Server::initTamagochiServer()");
		$this->server = IoServer::factory(new HttpServer(new WsServer($this)), 34543);
		return true;
	}
}
