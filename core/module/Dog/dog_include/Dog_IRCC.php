<?php
require_once 'Dog_Includes.php';
final class Dog_IRCC implements Dog_IRC
{
	/**
	 * @var Dog_Server
	 */
	private $server = false;
	private $socket = NULL;
	private $recv_buffer = ''; // buffers recv'd data until new line is seen
	private $context = false;
	private $timestamp = 0;
	
	private $queue = array();
	private $msgs_sent = 0;
	private $sent_time = 0;
	private $last_target = '';
	private $msgs_pntr = 0;
	private $read_error = false;
	
	public function isConnected() { return $this->socket !== NULL; }
	
	public function connect(Dog_Server $server, $blocking=0)
	{
		$this->socket = null;
		$this->server = $server;
		
		$opts = array(
			"ssl" => array(
				"verify_peer" => false,
				"verify_peer_name" => false,
			),
		);

		if (false === ($this->context = @stream_context_create($opts)))
		{
			return Dog_Log::error('Dog_IRC::connect() ERROR: stream_context_create()');
		}

		$url = $server->getURL();
		
		if (false === ($socket = @stream_socket_client(
				$url,
				$errno,
				$errstr,
				$server->getTimeout(),
				STREAM_CLIENT_CONNECT,
				$this->context)))
		{
			Dog_Log::error("Dog_IRC::connect() ERROR: stream_socket_client(): URL={$url} CONNECT_TIMEOUT=".$server->getTimeout());
			return Dog_Log::error(sprintf('Dog_IRC::connect() $errno=%d; $errstr=%s', $errno, $errstr));
		}
		
		if ($server->isSSL())
		{
			if (false === @stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_ANY_CLIENT))
			{
				return Dog_Log::error('Dog_IRC::connect() ERROR: stream_socket_enable_crypto(true, STREAM_CRYPTO_METHOD_ANY_CLIENT)');
			}
		}
		
		if (false === @stream_set_blocking($socket, 0))
		{
			return Dog_Log::error('Dog_IRC::connect() ERROR: stream_set_blocking(): $blocked=0');
		}
		
		$this->timestamp = time();
		$this->socket = $socket;
		
		return true;
	}
	
	public function hard_disconnect()
	{
		if (is_resource($this->socket)) {
			fclose($this->socket);
		}
		$this->socket = NULL;
		$this->read_error = false;
		$this->recv_buffer = '';
	}
	
	public function disconnect($message)
	{
		$this->send('QUIT :'.$message);
//		$this->hard_disconnect();
	}
	
	public function alive()
	{
		return $this->socket !== NULL && !$this->read_error;
	}
	
	public function receive()
	{		
		if (feof($this->socket))
		{
			$this->hard_disconnect();
			return false;
		}

		$res = fgets($this->socket, 2047);
		$this->read_error = $res === false && feof($this->socket);

		if ($this->read_error) {
			$this->hard_disconnect();
		}
		
		if ($res === false) {
			return false;
		}

		// read until new line (socket is non-blocking!)
		$this->recv_buffer .= $res;
		if (substr_compare($this->recv_buffer, "\n", -1) === 0)
		{
			$res = $this->recv_buffer;
			$this->recv_buffer = '';
			return $res;
		}

		return false;
	}
	
	public function sendAction($to, $message) { $this->sendPRIVMSG($to, "\x01ACTION {$message}\x01"); }
	public function sendRAW($message) { $this->queue[] = array('r', '!', GWF_IRCUtil::parseCleanState($message)); }
	public function sendNOTICE($to, $message) { $this->queue[] = array('n', $to, GWF_IRCUtil::parseCleanState($message)); }
	public function sendPRIVMSG($to, $message) { $this->queue[] = array('p', $to, GWF_IRCUtil::parseCleanState($message)); }
	
	public function send($message)
	{
// 		$message = str_replace(array("\r", "\n"), '', trim($message));
		$message = str_replace(array("\r", "\n"), '', $message);
		Dog_Log::server($this->server, new Dog_IRCMsg($message, $this->server->getNick()->getNick()));
		if (!is_resource($this->socket) || @fwrite($this->socket, "$message\r\n") === false)
		{
			$this->hard_disconnect();
			return false;
		}
		return true;
	}
	
	public function sendQueue($sent, $throttle)
	{
		if (0 === ($len = count($this->queue)))
		{
			return $sent;
		}
		
		if ($throttle <= 0)
		{
			return $this->flushQueue($sent);
		}
		
		while ($sent < $throttle)
		{
			if (!$this->sendQueueB())
			{
				break;
			}
			else
			{
				$sent++;
			}
		}
		
		return $sent;
	}
	
	private function sendQueueB()
	{
		if (0 === ($len = count($this->queue)))
		{
			return false;
		}
		
		for ($i = 0; $i < $len; $i++)
		{
			if ($this->msgs_pntr >= $len)
			{
				$this->msgs_pntr = 0;
			}
			
			$t = $this->queue[$this->msgs_pntr][1];
			if ($t !== $this->last_target)
			{
				$this->sendFromQueue($this->queue[$this->msgs_pntr]);
				$this->last_target = $t;
				unset($this->queue[$this->msgs_pntr]);
				$this->queue = array_values($this->queue);
				$this->msgs_pntr = 0;
				return true;
			}
			
			$this->msgs_pntr++;
		}
		
		$this->last_target = '';
		return $this->sendQueueB();
	}
	
	private function sendFromQueue(array $q)
	{
	    if ($this->server->isTwitch())
	    {
	        switch ($q[0])
	        {
	            case 'n': $this->sendSplitted("PRIVMSG {$q[1]} :", $q[2]); break;
	            case 'p': $this->sendSplitted("PRIVMSG {$q[1]} :", $q[2]); break;
	            case 'r': $this->send($q[2]); $this->msgs_sent--; break;
	        }
	    }
	    
		switch ($q[0])
		{
			case 'n': $this->sendSplitted("NOTICE {$q[1]} :", $q[2]); break;
			case 'p': $this->sendSplitted("PRIVMSG {$q[1]} :", $q[2]); break;
			case 'r': $this->send($q[2]); $this->msgs_sent--; break;
		}
	}
	
	private function flushQueue($sent)
	{
		foreach ($this->queue as $q)
		{
			$this->sendFromQueue($q);
			$sent++;
		}
		$this->queue = array();
		return $sent;
	}
	
	/**
	 * Send a message split into multiple.
	 * @param string $prefix Prefix for all messages.
	 * @param string $message The real message.
	 * @param int $split_len The length for each chunk.
	 */
	private function sendSplitted($prefix, $message, $split_len=420)
	{
		$len = strlen($message);
	
		if ($len <= $split_len)
		{
			return $this->send($prefix.$message);
		}
	
		$i = 0;
		while ($i < $len)
		{
			$to_read = $len - $i;
	
			if ($to_read > $split_len)
			{
				$j = GWF_String::strrchr($message, ' ', $i+$split_len);
	
				if ($j <= $i) {
					$j = $i + $split_len;
				}
				$m = substr($message, $i, $j-$i/*-1*/);
				$i = $j+1;
				$this->send($prefix.$m);
			}
	
			else
			{
				$this->send($prefix.substr($message, $i));
				$i = $len;
			}
		}
		return true;
	}
}
