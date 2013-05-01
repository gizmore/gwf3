<?php
require_once 'Lamb_News.php';
require_once 'Lamb_NewsFeed.php';
/**
 * Fetch news from an rss feed and display.
 * @author gizmore
 */
final class LambModule_News extends Lamb_Module
{
	const GLOBAL_BEHAVIOUR = 0; # 0-Source 1-Global 2-SuperGlobal
	const DISPLAYCOUNT_IDLE = 5;

	private $runlevel = 0; # 0-Idle 1-Timeout 2-fetch 3-parse 4-display 5-display-idle
	private $user = NULL;
	private $origin = '';
	private $displaycount = 0;  
	private $socket = NULL;
	private $received = '';
	private $queue = NULL;
	private $feed = NULL;
	
	################
	### Triggers ###
	################
	public function onInstall()
	{
		GDO::table('Lamb_News')->createTable(false);
		GDO::table('Lamb_NewsFeed')->createTable(false);
		# 2 default feeds :)
		echo $this->addFeed('http://www.heise.de/security/news/news.rdf').PHP_EOL;
		echo $this->addFeed('http://www.wechall.net/news/feed').PHP_EOL;
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge, $showHidden=true)
	{
		switch ($priviledge)
		{
			case 'admin': return array('-feed');
			case 'halfop': return array('+feed');
			case 'voice': return array('news');
			default: return array();
		}
	}
	
	public function getHelp()
	{
		return array(
			'-feed' => 'Usage: %CMD% <feed_id>. Deletes a feed.',
			'+feed' => 'Usage: %CMD% <url>. Add an rss feed.',
			'news' => 'Usage: %CMD% to display feeds. %CMD% <id> to show the feed. %CMD% drop to drop remaining news.',
		);
	}
	
