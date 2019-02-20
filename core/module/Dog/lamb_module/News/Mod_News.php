<?php
require_once 'Dog_News.php';
require_once 'Dog_NewsFeed.php';
/**
 * Fetch news from an rss feed and display.
 * @author gizmore
 */
final class DOGMOD_News extends Dog_Module
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
		GDO::table('Dog_News')->createTable(false);
		GDO::table('Dog_NewsFeed')->createTable(false);
		# 2 default feeds :)
		echo $this->addFeed('http://www.heise.de/security/news/news.rdf').PHP_EOL;
		echo $this->addFeed('http://www.wechall.net/news/feed').PHP_EOL;
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($privilege, $showHidden=true)
	{
		switch ($privilege)
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
	public function onTrigger(Dog_Server $server, Dog_User $user, $from, $origin, $command, $message)
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
		
		if (false === ($feed = Dog_NewsFeed::getByID($id))) {
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
		
		if (false !== ($feed = Dog_NewsFeed::getByURL($message))) {
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
			$feed = new Dog_NewsFeed(array(
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
	
	private function setupFeed(Dog_NewsFeed $feed, $content)
	{
		if (!Common::startsWith($content, '<?xml'))
		{
			Dog_Log::error('Feed does not start with <?xml');
			return false;
		}
		
		if (false === ($xml = simplexml_load_string($content)))
		{
			Dog_Log::error('Feed is not valid XML!');
			return false;
		}
		
		$a = $xml->attributes();
		$version = (string) $a['version'];
		
		switch ($version)
		{
			case '2.0': $rss_version = Dog_NewsFeed::RSS_20; break;
			default: Dog_Log::error(sprintf('RSS Version %s is not supported!', $version)); return false;
		}
		
		if  ( (!isset($xml->channel->title)) || ((string)$xml->channel->title==='') )
		{
			Dog_Log::error('Feed channel has no title!');
			return false;
		}
		
		$feed->setVar('lnf_name', (string)$xml->channel->title);
		$feed->setOption($rss_version, true);
		
		return true;
	}
	
	####################
	### Request News ###
	####################
	private function newsCommand(Dog_Server $server, Dog_User $user, $message, $origin=false)
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
		if (false === ($feeds = Dog_NewsFeed::getWorkingFeeds())) {
			return 'Database Error.';
		}
		
		if (count($feeds) === 0) {
			return sprintf('There are no working feeds in the database. Try %s+feed <url> to add one.', Dog::getTrigger());
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
	private function dropNews(Dog_Server $server)
	{
		if ($this->runlevel !== 5)
		{
			return 'There is no request running, nor are there any news left in the queue.';
		}
		$count = count($this->queue);
		$this->onDone($server);
		return sprintf('%d news has/have been dropped.', $count);
	}

	private function requestNews(Dog_Server $server, Dog_User $user, $message, $origin)
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
		if (false === ($feed = Dog_NewsFeed::getByID($id))) {
			return sprintf('The feed-id %d is unknown. Try %snews <feed_id>.', $id, Dog::getTrigger());
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

	private function resetTimer(Dog_Server $server)
	{
//		Lamb::instance()->addTimer($server, array($this, 'feedTimer'), NULL, 0.5);
		Lamb::instance()->addTimer(array($this, 'feedTimer'), 0.5, $server);
	}
	
	public function feedTimer(Dog_Server $server, $args)
	{
		switch ($this->runlevel)
		{
			case 0: # idle
				break;
			case 1: # TODO: Timeout
			case 2: # fetch
				while (false !== ($received = fgets($this->socket))) {
					$this->received .= $received;
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
				Dog_Log::error('Unknown runlevel: '. $this->runlevel);
				break;
		}

		$this->resetTimer($server);
		
		return true;
	}
	
	private function parse(Dog_Server $server, $received)
	{
		if (false === ($xml = simplexml_load_string($received)))
		{
			Dog_Log::error('Mod_News::parse() - simplexml_load_string() failed.');
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
	
	private function insertChannelItem(Dog_Server $server, $xml)
	{
		$news = GDO::table('Dog_News');
		
		$fid = $this->feed->getID();
		$url = (string)$xml->link;
		$title = (string)$xml->title;
		$descr = (string)$xml->description;
		if ( (false === ($item = Dog_News::getByTitle($fid, $title))) && 
			 (false === ($item = Dog_News::getByURL($this->feed->getID(), (string)$xml->title)))
			 )
		{
			// New News
			$item = new Dog_News(array(
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
				Dog_Log::error('Database error in Mod_News::insertChannelItem()');
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

	private function displayItem(Dog_Server $server)
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
			$t = Dog::getTrigger();
			$this->response($server, sprintf('There are %d more news from %s in the queue. Type %snews to see them or %snews drop.', $count, $this->feed->getVar('lnf_name'), $t, $t));
		}

		return true;
	}

	private function displayItemB(Dog_Server $server, Dog_News $item)
	{
		$item->saveOption(Dog_News::DISPLAYED, true);
		$this->response($server, $this->getMessage($item));
	}
	
	private function response(Dog_Server $server, $message)
	{
		if ($this->origin === $server->getBotsNickname()) {
			$server->reply($this->user->getVar('user_name'), $message);
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
	
	private function getMessage(Dog_News $item)
	{
		$url = $item->getVar('ln_url');
		$url = str_replace(array(' '), array('%20'), $url);
		return sprintf('%s ( %s )', $item->getVar('ln_title'), $url);
	}
	
	private function onDone(Dog_Server $server)
	{
		$this->runlevel = 0;
		$this->displaycount = 0;
		$this->queue = NULL;
		return true;
	}
}
?>