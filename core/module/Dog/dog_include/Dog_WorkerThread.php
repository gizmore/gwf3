<?php
require 'Dog_Worker.php';
/**
 * There is one fork at the very clean beginning, so there can be asynchronous tasks.
 * Publish tasks via async()
 * Execute callbacks via executeCallbacks()
 * @author gizmore
 * @license PD
 */
final class Dog_WorkerThread
{
	// Worker thread dynamic code styles.
	const REPLY = 1;
	const TYPE_OFFSET = 2;
	private static $TYPES = array('call', 'exec', 'include', 'eval');
	private static function type($msgtype) { return self::$TYPES[$msgtype-self::TYPE_OFFSET]; }
	private static function msgtype($type) { return array_search($type, self::$TYPES, true) + self::TYPE_OFFSET; }
	
	// Do we use fork or sync?
	private $pid = 0;
	private $forked = false;
	private $init_sleep = 10.0;
	
	// IPC Message queues.
	private $queue_in = null;
	private $qid_in = 6669; // QUEUE ID
	private $queue_out = null;
	private $qid_out = 6670; // QUEUE ID
	private $max_msg_len = 65535;
	
	// Callbacks
	private $callb_max = 3;   // max queued jobs at once
	private $callbacks = array();
	private $callbacnt = 1;
	private $replyhdlr = null;
	private $currcallb = 0;
	
	const RES_TIME = 0;
	const RES_SCOPE = 1;
	const RES_CALLBACK = 2;
	const RES_CALLARGS = 3;
	
	const IN_ID = 0;
	const IN_ARGS = 1;
	const IN_INCLUDES = 2;
	
	const OUT_ID = 0;
	const OUT_ARGS = 1;
	
	public static $CHILD_INSTANCE = null;
	
	public function __construct($qid_in=6667, $qid_out=6668, $msglen=65535, $call_max_time=300, $call_max_jobs=3, $init_sleep=2.0)
	{
		$this->qid_in = max((int)$qid_in, 0);
		$this->qid_out = max((int)$qid_out, 0);
		$this->max_msg_len = max((int)$msglen, 256);
		$this->callmxtim = max((int)$call_max_time, 5);
		$this->callb_max = max((int)$call_max_jobs, 1);
		$this->init_sleep = max(floatval($init_sleep), 0);
	}
	
	public function setReplyHandler($callback)
	{
		if (!GWF_Callback::isCallback($callback))
		{
			echo "ERROR: Dog_WorkerThread::setReplyHandler() - Invalid callback\nCALLBACK:".GWF_Callback::printCallback($callback)."\n";
			return false;
		}
		else
		{
			$this->replyhdlr = $callback;
			return true;
		}
	}
	
	public function start()
	{
		if (function_exists('pcntl_fork') && function_exists('msg_get_queue'))
		{
			return $this->fork();
		}
		else
		{
			echo "WARNING: Dog_WorkerThread::init() - No 'pcntl_fork' or no 'msg_get_queue'!\n";
			echo "WARNING: FALLBACK TO SYNCHRONOUS WORKERS :(\n";
			return false;
		}
	}

	private function fork()
	{
		if (!$this->initQueues())
		{
			return false;
		}
		
		if (-1 === ($this->pid = pcntl_fork()))
		{
			return false;
		}
		elseif ($this->pid)
		{
			$this->forked = true;
			return true;
		}
		else
		{
			$this->forked = true;
			$this->setupChild();
			usleep(intval($this->init_sleep * 1000000));
			$this->mainloop();
		}
	}
	
