<!-- GWF3 BB CODE BAR  -->
<div class="gwf3_bb_code_bar">
<div>
	<img src="{$root}img/bb/b.png"
		alt="[b]{$gwfl->bbhelp_b()}[/b]"
		title="[b]{$gwfl->bbhelp_b()}[/b]"
		onclick="return bbInsert('{$key}', '[b]', '[/b]')" />
		
	<img src="{$root}img/bb/i.png"
		alt="[i]{$gwfl->bbhelp_i()}[/i]"
		title="[i]{$gwfl->bbhelp_i()}[/i]"
		onclick="return bbInsert('{$key}', '[i]', '[/i]')" />
		
	<img src="{$root}img/bb/u.png"
		alt="[u]{$gwfl->bbhelp_u()}[/u]"
		title="[u]{$gwfl->bbhelp_u()}[/u]"
		onclick="return bbInsert('{$key}', '[u]', '[/u]')" />
	
	<img src="{$root}img/bb/code.png"
		alt="[code=lang]{$gwfl->bbhelp_code()}[/code]"
		title="[code=lang]{$gwfl->bbhelp_code()}[/code]"
		onclick="return bbInsertCode('{$key}');" />
	
	<img src="{$root}img/bb/quote.png" 
		alt="[quote=username]{$gwfl->bbhelp_quote()}[/quote]" 
		title="[quote=username]{$gwfl->bbhelp_quote()}[/quote]" 
		onclick="return bbInsert('{$key}', '[quote=Unknown]', '[/quote]')" />

	<img src="{$root}img/bb/url.png" 
		alt="[url=url]{$gwfl->bbhelp_url()}[/url] or [url]url[/url]" 
		title="[url=url]{$gwfl->bbhelp_url()}[/url] or [url]url[/url]" 
		onclick="return bbInsertURL('{$key}')" />

	<img src="{$root}img/bb/email.png"
		alt="[email=email@url]{$gwfl->bbhelp_email()}[/email] or [email]email[/email]" 
		title="[email=email@url]{$gwfl->bbhelp_email()}[/email] or [email]email[/email]" 
		onclick="return bbInsert('{$key}', '[email]', '[/email]')" />
	
	<img src="{$root}img/bb/noparse.png"
		alt="[noparse]{$gwfl->bbhelp_noparse()}[/noparse]"
		title="[noparse]{$gwfl->bbhelp_noparse()}[/noparse]"
		onclick="return bbInsert('{$key}', '[noparse]', '[/noparse]')"
	/>
	
	<img src="{$root}img/bb/score.png"
		alt="[score=5]{$gwfl->bbhelp_level()}[/score]"
		title="[score=5]{$gwfl->bbhelp_level()}[/score]"
		onclick="return bbInsert('{$key}', '[score=5]', '[/score]')"
	/>
	
	<img src="{$root}img/bb/spoiler.png" 
		alt="[spoiler]{$gwfl->bbhelp_spoiler()}[/spoiler]"
		title="[spoiler]{$gwfl->bbhelp_spoiler()}[/spoiler]"
		onclick="return bbInsert('{$key}', '[spoiler]', '[/spoiler]')"
	/>
{*	<img src="{$root}img/{$iconset}/user.png" 
	/>
*}
</div>

<div id="bb_code_{$key}"></div>

<div id="bb_url_{$key}" class="h">
	<select id="bb_url_prot_{$key}">
		<option value="/">{$smarty.const.GWF_SITENAME}</option>
		<option value="http://">HTTP</option> 
		<option value="https://">HTTPS</option> 
		<option value="">{$gwfl->other('3', 2, 1)}</option> 
	</select>
	<input id="bb_url_href_{$key}" type="text" value="google.de" />
	<input type="image" onclick="" />
</div>

<!-- /GWF3 BB CODE BAR  -->
</div>
