<?php
/**
 * Dog Quotes Module.
 * TODO: Say a random quote once in an hour.
 * @author gizmore
 * @version 4.0
 */
final class DOGMOD_Quote extends Dog_Module
{
	public function getOptions()
	{
		return array(
			'rand_quote' => 'c,a,i,0',     # channel admin int minutes
			'rand_quote_t' => 'c,x,i,0' # channel admin int timestamp (by script)
		);
	}
	
	public function onInitTimers()
	{
		Dog_Timer::addTimer(array($this, 'randomQuote'), NULL, 60);
	}
	
	public function randomQuote()
	{
		foreach (Dog::getServers() as $server)
		{
			$server instanceof Dog_Server;
			foreach ($server->getChannels() as $channel)
			{
				$channel instanceof Dog_Channel;
				
				if (  (!$this->isEnabled($server, $channel))
					||(($minutes = $this->getConfig('rand_quote', 'c')) <= 0) )
				{
					continue;
				}
				
				$now = time();
				$seconds = $minutes * 60;
				$last = (int)$this->getConfig('rand_quote_t', 'c');
				$elapsed = $now - $last;
				if ($last > 0)
				{
					$this->randomQuoteChannel($channel);
				}
				$this->setConfigVar('c', 'rand_quote_t', $now);
			}
		}
	}
	
	private function randomQuoteChannel(Dog_Channel $channel)
	{
		$message = $this->lang('random_quote', array($this->onDisplay()));
		$channel->sendPRIVMSG($message);
	}
	
	public function on_quote_Pb() { Dog::reply($this->onDisplay($this->msgarg())); }
	private function onDisplay($message='')
	{
		if ($message === '')
		{
			return $this->displayQuote(Dog_Quote::getRandomID());
		}
		
		if (Common::isNumeric($message))
		{
			return $this->displayQuote(intval($message));
		}
		
		$ids = Dog_Quote::searchQuotes($message);
		if (count($ids) === 0)
		{
			return sprintf('No quote found with search term "%s"', $message);
		}
		
		if (count($ids) === 1)
		{
			return $this->displayQuote($ids[0]);
		}
		
		
		return sprintf('Matching IDs: %s.', implode(', ', $ids));
	}
	
	private function displayQuote($id)
	{
		if (false === ($quote = Dog_Quote::getByID($id)))
		{
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		return sprintf('Quote(%d): %s - Rating(%d)', $id, $quote->getVar('quot_text'), $quote->getVar('quot_rating'));
	}

// 	public function on_ADDquote_Sb() { Dog::reply($this->onAdd(Dog::getUser()->getName(), $this->msgarg())); }
	public function on_ADDquote_Pc() { Dog::reply($this->onAdd(Dog::getUser()->getName(), $this->msgarg())); }
	private function onAdd($username, $message)
	{
		if ($message === '')
		{
			return $this->showHelp('+quote');
		}
		
		if (false === ($quote = Dog_Quote::insertQuote($username, $message)))
		{
			return 'Database Error.';
		}
		
		return sprintf('Quote has been added (ID:%d)', $quote->getID());
	}

	public function on_REMOVEquote_Ab() { Dog::reply($this->onDelete($this->msgarg())); }
// 	public function on_REMOVEquote_Sc() { Dog::reply($this->onDelete($this->msgarg())); }
	private function onDelete($message)
	{
		$id = (int)$message;
		if (false === ($quote = Dog_Quote::getByID($id)))
		{
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		if (false === ($quote->delete()))
		{
			return 'Database Error.';
		}
		return sprintf('Quote with ID %d has been deleted.', $id);
	}

	public function on_quoteUP_Pc() { Dog::reply($this->onVote(1)); }
	public function on_quoteDOWN_Pc() { Dog::reply($this->onVote(-1)); }
	private function onVote($vote)
	{
// 		$id = (int)$this->argv(0);
		if (false === ($quote = Dog_Quote::getByID($id)))
		{
			return sprintf('Quote with ID(%d) not found.', $id);
		}
		
		if (false === $quote->increase('quot_rating', $vote))
		{
			return 'Database Error.';
		}
		
		GWF_Counter::increaseCount('dog_quotevotes', 1);
		
		return 'Vote registered.';
	}

	public function on_quotes_Pb()
	{
		$votes = GWF_Counter::getCount('dog_quotevotes');
		$quotes = GDO::table('Dog_Quote');
		$count = $quotes->countRows();
		$last = $quotes->selectFirstObject('*', '', 'quot_date DESC');
		$last = $last === false ? '' : sprintf(' The last quote has been added by %s at %s.', $last->getVar('quot_username'), $last->displayDate());
		Dog::reply(sprintf('I have %d quotes in the database.%s The quotes have been voted %d times.', $count, $last, $votes));
	}
}
?>
