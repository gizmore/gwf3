<?php
require_once 'WC_Challenge.php';

/**
 * Helper stuff for a codinggeex challenge.
 * The plan is to not write much stuff for a cgx,
 * as they all have the same structure.
 * 
 * @author gizmore
 * @since 6.Feb.2023
 */
final class WC_CodegeexChallenge
{
	private $cgxNumber = 0;
	private $challenge = null;
	private $directory = null;
	
	public function __construct($cgxNumber, WC_Challenge $challenge, $directory)
	{
		$this->cgxNumber = $cgxNumber;
		$this->challenge = $challenge;
		$this->directory = $directory;
	}
	
	##############
	### Static ###
	##############
	/**
	 * Get CGX challenge for a folder path (cwd)
	 * 
	 * @param string $cwd
	 * @return WC_CodegeexChallenge
	 */
	public static function byCWD($cwd)
	{
		$cwd = str_replace('\\', '/', $cwd);
		$title = self::parseTitle($cwd);
		$number = self::parseNumber($title);
		$challenge = self::getWeChallChallenge($cwd, $title, $number);
		return new self($number, $challenge, $cwd);
	}
	
	private static function getWeChallChallenge($cwd, $title, $number)
	{
		if ($chall = WC_Challenge::getByTitle($title, false))
		{
			return $chall;
		}
		$i = strpos($cwd, '/challenge/');
		$url = substr($cwd, $i+1) . 'index.php';
		$score = self::parseScore($cwd);
        $solution = self::parseSolution2($cwd);
		return WC_Challenge::dummyChallenge($title, $score, $url, $solution, 0, self::getCreators($cwd), ['Training', 'CGX']);
	}
	
	private static function getCreators($cwd)
	{
		$path = "{$cwd}creators.php";
		if (!is_file($path))
		{
			return ['gizmore', 'x'];
		}
		return include $path;
	}
	
	/**
	 * Extract title from CGX README.md.
	 * 
	 * @param string $cwd
	 * @throws Exception
	 * @return string
	 */
	private static function parseTitle($cwd)
	{
		try
		{
			$path = "{$cwd}README.md";
			if (!file_exists($path))
			{
				throw new Exception("CGX challenge has no README.md");
			}
			$fh = fopen($path, 'r');
			// Like: "# CGX#15: Foo Bar - baz"
			$title = trim(fgets($fh));
			if (!$title)
			{
				throw new Exception("CGX challenge has no Title in README.md");
			}
			$matches = null;
			if (!preg_match('/^# CGX#\\d+: /D', $title, $matches))
			{
				throw new Exception("CGX challenge has no valid Title in README.md: $title");
			}
			return substr($title, 2);
		}
		finally
		{
			if (isset($fh))
			{
				fclose($fh);
			}
		}
	}
	
	private static function parseNumber($title)
	{
		$matches = null;
		if (!preg_match('/^CGX#(\\d+): /D', $title, $matches))
		{
			throw new Exception("Cannot parse CGX number from title: {$title}");
		}
		return $matches[1];
	}
	
	private static function parseScore($cwd)
	{
		$path = "{$cwd}score.php";
		return is_file($path) ? include $path : 0;
	}
	
	###########
	### API ###
	###########
	public function getNumber()
	{
		return $this->cgxNumber;
	}
	
	public function getChallenge()
	{
		return $this->challenge;
	}
	
	public function getScore()
	{
		return $this->challenge->getScore();
	}
	
	public function getSolution()
	{
		return $this->parseSolution();
	}
	
	/**
	 * Check if this entry has an interactive problem for the user.
	 * @return boolean
	 */
	public function hasProblem()
	{
		$path = $this->directory . 'flag.php';
		return is_file($path);
	}
	
	public function getFlag(): ?string
	{
		$sesskey = sprintf('CGX#%s#FLAG', $this->cgxNumber);
		if (!($flag = GWF_Session::get($sesskey)))
		{
			if ($flag = $this->parseFlag())
			{
				GWF_Session::set($sesskey, $flag);
			}
		}
		return $flag;
	}
	
	public function getProblem()
	{
		$sesskey = sprintf('CGX#%s#PRB', $this->cgxNumber);
		if (!($problem = GWF_Session::get($sesskey)))
		{
			if ($problem = $this->parseProblem())
			{
				GWF_Session::set($sesskey, $problem);
			}
		}
		return $problem;
	}
	
	public function hasVideo()
	{
		$path = $this->directory . 'video.php';
		return file_exists($path);
	}
	
