<?php
/**
 * This demo resource handler will respond to all messages sent to /echo/ on the socketserver below
 *
 * All this handler does is echoing the responds to the user
 * @author Chris
 *
 */
class TGC_PositionHandler extends WebSocketUriHandler {
	public function onMessage(IWebSocketConnection $user, IWebSocketMessage $msg) {
		$this->say("[ECHO] {$msg->getData()}");
		// Echo
		$user->sendMessage($msg);
	}

	public function onAdminMessage(IWebSocketConnection $user, IWebSocketMessage $obj){
		$this->say("[DEMO] Admin TEST received!");

		$frame = WebSocketFrame::create(WebSocketOpcode::PongFrame);
		$user->sendFrame($frame);
	}
}

/**
 * Demo socket server. Implements the basic eventlisteners and attaches a resource handler for /echo/ urls.
 *
 *
 * @author Chris
 *
 */
class TGC_Server implements IWebSocketServerObserver, GWF_WSI
{
	protected $server;
	protected $connected;
	

	public function __construct()
	{
		$this->server = new WebSocketServer("ssl://0.0.0.0:12345", 'iliketamagnochi');
		$this->server->addObserver($this);
		$this->server->addUriHandler("echo", new TGC_PositionHandler());
		$this->setupSSL();
	}

	public function setConnected($connected) { $this->connected = $connected; }
	public function isConnected() { return $this->connected; }
	public function getPEMFilename() { return 'protected/tgc.gizmore.org.pem'; }

	public function setupSSL()
	{
		$context = stream_context_create();

		// local_cert must be in PEM format
		stream_context_set_option($context, 'ssl', 'local_cert', $this->getPEMFilename());

		stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
		stream_context_set_option($context, 'ssl', 'verify_peer', false);

		$this->server->setStreamContext($context);
	}

	public function onConnect(IWebSocketConnection $user)
	{
		$this->say("[DEMO] {$user->getId()} connected");
	}

	public function onMessage(IWebSocketConnection $user, IWebSocketMessage $msg)
	{
		$this->say("[DEMO] {$user->getId()} says '{$msg->getData()}'");
	}

	public function onDisconnect(IWebSocketConnection $user)
	{
		$this->say("[DEMO] {$user->getId()} disconnected");
	}

	public function onAdminMessage(IWebSocketConnection $user, IWebSocketMessage $msg)
	{
		$this->say("[DEMO] Admin Message received!");

		$frame = WebSocketFrame::create(WebSocketOpcode::PongFrame);
		$user->sendFrame($frame);
	}

	public function say($msg = '')
	{
		echo "$msg \r\n";
	}

	public function mainloop()
	{
		$this->server->run($this);
	}

	############
	### Init ###
	############
	public function initTamagochiServer()
	{
		GWF_Log::logMessage("TGC_Server::initTamagochiServer");
		return true;
	}
}
