<?php # Usage: %CMD%. Show information of the current song played at http://slayradio.org
$url = 'http://slayradio.org/now_playing.php';

if (false === ($result = GWF_HTTP::getFromURL($url))) {
	return $bot->reply('Error 1: HTTP error');
}

# <strong>Lagerfeldt</strong><br>R-Type (Doppelganger Summer Remix)<p align="center"><small>Requested by <b><i>zeddan</i></b> <br></small>
if (1 === (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<p align="center"><small>Requested by <b><i>([^<]+)</i></b> <br></small>#', $result, $matches))) {
	$bot->reply(sprintf('Now Playing on http://slayradio.org %s - %s (requested by %s)',
		utf8_encode(html_entity_decode($matches[1], ENT_QUOTES)),
		utf8_encode(html_entity_decode($matches[2], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches[3], ENT_QUOTES))
	));
}

# <strong>CHaK</strong><br>Times of Lore (remix)<p align="center"><br>
elseif (1 === (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<p align="center">#', $result, $matches))) {
	$bot->reply(sprintf('Now Playing on http://slayradio.org %s - %s (requested by SlayRadio AI)',
		utf8_encode(html_entity_decode($matches[1], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches[2], ENT_QUOTES))
	));
}

# <strong>Makke</strong><br>I am a Database<br>From <b>It's Binary, Baby!</b><center><a href="http://www.c64audio.com/productInfo.php?cat=BINBABE" target="_new" border="0"><img src="/images/albums/Makke_-_Its_Binary_Baby.jpg" border="0"></a></center>
#<p align="center"><small>Requested by <b><i>gizmore</i></b> <br></small>
elseif ((1 === (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<br>#', $result, $matches1))) && 
	(1 === preg_match('#<small>Requested by <b><i>([^<]+)</i></b> <br></small>#', $result, $matches2)))
{
	$bot->reply(sprintf('Now Playing on http://slayradio.org %s - %s (requested by %s)',
		utf8_encode(html_entity_decode($matches1[1], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches1[2], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches2[1], ENT_QUOTES))
	));
}

# <strong>Reyn Ouwehand</strong><br>Magic Johnson&#039;s Basketball<br>From <b>The Blithe, The Blend & The Bizarre</b><center><a href="http://www.c64audio.com/productInfo.php?cat=PP004" target="_new" border="0"><img src="/images/albums/Reyn_-_BBB.jpg" border="0"></a></center>
elseif ((1 === (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<br>#', $result, $matches1))))
{
	$bot->reply(sprintf('Now Playing on http://slayradio.org %s - %s (requested by SlayRadio AI)',
		utf8_encode(html_entity_decode($matches1[1], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches1[2], ENT_QUOTES))
	));
}

#<div align="center"><font size="+1">Boz</font><br>BBB<br><a href="discuss.php?ID=883&what=show" onFocus="this.blur()"><img src="/site_styles/slay_radio/images/live_ani_light.gif" border="0"></a><br><br<b>Now playing:</b><br>Dafunk - Driven21
#(tiny rmx)<br><br>[<span class="link" onclick="window.location.href='discuss.php?ID=883&what=show';">Discuss this show</span>]</div><br>
elseif (true === false)
{
	
}
elseif (1 === preg_match('#<font size="\+1">([^<]+)</font>#', $result, $matches))
{
	$bot->reply(sprintf('There is probably a live show on http://slayradio.org: %s.', $matches[1]));
}
else {
	echo $result.PHP_EOL;
	$bot->reply('Error 2: all preg_match() failed.');
}

?>