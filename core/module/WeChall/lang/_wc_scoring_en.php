<?php
$lang = array(
	# Scoring Faq
	'pt_scorefaq' => '[WeChall] Scoring faq',
	'mt_scorefaq' => 'WeChall Scoring FAQ Explained.',
	'scoring_faqt' => 'Scoring on WeChall',
	'scoring_faq' => 
		'This page describes the scoring on WeChall.<br/>'.
		'<br/>'.
		'Currently, each site has a certain score that depends on three factors:<br/>'.
		'<br/>'.
		'1. The base score for the site.<br/>'.
		'2. The number of challenges on that site.<br/>'.
		'3. How well our users do on that site.<br/>'.
		'<br/>'.
		'Example:<br/>'.
		'Electrica\'s base score is 10000 (default value, adjustable by admins).<br/>'.
		'Because it has 44 challenges a score of 25 * 44 = 1100 is added to that to get to 11100.'.
		'On average our users have completed 42%% on that site.<br/>'.
		'The score for that site then becomes base+base-avg*base, or<br/>'.
		'11100 + 11100 - 4662 = 17538 points.<br/>'.
		'So the harder a site is the more points it generates.<br/>'.
		'<br/>'.
		'The score of a site determines how much rankpoints for WeChall you get.<br/>'.
		'<br/>'.
		'Example:<br/>'.
		'Imagine Peter has got 30000 points on HackQuest, from a maximum of 100000 points.<br/>'.
		'This means Peter has solved 30%% on Hackquest.<br/>'.
		'This percentage is adjusted with a formula (p*p/100) that makes higher percentages relatively worth more than lower percentages.<br/>'.
		'So on WeChall he gets 9%% (30*30/100) of the HackQuest sitescore for that.<br/>'.
		'HackQuest currently has a score of 19698, so Peter gets 1773 rankpoints.<br/>'.
		'<br/>'.
		'The admins can manually adjust the base score for sites.<br/>'.
		'It may be possible that a site with less or easier challenges may get a lower score than a site with lots of difficult challs.<br/>'.
		'<br/>'.
		'Don\'t hesitate to ask on the <a href="%1$s">forum</a> if any of this is unclear to you.',
);
?>
