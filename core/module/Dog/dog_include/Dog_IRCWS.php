<?php
require_once(GWF_CORE_PATH.'inc/3p/phpws/websocket.server.php');

final class Dog_IRCWS implements IWebSocketServerObserver, Dog_IRC
{
	public static $PARENT_PID = -1;
	
	/**
	 * @var Dog_Server
	 */
	private $server = NULL;
	/**
	 * @var WebSocketServer
	 */
	private $socket = NULL;
	private $connected = false;
	private $users = array();
	private $conns = array();
	private $queue_in = NULL;
	private $queue_out = NULL;
	
	public function alive() { return $this->socket !== NULL; }
	
	public function isConnected()
	{
		return $this->connected !== false;
	}
	
	public function connect(Dog_Server $server, $blocking=0)
	{
		$this->socket = new WebSocketServer('tcp://0.0.0.0:31337', 'rob_hubbard_fanclub!');
		$this->socket->addObserver($this);
		
		$pid = pcntl_fork();
		if ($pid == -1)
		{
			return false;
		}
		else if ($pid)
		{
			$this->server = $server;
			self::$PARENT_PID = $pid;
			if (!$this->initQueues())
			{
				die('Cannot get message queue :(');
			}
			$this->connected = true;
		}
		else
		{
			
			$this->server = $server;
			// we are the child
			declare(ticks = 1);
			if (false === pcntl_signal(SIGINT, array($this, 'SIGINT')))
			{
				die('Cannot install SIGINT handler in '.__FILE__.PHP_EOL);
			}
// 			set_error_handler(array($this, 'SIGINT'));
// 			register_shutdown_function(array($this, 'SIGINT'));
			
			if (!$this->initQueues())
			{
				die('Cannot get message queue :(');
			}
			$this->socket->initQueue((int)$server->getID());
			$this->socket->run();
		}
	}
	
	private function initQueues()
	{
		if (false === ($this->queue_in = msg_get_queue(1000 + $this->server->getID())))
		{
			return false;
		}
		if (false === ($this->queue_out = msg_get_queue(2000 + $this->server->getID())))
		{
			return false;
		}
		return true;
	}
	
	public function SIGINT()
	{
		pcntl_wait(self::$PARENT_PID);
// 		sleep(1);
		die("SIGINT IN CHILD!\n");
	}
	
	public function disconnect($message)
	{
		$this->connected = false;
// 		fclose($this->socket->getStreamContext());
	}
	
	public function sendQueue($sent, $throttle)
	{
	}
	
	private function onLogin(IWebSocketConnection $user, $message)
	{
		$data = explode(' ', $message);
		if (count($data) !== 3)
		{
			return false;
		}
		$ename = GDO::escape($data[1]);
		$table = GDO::table('Dog_User');
		if (false === ($dog_user = $table->selectFirstObject('*', "user_name='$ename'")))
		{
			$this->sendToUser($user->getId(), 'Unknown username!');
			return false;
		}
		
		if (false === GWF_Password::checkPasswordS($data[2], $dog_user->getVar('user_pass')))
		{
			$this->sendToUser($user->getId(), 'Wrong password!');
			return false;
		}
		
		$this->sendToUser($user->getId(), 'XLIN1');
		$this->users[$user->getId()] = $dog_user;
		$this->addToQueue($user, $dog_user, 'PRIVMSG Dog :.login '.$data[2]);
		return true;
	}
	
	public function isLoggedIn(IWebSocketConnection $user)
	{
		return isset($this->users[$user->getId()]) ? $this->users[$user->getId()] : false;
	}
	
	public function receive()
	{
		$type = NULL;
		$message = NULL;
		if (false === msg_receive($this->queue_in, 1, $type, 16384, $message, false, MSG_IPC_NOWAIT))
		{
			return false;
		}
		$id = Common::substrUntil($message, ':');
		$message = Common::substrFrom($message, ':');
		$this->conns[$this->parseUsername($message)] = (int)$id;
		return $message;
	}
	
	private function parseUsername($message)
	{
		return substr(Common::substrUntil($message, '!'), 1);
	}
	
	public function send($message)
	{
		echo "SENDING: $message\n";
	}
	
	public function sendAction($to, $message)
	{
		echo "ACTION: $message\n";
		$this->sendToUser($this->getConnectionFor($to), $message);
	}
	
	public function sendRAW($message)
	{
		echo "RAW: $message\n";
	}
	
	public function sendNOTICE($to, $message)
	{
		echo "NOTICE: $message\n";
		$this->sendToUser($this->getConnectionFor($to), $message);
	}
	
	public function sendPRIVMSG($to, $message)
	{
		echo "PRIVMSG: $message\n";
		$this->sendToUser($this->getConnectionFor($to), $message);
	}
	
	private function getConnectionFor($username)
	{
		return $this->conns[$username];
	}
	
	private function addToQueue(IWebSocketConnection $user, Dog_User $dog_user, $message)
	{
		$message = sprintf(":%s!%s@websocket %s", $dog_user->getName(), $dog_user->getName(), $message);
		echo "Adding $message\n";
		msg_send($this->queue_in, 1, $user->getId().':'.$message, false);
	}
	
	private function sendToUser($id, $message)
	{
		echo "Send to user: $message\n";
		#$user->sendFrame(WebSocketFrame::create(WebSocketOpcode::TextFrame, $message));
		msg_send($this->queue_out, 1, $id.':'.$message, false);
	}

	public function onConnect(IWebSocketConnection $user)
	{
		$this->say("[DEMO] {$user->getId()} connected");
	}

	public function onMessage(IWebSocketConnection $user, IWebSocketMessage $msg)
	{
		$this->say("[DEMO] {$user->getId()} says '{$msg->getData()}'");
		
		$message = $msg->getData();
		if (Common::startsWith($message, 'XLIN'))
		{
			$this->onLogin($user, $message);
		}
		elseif (false !== ($dog_user = $this->isLoggedIn($user)))
		{
			$this->addToQueue($user, $dog_user, $message);
		}
		else
		{
			$this->say("OOOPS!");
		}
	}

	public function onDisconnect(IWebSocketConnection $user)
	{
		unset($this->users[$user->getId()]);
		$this->say("[DEMO] {$user->getId()} disconnected");
	}

	public function onAdminMessage(IWebSocketConnection $user, IWebSocketMessage $msg)
	{
		$this->say("[DEMO] Admin Message received!");
		$frame = WebSocketFrame::create(WebSocketOpcode::PongFrame);
		$user->sendFrame($frame);
	}

	public function say($msg)
	{
		echo "$msg \r\n";
	}
}
?>
