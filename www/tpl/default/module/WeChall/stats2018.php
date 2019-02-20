<?php
$year0 = 2008;
$yearNow = (int)date('Y');
$years = array(); for ($year = $year0; $year <= $yearNow; $year++) $years[] = $year;
$monthNames = array('UNK', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
$userT = GDO::table('GWF_User');
$shistT = GDO::table('WC_HistorySite');
$histT = GDO::table('WC_HistoryUser2');
$blokT = GDO::table('WC_SolutionBlock');
$soluT = GDO::table('WC_ChallSolved');
$siteT = GDO::table('WC_Site');

set_time_limit(0);

/**
 * @var GWF_User[] $leets
 */
$leets = array();
$result = $userT->select('*', 'user_level>999 AND ((user_options&3)=0)'); # AND user_lastactivity>'.(time()-60*60*24*365));

while ($row = $userT->fetch($result, GDO::ARRAY_O))
{
	$row instanceof GWF_User;
	$leets[$row->getID()] = $row;
}



?>
0) Intro
I am very happy to announce.
WeChall turns 10 years old.

Actually, February the 12th was, when wechall went live, according to [url http://web.archive.org/web/20080226060728/http://www.wechall.net:80/]archive.org[/url]
But we failed.

@rhican read the source, yes – we were open source since day0, and he found a way to hack us.
He registered as @Inferno and got admin, because of the nickname, and deleted all 10 users.

A few days later, on February the 18th 2008, wechall went live; again.

There was only one other breach after that one.
It happened when i exposed the wechall dev site to a friend. He got access to gwf3/protected folder, downloaded the whole db and promised to delete the backup.

Around 2010; Kender did a nice birthday post with statistics. I will do the same here.
But, before we come to the statistics, i wanna recall some other events.

There surely was the event when 10 sites had joined wechall and we became kinda network.
It all happened so fast :)

I also remember when a famous scene magazine asked for advertised news on wechall; I refused the request.

I also remember when i asked project euler to join wechall.
My mistake was to ask in the public forums, and so euler did never consider to join? :(
Anyway.... [SPOJ], a similar site joined a few months afterwards.

One funny story to recall is when korean sites started to join... And it felt great to be accepted as a website in the asian market.
I was excited, and pondered about the countryflags.... The democratic Republic of Korea had not the white and red country flag i think it should have.
I swapped the flags of North- and South Korea, thinking democratic was the south...
It took exactly 10 minutes until i got a mail because of my error.
Quickly i changed back the flags, and learned that the south is not labeled democratic, but the north is! :)

Another topic i remember is psychosis.
Myself got crazy the first time in 2002, long before we did wechall.
It took years to recover from only sitting in the kitchen, drinking beer, and solving sudokus.
Around 2015, i got another psychosis, and got into hospital.
Around the same time, the wechall server was closed down because of "baim is a virus".
We had like 2 weeks downtime, until i purchased a phonecard with internet.
Armed with a crappy S3Mini Android and juicyssh, i was able to reactivate everything, while still in hospital.
Another guy who got psychosis was @vbms.... he had proof the BND is watching him and manipulating him with brainwaves.
I think psychosis can easily happen to a challenger :)
Not funny? ;)

A big change also was when dloser became the de-facto sys-admin for wechall around 2016.
He has root on all wechall boxes since then and really kept wechall and our challenges alive.
Performance should be alright on all machines, and i hope there was no legit IP ban since then.
A big big thanks to you, @dloser!

Before i forget... i also started a donation campaign a few months ago, which turned out successful.
Thanks to all who support us!

gizmore

<hr/>
Now lets come to the stats....
which are postponed to Feb,18th.

<hr/>
0) How many users you get a month?
A) I counted the users who joined and are still active.

<?php
// echo "<p>Grouped by month, we sum the users who are still active today.<br/>Active means a last_activity since 3 months.<br/>Only users with score>0 are counted. Also the botflag is checked.</p>\n";
// echo "<table>\n";
// echo "<thead><tr><th>Month</th><th>Year</th><th>Still active users.</th></tr></thead>\n";
// $totalActiveUsers = 0;
// for ($year = $year0; $year <= $yearNow; $year++)
// {
// 	for ($month = 1; $month <= 12; $month++)
// 	{
// 		$usersPerMonth = 0;
// 		$test = sprintf('%04d%02d', $year, $month);
// 		$cut = time() - (24*60*60*92);
// 		$usersPerMonth = $userT->selectVar('COUNT(*)', "user_regdate LIKE '$test%' AND user_lastactivity > $cut AND ((user_options&3)=0) AND user_level>0");
// 		$totalActiveUsers += $usersPerMonth;
// 		printf("<tr><td>%s</td><td>%d</td><td><b>%d</b></td>\n", $monthNames[$month], $year, $usersPerMonth);
// 	}
// }
// echo "</table>\n";
// echo "<p>This gives us a total of around $totalActiveUsers total active users currently... maybe subtract 300 for those who will quit soon?</p>\n";
?>

