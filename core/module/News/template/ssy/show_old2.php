<?php SSYHTML::$menuID = SSY_MENU_NEWS; ?>
<?php echo SSYHTML::getBoxTitled($tLang->lang('title'), $tLang->lang('info')); ?>
<?php
if (count($tVars['news']) === 0) {
	$tVars['news'] = array(GWF_NEWS::getFakeNews($tLang->lang('title_no_news'), $tLang->lang('msg_no_news')));
}
?>
<span class="t" style="">
<span class="ssy800v_R ssy_st_out3"><span class="ssy_small_softbox">
<?php
echo sprintf('<a href="/newsletter/subscribe">%s</a>', $tLang->lang('btn_sign'));
echo '<span class="b" style="height: 20px;"></span>';
$iso = GWF_Language::getCurrentISO();
foreach ($tVars['titles'] as $id => $d)
{
	$title = $d[0];
	$etitle = Common::urlencodeSEO($d[0]);
	$catid = $d[1];
	$cat = $d[2];#($catid === 0) ? GWF_HTML::lang('no_category') : $d[2];
	$cat = Common::urlencodeSEO($cat);
	$newsid = (int)$d[3];
	$url = sprintf(GWF_WEB_ROOT.'news/%s/%s/%s/%s/%s#newsid_%d', $iso, $catid, $cat, $newsid, $etitle, $newsid);
	echo sprintf('<a href="%s">%s</a>', $url, GWF_HTML::display($title));
}
?>
</span>
	<span class="ssy_st_out3_t ssy800h"><?php echo $tVars['page_menu']; ?></span>
	<span class="ssy800v ssy_st_out2">
		<span class="ssy800v_R ssy_st_out1">
			
			<?php foreach ($tVars['news'] as $news) { $t = $news->getTranslation(); ?>
				<a class="gwf_newsbox_item" href="#newsid_<?php echo $news->getID(); ?>"></a>
				<span class="gwf_newsbox_item">
					<span class="gwf_newsbox_date"><?php echo $news->displayDate(); ?></span>
					<span class="gwf_newsbox_author"><?php echo $news->displayAuthor(); ?></span>
					<span class="gwf_newsbox_title"><?php echo $news->displayTitle(); ?></span>
					<span class="gwf_newsbox_message"><?php echo $news->displayMessage(); ?></span>
				</span>
			<?php } ?>	
		</span>
	</span>
</span>
</span>
