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
		return WC_Challenge::dummyChallenge($title, $score, $url, false, 0, self::getCreators($cwd), ['Training', 'CGX']);
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
		$path = $this->directory . 'problem.php';
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
	
	public function getDraftBox()
	{
		return GWF_Box::box(
			$this->getDraft(),
			WC_HTML::lang('draft', [$this->getNumber()]));
	}
	
	public function getVideoBox()
	{
		return GWF_Box::box(
			$this->getVideoBoxContent(),
			WC_HTML::lang('video', [$this->getNumber()]));
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
	
	###############
	### Private ###
	###############
	private function getDraft()
	{
		$path = $this->directory . 'README.md';
		$markdown = file_get_contents($path);
		return nl2br($markdown);
	}
	
	private function getVideoBoxContent()
	{
		$title = $this->challenge->getTitle();
		$url = $this->directory . 'video.php';
		$url = include $url;
		return <<<EOF
<iframe width="790" height="665"
src="{$url}"
title="$title"
frameborder="0"
allow="accelerometer; autoplay; clipboard-write; encrypted-media;
gyroscope; picture-in-picture; web-share"
allowfullscreen></iframe>
EOF;
	}
	
	private function parseFlag(): ?string
	{
		$user = GWF_User::getStaticOrGuest();
		$path = $this->directory . 'flag.php';
		return include $path;
	}
	
	private function parseProblem()
	{
		$user = GWF_User::getStaticOrGuest();
		$flag = $this->getFlag();
		$path = $this->directory . 'problem.php';
		return include $path;
	}
	
	private function parseSolution()
	{
		$user = GWF_User::getStaticOrGuest();
		$flag = $this->getFlag();
		$path = $this->directory . 'solution.php';
		return include $path;
	}
	
}
