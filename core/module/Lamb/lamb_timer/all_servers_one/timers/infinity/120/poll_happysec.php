<?php
/*
 * 
 * config text = [HS-Forum] New post: '%s' by %s in forum '%s' ( http://www.happy-security.de/?modul=forum&action=lastpost&id=%s )
 * 
class Notifier extends Timer {
	
	function isTriggered() {
	
		echo "Checking for new Forum Posts..\n";
		for($x=0;$x<2;$x++) {
			$res = libHTTP::GET("www.happy-security.de",
								"/index.php?modul=forum&action=showunread",
								"HS-COOKIE=".$this->CONFIG['cookie'],
								15);
			if(!$res) {
				echo "Timeout.";
				return false;
			}
		}
		
		$text = strtr($res['raw'],array("\n" => " ", "\r" => ""));
		preg_match_all('#(\d+) id="thema" title="(.*?)".*?id="board">(.*?)</b>.*?id="letzter_name">(.*?)</a>#',$text,$arr);
		
		$results = sizeof($arr[1]);
		
		for($x=0;$x<$results;$x++) {
			$id     = $arr[1][$x];
			$topic  = $arr[2][$x];
			$forum  = $arr[3][$x];
			$author = $arr[4][$x];
			
			$text = sprintf($this->CONFIG['text'],
								$topic,
								$author,
								$forum,
								$id
							);
			$this->sendBroadcast($text);
			
			libHTTP::GET("www.happy-security.de",
						 "/index.php?modul=forum&action=topic&id=".$id,
						 "HS-COOKIE=".$this->CONFIG['cookie'],
						 15);
		}
		
		
		
		
	}
	
}

*/
?>