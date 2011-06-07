<?php
final class Lamb_IRC
{
	private $host;
	private $protocol = 'irc'; 
	private $port;
	private $socket = NULL;
	private $blocked = 0;
	private $timestamp = 0;
	private $context = NULL;
	
	public function __construct($host, $default_port=6667)
	{
		# Host & Protocol
		if (false === ($this->host = Common::substrFrom($host, '://', false)))
		{
			$this->host = $host; # No protocol
			$this->protocol = 'irc'; # so IRC
		}
		else
		{
			$this->protocol = Common::substrUntil($host, '://'); # IRCS or IRC
		}
		
		# Port
		$this->port = intval(Common::substrFrom($this->host, ':', $default_port));
		
		# Host without protocol and port
		$this->host = Common::substrUntil($this->host, ':');
	}	

	public function __destruct()
	{
		$this->disconnect('Lamb_IRC::__destruct()');
	}
	
	/**
	 * Disconnect from an IRCD.
	 * @param string $message the quit message
	 */
	public function disconnect($message)
	{
		if ($this->socket !== NULL)
		{
			# Politely quit.
			$message = $message === '' ? 'Lamb_IRC::disconnect()' : $message;
			$this->send('QUIT :'.$message);
			# Close the socket
			fclose($this->socket);
			$this->socket = NULL;
			$this->context = NULL;
			Lamb_Log::logDebug('Lamb_IRC::disconnect() from '.$this->host.PHP_EOL);
		}
	}
	
	public function getHostname()
	{
		return $this->host;
	}
	
	public function getPort()
	{
		return $this->port;
	}
	
	public function isConnected()
	{
		return $this->socket !== NULL;
	}
	
	public function isSSL()
	{
		return $this->protocol === 'ircs';
	}
	
	public function connect($blocked=0)
	{
		$this->blocked = $blocked ? 1 : 0;
		
		$protocol_part = $this->isSSL() ? 'ssl://' : '';
		
		if (false === ($this->context = stream_context_create()))
		{
			Lamb_Log::logError('Lamb_IRC::connect() ERROR: stream_context_create()');
			return false;
		}
		
		$url = $protocol_part.$this->host.':'.$this->port;
		
		Lamb_Log::logDebug('Lamb_IRC::connect() to '.$url);
		
		if (false === ($this->socket = @stream_socket_client(
				$url,
				$errno,
				$errstr,
				LAMB_CONNECT_TIMEOUT,
				STREAM_CLIENT_CONNECT,
				$this->context)))
		{
			$this->socket = NULL;
			Lamb_Log::logError("Lamb_IRC::connect() ERROR: stream_socket_client(): $url={$url} LAMB_CONNECT_TIMEOUT=".LAMB_CONNECT_TIMEOUT);
			Lamb_Log::logError(sprintf('ERROR in stream_socket_client(): $errno=%d; $errstr=%s', $errno, $errstr));
			return false;
		}
		
		if (false === stream_set_blocking($this->socket, $blocked))
		{
			Lamb_Log::logError('Lamb_IRC::connect() ERROR: stream_set_blocking(): $blocked='.$blocked);
		}
		
		$this->timestamp = time();
		
		return true;
	}
	
	public function getMessage()
	{
		if ($this->socket === NULL)
		{
			return false;
		}
		
		# Return false on eof
		if (feof($this->socket))
		{
			$this->disconnect('Lamb_IRC::getMessage() got "feof".');
			return false;
		}
		
		# Peek message
		if (false === ($msg = fgets($this->socket)))
		{
			return false;
		}
		
		if ('' === ($msg = trim($msg)))
		{
			return $this->checkTimeout(); # Nothing happens
		}
		else
		{
			$this->timestamp = time(); # New message
		}
		
		return $msg;
	}
	
	private function checkTimeout()
	{
		if ((time() - $this->timestamp) > LAMB_PING_TIMEOUT)
		{
			$this->disconnect('Timed out!');
			return false; 
		}
		return '';
	}
	
	public function send($message)
	{
		if ($this->isFlooding())
		{
			Lamb_Log::logDebug("Flooding");
			sleep(1);
		}
		
		# Anti remote irc cmd execution.
		$message = str_replace(array("\r", "\n"), '', $message);
		fprintf($this->socket, "%s\r\n", $message);
		
		# Log?
		$server = Lamb::instance()->getCurrentServer();
		if ($server->isLogging())
		{
			Lamb_Log::logChat($server, $message);
		}
		
		return fflush($this->socket);
	}
	
	##################
	### Anti Flood ###
	##################
	private $flood_count = 0;
	private $flood_time = 0;
	const FLOOD_TIMEOUT = 3.0;
	const DEFAULT_FLOOD_AMOUNT = 5;
	private function isFlooding()
	{
		$server = Lamb::instance()->getCurrentServer();
		if (!$server->isThrottled())
		{
			return false;
		}
		
		$t2 = microtime(true);
		$t1 = $this->flood_time;
		if (($t2 - $t1) > self::FLOOD_TIMEOUT)
		{
			$this->flood_count = 0;
			$this->flood_time = $t2;
		}
		else
		{
			$this->flood_count++;
			if ($this->flood_count >= $server->getInt('serv_flood_amt'))
			{
				return true;
			}
		}
		return false;
	}
	
	public function sendPrivmsg($to, $message)
	{
		return $this->sendSplitted('PRIVMSG '.$to.' :', $message);
	}
	
	public function sendCTCPReply($to, $message)
	{
		return $this->sendNotice($to, chr(1).$message.chr(1));
	}
	
	public function sendCTCPRequest($to, $message)
	{
		return $this->sendPrivmsg($to, chr(1).$message.chr(1));
	}
	
	public function sendNotice($to, $message)
	{
		return $this->sendSplitted('NOTICE '.$to.' :', $message);
	}
	
	public function sendAction($to, $message)
	{
		return $this->sendPrivmsg($to, "\x01ACTION $message\x01");
	}
	
	/**
	 * Send a message split into multiple.
	 * @param string $prefix Prefix for all messages.
	 * @param string $message The real message.
	 * @param int $split_len The length for each chunk.
	 */
	private function sendSplitted($prefix, $message, $split_len=255)
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
				$j = self::strrchr( $message, ' ', $i+$split_len);
				
				if ($j <= $i) { $j = $i + $split_len; }
				$m = substr($message, $i, $j-$i/*-1*/);
				$i = $j+1;
				if (false === $this->send($prefix.$m))
				{
					return false;
				}
			}
			
			else
			{
				if (false === $this->send($prefix.substr($message, $i)))
				{
					return false;
				}
				$i = $len;
			}
		}
		return true;
	}
	
	
	/**
	 * Return the last position of a char, counting backwards from offset.
	 * This function is not binary safe!
	 * @param string $s
	 * @param char $c
	 * @param int $offset
	 */
	private static function strrchr($s, $c, $offset=0)
	{
		$len = strlen($s);
		$i = Common::clamp((int)$offset, 0, $len-1);
		while ($i >= 0)
		{
			if ($s{$i} === $c)
			{
				return $i;
			}
			$i--;
		}
		return false;
	}
	
}
?>