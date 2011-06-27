<?php

final class SF_color extends GWF_Method
{
	private static $SF = NULL;
	
	private static $layoutcolors = array(
		'blue' => array(
			'base_color' => 'blue',
			'design_dark' => '#076df3',
			'design_light' => '#00a3f9',
			'border_dark' => '#076df3',
			'border_light' => '#00a3f9',
		),
		'green' => array(
			'base_color' => 'green',
			'design_dark' => '#006400',
			'design_light' => '#00FF00',
			'border_dark' => '#006400',
			'border_light' => '#00FF00',
		),
		'orange' => array(
			'base_color' => 'orange',
			'design_dark' => '#FF8C00',
			'design_light' => '#FFA500',
			'border_dark' => '#FF8C00',
			'border_light' => '#FFA500',
		),
			'red' => array(
			'base_color' => 'red',
			'border_light' => '#a33a3a',
			'border_dark' => '#8e0a0a',
			'design_light' => '#FF0000',
			'design_dark' => '#8B0000',
		),
		'yellow' => array(
			'base_color' => 'yellow',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
		),
		'purple' => array(
			'base_color' => 'purple',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
		),
		'white' => array(
			'base_color' => 'white',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
		),
		'black' => array(
			'base_color' => 'black',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
		),
		'brown' => array(
			'base_color' => 'brown',
			'border_light' => '#',
			'border_dark' => '#',
			'design_light' => '#',
			'design_dark' => '#',
		)
	);
	private static $formaction = array(
		'login' => '/login',
		'register' => '/register',
		'tell_a_friend' => 'index.php?form=tell_a_friend',
		'contact' => 'index.php?form=contact',
		'logout' => 'index.php?form=logout',
		'profile' => 'index.php?form=profile',
		'donate' => 'index.php?form=donate',
		'design_switch' => 'index.php?form=design_switch',
		'shell' => 'index.php?mo=SF&amp;me=Shell',
	);
	private static $meta = array(
		'content-type' => array('content-type', 'text/html;charset=utf-8', true),
		'author' => array('author', 'Florian Best', false),
		'application-name' => array('application-name', 'SpaceFramework',false),
		'keywords' => array('keywords', 'Hip-Hop,Graffiti,Rap,Breakdance,Computer,Internet,Hacking,Japan', false),
		'description' => array('description', 'Hip-Hop Rap Graffiti Breakdance Dj-ing Computer Hacking Cracking Coding Programmieren Linux Sicherheit Security Tutorials Schulkritik Umweltschutz Japan', false),
		'generator' => array('generator', 'GWF+SF', false),
		'robots' => array('robots', 'noindex, nofollow', false),//'noindex,nofollow',
		'googlebot' => array('googlebot', 'noindex, nofollow', false),//'noindex,nofollow',
	#	'publisher' => array('publisher', 'Florian Best', false),
	#	'copyright' => array('copyright', 'Florian Best', false),
	#	'pagetopic' => array('pagetopic', 'Florian Best', false),
	#	'webauthor' => array('webauthor', 'Florian Best', false),
	#	'language' => array('language', 'Deutsch', false),
	#	'revisit-after' => array('revisit-after', '', false),
	#	'abstract' => array('abstract', '', false),
	#	'distribution' => array('distribution', '', false),
	#	'expires' => array('expires', '', false),
	#	'googlebot' => array('googlebot', '', false),
	#	'rating' => array('rating', ' ', false),
	#	'reply-to' => array('reply-to', ' ', false),
	#	'audience' => array('audience', 'Alle', false),
	#	'MSSmartTagsPreventParsing' => array('MSSmartTagsPreventParsing', 'TRUE', false),
	#	'cache-control' => array('cache-control', '', true),
	#	'cookie' => array('cookie', '', true),
	#	'disposition' => array('disposition', '', true),
	#	'imagetoolbar' => array('imagetoolbar', 'false', true),
	#	'ms_theme' => array('ms_theme', '', true),
	#	'pics-label' => array('pics-label', '', true),
	#	'pragma' => array('pragma', '', true),
	#	'resource type' => array('resource type', '', true),
	#	'resfresh' => array('resfresh', '', true),
	#	'script-type' => array('script-type', '', true),
	#	'style-type' => array('style-type', '', true),
	#	'window-target' => array('window-target', '', true),
	); 
	
	public function __construct() {
		self::$SF = new SF;
		self::$SF->setLayoutColor(self::$layoutcolors);
	}
	public function init() {
		$SF = self::$SF;
		$SF->setMeta(self::$meta);
		$SF->setFormActions(self::$formaction);
		$SF->setPageTitlePre('www.FlorianBest.de - ');
		GWF_Website::addCSS('/index.php?ajax=SF&amp;mo=SF&amp;me=color');
		$SF->setDesignCSS(array('reset', 'gwf3', 'design', 'main', 'format'));
		$SF->setLayoutCSS(array('layout', 'navigation', 'headnavi'));
		$SF->setDoctype('html5');

		if(isset($_GET['sec'])) GWF_Website::addDefaultOutput('Please login to see content!');

	}
	public function getHTAccess(GWF_Module $module)
	{
		return 'RewriteRule ^colorCSS/?$ index.php?ajax=SF&mo=SF&me=color'.PHP_EOL.
		       'RewriteRule ^layoutcolor/(.*+)$ index.php?layoutcolor=$1'.PHP_EOL;
	}
	
	public function execute(GWF_Module $module)
	{
		$SF = self::$SF;
		$SF->sendHeader('Content-type: text/css; charset=UTF-8');

		return $this->templateColor($module, $SF->getColorCSS());
	}
	
	private function templateColor(Module_SF $module, $tVars)
	{
		return $module->template('color.tpl', $tVars);
	}
	
}

if(Common::getGet('ajax') != 'SF') {
	$SFC = new SF_color;
	$SFC->init();
}