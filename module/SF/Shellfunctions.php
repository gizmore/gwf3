<?php

final class Shellfunctions# extends SF_Shell 
{
	public function lp() { return GWF_Website::addCSS('/templates/SF/css/print.css'); }
	public function lpr() { return self::lp(); }
	public function md5(array $cmd) { return md5($cmd[1]); }
	public function date() { return GWF_Time::displayDate(GWF_Time::getDate(14)); }
#	public function () {}
#	public function () {}
#	public function () {}
#	public function () {}
}