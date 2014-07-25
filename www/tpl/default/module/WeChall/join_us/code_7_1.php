<?php
# Validate Args
if (!isset($_GET['datestamp']) || !isset($_GET['limit'])) {
	die('Error: Missing arg datestamp or limit.');
}
$limit = (int) $_GET['limit'];
if ($limit > 10 || $limit < 1) {
	die('Error: Limit has to be between 1 and 10.');
}
$date = $_GET['datestamp'];
$date = mysql_real_escape_string($date);
if (strlen($date) !== 14) {
	die('Error: datestamp has to be 14 chars long.');
}

# Query the threads.
# You might need to convert datestamp into unix timestamp.
#$time = strtotime(sprintf('%s-%s-%s %s:%s:%s', $y, $m, $d, $h, $i, $s));
$query = "SELECT * FROM threads WHERE thread_lastpostdate >= '$date' ORDER BY thread_lastpostdate DESC";
if (false === ($result = mysql_query($query))) {
	die('Database error 1');
}

# Fetch all rows
$threads = array();
while (false !== ($row = mysql_fetch_assoc($result)))
{
	$threads[] = $row;
}
mysql_free_result($result);

# Reverse the order
$threads = array_reverse($threads);

# Output the data
# Format: threadid::datestamp::groupid::url::nickname::threadname
foreach ($threads as $row)
{
	$censor = $row['groupid'] > 0;
	
	echo $row['threadid'];
	echo '::';
	echo $row['datestamp'];
	echo '::';
	echo $row['boardid'];
	echo '::';
	echo escape_csv_like(forum_push_get_url($row, $censor)); # Get url and censor, if desired.
	echo '::';
	echo escape_csv_like(forum_push_nickname($row, $censor)); # Get nickname and censor if desired.
	echo '::';
	echo escape_csv_like(forum_push_threadname($row, $censor)); # Print thread title, censored if desired.
	echo "\n";
}

function escape_csv_like($string)
{
	return str_replace(array(':', "\n"), array('\\:', "\\\n"), $string);
}
