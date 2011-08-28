<?php
require_once 'Lamb_Link.php';
/**
 * @author gizmore
 */
final class LambModule_Link extends Lamb_Module
{
	const MAX_COUNT = 25;
	
	################
	### Triggers ###
	################
	public function onInstall()
	{
		GDO::table('Lamb_Link')->createTable(false);
	}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('links', 'link', 'link++', 'link--');
			case 'halfop': return array('-link');
			default: return array();
		}
	}
	public function getHelp()
	{
		return array(
			'link' => 'Usage: %CMD% [id|search terms]. Display or search for a link. When no argument is given, a random link is displayed.',
			'links' => 'Usage: %CMD%. Display statistics for the links module.',
			'link++' => 'Usage: %CMD% <id>. Vote a link up.',
			'link--' => 'Usage: %CMD% <id>. Vote a link down.',
			'-link' => 'Usage: %CMD% <id>. Remove a link from the database.',
		);
	}

	#####################################
	### Add a link on normal privmsgs ###
	#####################################
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message)
	{
		if (!preg_match_all('#(https?://[^\ ]+)#', $message, $matches)) {
			return;
		}
		
		foreach ($matches as $match)
		{
			$this->onAdd($user->getVar('lusr_name'), $match[0]);
		}
	}
	
	private function onAdd($username, $url)
	{
		if (false !== ($link = Lamb_Link::getByURL($url)))
		{
			return true;
		}
		
		if (false === ($description = $this->getDescription($url)))
		{
			Lamb_Log::logError('Mod_Link::onAdd() failed. URL: '.$url.'; Username: '.$username);
			return false;
		}
		
		if (false === ($link = Lamb_Link::insertLink($username, $url, $description)))
		{
			GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
		}
		
		return sprintf('Inserted Link %s (ID:%d)', $url, $link->getID());
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
			Lamb_Log::logError('Mod_Link::getDescription(): getFromURL() failed. URL: '.$url);
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
		
		return $title.' - '.$descr;
	}
	
	private function decode($s)
	{
		$s = str_replace(array('&nbsp;'), array(' '), $s);
		$s = htmlspecialchars_decode($s, ENT_QUOTES);
		return strlen($s) > 1024 ? substr($s, 0, 1024) : $s;
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		switch ($command)
		{
			case 'link': $out = $this->onDisplay($message); break;
			case 'links': $out = $this->stats(); break;
			case 'link++': $out = $this->onVote($message, 1); break;
			case 'link--': $out = $this->onVote($message, -1); break;
			case '-link': $out = $this->onDelete($message); break;
		}
		$server->reply($origin, $out);
	}
	
	### FROM SR4
	public static function randomData(array $data, $total, $chance_none=0)
	{
		$total = (int)$total;
		$chance_none = (int) $chance_none;
		shuffle($data); shuffle($data); shuffle($data);
		$chance = $total + $chance_none;
		$rand = rand(1, $chance);
		if ($rand <= $chance_none) {
			return false;
		}
		$rand -= $chance_none;
		foreach ($data as $d)
		{
			if ($rand <= $d[1])
			{
				return $d[0];
			}
			$rand -= $d[1];
		}
		return false;
	}
	
	private function getRandomID()
	{
		$db = gdo_db();
		$data = array();
		$links = GWF_TABLE_PREFIX.'lamb_links';
		$query = "SELECT link_id, link_rating FROM $links";
		if (false === ($result = $db->queryRead($query))) {
			return false;
		}
		$total = 0;
		while (false !== ($row = $db->fetchRow($result)))
		{
			$row[1] += 2;
			$data[] = array($row[0], $row[1]);
			$total += $row[1];
		}
		return self::randomData($data, $total);
	}
	
	private function onDisplay($message)
	{
		if ($message === '') {
			if (false === ($id = $this->getRandomID())) {
				return 'The database seems empty.';
			} else {
				return $this->displayLink($id);
			}
		}
		
		if (is_numeric($message))
		{
			return $this->displayLink(intval($message));
		}
		
		
		$ids = Lamb_Link::searchLinks($message);

		$count = count($ids);
		
		if ($count === 0) {
			return sprintf('No link found with search term "%s"', $message);
		}
		
		if ($count === 1) {
			return $this->displayLink($ids[0]);
		}
		
		if ($count > self::MAX_COUNT) {
			$more = sprintf(', and %s more', $count-self::MAX_COUNT);
			$ids = array_slice($ids, 0, self::MAX_COUNT);
		}
		else {
			$more = '';
		}
		
		return sprintf('%s Matches: %s%s.', $count, implode(', ', $ids), $more);
	}
	
	private function displayLink($link_id)
	{
		$link_id = (int) $link_id;
		if (false === ($link = Lamb_Link::getByID($link_id))) {
			return sprintf('Link with ID(%d) is unknown.', $link_id);
		}
		
		return sprintf('Link %d: %s - %s - Rated: %s.', $link_id, $link->getVar('link_url'), $link->getVar('link_text'), $link->getVar('link_rating'));
	}
	
	private function stats()
	{
		$votes = GWF_Counter::getCount('lamb_linkvotes');
		$links = GDO::table('Lamb_Link');
		$count = $links->countRows();
		return sprintf('I have %d links in the database which have been voted %d times. The last ID is %d.', $count, $votes, $links->selectVar('MAX(link_id)'));
	}
	
	private function onVote($message, $by)
	{
		if ($message === '')
		{
			$a = $by > 0 ? '++' : '--';
			return $this->getHelpText('link'.$a);
		}
		$id = (int)$message;
		if (false === ($link = Lamb_Link::getByID($id)))
		{
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		if (false === $link->increase('link_rating', $by))
		{
			return 'Database Error.';
		}
		GWF_Counter::increaseCount('lamb_linkvotes', 1);
		return 'Vote registered.';
	}
	
	private function onDelete($message)
	{
		$link_id = (int) $message;
		if (false === ($link = Lamb_Link::getByID($link_id))) {
			return sprintf('Link with ID(%d) is unknown.', $link_id);
		}
		if (false === $link->delete()) {
			return 'Database error.';
		}
		return sprintf('Link with ID(%d) has been deleted.', $link_id);
	}
}
?>