<hr/>
1) Which was the korean site(s) that joined with the largest userbase?

Webhacking.kr

<hr/>

<hr/>
2) Which users did the most work / gained the most points (no score from linking) (bymonth)
<?php
// foreach ($years as $year)
// {
// 	foreach ($months as $month)
// 	{
// 		printf(PHP_EOL.'<table><thead>');
// 		printf('<tr><th>%s %s</th></tr>', $year, $monthNames[$month]);
// 		printf('<tr><th>User</th><th>Scoregain</th></tr>', $year, $monthNames[$month]);
// 		printf('</thead><tbody>');
// 		$top10 = array();
// // 		foreach ($leets as $user)
// 		{
// 			$date = sprintf("%04d%02d", $year, $month);
// 			$cut = GWF_Time::getTimestamp($date);
// 			$cut2 = $cut + 60*60*24*30;
// 			$gainPoints = $histT->selectArrayMap(
// 					'userhist_uid, userhist_uid, SUM(userhist_gain_score) topgain',
// 					"userhist_type='gain' AND userhist_date BETWEEN $cut AND $cut2",
// 					"topgain DESC",
// 					null,
// 					GDO::ARRAY_A,
// 					5,
// 					-1,
// 					null,
// 					'userhist_uid'
// 					);
// // 			$top10[] = array($gainPoints, $user);
// 			$top10  = $gainPoints;
// 		}
// 		uasort($top10, function($a, $b){
// 			return $b['topgain'] - $a['topgain'];
// 		});
// 		$rank = 1;
// 		foreach ($top10 as $uid => $data)
// 		{
// 			if ($rank > 10) break;
// 			$leet = isset($leets[$uid]) ? $leets[$uid]->displayProfileLink() : 'unknown';
// 			printf('<tr><td>%s</td><td>%s</td></tr>', $leet, $data['topgain']);
// 		}
// 		printf('</tbody></table>');
// 	}
// }
// ?>


<hr/>
3) How many valid/invalid solutions have been entered? (group by month)
<?php
// $solutions = array();

// foreach ($years as $year)
// {
// 	foreach ($months as $month)
// 	{
// 		$key = $year . " " . $monthNames[$month];
// 		$solutions[$key] = array('fail'=>0, 'success'=>0);
// 	}
// }

// $result = $blokT->select('*');
// while ($row = $blokT->fetch($result, GDO::ARRAY_O))
// {
// 	$time = $row->getVar('wcsb_time');
// 	$year = date('Y', $time);
// 	$month = intval(date('m', $time), 10);
// 	$key = $year . " " . $monthNames[$month];
// 	$solutions[$key]['fail']++;
// }
// $blokT->free($result);
// $result = $soluT->select('*', "csolve_date IS NOT NULL");
// while ($row = $soluT->fetch($result, GDO::ARRAY_O))
// {
// 	$date = $row->getVar('csolve_date');
// 	$time = GWF_Time::getTimestamp($date);
// 	$year = date('Y', $time);
// 	$month = intval(date('m', $time), 10);
// 	$key = $year . " " . $monthNames[$month];
// 	if (isset($solutions[$key]))
// 	{
// 		$solutions[$key]['success']++;
// 	}
// }
// $soluT->free($result);
// foreach ($solutions as $key => $data)
// {
// 	printf("%s: %s fail vs. %s success<br/>\n", $key, $data['fail'], $data['success']);
// }
?>

<hr/>
6) User with most failed solutions
<?php
// $result = $blokT->select('COUNT(*) AS count, wcsb_uid', 'wcsb_uid>0', 'count desc', NULL, -1, -1, 'wcsb_uid');
// $rank = 1;
// while ($row = $blokT->fetch($result, GDO::ARRAY_N))
// {
// 	if (isset($leets[$row[1]]))
// 	{
// 		printf("Rank %s: %s (%s)", $rank++, $leets[$row[1]]->displayUsername(), $row[0]);
// 	}
	
// 	if ($rank > 10)
// 	{
// 		break;
// 	}
// }
// $blokT->free($result);
?>
<hr/>
0) How many users are still active (1 month instead of 24h)
<?php
// $cut = time() - (24*24*60 * 30);
// $count = $userT->selectVar('COUNT(*)', "user_lastactivity>$cut");
// echo "$count<br/>\n";
?>
<hr/>
0) Best IRC Channel

