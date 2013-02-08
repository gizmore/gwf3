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
	
	public function event_privmsg()
	{
		if (!Dog::isTriggered())
		{
			$user = Dog::getUser();
			if (preg_match_all('#(https?://[^\ ]+)#D', $this->msg(), $matches))
			{
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
		
		if (false === ($link = Dog_Link::insertLink($user->getID(), $url, $description)))
		{
			GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		Dog_Log::user($user, sprintf('Inserted Link %s (ID:%d)', $url, $link->getID()));
	}
	
	private function getDescription($url)
	{
		# Get page content
		# TODO: Only download .txt and .html content!
		GWF_HTTP::setTimeout(10);
		GWF_HTTP::setConnectTimeout(3);
		$content = GWF_HTTP::getFromURL($url);
		GWF_HTTP::setTimeout();
		GWF_HTTP::setConnectTimeout();
		if ($content === false)
		{
			Dog_Log::error('Mod_Link::getDescription(): getFromURL() failed. URL: '.$url);
			return false;
		}
		
		# Get Title from html
		if (0 === preg_match('#< *title *>([^<]+)< */ *title *>#i', $content, $matches))
		{
			return false;
		}
		
		$title = $this->decode($matches[1]);

		$descr = '';
		if (1 === preg_match('#(< *meta.*description[^>]*>)#i', $content, $matchesB)) {
			$tag = $matchesB[1];
			if (1 === preg_match('#content=["\']([^"\']+)["\']#', $tag, $matchesB)) {
				$descr = ' - '.$this->decode($matchesB[1]);
			}
		}
		
		$back = $title.' - '.$descr;
		
		return $back;
	}
	
	private function decode($s)
	{
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