	private function initQueues()
	{
		return( (false !== ($this->queue_in  = msg_get_queue($this->qid_in ))) &&
		        (false !== ($this->queue_out = msg_get_queue($this->qid_out))) );
	}
	
	
	public function executeCallbacks()
	{
		if ($this->forked)
		{
			$msgtype = 0;
			$message = null;
			while (false !== msg_receive($this->queue_out, 0, $msgtype, $this->max_msg_len, $message, true, MSG_IPC_NOWAIT))
			{
				printf("Dog_WorkerThread::parent_receive: $msgtype\nMSG: %s\n", print_r($message, true));
				if (isset($this->callbacks[$message[self::OUT_ID]]))
				{
					if ($msgtype === self::REPLY)
					{
						$this->sendReply($message);
					}
					else
					{
						$this->executeResult($this->getResult($message));
					}
				}
			}
		}
	}
	
	private function getResult(array $message)
	{
		$id = $message[self::OUT_ID];
		$result = $this->callbacks[$id];
		unset($this->callbacks[$id]);
		if ($message[self::OUT_ARGS] !== null)
		{
			$result[self::RES_CALLARGS][] = $message[self::OUT_ARGS];
		}
		return $result;
	}
	
	private function executeResult(array $result)
	{
		printf("Dog_WorkerThread::executeResult()cb: %s\n", print_r($result[self::RES_CALLBACK], true));
		printf("Dog_WorkerThread::executeResult()args: %s\n", print_r($result[self::RES_CALLARGS], true));
		$callback = $result[self::RES_CALLBACK];
		if (GWF_Callback::isCallback($callback))
		{
			Dog::setScope($result[self::RES_SCOPE]);
			call_user_func_array($callback, $result[self::RES_CALLARGS]);
		}
		else
		{
			echo "Dog_WorkerThread::executeResult() - Invalid callback: ".GWF_Callback::printCallback($callback)."\n";
		}
	}
	
	private function sendReply($message)
	{
		$callback = $this->callbacks[$message[self::OUT_ID]];
		Dog::setScope($callback[self::RES_SCOPE]);
		Dog::reply($message[self::OUT_ARGS]);
	}
	
	private function cleanupCallbacks()
	{
		$clamp = time() - $this->callmxtim;
		foreach ($this->callbacks as $id => $callback)
		{
			if ($callback[self::RES_TIME] < $clamp)
			{
				unset($this->callbacks[$id]);
			}
		}
	}
	
	/**
	 * Queue something for async.
	 * @param string $type
	 * @param mixed $message - Input for typefunc
	 * @param mixed $callback
	 * @param array $args - callback args
	 */
	public function async($type, $message, $callback=null, array $args=array(), array $includes=array())
	{
		if (!GWF_Callback::isCallback($callback, true, true))
		{
			echo "Dog_WorkerThread::async() - Invalid Callback!\n";
		}
		
		elseif (!in_array($type, self::$TYPES, true))
		{
			echo "Dog_WorkerThread::async() - Unknown Type: $type\n";
		}
		
		elseif (!is_array($args))
		{
			echo "Dog_WorkerThread::async() - Args is not an array\n";
		}
		
		elseif (!$this->forked)
		{
			# Fallback to synchronous
			return $this->sync($type, $message, $callback, $args, $includes);
		}
		
		else
		{
			return $this->queue($type, Dog::getScope(), $message, $callback, $args, $includes);
		}

		return false;
	}
	
	public function async_function($function, $callargs, $callback=null, array $args=array(), array $includes=array())
	{
		return $this->async('call', array($function, $callargs), $callback, $args, $includes);
	}
	
	public function async_method($class, $method, $callargs, $callback=null, array $args=array(), array $includes=array())
	{
		return $this->async_function(array($class, $method), $callargs, $callback, $args, $includes);
	}
	
	private function sync($type, $message, $callback, array $args, array $includes)
	{
		self::$CHILD_INSTANCE = $this;
		$this->includes($includes);
		$result = array(time(), $callback, $args, $this->executeQueueMessage($type, $message));
		$this->executeResult($result);
		return true;
	}

