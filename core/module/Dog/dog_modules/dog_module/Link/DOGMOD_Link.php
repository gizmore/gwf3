<?php
/**
 * Fetches html sites via links and does some indexing of meta description and title.
 * @author gizmore
 * @version 4.0
 * @since 3.0
 */
final class DOGMOD_Link extends Dog_Module
{
	const MAX_COUNT = 25;
	
	public function getOptions()
	{
		return array(
			'collect_chan' => 'c,o,i,2',
			'collect_serv' => 's,i,i,2',
			'collect_user' => 'u,l,i,2',
			'collect_glob' => 'g,x,i,2',
			'images_chan' => 'c,o,i,2',
			'images_serv' => 's,i,i,2',
			'images_user' => 'u,l,i,2',
			'images_glob' => 'g,x,i,2',
		);
	}
	
	/**
	 * Return only 0=off, 1=on, 2=dontcare
	 */
	public function getCollectConf($varname, $scope)
	{
		$value = (int)$this->getConfig($varname, $scope);
		return ($value === 0) || ($value === 1) ? $value : 2;
	}
	
	public function collectorEnabled($collector='collect')
	{
		if (Dog::getUser()===false) return false;
		$user = $this->getCollectConf($collector.'_user', 'u');
		$chan = $this->getCollectConf($collector.'_chan', 'c');
		$serv = $this->getCollectConf($collector.'_serv', 's');
		$glob = $this->getCollectConf($collector.'_glob', 'g');
		
		if (false !== Dog::getChannel())
		{
			return $this->collectorEnabledArray(array($user, $chan, $serv, $glob));
		}
		else
		{
			return $this->collectorEnabledArray(array($user, $serv, $glob));
		}
	}
	
	public function collectorEnabledArray(array $array)
	{
		foreach ($array as $value)
		{
			if ($value !== 2)
			{
				return $value === 1;
			}
		}
		return true;
	}
	
	public function event_privmsg()
	{
		if (!Dog::isTriggered() && $this->collectorEnabled())
		{
			$user = Dog::getUser();
			if (preg_match_all('#(https?://[^\ ]+)#D', $this->msg(), $matches))
			{
				array_shift($matches);
				foreach ($matches as $match)
				{
					$this->onAdd($user, $match[0]);
				}
			}
		}
	}
	
	private function onAdd(Dog_User $user, $url)
	{
		if (false !== ($link = Dog_Link::getByURL($url)))
		{
			return true;
		}
		
		if (false === ($description = $this->getDescription($url)))
		{
			Dog_Log::error('Mod_Link::onAdd() failed. URL: '.$url);
			return false;
		}
		
		$type = $description[0];
		$description = $description[1];
		
		switch ($type)
		{
			case 'image':
				if (false === ($link = Dog_Link::insertImage($user->getID(), $url, $description)))
				{
					GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
					return;
				}
				break;
				
			case 'html':
				if (false === ($link = Dog_Link::insertLink($user->getID(), $url, $description)))
				{
					GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
					return;
				}
				break;
			default:
				echo "UNKNOWN TYPE: $type\n";
				return;
		}
		
		Dog_Log::user($user, sprintf('Inserted Link %s (ID:%d)', $url, $link->getID()));
	}
	
	private function getDescription($url)
	{
		# Get page content
		# TODO: Only download .txt and .html content!
		GWF_HTTP::setTimeout(10);
		GWF_HTTP::setConnectTimeout(3);
		$content = GWF_HTTP::getFromURL($url, true);
		GWF_HTTP::setTimeout();
		GWF_HTTP::setConnectTimeout();
		
		if ($content === false)
		{
			Dog_Log::error('Mod_Link::getDescription(): getFromURL() failed. URL: '.$url);
			return false;
		}
		
		list ($head, $content) = preg_split("/[\r\n]{4}/", $content, 2);
		$type = Common::regex('/Content-Type: *(.*)/Di', $head);

		echo $type.PHP_EOL;
		
		if (Common::startsWith($type, 'image'))
		{
			return array('image', $content);
		}

		$cs = Common::regex('/charset\\s*=\\s*([^;\\s]*)/i', $type);
		echo $cs . PHP_EOL;
		$in_charset = ($cs !== false) ? $cs : "ISO-8859-1";

		# Get Title from html
		if (0 === preg_match('#< *title *>([^<]+)< */ *title *>#i', $content, $matches))
		{
			return false;
		}
		
		$title = $this->decode($matches[1], $in_charset);

		$descr = '';
		if (1 === preg_match('#(< *meta.*description[^>]*>)#i', $content, $matchesB)) {
			$tag = $matchesB[1];
			if (1 === preg_match('#content=["\']([^"\']+)["\']#', $tag, $matchesB)) {
				$descr = ' - '.$this->decode($matchesB[1], $in_charset);
			}
		}
		
		return array('html', $title.' - '.$descr);
	}
	
