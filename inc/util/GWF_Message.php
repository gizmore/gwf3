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
    
    private static $bbSmileyPath = 'img/smile/';
    private static $bbSmileys = array(
    	'=D' => array('002_biggrin.gif', 'Yay'),
    	
    	'o-o' => array('002_sconfused.gif', 'Confused'),
    	'O-O' => array('002_sconfused.gif', 'Confused'),

    	'B)' => array('002_scool.gif', 'Cool'),
    	'B-)' => array('002_scool.gif', 'Cool'),
    	
		":'(" => array('002_scry.gif', 'Cry'),
    	
    	':P' => array('002_sdrool.gif', 'Drool'),
    	':-P' => array('002_sdrool.gif', 'Drool'),
    	':p' => array('002_sdrool.gif', 'Drool'),
    	':-p' => array('002_sdrool.gif', 'Drool'),

    	':D' => array('002_shappy.gif', 'Happy'),
    	':-D' => array('002_shappy.gif', 'Happy'),
    
    	'>:-(' => array('002_smad.gif', 'Mad'),
    	'>:-/' => array('002_smad.gif', 'Mad'),
    	
    	':-(' => array('002_ssad.gif', 'Sad'),
    	':(' => array('002_ssad.gif', 'Sad'),

    	'oO' => array('002_ssleepy.gif', 'Euh'),
    	'o-O' => array('002_ssleepy.gif', 'Euh'),
    	'Oo' => array('002_ssleepy.gif', 'Euh'),
    	'O-o' => array('002_ssleepy.gif', 'Euh'),
    
    	':)' => array('002_ssmile.gif', 'Smile'),
    	':-)' => array('002_ssmile.gif', 'Smile'),
    
    	':O' => array('002_ssuprised.gif', 'Woot'),
    	':-O' => array('002_ssuprised.gif', 'Woot'),
    	':o' => array('002_ssuprised.gif', 'Woot'),
        ':-o' => array('002_ssuprised.gif', 'Woot'),
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
//    	require_once("script/bbreplace.php");
//    	
//    	$userscore = User::isLoggedIn() ? $_SESSION["user"]->getVar("totalscore") : 0;
//    	
//    	$back = '<div class="bb_replace_bar">';
//    	
//    	foreach (self::$bbReplaceNew as $code => $data) {
//    		
//    		$score = $data["score"];
//    		$script = $data["script"];
//    		$alt = $data["help"];
//
//    		if ($script === false) {
//    			continue;
//    		}
//    		
//    		if ($userscore < $score) {
//    			continue;
//    		}
//    		
//    		$onclick = $script == "" ? "" : "onclick=\"return $script\"";
//    		$back .= '<div class="bb_replace">';
//    		$alt = htmlspecialchars($alt);
//    		$back .= "<img src=\"/image/button/bb/$code.png\" alt=\"$alt\" title=\"$alt\" $onclick />";
//    		$back .= "</div>";
//    		
//    	}
//    	
//    	$back .= "</div>\n";
//    	
//    	return $back;
//    	
//    }

//    private static $parser = false;
//    private static function init()
//    {
//    	static $inited = false;
//    	if (!$inited)
//    	{
//			require_once 'inc3p/quickerubb.php';
//			self::$parser = new ubbParser();
//    	}
//    }
    
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
//    	$message = self::wordwrap($message);
    	
    	if (!$allowBB) {
    		$message = sprintf('[noparse]%s[/noparse]', $message);
    	}

		self::init($allowSmiley, $highlight);
		
//    	ubbsetsmileys(self::$bbSmileys, GWF_WEB_ROOT.self::$bbSmileyPath, $allowIMG, $allowSmiley);
    	
//		self::$parser->setHighlight($highlight);
		
		return GWF_BBCode::decode($message);
//		return GWF_BB3::decode($message);
//		return self::$parser->parse($message);
    }
    
    private static function init($allowSmiley, $highlight)
    {
    	GWF_BBCode::initSmileys(self::$bbSmileys, self::$bbSmileyPath, $allowSmiley);
    	GWF_BBCode::initHighlighter($highlight);
//    	GWF_BB3::initSmileys(self::$bbSmileys, self::$bbSmileyPath, $allowSmiley);
//    	GWF_BB3::initHighlighter($highlight);
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
		require_once 'inc3p/quickerubb.php';

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
		
		ubbsetsmileys(self::$bbSmileys, self::$bbSmileyPath, $showimgs, $showsmiley);
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
	
?>
