<?php
final class Shadowcmd_gmq extends Shadowcmd
{
	public static function execute(SR_Player $player, array $args)
	{
		$bot = Shadowrap::instance($player);
		if ((count($args) < 2) || (count($args) > 4))
		{
			$bot->reply(Shadowhelp::getHelp($player, 'gmq'));
			return false;
		}
		
		$target = Shadowrun4::getPlayerByShortName($args[0]);
		if ($target === -1)
		{
			$player->message('The username is ambigious.');
			return false;
		}
		if (false === $target)
		{
			$player->message('The player is not in memory or unknown.');
			return false;
		}
		
		if (false === $target->isCreated())
		{
			$bot->reply(sprintf('The player %s has not started a game yet.', $args[0]));
			return false;
		}
		
		$questname = $args[1];
		$quests = SR_Quest::getQuests();
		if (false === array_key_exists($questname,$quests))
		{
			$bot->reply(sprintf('The quest %s does not exist.', $args[1]));
			return false;
		}
		$quest = $quests[$questname];

		$internalname = substr(get_class($quest),6);
		if (false === ($quest = SR_Quest::getQuest($target,$internalname)))
		{
			$bot->reply(sprintf('Cannot get quest %s. (Should not happen.)', $args[1]));
			return false;
		}
		$questname = $quest->getQuestName();
		
		if (count($args) === 2)
		{
			$old = $quest->getOptions();
			$bot->reply(sprintf('Quest %s of %s has status 0x%x (%s).', $questname, $target->getUser()->getName(), $old, SR_Quest::optionsToString($old)));
			return true;
		}

		if (strtolower($args[2]) === 'amount')
		{
			$old = $quest->getAmount();

			if (count($args) === 3)
			{
				$bot->reply(sprintf('Quest %s of %s has amount %d.', $questname, $target->getUser()->getName(), $old));
				return true;
			}

			$new = (int) $args[3];

			$quest->saveAmount($new);
			$bot->reply(sprintf('Set amount of quest %s of %s from %d to %d.', $questname, $target->getUser()->getName(), $old, $new));
			
			return true;
		}

		elseif (strtolower($args[2]) === 'data')
		{
			$old = $quest->getQuestDataBare();

			if (count($args) === 3)
			{
				$msg = sprintf('Quest %s of %s has ', $questname, $target->getUser()->getName());
				if (NULL !== $old)
				{
					$msg .= "has data {$old}.";
				} else {
					# XXX Perhaps show serialisation of getQuestData (array()) in this case?
					$msg .= 'no data.';
				}
				$bot->reply($msg);
				return true;
			}
			
			$new = $args[3];

			if ($new === serialize(false))
			{
				$new = false;
			} elseif (false === ($new = unserialize($new)))
			{
				$bot->reply('Invalid serialized data supplied!');
				return false;
			}

			$quest->saveQuestData($new);
			$new = $quest->getQuestDataBare();
			$bot->reply(sprintf('Set data of quest %s of %s from %s to %s.', $questname, $target->getUser()->getName(), $old, $new));
			
			return true;
		}

		# Not amount or data --> set status

		$old = $quest->getOptions();
		$new = $args[2]*1; # XXX ugly conversion to int (allowing "0x...")

		$quest->saveOption(-1,false); # first clear all bits
		$quest->saveOption($new);
		$bot->reply(sprintf('Set status of quest %s of %s from 0x%x to 0x%x.', $questname, $target->getUser()->getName(), $old, $new));

		return true;
	}
}
?>
