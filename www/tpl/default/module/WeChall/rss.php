<?php
/** @var array $tVars */
function wechall_rss_cdata($value)
{
	$value = @iconv('UTF-8', 'UTF-8//IGNORE', (string)$value);
	$value = $value === false ? '' : $value;
	$value = preg_replace('/[^\x09\x0A\x0D\x20-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $value);
	return '<![CDATA['.str_replace(']]>', ']]]]><![CDATA[>', $value === null ? '' : $value).']]>';
}
?>
<rss version="2.0">
	<channel>
		<title>WeChall activity</title>
		<link><?php echo GWF_HTML::display($tVars['web_url']); ?></link>
		<description>WeChall forum posts and news</description>
		<language><?php echo GWF_HTML::display($tVars['language']); ?></language>
		<atom:link xmlns:atom="http://www.w3.org/2005/Atom" href="<?php echo GWF_HTML::display($tVars['feed_url']); ?>" rel="self" type="application/rss+xml" />
<?php foreach ($tVars['items'] as $item) { ?>
		<item>
<?php if ($item['type'] === 'forum') { ?>
			<threadId><?php echo (int)$item['thread_id']; ?></threadId>
			<postId><?php echo (int)$item['post_id']; ?></postId>
			<threadTitle><?php echo wechall_rss_cdata($item['thread_title']); ?></threadTitle>
			<postTitle><?php echo wechall_rss_cdata($item['post_title']); ?></postTitle>
			<title><?php echo wechall_rss_cdata($item['post_title']); ?></title>
<?php } else { ?>
			<newsId><?php echo (int)$item['news_id']; ?></newsId>
			<title><?php echo wechall_rss_cdata($item['title']); ?></title>
<?php } ?>
			<link><?php echo GWF_HTML::display(Common::getAbsoluteURL($item['link'], false)); ?></link>
			<guid isPermaLink="false"><?php echo GWF_HTML::display($item['guid']); ?></guid>
			<author><?php echo wechall_rss_cdata($item['author']); ?></author>
			<description><?php echo wechall_rss_cdata($item['description']); ?></description>
<?php if ($item['pub_date'] !== null) { ?>
			<pubDate><?php echo GWF_HTML::display($item['pub_date']); ?></pubDate>
<?php } ?>
		</item>
<?php } ?>
	</channel>
</rss>
