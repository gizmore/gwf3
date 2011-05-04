<rss version="2.0">
	<channel>
		<title><?php echo $tLang->lang('rss_title'); ?></title>
		<link><?php echo $tVars['title_link']; ?></link>
		<description><?php echo $tLang->lang('rss_title'); ?></description>
		<language><?php echo $tVars['language']; ?></language>
		<lastBuildDate><?php echo $tVars['build_date']; ?></lastBuildDate>
		<pubDate><?php echo $tVars['pub_date']; ?></pubDate>
		<image>
			<title><?php echo $tLang->lang('rss_img_title'); ?></title>
			<url><?php echo $tVars['image_url']?></url>
			<link><?php echo $tVars['image_link']?></link>
			<width><?php echo $tVars['image_width']?></width>
			<height><?php echo $tVars['image_height']?></height>
		</image>
<?php foreach ($tVars['items'] as $item) { $item instanceof GWF_News; ?>
		<item>
			<title><![CDATA[<?php echo $item['title']; ?>]]></title>
			<link><?php echo $item['link']; ?></link>
			<description><![CDATA[<?php echo $item['descr']; ?>]]></description>
			<guid><?php echo $item['guid']; ?></guid>
			<pubDate><?php echo $item['pub_date']; ?></pubDate>
		</item>
<?php } ?>
	</channel>
</rss>