	private function decode($s, $in_charset)
	{
		$s = iconv($in_charset, "UTF-8//IGNORE", $s);
		$s = str_replace(array('&nbsp;'), array(' '), $s);
		$s = htmlspecialchars_decode($s, ENT_QUOTES);
		return strlen($s) > 1024 ? substr($s, 0, 1024) : $s;
	}
	
	/**
	 * @return Dog_Link
	 */
	private function getRandomLink()
	{
		if (false === ($links = GDO::table('Dog_Link')->selectRandom('*')))
		{
			return false;
		}
		if (count($links) === 0)
		{
			return false;
		}
		return $links[0];
	}
	
	################
	### Triggers ###
	################
	public function on_link_Pb()
	{
		if ('' === ($message = $this->msgarg()))
		{
			if (false === ($link = $this->getRandomLink()))
			{
				return Dog::rply('err_no_results');
			}
			else
			{
				return $this->displayLinkObject($link);
			}
		}
		
		if (is_numeric($message))
		{
			return $this->displayLink($message);
		}
		
		
		$ids = Dog_Link::searchLinks($message);

		$count = count($ids);
		
		if ($count === 0)
		{
			return $this->rply('err_no_match');
		}
		
		if ($count === 1)
		{
			return $this->displayLink($ids[0]);
		}
		
		if ($count > self::MAX_COUNT)
		{
			$more = $count-self::MAX_COUNT;
			$ids = array_slice($ids, 0, self::MAX_COUNT);
		}
		else {
			$more = 0;
		}
		
		$key = $more === 0 ? 'matches' : 'match_more';
		$this->rply($key, array($count, implode(', ', $ids), $more));
	}
	
	private function displayLink($link_id)
	{
		if (false === ($link = Dog_Link::getByID($link_id)))
		{
			$this->rply('err_link_id', array(intval($link_id)));
		}
		else
		{
			$this->displayLinkObject($link);
		}
	}
	
	private function displayLinkObject(Dog_Link $link)
	{
		$this->rply('show_link', array($link->getID(), $link->getURL(), $link->displayText(), $link->getRating()));
	}
	
	public function on_links_Pb()
	{
		$votes = GWF_Counter::getCount('dog_linkvotes');
		$links = GDO::table('Dog_Link');
		$count = $links->countRows();
		$this->rply('stats', array($count, $votes, $links->selectVar('MAX(link_id)')));
	}
	
	public function on_linkUP_Lc() { $this->onVote(1); }
	public function on_linkDOWN_Lc() { $this->onVote(-1); }
	private function onVote($by)
	{
		if ('' === ($message = $this->msgarg()))
		{
			$a = $by > 0 ? '++' : '--';
			$this->showHelp('link'.$a);
		}
		elseif (false === ($link = Dog_Link::getByID($message)))
		{
			$this->rply('err_link_id', array(intval($message)));
		}
		elseif (!$link->increase('link_rating', $by))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		elseif (!GWF_Counter::increaseCount('dog_linkvotes', 1))
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		else
		{
			$this->rply('voted');
		}
	}
	
	public function on_REMOVElink_Ob()
	{
		if ('' === ($message = $this->msgarg()))
		{
			$this->showHelp('-link');
		}
		elseif (false === ($link = Dog_Link::getByID($message)))
		{
			$this->rply('err_link_id', array(intval($message)));
		}
		elseif (!$link->delete())
		{
			Dog::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		else
		{
			$this->rply('deleted', array($link->getID()));
		}
	}
}
