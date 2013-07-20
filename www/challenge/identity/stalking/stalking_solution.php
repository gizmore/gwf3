<?php
require 'stalking.gizmore.php.inc';
# CompanyName,FirstNameOfAnyCoworker,NameOfLittleBrother,NameOfRealLove,FavoriteBand
function stalking_check_answer(WC_Challenge $chall, $answer)
{
	$answer = mb_strtolower($answer); // To Lower
	$answer = str_replace(' ', '', $answer); // No Spaces
	$sections = explode(',', $answer);
	$sc = count($sections);
	if ($sc !== 5)
	{
		return $chall->lang('err_sections', array($sc));
	}
	
	list($company, $coworker, $brother, $love, $band) = $sections;
	
	if (stalking_company($company) && stalking_coworker($coworker) && stalking_brother($brother) && stalking_love($love) && stalking_band($band))
	{
		return false;
	}
	else
	{
		return $chall->lang('err_wrong');
	}
}