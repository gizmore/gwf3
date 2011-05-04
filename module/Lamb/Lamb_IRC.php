<?php
final class Lamb_IRC
{
	private $host;
	private $protocol = 'irc'; 
	private $port;
	private $socket = false;
	private $blocked = 0;
	private $timestamp = 0;
	private $context = NULL;
	
	public function __construct($host, $port=6667)
	{
		// Host & Protocol
		if (false === ($this->host = Common::substrFrom($host, '://', false))) {
			$this->host = $host; // No protocol
			$this->protocol = 'irc'; // so IRC
		}
		else {
			// IRCS or IRC
			$this->protocol = Common::substrUntil($host, '://');
			
			
		}
		
		$this->port = intval(Common::substrFrom($this->host, ':', '6667'));
		$this->host = Common::substrUntil($this->host, ':');
//		$this->port = $port;
	}	

	public function __destruct()
	{
		$this->disconnect();
	}
	
	public function disconnect()
	{
		if ($this->socket !== false)
		{
			Lamb_Log::log('Lamb_IRC::disconnect() from '.$this->host.PHP_EOL);
			fclose($this->socket);
			$this->socket = false;
			$this->context = NULL;
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
		return $this->socket !== false;
	}
	
	public function isSSL()
	{
		return $this->protocol === 'ircs';
	}
	
	public function connect($blocked=0)
	{
//		Lamb_Log::log('Lamb_IRC::connect() to '.$this->host);
		
		$this->blocked = $blocked ? 1 : 0;
		
		$protocol_part = $this->isSSL() ? 'ssl://' : '';
		
		if (false === ($this->context = stream_context_create())) {
			Lamb_Log::log('Lamb_IRC::connect() ERROR: stream_context_create()');
			return false;
		}
		
		$url = $protocol_part.$this->host.':'.$this->port;
		Lamb_Log::log('Lamb_IRC::connect() to '.$url);
		
		if (false === ($this->socket = @stream_socket_client(
				$url,
				$errno,
				$errstr,
				LAMB_CONNECT_TIMEOUT,
				STREAM_CLIENT_CONNECT,
				$this->context)))
		{
			Lamb_Log::log('Lamb_IRC::connect() ERROR: stream_socket_client(): $url= '.$url);
			Lamb_Log::log(sprintf('ERROR in stream_socket_client(): $errno=%d; $errstr=%s', $errno, $errstr));
			return false;
		}
		
		if (false === stream_set_blocking( $this->socket, $blocked )) {
			Lamb_Log::log('WARNING: Lamb_IRC::connect() ERROR: stream_set_blocking(): $blocked='.$blocked);
		}
		
		$this->timestamp = time();
		
		return true;
	}
	
	public function getMessage()
	{
		if ($this->socket === false) {
			return false;
		}
		
		# Return false on eof
		if (feof($this->socket)) {
			$this->disconnect();
			return false;
		}
		
		# Peek message
		if (false === ($msg = fgets($this->socket))) {
			return false;
		}
		
		if ('' === ($msg = trim($msg))) {
			return $this->checkTimeout(); # Nothing happens
		} else {
			$this->timestamp = time(); # New message
		}
		return $msg;
	}
	
	private function checkTimeout()
	{
		if ((time() - $this->timestamp) > LAMB_PING_TIMEOUT) {
			$this->disconnect();
			return false; 
		}
		return '';
	}
	
	public function send($message)
	{
		if ($this->isFlooding()) {
			echo "Flooding!\n";
			sleep(1);
		}
		$message = str_replace(array("\r", "\n"), '', $message);
		Lamb_Log::log($message);
		if (false === (fprintf($this->socket, "%s\r\n", $message))) {
			$this->disconnect();
		}
		fflush($this->socket);
	}
	
	### Anti Flood
	private $flood_count = 0;
	private $flood_time = 0;
	const FLOOD_TIMEOUT = 3.0;
	const FLOOD_AMOUNT = 5;
	private function isFlooding()
	{
		$t2 = microtime(true);
		$t1 = $this->flood_time;
		if (($t2 - $t1) > self::FLOOD_TIMEOUT) {
			$this->flood_count = 0;
			$this->flood_time = $t2;
		}
		else {
			$this->flood_count++;
			if ($this->flood_count >= self::FLOOD_AMOUNT) {
				return true;
			}
		}
		return false;
	}
	
	public function sendPrivmsg($to, $message)
	{
		$this->sendSplitted('PRIVMSG '.$to.' :', $message);
//		$this->send(sprintf('PRIVMSG %s :%s', $to, $message));
	}
	
	public function sendCTCPReply($to, $message)
	{
		$this->sendNotice($to, chr(1).$message.chr(1));
	}
	
	public function sendCTCPRequest($to, $message)
	{
		$this->sendPrivmsg($to, chr(1).$message.chr(1));
	}
	
	public function sendNotice($to, $message)
	{
		$this->sendSplitted('NOTICE '.$to.' :', $message);
//		$this->send(sprintf('NOTICE %s :%s', $to, $message));
	}
	
	public function sendAction($to, $message)
	{
		$this->sendPrivmsg($to, "\x01ACTION $message\x01");
	}
	
	private function sendSplitted($prefix, $message, $split_len=255)
	{
		$len = strlen($message);
		if ($len <= $split_len) {
			return $this->send($prefix.$message);
		}
		
		$i = 0;
		while ($i < $len)
		{
			$to_read = $len - $i;
			if ($to_read > $split_len) {
				$j = self::strrchr( $message, ' ', $i+$split_len);
				
				if ($j <= $i) { $j = $i + $split_len; }
				$m = substr($message, $i, $j-$i/*-1*/);
				$i = $j+1;
				$this->send($prefix.$m);
			}
			else {
				$this->send($prefix.substr($message, $i));
				$i = $len;
			}
		}
	}
	
	
	/**
	 * Return the last position of a char, counting backwards from offset.
	 * This function is not binary safe!
	 * @param unknown_type $s
	 * @param unknown_type $c
	 * @param unknown_type $offset
	 */
	private static function strrchr($s, $c, $offset=-1)
	{
		$len = strlen($s);
		$i = Common::clamp((int)$offset, 0, $len-1);
		while ($i >= 0)
		{
			if ($s{$i} === $c) {
				return $i;
			}
			$i--;
		}
		return false;
	}
	
}
?>