	public function isRunning()
	{
		return $this->runlevel > 0;
	}

	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		switch ($command)
		{
			case '-feed': $out = $this->removeFeed($message); break;
			case '+feed': $out = $this->addFeed($message); break;
//			case 'newsp': $out = $this->newsCommand($server, $user, $message, true); break;
			case 'news': $out = $this->newsCommand($server, $user, $message, $origin); break;
		}
		$server->reply($origin, $out);
	}
	
	####################
	### Add/Rem Feed ###
	####################
	private function removeFeed($message)
	{
		$id = (int)$message;
		
		if (false === ($feed = Lamb_NewsFeed::getByID($id))) {
			return sprintf('The feed with ID:%d is unknown.', $id);
		}
		
		if (false === $feed->onDelete()) {
			return 'Database error.';
		}
		
		return sprintf('The feed with ID:%d has been deleted.', $id);
	}
	
	private function addFeed($message)
	{
		if (false === ($content = GWF_HTTP::getFromURL($message))) {
			return sprintf('URL is invalid or does not exist.');
		}
		
		if (false !== ($feed = Lamb_NewsFeed::getByURL($message))) {
			if ($feed->isDeleted())
			{
				$feed->onUnDelete();
			}
			else
			{
				return sprintf('This feed is already in the database.');
			}
		}
		else
		{
			$feed = new Lamb_NewsFeed(array(
				'lnf_id' => 0,
				'lnf_name' => '',
				'lnf_url' => $message,
				'lnf_options' => 0,
				'lnf_lastdate' => '00000000000000',
			));
		}
		
		if (false === $this->setupFeed($feed, $content)) {
			return 'The feed seems broken :(';
		}
		
		if ($feed->getID() == 0) {
			$feed->insert();
		} else {
			$feed->replace();
		}

		return sprintf('Added Feed as %s (ID:%d).', $feed->getVar('lnf_name'), $feed->getID());
	}
	
	private function setupFeed(Lamb_NewsFeed $feed, $content)
	{
		if (!Common::startsWith($content, '<?xml'))
		{
			Lamb_Log::logError('Feed does not start with <?xml');
			return false;
		}
		
		if (false === ($xml = simplexml_load_string($content)))
		{
			Lamb_Log::logError('Feed is not valid XML!');
			return false;
		}
		
		$a = $xml->attributes();
		$version = (string) $a['version'];
		
		switch ($version)
		{
			case '2.0': $rss_version = Lamb_NewsFeed::RSS_20; break;
			default: Lamb_Log::logError(sprintf('RSS Version %s is not supported!', $version)); return false;
		}
		
		if  ( (!isset($xml->channel->title)) || ((string)$xml->channel->title==='') )
		{
			Lamb_Log::logError('Feed channel has no title!');
			return false;
		}
		
		$feed->setVar('lnf_name', (string)$xml->channel->title);
		$feed->setOption($rss_version, true);
		
		return true;
	}
	
	####################
	### Request News ###
	####################
	private function newsCommand(Lamb_Server $server, Lamb_User $user, $message, $origin=false)
	{
		$command = trim(Common::substrUntil($message, ' '));
		$message = trim(Common::substrFrom($message, ' ', $message));
		switch ($command)
		{
			case 'drop':
				return $this->dropNews($server);
			case '':
				if ($this->runlevel === 0) { return $this->showFeeds(); }
			default:
				return $this->requestNews($server, $user, $message, $origin);
		}
	}

	private function showFeeds()
	{
		if (false === ($feeds = Lamb_NewsFeed::getWorkingFeeds())) {
			return 'Database Error.';
		}
		
		if (count($feeds) === 0) {
			return sprintf('There are no working feeds in the database. Try %s+feed <url> to add one.', LAMB_TRIGGER);
		}
		
		$back = '';
		foreach ($feeds as $feed)
		{
			$back .= sprintf(', %s(%d)', $feed->getVar('lnf_name'), $feed->getID());
		}
		return substr($back, 2);
	}
	
	############################
	### Core News Feed stuff ###
	############################
	private function dropNews(Lamb_Server $server)
	{
		if ($this->runlevel !== 5)
		{
			return 'There is no request running, nor are there any news left in the queue.';
		}
		$count = count($this->queue);
		$this->onDone($server);
		return sprintf('%d news has/have been dropped.', $count);
	}

	private function requestNews(Lamb_Server $server, Lamb_User $user, $message, $origin)
	{
		// display more?
		if ($this->runlevel === 5)
		{
			$this->displaycount = 0;
			$this->runlevel = 4;
			$this->resetTimer($server);
			
			$count = count($this->queue);
			return sprintf('Displaying %d more items out of %d...', min(self::DISPLAYCOUNT_IDLE, $count), $count);
		}
		// Double request?
		elseif ($this->isRunning()) {
			return sprintf('There is already a newsfeed request running...');
		}
		
		
		$id = (int) $message;
		if (false === ($feed = Lamb_NewsFeed::getByID($id))) {
			return sprintf('The feed-id %d is unknown. Try %snews <feed_id>.', $id, LAMB_TRIGGER);
		}
		
		$this->feed = $feed;
		$url = $feed->getVar('lnf_url');
		if (!( $this->socket = @fopen($url, "r") )) {
			return sprintf('Can not connect to feed ( %s ).', $url);
		}
		stream_set_blocking($this->socket, 0);
		
		$this->runlevel = 2;
		$this->received = '';
		$this->origin = $origin;
		$this->user = $user;
		$this->displaycount = 0;
		
		$this->resetTimer($server);
		
		return sprintf('Sending rss request to %s ( %s ).', $feed->getVar('lnf_name'), $url);
	}

	private function resetTimer(Lamb_Server $server)
	{
//		Lamb::instance()->addTimer($server, array($this, 'feedTimer'), NULL, 0.5);
		Lamb::instance()->addTimer(array($this, 'feedTimer'), 0.5, $server);
	}
	
	public function feedTimer(Lamb_Server $server, $args)
	{
		switch ($this->runlevel)
		{
			case 0: # idle
				break;
			case 1: # TODO: Timeout
			case 2: # fetch
				while (false !== ($recieved = fgets($this->socket))) {
					$this->received .= $recieved;
				}
				if (feof($this->socket)) {
					$this->runlevel = 3;
				}
				break;
			case 3: # parse
				$this->runlevel = 4;
				$this->parse($server, $this->received);
				break;
			case 4: # display
				$this->displayItem($server);
				break;
			case 5:
				return true;
			default:
				Lamb_Log::logError('Unknown runlevel: '. $this->runlevel);
				break;
		}

		$this->resetTimer($server);
		
		return true;
	}
	
	private function parse(Lamb_Server $server, $received)
	{
		if (false === ($xml = simplexml_load_string($received)))
		{
			Lamb_Log::logError('Mod_News::parse() - simplexml_load_string() failed.');
			return false;
		}
		
		$len = count($xml->channel->item);
		for ($i = 0; $i < $len; $i++)
		{
			if (false === $this->insertChannelItem($server, $xml->channel->item[$i])) {
				return false;
			}
		}
		
		if (count($this->queue) === 0) {
			$this->response($server, sprintf('There are no news on %d) %s ( %s ).', $this->feed->getVar('lnf_id'), $this->feed->getVar('lnf_name'), $this->feed->getVar('lnf_url')));
			$this->onDone($server);
			return true;
		}
		
		return true;
		
	}
	
	private function insertChannelItem(Lamb_Server $server, $xml)
	{
		$news = GDO::table('Lamb_News');
		
		$fid = $this->feed->getID();
		$url = (string)$xml->link;
		$title = (string)$xml->title;
		$descr = (string)$xml->description;
		if ( (false === ($item = Lamb_News::getByTitle($fid, $title))) && 
			 (false === ($item = Lamb_News::getByURL($this->feed->getID(), (string)$xml->title)))
			 )
		{
			// New News
			$item = new Lamb_News(array(
				'ln_id' => 0,
				'ln_fid' => $fid,
				'ln_date' => GWF_Time::getDate(GWF_Date::LEN_SECOND),
				'ln_title' => $title,
				'ln_url' => $url,
				'ln_descr' => $descr,
				'ln_options' => 0,
			));
			if (false === $item->insert())
			{
				Lamb_Log::logError('Database error in Mod_News::insertChannelItem()');
			}
			else
			{
				$this->queue[] = $item;
			}
		}
		
		elseif ( ($this->origin === $server->getBotsNickname()) || (!$item->isDisplayed()) )
		{
			$this->queue[] = $item;
		}
		
		return true;
	}

	private function displayItem(Lamb_Server $server)
	{
		$count = count($this->queue);

		// Display one
		if ($count > 0)
		{
			$this->displayItemB($server, array_shift($this->queue));
			$count --;
		}
		
		// Done?
		if ($count === 0) {
			return $this->onDone($server);
		}
		
		// We displayed one more
		$this->displaycount++;
		if ($this->displaycount === self::DISPLAYCOUNT_IDLE) {
			$this->runlevel = 5; # Idle a while
			$t = LAMB_TRIGGER;
			$this->response($server, sprintf('There are %d more news from %s in the queue. Type %snews to see them or %snews drop.', $count, $this->feed->getVar('lnf_name'), $t, $t));
		}

		return true;
	}

	private function displayItemB(Lamb_Server $server, Lamb_News $item)
	{
		$item->saveOption(Lamb_News::DISPLAYED, true);
		$this->response($server, $this->getMessage($item));
	}
	
	private function response(Lamb_Server $server, $message)
	{
		if ($this->origin === $server->getBotsNickname()) {
			$server->reply($this->user->getVar('lusr_name'), $message);
			return;
		}
		
		switch (self::GLOBAL_BEHAVIOUR)
		{
			case 0: $server->reply($this->origin, $message); break; 
			case 1: Lamb::instance()->globalMessage($message); break;
			case 2: Lamb::instance()->superGlobalMessage($message); break;
			default: break;
		}
	}
	
	private function getMessage(Lamb_News $item)
	{
		$url = $item->getVar('ln_url');
		$url = str_replace(array(' '), array('%20'), $url);
		return sprintf('%s ( %s )', $item->getVar('ln_title'), $url);
	}
	
	private function onDone(Lamb_Server $server)
	{
		$this->runlevel = 0;
		$this->displaycount = 0;
		$this->queue = NULL;
		return true;
	}
}
?>