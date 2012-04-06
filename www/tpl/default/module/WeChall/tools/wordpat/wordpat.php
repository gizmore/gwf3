<?php
$external_href = "http://pajhome.org.uk/crypt/wordpat.html";
$wordlist_href = GWF_WEB_ROOT.'tpl/default/module/WeChall/applet/wordlists';
$patterns_href = GWF_WEB_ROOT.'tpl/default/module/WeChall/applet/patterns';
echo GWF_Box::box($tVars['lang2']->lang('page_info', array($external_href, $wordlist_href, $patterns_href)), $tVars['lang2']->lang('page_title'));

if (false !== Common::getPost('wordpat'))
{
	wordpat(wordpatComputePattern(Common::getPost("pattern")));
}

function wordpat($pattern)
{
	if (false === ($pattern = wordpatValidatePattern($pattern))) {
		return htmlDisplayError("Invalid pattern");
	}
	
	if (false === ($matches = wordpatMatch($pattern))) {
		return htmlDisplayError("Internal error");
	}
	
	$numMatches = count($matches);
	
	$title = "$numMatches words matching '$pattern'";
	if ($numMatches == 0) {
		$text = "No Match";
	} else {
		$text = '<table><tr>';
		$i = 0;
		foreach ($matches as $match) {
			$text .= "<td style=\"margin: 1px 6px; padding: 1px 6px;\">$match</td>";
			$text .= (++$i % 5 == 0) ? "</tr><tr>" : "";
		}
		$text .= '</tr></table>';
	}
	
	echo GWF_Box::box($text, $title);
}

function wordpatDigitToDec($digit) {
	
	if ($digit == 0) {
		return (int)(10 + $digit - 'A');
	}
	
	return (int)$digit;
	
}

function wordpatDecToDigit($decimal) {
	
	if ($decimal < 10) {
		return $decimal + '0';
	}
	
	return 'A' + $decimal - 10;

}

function wordpatValidatePattern($pattern) {

	if ($pattern == "") {
		return false;
	}
	
	$pattern = trim(strtoupper($pattern));
	
	if (0 === preg_match("/^[A-P0-9]{2,20}$/D", $pattern)) {
		return htmlDisplayError("Invalid character set");
	}
	
	$found = array();
	$highest = 1;
	
	$len = strlen($pattern);
	
	for ($i = 0; $i < $len; $i++) {
		
		$val = wordpatDigitToDec($pattern[$i]);
		
		if ($val > ($i + 1)) {
			return htmlDisplayError("Higher numbers than strlen");
		}
		
		if ($val > $highest) {
			$highest = $val;
		}
		
	}
	
	if ($pattern == "" || $len < $highest) {
		return htmlDisplayError("Higher numbers than strlen");
	}
	
	for ($i = 1; $i < $highest; $i++) {
		
		$char1 = wordpatDecToDigit($i);
		$char2 = wordpatDecToDigit($i+1);

		if (strpos($pattern, "$char2") < strpos($pattern, "$char1")) {
			return htmlDisplayError("Wrong order. try 123 instead of 321");
		}
		
	}
	
	return $pattern;
	
}

function wordpatMatch($pattern) {
	
	$len = strlen($pattern);
	
	$country = (int) Common::getPost("country", 2);
	$iso = Common::getPost('iso', 'en');
	if (!preg_match('/^[a-z]{2}$/D', $iso)) {
		$iso = 'en';
	}
	
	$filename = GWF_WWW_PATH.'tpl/default/module/WeChall/applet/patterns/'.$iso.'/'.$len.'.wl';
//	$filename = "tools/Wordpat/patterns/$country/$len.wl";
	if (!file_exists($filename)) {
		echo GWF_HTML::err('ERR_FILE_NOT_FOUND', array(GWF_HTML::display($filename)));
		return false;
	}
	
	if (false === ($file = fopen($filename, "r"))) {
		echo GWF_HTML::err('ERR_GENERAL', array(__FILE__, __LINE__));
		return false;
	}
	
	$match = "$len-$pattern";
	$foundit = false;
	$results = array();
	
	while (false !== ($line = fgets($file))) {

		$line = trim($line);

		if ($line == $match) {
			$foundit = true;
		}
		elseif ($line[0]>='0' && $line[0]<='9' && $foundit) {
			break;
		} 
		elseif ($foundit) {
			$results[] = $line;
		}
		
	}
		
	return $results;
	
}

function wordpatComputePattern($string) {
	
	$pattern = "";
	$key = "";
	
	$len = strlen($string);
	
	for ($i = 0; $i < $len; $i++) {
		
		$current = strpos($key, $string[$i]);

		if ($current === false) {
			$key .= $string[$i];
			$current = strlen($key);
		}
		else {
			$current++;
		}
		
		$pattern .= wordpatDecToDigit($current);
		
	}
	
	return $pattern;
	
}

function wordpat_getLangSelect()
{
	$data = array();
	$langs = array('en','fr','de');
	foreach ($langs as $iso)
	{
		if (false === ($lang = GWF_Language::getByISO($iso))) {
			continue;
		}
		$data[] = array($lang->displayName(), $iso);
	}
	return GWF_Select::display('iso', $data, Common::getPost('iso', 'en'));
}

?>
<div>
	<form method="post" action="/tools/Wordpat">
		<div>
			<?php echo wordpat_getLangSelect(); ?>
			<input type="text" name="pattern" value="" />
			<input type="submit" name="wordpat" value="<?php echo $tVars['lang2']->lang('btn_wordpat'); ?>" />
		</div>
	</form>
</div>
