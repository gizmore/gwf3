<?php
final class Renraku04_Elevator extends Renraku_Elevator
{
	public function onLeaveLocation(SR_Party $party)
	{
		$errors = '';
		
		foreach ($party->getMembers() as $member)
		{
			$member instanceof SR_Player;
			if (false === ($item = $member->getInvItemByName('ID4Card')))
			{
				$errors .= sprintf(', %s', $member->getName());
			}
			else
			{
				$member->message(sprintf('You use one of your %d ID4 cards...', $item->getAmount()));
				$item->useAmount($member, 1);
			}
		}
		
		if ($errors !== '')
		{
			$party->notice(sprintf('%s do(es) not have an ID4Card... You hear the alarm sound!', substr($errors, 2)));
			if (false !== ($city = $this->getCityClass()))
			{
				$city->setAlert($party, GWF_Time::ONE_HOUR*2);
			}
		}
	}
	
}
?>
