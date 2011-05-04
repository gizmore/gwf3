<?php
require_once 'Lamb_Quote.php';
/**
 * @author gizmore
 */
final class LambModule_Quote extends Lamb_Module
{
	################
	### Triggers ###
	################
	public function onInit(Lamb_Server $server) {}
	public function onInstall() { GDO::table('Lamb_Quote')->createTable(false); }
	public function onNotice(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onPrivmsg(Lamb_Server $server, Lamb_User $user, $from, $origin, $message) {}
	public function onTimer() {}
	
	###############
	### Getters ###
	###############
	public function getTriggers($priviledge)
	{
		switch ($priviledge)
		{
			case 'public': return array('quote', '+quote', 'quote++', 'quote--', 'quotes');
			case 'halfop': return array('-quote');
			default: return array();
		}
	}
	
	public function getHelp($trigger)
	{
		$help = array(
			'quote' => 'Usage: %TRIGGER%quote <id|search terms>. Search the quote database.',
			'+quote' => 'Usage: %TRIGGER%+quote <quote text to add>. Will add a quote to the database.',
			'-quote' => 'Usage: %TRIGGER%-quote <id>. Remove a quote from the database.',
			'quote++' => 'Usage: %TRIGGER%quote++ <id>. Vote a quote up.',
			'quote--' => 'Usage: %TRIGGER%quote-- <id>. Vote a quote down.',
			'quotes' => 'Usage: %TRIGGER%quotes. Show quote statistics.',
		);
		return isset($help[$trigger]) ? $help[$trigger] : '';
	}
	
	################
	### Commands ###
	################
	public function onTrigger(Lamb_Server $server, Lamb_User $user, $from, $origin, $command, $message)
	{
		switch ($command)
		{
			case 'quote': $out = $this->onDisplay($message); break;
			case '+quote': $out = $this->onAdd($user->getVar('lusr_name'), $message); break;
			case '-quote': $out = $this->onDelete($message); break;
			case 'quote++': $out = $this->onVote($message, 1); break;
			case 'quote--': $out = $this->onVote($message, -1); break;
			case 'quotes': $out = $this->stats(); break;
		}
		$server->reply($origin, $out);
	}
	
	private function onDisplay($message)
	{
		if ($message === '') {
			return $this->displayQuote(Lamb_Quote::getRandomID());
		}
		
		if (is_numeric($message))
		{
			return $this->displayQuote(intval($message));
		}
		
		$ids = Lamb_Quote::searchQuotes($message);
		if (count($ids) === 0) {
			return sprintf('No quote found with search term "%s"', $message);
		}
		
		if (count($ids) === 1) {
			return $this->displayQuote($ids[0]);
		}
		
		return sprintf('Matching IDs: %s.', implode(', ', $ids));
	}
	
	private function displayQuote($id)
	{
		if (false === ($quote = Lamb_Quote::getByID($id))) {
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		return sprintf('Quote(%d): %s - Rating(%d)', $id, $quote->getVar('quot_text'), $quote->getVar('quot_rating'));
	}

	private function onAdd($username, $message)
	{
		if ($message === '') {
			return str_replace('%TRIGGER%', LAMB_TRIGGER, $this->getHelp('+quote'));
		}
		
		if (false === ($quote = Lamb_Quote::insertQuote($username, $message))) {
			return 'Database Error.';
		}
		
		return sprintf('Quote has been added (ID:%d)', $quote->getID());
	}

	private function onDelete($message)
	{
		$id = (int)$message;
		if (false === ($quote = Lamb_Quote::getByID($id))) {
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		if (false === ($quote->delete())) {
			return 'Database Error.';
		}
		return sprintf('Quote with ID %d has been deleted.', $id);
	}

	private function onVote($message, $vote)
	{
		$id = (int)$message;
		if (false === ($quote = Lamb_Quote::getByID($id))) {
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		
		if (false === $quote->increase('quot_rating', $vote)) {
			return 'Database Error.';
		}
		
		GWF_Counter::increaseCount('lamb_quotevotes', 1);
		
		return 'Vote registered.';
	}

	private function stats()
	{
		$votes = GWF_Counter::getCount('lamb_quotevotes');
		$quotes = GDO::table('Lamb_Quote');
		$count = $quotes->countRows();
		$last = $quotes->selectFirstObject('*', '', 'quot_date DESC');
		$last = $last === false ? '' : sprintf(' The last quote has been added by %s at %s.', $last->getVar('quot_username'), $last->displayDate());
		return sprintf('I have %d quotes in the database.%s The quotes have been voted %d times.', $count, $last, $votes);
		
	}
}
?>