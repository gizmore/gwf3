<?php
chdir("../../");
define('GWF_PAGE_TITLE', 'Trivia');
require_once("html_head.php");
/*
 * Session usage: 
 */
//$_ZESSION["trivia_question"]; Question number 
//$_ZESSION["trivia_question_hashes"]; Already answered questions 
//$_ZESSION["trivia_solution"];
//$_ZESSION["trivia_timeout"]; 
/*
 * config
 */
define("TRIVIA_NUM_QUESTIONS", 8);
define("TRIVIA_MIN_TIMOUT", 25);
define("TRIVIA_TIMOUT_ADD", 5);
define("TRIVIA_GAP_CHAR", "*");
define("TRIVIA_CHEATCODE", "TheCrystalBallIsYours");
define("TRIVIA_NO_HINT", "-?-");
/*
 * Show header
 */
if (false === ($chall = WC_Challenge::getByTitle("Trivia"))) {
	$chall = WC_Challenge::dummyChallenge("Trivia", 4, '', false);
}
$chall->showHeader();

/*
 * Prepare Session
 */
Trivia::init();

/*
 * Check solution
 */
switch (Common::getPost("cmd")) {
	case "Answer": 
		if (false === (Trivia::checkAnswer($chall, Common::getPost("answer")))) {
			echo Trivia::getNextQuestion($chall);
		}
		else {
			if (GWF_User::isLoggedIn()) {
				$chall->onChallengeSolved(GWF_Session::getUserID());
			}
			else {
//				htmlDisplayMessage($chall->lang('msg_solved', array(TRIVIA_CHEATCODE)));
				htmlDisplayMessage($chall->lang('msg_solved', array('XXXXXXXXXXXXXXX')));
			}
		}
		break;
	default: Trivia::onLoose(); echo Trivia::getNextQuestion($chall); break;
}

/*
 * ----- functions -----
 */

class Trivia {
	
	private static $questionDir = "challenge/trivia/74k37h053";
	
	private static function getRandomFile() {
	
		if (false === ($dir = dir(self::$questionDir))) {
			die("ERROR TRIVIA 1!");
		}
	
		$back = array();
	
		while (false !== ($d = $dir->read())) {
			
			if (strpos($d, ".") === 0) {
				continue;
			}
			
			$back[] = $d;
	
		}
	
		return self::$questionDir."/".GWF_Random::arrayItem($back);
	
	}

	private static $tries = 0;
	public static function init()
	{
		self::$tries = 0;
		if (!GWF_Session::exists('trivia_question'))
		{
			GWF_Session::set('trivia_question', 1);
			GWF_Session::set('trivia_question_hashes', array());
		}
	}
	
	private static function getAllQuestions() {
		
		if (false === ($dir = dir(self::$questionDir))) {
			die("ERROR TRIVIA 2");
		}
	
		$back = array();
	
		while (false !== ($d = $dir->read())) {
			
			if (strpos($d, ".") === 0) {
				continue;
			}
			
			$filename = self::$questionDir."/".$d;
			$back = array_merge($back, file($filename));
	
		}
	
		return $back;
		
		
	}
	
	public static function getNextQuestion(WC_Challenge $chall)
	{
	
		if (++self::$tries == 6) {
			die("ERROR TRIVIA 3");
		}
		
		$merged = self::getAllQuestions();
		
		#$file = file(self::getRandomFile());
		if ("" == ($line = trim(GWF_Random::arrayItem($merged)))) {
			return self::getNextQuestion($chall);
		}
		
		$data = explode("/", $line);
		if (count($data) < 4) {
			htmlDisplayError($line);
//			var_dump($data);
			return self::getNextQuestion($chall);
		}
		
		$question = $data[count($data)-1];
		$questionHash = md5($question);

		$hashes = GWF_Session::getOrDefault('trivia_question_hashes', array());
		
		if (in_array($questionHash, $hashes, true)) {
			return self::getNextQuestion($chall);
		}
		$hashes[] = $questionHash;
		
		GWF_Session::set('trivia_question_hashes', $hashes);
		
		unset($data[0]);
		$category = $data[1];
		unset($data[1]);
		
		$solutions = array();
//		$_SESSION["trivia_solution"] = array();
		foreach ($data as $id => $answer)
		{
			$answer = trim($answer);
			if ($answer === "") {
				continue;
			}
//			unset($data[$id]);
			$solutions[] = $answer;
//			$_SESSION["trivia_solution"][] = $answer;
		}
		GWF_Session::set('trivia_solution', $solutions);
	
		$hint = self::getHint($solutions[0]);
		
		$questionNR = GWF_Session::getOrDefault('trivia_question', 1);
//		$questionNR = $_SESSION["trivia_question"];
		
//		$questionNR = $_SESSION["trivia_question"];
		
		$timelimit = self::getTimeout();
		GWF_Session::set('trivia_timeout', (time() + $timelimit));
//		$_SESSION["trivia_timeout"] = time() + $timelimit;
		$form = self::getForm();
		return GWF_Box::box($chall->lang('box_info', array($timelimit, $category, $question, $hint, $form)), $chall->lang('box_title', array($questionNR)));
		
	}

