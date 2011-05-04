<?php echo GWF_Button::generic($tLang->lang('btn_checker'), $tVars['href_checker']); ?>
<?php echo GWF_Button::generic($tLang->lang('btn_bundle'), $tVars['href_bundle']); ?>

<?php
$headers = array(
	array($tLang->lang('th_filename')),
	array($tLang->lang('th_count')),
	array($tLang->lang('th_branched')),
	array($tLang->lang('th_filesize')),
);

$counter = array();
$files = $tVars['files'];

foreach ($files as $file)
{
	list($fullpath, $branched, $langfile, $iso, $filename) = $file;
	if (!isset($counter[$fullpath])) {
		$counter[$fullpath] = 1;
	} else {
		$counter[$fullpath]++;
	}
}

$yes = $tLang->lang('yes');
$no = $tLang->lang('no');

echo '<table>';
echo GWF_Table::displayHeaders1($headers, '');
foreach ($files as $file)
{
	list($fullpath, $branched, $langfile, $iso, $filename) = $file;
	if ($iso !== 'en') {
		continue;
	}
	$href = GWF_WEB_ROOT.'index.php?mo=Language&amp;me=EditFiles&amp;filename='.urlencode($fullpath);
	$count = $counter[$fullpath];
	echo GWF_Table::rowStart();
	echo sprintf('<td><a href="%s">%s</a></td>', $href, GWF_HTML::display($fullpath));
	echo sprintf('<td><a href="%s">%d</a></td>', $href, $count);
	echo sprintf('<td><a href="%s">%s</a></td>', $href, $branched ? $yes : $no);
	echo sprintf('<td><a href="%s">%s</a></td>', $href, $langfile->getVar('lf_size'));
	echo GWF_Table::rowEnd();
}
echo '</table>';

?>