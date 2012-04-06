<?php
/**
 * Wrapper Method for some tools and stuff.
 * @author gizmore
 */
final class WeChall_Tools extends GWF_Method
{
	public function getHTAccess()
	{
		return
			'RewriteRule ^tools/?$ index.php?mo=WeChall&me=Tools&list=1'.PHP_EOL.
			# Tools
			'RewriteRule ^tools/JPK/?$ index.php?mo=WeChall&me=Tools&file=jpk'.PHP_EOL.
			'RewriteRule ^tools/YaBfDbg/?$ index.php?mo=WeChall&me=Tools&file=yabfdbg'.PHP_EOL.
			'RewriteRule ^tools/JCS/?$ index.php?mo=WeChall&me=Tools&file=jcs'.PHP_EOL.
			'RewriteRule ^tools/JDicTac/?$ index.php?mo=WeChall&me=Tools&file=jdictac'.PHP_EOL.
			'RewriteRule ^tools/Wordpat/?$ index.php?mo=WeChall&me=Tools&file=wordpat'.PHP_EOL.
			# Downloads
			'RewriteRule ^tools/wordlists/?$ index.php?mo=WeChall&me=Tools&file=wordlists'.PHP_EOL.
			'RewriteRule ^tools/wordlists/english.zip$ core/module/WeChall/tpl/default/tools/wordlists/files/english.zip'.PHP_EOL.
			# Tutorials
			'RewriteRule ^tutorials/starting_cpp.php$ index.php?mo=WeChall&me=Tools&file=startcpp'.PHP_EOL.
//			'RewriteRule ^tutorial/encoding_lesson$ index.php?mo=WeChall&me=Tools&file=encodings'.PHP_EOL.
			'';
	}

	public function execute()
	{
		if (Common::getGetString('list', '0') === '1')
		{
			return $this->module->template("tools/list.tpl");
		}
		
		$whitelist = array(
			'jpk', 'yabfdbg', 'jcs', 'jdictac', 'wordpat',
			'wordlists',
			'startcpp', 'encodings',
		);
		$file = Common::getGet('file');
		if (!in_array($file, $whitelist, true)) {
			return GWF_HTML::err('ERR_PARAMETER', array(__FILE__, __LINE__, 'file'));
		}
		
		# Counter Box
		$count = GWF_Counter::getAndCount($file, 1);
		$box = GWF_Box::box($this->module->lang('pi_viewcount', array($count)));
		
		# Translations
		$langpath = $this->module->getDir().'/lang/'.$file;#.'/'.$file;
		$trans = new GWF_LangTrans($langpath);
		GWF_Website::setPageTitle($trans->lang('page_title'));
		GWF_Website::setMetaTags($trans->lang('meta_tags'));
		
		$tVars = array(
			'lang2' => $trans,
		);
		
		
		return $this->module->templatePHP("tools/$file/$file.php", $tVars).$box;
	}
}
?>