	##############
	### Render ###
	##############
	public function getInfoBox()
	{
		$path = $this->directory . 'info.php';
		$chall = $this->challenge;
		if (is_file($path))
		{
			$text = include $path;
		}
		else
		{
			$text = $chall->lang('info');
		}
		return GWF_Box::box($text, $chall->lang('title'));
	}
	
	public function getSolverBox()
	{
		if (!$this->hasProblem())
		{
			return GWF_Box::box(
				$this->getSolverContent(),
				WC_HTML::lang('solver'));
		}
	}
	
	public function getDraftBox()
	{
        return $this->getDraft();
//		return GWF_Box::box(
//			$this->getDraft(),
//			WC_HTML::lang('draft', [$this->getNumber()]));
	}
	
	public function getVideoBoxes()
	{
		$title = $this->challenge->getTitle();
		$url = $this->directory . 'video.php';
		$urls = include $url;
		if (!is_array($urls))
		{
			$urls = [$urls];
		}
		$back = '';
		foreach ($urls as $key => $url)
		{
			if (is_numeric($key))
			{
				$key++;
			}
			$back .= $this->getVideoBox($key, $title . "-{$key}", $url);
		}
		return $back;
	}
	
	public function getVideoBox($key, $title, $url)
	{
		$expand = @$_GET['video'] == $key;
		$t = WC_HTML::lang('video', [$title, $this->getVideoTitle($key)]);
		$url2 = $this->challenge->getHREF() . "?video={$key}#video_{$key}";
		$anchor = "<a id=\"video_{$key}\" href=\"{$url2}\">$t</a>";
		return GWF_Box::box(
			$this->getVideoBoxContent($key, $title, $url, $expand),
			$anchor);
	}
	
	public function getProblemBox()
	{
		$description = '';
		$problem = $this->getProblem();
		if ($this->challenge->hasLang('problem'))
		{
			$description = $this->challenge->lang('problem');
			$description = "<br/>\n{$description}<br/>\n";
		}
		return GWF_Box::box(
			WC_HTML::lang('problem_box', [$description, $problem]),
			WC_HTML::lang('problem', [$this->getNumber()]));
	}
	
	/**
	 * Mark a challenge as solved, for video tutorial challenges without a problem.
	 */
	public function markAuxilarySolved()
	{
		if (isset($_GET['mark_solved']))
		{
			if (!$this->hasProblem())
			{
				$c = $this->getChallenge();
				$c->onChallengeSolved();
			}
			else
			{
				die('Invalid solver token. This incident is being reported! ;=)'); # hehe
			}
		}
	}
	
	###############
	### Private ###
	###############
	private function getDraft()
	{
		$path = $this->directory . 'README.md';
		$markdown = file_get_contents($path);
        require_once '../core/inc/util/GWF_Markdown.php';
        return GWF_Markdown::parse($markdown);
	}


	private function getVideoBoxContent($key, $title, $url, $expanded=false)
	{
		if ($expanded)
		{
			return <<<EOF
<iframe width="790" height="665"
src="{$url}"
title="{$title}"
frameborder="0"
allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
allowfullscreen>
</iframe>
EOF;
		}
		else
		{
			$t = WC_HTML::lang('click_to_expand');
			$url = $this->challenge->getHREF() . "?video={$key}#video_{$key}";
			return "<a href=\"{$url}\">{$t}</a>\n";
		}
	}
	
	private function parseFlag(): ?string
	{
// 		$user = GWF_User::getStaticOrGuest();
		$path = $this->directory . 'flag.php';
		return include $path;
	}
	
	private function parseProblem()
	{
		$user = GWF_User::getStaticOrGuest();
		$flag = $this->getFlag();
		$path = $this->directory . 'problem.php';
		if (!is_file($path))
		{
			$path = $this->directory . 'flag.php';
		}
		return include $path;
	}

    private function parseSolution()
    {
        $user = GWF_User::getStaticOrGuest();
        $flag = $this->getFlag();
        $path = $this->directory . 'solution.php';
        return @include $path;
    }

    private static function parseSolution2($cwd)
    {
        $user = GWF_User::getStaticOrGuest();
        $path = $cwd . 'solution.php';
        return @include($path);
    }


    private function getVideoTitle($key)
	{
		$c = $this->challenge;
		$key = "video_{$key}";
		if ($c->hasLang($key))
		{
			return $c->lang($key);
		}
		return WC_HTML::lang('vid');
	}
	
	private function getSolverContent()
	{
		$rand = ((float)rand())*0.01+1.00; # Just to confuse some lamerz :P
		$here = WC_HTML::lang('click_here');
		$indx = $this->challenge->getHREF();
		$anch = "<a href=\"{$indx}?mark_solved={$rand}\">$here</a>";
		return WC_HTML::lang('solver_box', [$anch]);
	}
	
}
