<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<atom:link href="<?php echo htmlspecialchars(Common::getAbsoluteURL($tVars['title_link'], false)); ?>" rel="self" type="application/rss+xml" />
		<title><?php echo GWF_HTML::display($tVars['feed_title']); ?></title>
		<link><?php echo htmlspecialchars(Common::getAbsoluteURL($tVars['title_link'], false)); ?></link>
		<description><?php echo GWF_HTML::display($tVars['feed_description']); ?></description>
		<language><?php echo $tVars['language']; ?></language>
		<lastBuildDate><?php echo $tVars['build_date']; ?></lastBuildDate>
		<pubDate><?php echo $tVars['pub_date']; ?></pubDate>
		<image>
			<title><?php echo GWF_HTML::display($tVars['feed_title']); ?></title>
			<url><?php echo $tVars['image_url']?></url>
			<link><?php echo htmlspecialchars(Common::getAbsoluteURL($tVars['title_link'], false)); ?></link>
			<width><?php echo $tVars['image_width']?></width>
			<height><?php echo $tVars['image_height']?></height>
		</image>
<?php foreach ($tVars['items'] as $item) { $item instanceof GWF_RSSItem; ?>
		<item>
			<title><?php echo GWF_RSS::displayCData($item->getRSSTitle()); ?></title>
<?php if ($link =  $item->getRSSLink()) echo sprintf('<link>%s</link>', GWF_HTML::display(Common::getAbsoluteURL($link, false))).PHP_EOL; ?>
			<description><?php echo GWF_RSS::displayCData($item->getRSSDescription()); ?></description>
<?php if ($guid =  $item->getRSSGUID()) echo sprintf('<guid>%s</guid>', GWF_HTML::display(Common::getAbsoluteURL($guid, false))).PHP_EOL; ?>
			<pubDate><?php echo GWF_RSS::displayDate($item->getRSSPubDate()); ?></pubDate>
		</item>
<?php } ?>
	</channel>
</rss>
