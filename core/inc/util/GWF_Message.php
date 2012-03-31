<?php
/* @Copyright(c) 2008,2009 under the WeChall Public License in license.php.
 * @Author(s): Gizmore
 * @Description: Message methods, Using quickerubb.php 
*/
class GWF_Message {

	/*
	 * BB Replacements
	 */
	private static $bbReplaceNew = array(

		'b' => array(
			'score' => 0,
			'help' => '[b]<b>bold</b>[/b]',
			'script' => 'bbInsert(\'[b]\', \'[/b]\')',
		),

		'i' => array(
			'score' => 0,
			'help' => '[i]<em>italic</em>[/i]',
			'script' => 'bbInsert(\'[i]\', \'[/i]\')',
		),

		'u' => array(
			'score' => 0,
			'help' => '[u]<u>underlined</u>[/u]',
			'script' => "bbInsert('[u]', '[/u]')",
		),

		'code' => array(
			'score' => 0,
			'help' => '[code=lang]Mark text as code[/code]',
			'script' => "bbInsert('[code]', '[/code]')",
		),

		'quote' => array(
			'score' => 0,
			'help' => '[quote=username]quote someone[/quote]',
			'script' => "bbInsert('[quote=Unknown]', '[/quote]')",
		),

		'url' => array(
			"score" => 0,
			"help" => "[url=url]link_text[/url] or [url]url[/url]",
			"script" => "bbInsert('[url=http://]', '[/url]')",
		),

		"email" => array(
			"score" => 0,
			"help" => "[email=email@url]link_text[/email] or [email]email[/email]",
			"script" => "bbInsert('[email]', '[/email]')",
		),

		"noparse" => array(
			"score" => 0,
			"help" => "[noparse]disable bb-decoding[/noparse]",
			"script" => "bbInsert('[noparse]', '[/noparse]')",
		),
  	
		'spoiler' => array(
			'score' => 0,
			'help' => '[spoiler]Invisible text that is shown with a click[/spoiler]',
			"script" => "bbInsert('[spoiler]', '[/spoiler]')",
		),
	);

	private static $bbSmileyPath;
	public static function bbSmileyPath()
	{
		if(!isset(self::$bbSmileyPath))
		{
			$path = sprintf('img/%s/smile/', GWF_ICON_SET);
			if(is_dir(GWF_WWW_PATH.$path))
			{
				self::$bbSmileyPath = $path;
			}
			else
			{
				self::$bbSmileyPath = 'img/default/smile/';
			}
		}
		return self::$bbSmileyPath;
	}

	private static $bbSmileys = array(
		'=D' => array('biggrin.png', 'Yay'),

		'o-o' => array('sconfused.png', 'Confused'),
		'O-O' => array('sconfused.png', 'Confused'),

		'B)' => array('scool.png', 'Cool'),
		'B-)' => array('scool.png', 'Cool'),

		":'(" => array('scry.png', 'Cry'),

		':P' => array('sdrool.png', 'Drool'),
		':-P' => array('sdrool.png', 'Drool'),
		':p' => array('sdrool.png', 'Drool'),
		':-p' => array('sdrool.png', 'Drool'),

		':D' => array('shappy.png', 'Happy'),
		':-D' => array('shappy.png', 'Happy'),

		'>:-(' => array('smad.png', 'Mad'),
		'>:-/' => array('smad.png', 'Mad'),

		':-(' => array('ssad.png', 'Sad'),
		':(' => array('ssad.png', 'Sad'),

		'oO' => array('ssleepy.png', 'Euh'),
		'o-O' => array('ssleepy.png', 'Euh'),
		'Oo' => array('ssleepy.png', 'Euh'),
		'O-o' => array('ssleepy.png', 'Euh'),

		':)' => array('ssmile.png', 'Smile'),
		':-)' => array('ssmile.png', 'Smile'),

		':O' => array('ssuprised.png', 'Woot'),
		':-O' => array('ssuprised.png', 'Woot'),
		':o' => array('ssuprised.png', 'Woot'),
		':-o' => array('ssuprised.png', 'Woot'),
	);

	#----- end of static -----#

	private $message;

	/**
	 * constructor
	 * @param: string message
	 */
	public function __construct($message)
	{
		$this->message = $message;
	}

	/**
	 * return a form input field, containing the message + the editing bar
	*/
//	public function getFormInputB($fieldname="message", $textAreaClass="") {
//		
//		$class = $textAreaClass == "" ? "" : "class=\"$textAreaClass\"";
//		
//		$back = self::getBBReplaceBar();
//		
//		$back .= '<div class="message_input">';
//		$back .= '<textarea '.$class.' name="'.$fieldname.'" id="bb_message" rows="20" cols="20">';
//		$back .= $this->message;
//		$back .= '</textarea>';
//		$back .= '</div>';
//		$back .= "\n";
//		
//		return $back;
//		
//	}

