<?php

/**
 * Send the user to google translate with a post as content and browser lang as target language.
 * The source language is set to auto.
 * @author gizmore
 */
final class Forum_GTrans extends GWF_Method
{
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^forum/google/translate/post/([0-9]+)$ index.php?mo=Forum&me=GTrans&pid=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		return $this->gTranslate($module);
	}
	
	private function gTranslate(Module_Forum $module)
	{
		if (false === ($post = $module->getCurrentPost())) {
			return $module->error('err_post');
		}
		if (false === ($thread = $post->getThread())) {
			return $module->error('err_post');
		}
		if (false === ($thread->hasPermission(GWF_Session::getUser()))) {
			return $module->error('err_post_perm');
		}

		$text = $post->displayTitle().PHP_EOL.PHP_EOL.$post->displayMessage();
		$text = preg_replace('/<[^>]+>/', '', $text);
		$text = str_replace('|', '-', $text);
		$text = urlencode($text);
		
		$browser_lang = GWF_Language::getCurrentISO();
		
		$url = 'http://translate.google.com/translate_t#auto|'.$browser_lang.'|'.$text;
		header('Location: '.$url);
	}
	
}

?>
