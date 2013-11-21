<?php
$lang = array(
	'en' => array(
		'help' => 'Usage: %CMD%. Show information of the current song played at http://slayradio.org - mplayer http://relay1.slayradio.org:8000',
		'np' => 'Now Playing on http://slayradio.org %s - %s (requested by %s)',
		'live' => "There is probably a \X02live show\X02 on http://slayradio.org: \X02%s\X02.",
		'ki' => 'SlayRadio AI',
	),
);
$plugin = Dog::getPlugin();
$ki = $plugin->lang('ki');

$url = 'http://slayradio.org/now_playing.php';

if (false === ($result = GWF_HTTP::getFromURL($url)))
{
	return Dog::rply('err_response');
}

# <strong>Lagerfeldt</strong><br>R-Type (Doppelganger Summer Remix)<p align="center"><small>Requested by <b><i>zeddan</i></b> <br></small>
if (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<p align="center"><small>Requested by <b><i>([^<]+)</i></b> <br></small>#', $result, $matches))
{
	$plugin->rply('np', array(
		utf8_encode(html_entity_decode($matches[1], ENT_QUOTES)),
		utf8_encode(html_entity_decode($matches[2], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches[3], ENT_QUOTES))
	));
}

# <strong>CHaK</strong><br>Times of Lore (remix)<p align="center"><br>
elseif (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<p align="center">#', $result, $matches))
{
	$plugin->rply('np', array(
		utf8_encode(html_entity_decode($matches[1], ENT_QUOTES)),
		utf8_encode(html_entity_decode($matches[2], ENT_QUOTES)), 
		$ki
	));
}

# <strong>Makke</strong><br>I am a Database<br>From <b>It's Binary, Baby!</b><center><a href="http://www.c64audio.com/productInfo.php?cat=BINBABE" target="_new" border="0"><img src="/images/albums/Makke_-_Its_Binary_Baby.jpg" border="0"></a></center>
#<p align="center"><small>Requested by <b><i>gizmore</i></b> <br></small>
elseif ((preg_match('#<strong>([^<]+)</strong><br>([^<]+)<br>#', $result, $matches))
	 && (preg_match('#<small>Requested by <b><i>([^<]+)</i></b> <br></small>#', $result, $matches2)) )
{
	$plugin->rply('np', array(
		utf8_encode(html_entity_decode($matches[1], ENT_QUOTES)),
		utf8_encode(html_entity_decode($matches[2], ENT_QUOTES)), 
		utf8_encode(html_entity_decode($matches2[1], ENT_QUOTES))
	));
}

# <strong>Reyn Ouwehand</strong><br>Magic Johnson&#039;s Basketball<br>From <b>The Blithe, The Blend & The Bizarre</b><center><a href="http://www.c64audio.com/productInfo.php?cat=PP004" target="_new" border="0"><img src="/images/albums/Reyn_-_BBB.jpg" border="0"></a></center>
elseif ((1 === (preg_match('#<strong>([^<]+)</strong><br>([^<]+)<br>#', $result, $matches))))
{
	$plugin->rply('np', array(
		utf8_encode(html_entity_decode($matches[1], ENT_QUOTES)),
		utf8_encode(html_entity_decode($matches[2], ENT_QUOTES)), 
		$ki
	));
}

#<div align="center"><font size="+1">Boz</font><br>BBB<br><a href="discuss.php?ID=883&what=show" onFocus="this.blur()"><img src="/site_styles/slay_radio/images/live_ani_light.gif" border="0"></a><br><br<b>Now playing:</b><br>Dafunk - Driven21
#(tiny rmx)<br><br>[<span class="link" onclick="window.location.href='discuss.php?ID=883&what=show';">Discuss this show</span>]</div><br>
elseif (true === false)
{
}

elseif (1 === preg_match('#<font size="\+1">([^<]+)</font>#', $result, $matches))
{
	$plugin->rply('live', array($matches[1]));
	Dog::reply(sprintf('', $matches[1]));
}

else
{
	Dog::rply('err_response');
}
?>