	private function queue($type, Dog_Scope $scope, $message, $callback=null, array $args, array $includes)
	{
		if (count($this->callbacks) >= $this->callb_max)
		{
			$this->cleanupCallbacks();
			return false;
		}
		printf('Dog_WorkerThread::queue(%s, %s, %s, %s, %s, %s)', $type, $scope, print_r($message, true), GWF_Callback::printCallback($callback), print_r($args, true), print_r($includes, true));
		if (msg_send($this->queue_in, self::msgtype($type), array($this->callbacnt, $message, $includes)))
		{
			return $this->storeCallback($callback, $args, $scope);
		}
	}
	
	private function storeCallback($callback=null, array $args, Dog_Scope $scope)
	{
		$this->callbacks[(string)($this->callbacnt++)] = array(time(), $scope, $callback, $args);
		return true;
	}

	########################
	### CHILD BELOW HERE ###
	########################
	public function SIGINT()
	{
		echo "Dog_WorkerThread::SIGINT()\n";
		pcntl_wait($this->pid);
		die('SIGINT!');
	}
	
	private function setupChild()
	{
		self::$CHILD_INSTANCE = $this;
		
		declare(ticks = 1);
		if (false === pcntl_signal(SIGINT, array(__CLASS__, 'SIGINT')))
		{
			die('Cannot install SIGINT handler in '.__FILE__.PHP_EOL);
		}
// 		chdir('../../../');
		
		GWF_Log::init(false, GWF_Log::_DEFAULT-GWF_Log::BUFFERED, GWF_PATH.'www/protected/logs/dog/worker');
		GWF_Log::logCron('--================--');
		GWF_Log::logCron('-= Worker started =-');
		GWF_Log::logCron('--================--');
	}
	
	public function reply($message)
	{
		if ($this->forked)
		{
			GWF_Log::logMessage('Worker: '.$message);
			msg_send($this->queue_out, self::REPLY, array($this->currcallb, $message));
		}
		else
		{
			Dog::reply($message);
		}
	}
	
	private function mainloop()
	{
// 		echo "Dog_WorkerThread::mainloop()\n";
		while (true)
		{
			$this->process();
			usleep(200000);
		}
	}
	
	private function process()
	{
		$msgtype = 0;
		$message = null;
		if (msg_receive($this->queue_in, 0, $msgtype, $this->max_msg_len, $message))
		{
			printf("Child: $msgtype:  %s\n", print_r($message, true));
			$this->currcallb = $message[self::IN_ID];
			$this->includes($message[self::IN_INCLUDES]);
			$result = $this->executeQueueMessage(self::type($msgtype), $message[self::IN_ARGS]);
			printf("Child sending: %s\n", print_r($result, true));
			msg_send($this->queue_out, $msgtype, array($message[self::IN_ID], $result));
		}
	}
	
	private function includes(array $includes)
	{
		printf('Dog_WorkerThread::includes() %s', print_r($includes));
		foreach ($includes as $filename)
		{
			require_once $filename;
		}
	}
	
	private function executeQueueMessage($type, $message)
	{
		printf("executeQueueMessage: %s\n", print_r($message, true));
		return call_user_func(array(__CLASS__, 'msg_type_'.$type), $message);
	}
	
	private function msg_type_call($message)
	{
		printf("msg_type_call: %s\n", print_r($message, true));
		
		if ( (!is_array($message)) || (count($message) !== 2) )
		{
			GWF_Log::logCritical("Dog_WorkerThread::msg_type_call() - The message from queue is not array(func, args)");
		}
		elseif (!GWF_Callback::isCallback($message[0]))
		{
			GWF_Log::logCritical("Dog_WorkerThread::msg_type_call() - message[0] is not a valid callback");
		}
		elseif (!is_array($message[1]))
		{
			GWF_Log::logCritical("Dog_WorkerThread::msg_type_call() - message[1] is not an args array");
		}
		else
		{
			printf("msg_type_call: %s\n%s", print_r($message[0]), print_r($message[1]));
			return call_user_func_array($message[0], $message[1]);
		}
	}
}
