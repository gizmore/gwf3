<?php
interface Dog_IRC
{
	public function alive();
	public function isConnected();
	public function connect(Dog_Server $server, $blocking);
	public function disconnect($message);
	public function sendQueue($sent, $throttle);
	public function receive();
	public function send($message);
	
	public function sendAction($to, $message);
	public function sendRAW($message);
	public function sendNOTICE($to, $message);
	public function sendPRIVMSG($to, $message);
}
?>
