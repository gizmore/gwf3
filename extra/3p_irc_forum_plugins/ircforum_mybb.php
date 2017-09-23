<?php
# Validate Args
header('Content-Type: text/plain; charset=UTF-8');
header('Cache-Control: no-cache, no-store, must-revalidate, pre-check=0, post-check=0, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
$con = mysql_connect("localhost", "username", "password");
mysql_select_db("database", $con);
if (!isset($_GET['datestamp']) || !isset($_GET['limit'])) {
	die('Error: Missing arg datestamp or limit.');
}
$limit = (int) $_GET['limit'];
if ($limit > 10 || $limit < 1) {
	die('Error: Limit has to be between 1 and 10.');
}
$date = getd(14, $_GET['datestamp']);

if ( (!isset($_GET['datestamp'])) || (!is_string($_GET['datestamp'])) )
{
    die('Error: Missing string get paramter: datestamp in format YYYYmmddHHiiss.');
}
 
if (!($date = getTimestamp($_GET['datestamp'])))
{
    die('Error: Invalid get paramter: datestamp in format YYYYmmddHHiiss.');
}

# Query the threads.
# You might need to convert datestamp into unix timestamp.
#$time = strtotime(sprintf('%s-%s-%s %s:%s:%s', $y, $m, $d, $h, $i, $s));
$query = "SELECT t.tid, t.subject, t.fid, p.pid, p.username, p.dateline FROM mybb_threads t LEFT JOIN mybb_posts p ON t.tid = p.tid WHERE p.dateline >= '$date' ORDER BY p.dateline DESC LIMIT $limit";
if (false === ($result = mysql_query($query))) {
	die('Database error 1' . mysql_error());
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

	echo $row['tid'];
	echo '::';
	echo getd(14, $row['dateline']);
	echo '::';
        echo $row['fid'];
        echo '::';
	echo escape_csv_like("http://elitesforum.cu.cc/showthread.php?tid=" . $row['tid'] . "&pid=" . $row['pid'] . "#pid" . $row['pid']); # Get url and censor, if desired.
	echo '::';
	echo escape_csv_like($row['username']); # Get nickname and censor if desired.
	echo '::';
	echo escape_csv_like($row['subject']); # Print thread title, censored if desired.
	echo "\n";
}


function escape_csv_like($string)
{
	return str_replace(array(':', "\n"), array('\\:', "\\\n"), $string);
}

function getTimestamp($gwf_date)
{
    if (0 === preg_match('/^(\d{4})?(\d{2})?(\d{2})?(\d{2})?(\d{2})?(\d{2})?$/D', $gwf_date, $matches)) {
        return false;
    }
    return mktime(
        isset($matches[4]) ? intval($matches[4], 10) : 0,
        isset($matches[5]) ? intval($matches[5], 10) : 0,
        isset($matches[6]) ? intval($matches[6], 10) : 0,
        isset($matches[2]) ? intval($matches[2], 10) : 0,
        isset($matches[3]) ? intval($matches[3], 10) : 0,
        isset($matches[1]) ? intval($matches[1], 10) : 0
    );
}

function getd($len=14, $time=NULL)
{
    if ($time === NULL)
    	$time = time();
    
    $dates = array(4=>'Y',6=>'Ym',8=>'Ymd',10=>'YmdH',12=>'YmdHi',14=>'YmdHis', 17=>'YmdHis000');
    return date($dates[$len], $time);
}