Well that's easy... there is #wargames on ircs://irc.overthewire.org:6697/ and
ircs://irc.root-me.org:6697/#root-me which is french mostly, but a lot of users indicate english is fine as well.

<hr/>

0) Best newcomer site (users per month) (what is a newcomer site?)
A newcomer site is a site that joined with a usercount below 500.
Just lets break it down on user gain per month for all newcomer sites...
<?php
printf('<table><thead>');
printf('<tr><th>Users then<th colspan="2">Joindate</th><th>Site</th><th>Total users now</th><th>Users per month</th></tr></thead>');
$result= $siteT->select('*', 'site_status IN ("up","down")', 'site_joindate ASC');
$newcomers = [];
$allSites = [];
while ($site = $siteT->fetch($result, GDO::ARRAY_O))
{
	$site instanceof WC_Site;
	$allSites[$site->getID()] = $site;
	$beginUsers = $shistT->selectVar('MIN(sitehist_usercount)', "sitehist_sid={$site->getID()} AND sitehist_usercount>0");
	$site->setVar('minUsers', $beginUsers);
	if ($beginUsers < 500)
	{
		$newcomers[$site->getID()] = $site;
	}
}
$newcomerdata = [];
foreach ($newcomers as $newcomer)
{
	$newcomer instanceof WC_Site;
	$sid = $newcomer->getID();
	$newcomerdata[$sid]['avgusers'] = [];
	$newcomerdata[$sid]['avgchalls'] = [];
	foreach ($years as $year)
	{
		foreach ($months as $month)
		{
			$key = $year . $monthNames[$month];
			$time = mktime(0,0,0,$month,1,$year);
			$result = $shistT->select('sitehist_usercount, sitehist_challcount', "sitehist_sid={$newcomer->getID()} AND sitehist_date<$time", 'sitehist_date DESC');
			$row = $shistT->fetch($result, GDO::ARRAY_N);
			$shistT->free($result);
			$newcomerdata[$sid][$key] = $row;
			list($lastusers, $lastchalls) = @$newcomerdata[$sid][$lastkey];
			$newcomerdata[$sid]['avgusers'][] = $row[0] - $lastusers;
			$newcomerdata[$sid]['avgchalls'][] = $row[1] - $lastchalls;
			$lastkey = $key;
		}
	}
}
foreach ($newcomerdata as $sid => $data)
{
	foreach ($data['avgusers'] as $k => $v)
	{
		if ($v == 0)
		{
			unset($data['avgusers'][$k]);
		}
	}
	$avg = $data['avgusers'];
	$discard = array_shift($avg);
	$ends = array_pop($avg);
	if (count($avg))
	{
		$newcomerdata[$sid]['avgusers'] = round(array_sum($avg) / count($avg), 2);
	}
	else
	{
		$newcomerdata[$sid]['avgusers'] = 0;
	}
	
	foreach ($data['avgchalls'] as $k => $v)
	{
		if ($v == 0)
		{
			unset($data['avgchalls'][$k]);
		}
	}
	$avg = $data['avgchalls'];
	$discard = array_shift($avg);
	$ends = array_pop($avg);
	if (count($avg))
	{
		$newcomerdata[$sid]['avgchalls'] = array_sum($avg) / count($avg);
	}
	else
	{
		$newcomerdata[$sid]['avgchalls'] = 0;
	}
}
uasort($newcomerdata, function($a, $b){
	return $b['avgusers'] - $a['avgusers'];
});
foreach ($newcomerdata as $sid => $data)
{
	$site = $allSites[$sid];
	$joindate = $site->getVar('site_joindate');
	$joinyear = substr($joindate, 0, 4);
	$joinmonth = intval(substr($joindate, 4, 2), 10);
	printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%.02f</td><td>%d</td></tr>\n",
			$site->getVar('minUsers'), $joinyear, $monthNames[$joinmonth], $site->displayLink(), $data['avgusers'], $site->getUsercount());
// 	echo "{$site->displayName()} ({$data['avgusers']} users per month) ({$site->getUsercount()} users)<br/>";
}

uasort($newcomerdata, function($a, $b){
	return $b['avgchalls'] - $a['avgchalls'];
});
	
foreach ($newcomerdata as $sid => $data)
{
	$site = $allSites[$sid];
// 	echo "{$site->displayName()} ({$data['avgchalls']} challs per month) ({$site->getChallcount()} challs)<br/>";
}
printf('</table>');
?>





<hr/>
4) How many PM did the people sent? (anonymized a bit)


<hr/>
5) How many forum posts per month?