	private static function getForm() {
		
		return
			"<form name='trivia' method='post'>".
			GWF_CSRF::hiddenForm('').
//			Session::getCSRF().
			"<input type='text' name='answer' value=''>".
			"<input type='submit' name='cmd' value='Answer'>".
			"</form>".
			"<script>document.trivia.answer.focus();</script>"; 
		
	}
	
	private static function getHint($answer) {
		
		$blacklist = array(
			"true", "false",
			"yes", "no", "wrong", "never",
		);
		if (in_array(strtolower($answer), $blacklist)) {
			return TRIVIA_NO_HINT;
		}
		
		$words = explode(" ", $answer);
		$back = array();
		
		/*
		 * Answer too short (by Z)
		 */
//		if (3 >= ($answerLen = strlen($answer))) {
//			return str_repeat(TRIVIA_GAP_CHAR, $answerLen);
//		}
		
		// ***
		// T***
		// Ha*******
		
		
		
		foreach ($words as $word)
		{
//			$current = "";
//			var_dump($word);
			$len = strlen($word);
//			var_dump($len);
			$nRevealed = intval($len / 4); 
			$word = substr($word, 0, $nRevealed);
//			var_dump($word);
//			var_dump($nRevealed);
			$word .= str_repeat(TRIVIA_GAP_CHAR, $len - $nRevealed);
//			var_dump(strlen($word));
			$back[] = $word;
//			echo '<hr/>';
		}
		
		$hint = implode(" ", $back);
		
		return $hint;
//		return preg_replace("/[0-9]/", TRIVIA_GAP_CHAR, $hint);
		
	}
	
	private static function getTimeout()
	{
		$qnum = GWF_Session::getOrDefault('trivia_question', 1);
		return TRIVIA_MIN_TIMOUT + ((TRIVIA_NUM_QUESTIONS - ($qnum)) * TRIVIA_TIMOUT_ADD);
	}
	
	private static function getLooserMsg(WC_Challenge $chall)
	{
		return GWF_Random::arrayItem($chall->lang('looser'));
	}
	
	private static function getCongratMsg(WC_Challenge $chall)
	{
		return GWF_Random::arrayItem($chall->lang('winner'));
	}
	
	public static function onLoose()
	{
		GWF_Session::set('trivia_question', 1);
		GWF_Session::set('trivia_question_hashes', array());
	}
	
	public static function checkAnswer(WC_Challenge $chall, $answer) {
		
//		if ($_SESSION["trivia_timeout"] < time()) {
		if (GWF_Session::getOrDefault('trivia_timeout',0) < time()) {
			self::onLoose();
			return htmlDisplayError($chall->lang('err_timeout'));
		}
		
		$answer = strtolower(trim(Common::getPost("answer")));
		if ("" == ($answer)) {
			self::onLoose();
			return htmlDisplayError($chall->lang('err_answer_missing'));
		}
		
		if (false === ($solution = GWF_Session::getOrDefault("trivia_solution", false))) {
			return htmlDisplayError($chall->lang('err_no_question'));
		}
		foreach ($solution as $i => $s) {
			$solution[$i] = strtolower($s);
		}
		
		$qnum = GWF_Session::getOrDefault('trivia_question', 1);
		
		if ($answer == TRIVIA_CHEATCODE) {
			$qnum = TRIVIA_NUM_QUESTIONS + 1;
		}
		else if (in_array($answer, $solution, true)) {
			htmlDisplayMessage(self::getCongratMsg($chall));
			$qnum++;
		}
		else {
			htmlDisplayError(self::getLooserMsg($chall), false);
			self::onLoose();
			return false;
		}
		
		GWF_Session::set('trivia_question', $qnum);
		
		if ($qnum > TRIVIA_NUM_QUESTIONS) {
			self::onLoose();
			return true;
		}

		return false;
	}
}

echo $chall->copyrightFooter();
require_once 'html_foot.php';
?>