<?php
/**
 * Combined public WeChall activity feed.
 *
 * Forum posts are deliberately included even when a guest may not read them.
 * Such entries are redacted except for stable thread/post IDs and publication time.
 */
final class WeChall_RSS extends GWF_Method
{
	public function getHTAccess()
	{
		return 'RewriteRule ^wechall/feed/?$ index.php?mo=WeChall&me=RSS'.PHP_EOL;
	}

	public function execute()
	{
		GWF3::setConfig('store_last_url', false);
		header('Content-Type: application/rss+xml; charset=UTF-8');
		header('Content-Disposition: attachment; filename="wechall-feed.rss"');

		$tVars = array(
			'items' => $this->getItems(),
			'feed_url' => Common::getAbsoluteURL(GWF_WEB_ROOT.'wechall/feed', false),
			'web_url' => Common::getAbsoluteURL(GWF_WEB_ROOT, false),
			'language' => GWF_Language::getCurrentISO(),
		);

		echo '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL;
		echo $this->module->templatePHP('rss.php', $tVars);
		die();
	}

	/**
	 * @return array[] newest first
	 */
	private function getItems()
	{
		$items = array_merge($this->getForumItems(), $this->getNewsItems());
		usort($items, function(array $a, array $b) {
			return strcmp($b['sort_date'], $a['sort_date']);
		});
		return array_slice($items, 0, 20);
	}

	/**
	 * Keep every forum post in the feed. Restricted posts get a redacted item
	 * rather than being silently omitted, so clients can retain stable history.
	 */
	private function getForumItems()
	{
		$items = array();
		GWF_Module::loadModuleDB('Forum', true);
		$posts = GDO::table('GWF_ForumPost')->selectObjects('*', '1', 'post_date DESC');
		foreach ($posts as $post)
		{
			$post instanceof GWF_ForumPost;
			$thread = $post->getThread();
			$public = $this->isPublicForumPost($post, $thread);
			$threadID = $post->getThreadID();
			$postID = $post->getID();

			$items[] = array(
				'type' => 'forum',
				'thread_id' => $threadID,
				'post_id' => $postID,
				'guid' => "forum-thread-{$threadID}-post-{$postID}",
				'link' => $public ? $thread->getPostHREF($post) : GWF_WEB_ROOT."forum-t{$threadID}/unknown.html#post{$postID}",
				'thread_title' => $public ? $thread->getVar('thread_title') : 'Unknown',
				'post_title' => $public ? $post->getVar('post_title') : 'Unknown',
				'author' => $public ? $post->getPosterName() : 'Unknown',
				'description' => $public ? $post->getMessage() : 'Unknown',
				// Publication time is not sensitive and lets feed readers retain chronology.
				'pub_date' => GWF_Time::rssDate($post->getDate()),
				'sort_date' => $post->getDate(),
			);
		}
		return $items;
	}

	private function isPublicForumPost(GWF_ForumPost $post, $thread)
	{
		return ($thread !== false) &&
			($post->getGroupID() === '0') &&
			$post->isOptionEnabled(GWF_ForumPost::GUEST_VIEW) &&
			!$post->isInModeration() &&
			!$post->isDeleted() &&
			($thread->getGroupID() === '0') &&
			$thread->isGuestView() &&
			!$thread->isInModeration() &&
			!$thread->isDeleted();
	}

	private function getNewsItems()
	{
		$items = array();
		GWF_Module::loadModuleDB('News', true);
		$lang = GWF_Language::getCurrentLanguage();
		$news = GWF_News::getNews(0, 0, 1, 'news_date DESC', false);
		foreach ($news as $item)
		{
			$item instanceof GWF_News;
			$items[] = array(
				'type' => 'news',
				'news_id' => $item->getID(),
				'guid' => 'news-'.$item->getID(),
				'link' => $item->hrefShow($lang),
				'title' => $item->getTitle(),
				'author' => $item->displayAuthor(),
				'description' => $item->getMessage(),
				'pub_date' => $item->rssDate(),
				'sort_date' => $item->getDate(),
			);
		}
		return $items;
	}
}