	/*
	 * Get a replacement javascript bar, to aid in editing
	 */
//	public function getBBReplaceBar() {
//		
//		require_once("script/bbreplace.php");
//		
//		$userscore = User::isLoggedIn() ? $_SESSION["user"]->getVar("totalscore") : 0;
//		
//		$back = '<div class="bb_replace_bar">';
//		
//		foreach (self::$bbReplaceNew as $code => $data) {
//
//			$score = $data["score"];
//			$script = $data["script"];
//			$alt = $data["help"];
//
//			if ($script === false) {
//				continue;
//			}
//
//			if ($userscore < $score) {
//				continue;
//			}
//
//			$onclick = $script == "" ? "" : "onclick=\"return $script\"";
//			$back .= '<div class="bb_replace">';
//			$alt = htmlspecialchars($alt);
//			$back .= "<img src=\"/image/button/bb/$code.png\" alt=\"$alt\" title=\"$alt\" $onclick />";
//			$back .= "</div>";
//
//		}
//		
//		$back .= "</div>\n";
//		
//		return $back;
//		
//	}

//	private static $parser = false;
//	private static function init()
//	{
//		static $inited = false;
//		if (!$inited)
//		{
//			require_once 'core/inc/3p/quickerubb.php';
//			self::$parser = new ubbParser();
//		}
//	}

	/**
	 * Display a message bb decoded.
	 * @param string $message the message
	 * @param boolean $allowBB allow bbcode
	 * @param boolean $allowSmiley allow smileys
	 * @param boolean $allowIMG allow external img
	 * @param array $highlight highlight strings
	 * @return string html
	 */
	public static function display($message, $allowBB=true, $allowSmiley=true, $allowIMG=false, array $highlight=array())
	{
//		$message = self::wordwrap($message);

		if (!$allowBB) {
			$message = sprintf('[noparse]%s[/noparse]', $message);
		}

		self::init($allowSmiley, $highlight);

//		ubbsetsmileys(self::$bbSmileys, GWF_WEB_ROOT.self::bbSmileyPath(), $allowIMG, $allowSmiley);

//		self::$parser->setHighlight($highlight);

		return GWF_BBCode::decode($message);
//		return GWF_BB3::decode($message);
//		return self::$parser->parse($message);
	}

	private static function init($allowSmiley, $highlight)
	{
		GWF_BBCode::initSmileys(self::$bbSmileys, self::bbSmileyPath(), $allowSmiley);
		GWF_BBCode::initHighlighter($highlight);
//		GWF_BB3::initSmileys(self::$bbSmileys, self::bbSmileyPath(), $allowSmiley);
//		GWF_BB3::initHighlighter($highlight);
	}

	private static function wordwrap($string, $maxlen=72, $break="\n")
	{
		return preg_replace('#(\S{'.$maxlen.',})#e', "chunk_split('$1', ".$maxlen.", '".$break."')", $string); 
	}

	/**
	 * return the message bb-replaced.
	 * the user is the poster, and thus different replacements can be taken for different skilled users.
	 */
/*	public function bbReplace($posterid, $defaultScore=false)
	{
		require_once 'core/inc/3p/quickerubb.php';

		if ($defaultScore !== false) {
			$score = $defaultScore;
		}
		elseif (false === ($poster = UserTable::singleton()->getRow($posterid))) {
			$score = 0;
			$username = 'Unknown';
		}
		else {
			$score = intval($poster->getVar('totalscore'));
			$username = $poster->getVar('username');
		}
		$parser = new ubbParser();
		$parser->setUsername('test');
		$parser->setScores($this->getScoresForNewBB(), $score);

		if (false === ($user = Session::get('user')))
		{
			$showimgs = false;
			$showsmiley = true;
		}
		else
		{
			$showimgs = $user->isOptionEnabled(USER_OPTION_SHOW_IMAGES);
			$showsmiley = $user->isOptionEnabled(USER_OPTION_SHOW_SMILEYS);
		}

		ubbsetsmileys(self::$bbSmileys, self::bbSmileyPath(), $showimgs, $showsmiley);
		#echo $this->message;

		return '<div class="quickerubb">'.$parser->parse($this->message).'</div>';
	}*/

	private function getScoresForNewBB()
	{
		$back = array();
		foreach (self::$bbReplaceNew as $tag => $data)
		{
			$back[$tag] = $data['score'];
		}
		return $back;
	}

	public static function getQuickSearchHighlights($term)
	{
		if (!is_string($term)) {
			$term = '';
		}
		$term = trim(str_replace(array(',', '+'), ' ', $term));
		return preg_split('/ +/', $term);
	}

	public static function getCodeBar($key)
	{
		$tVars = array(
			'key' => $key,
		);
		return GWF_Template::templateMain('bb_codebar.tpl', $tVars);
	}
}


