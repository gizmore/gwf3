<?php
final class Wanda_Credits extends GWF_Method
{
	public function scrollText()
	{
		return <<<EOC
...........25............\n
.Well that is a scroller.\n
.                       .\n
.       H               .\n
.	            E       .\n
.       R               .\n
.               E       .\n
.                       .\n
.                       .\n
.       W       E       .\n
.		                .\n
.         THANK!        .\n
.                       .\n
.      THE PEOPLE!      .\n
.                       .\n
.                       .\n
.   WHO INSPIRED US!    .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.   WHO GAVE US GIFTS   .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.     !BITWARRIORS!     .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.      FAIR LIGHT       .\n
.         TLC           .\n
.   WORLD O.F WONDERS   .\n
.       SKID ROW        .\n
.      BYTEBANDIT       .\n
.         AS.D          .\n
.      LUCAS ARTS       .\n
.       BULLFROG        .\n
.        E LITE         .\n
.          Z            .\n
.          Z            .\n
.          Z            .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.     !!!TEACHERS!!!    .\n
.                       .\n
.       HERR MIEHE      .\n
.       FRAU MORAWE     .\n
.       HERR CLEMENS    .\n
.       FRAU GÜNTHER    .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.   art is (c)by Anja   .\n
.   Text by gizmore     .\n
.........................\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.                       .\n
.	                    .\n
.                       .\n
EOC;
		return str_replace("\r", '', $scroll_text);
	}
	
	public function getHTAccess()
	{
		return 'RewriteRule ^wanda/credits/?$ index.php?mo=Wanda&me=Credits'.PHP_EOL;
	}
	
	public function execute()
	{
		$tVars = array(
			'rand' => GWF_Random::rand(0, 65535),
			'scrollText' => $this->scrollText(),
			'width' => $this->gridWidth(),
			'height' => $this->gridHeight(),
		);
		return $this->module->templatePHP('credits.php', $tVars);
	}
	
	###############
	### private ###
	###############
	private function gridWidth()
	{
		return strpos($this->scrollText(), "\n");
	}
	
	private function gridHeight()
	{
		$w = $this->gridWidth() + 1;
		return (int)(mb_strlen($this->scrollText()) / $w);
	}

}


