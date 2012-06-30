<!-- GWF3 BB CODE BAR  -->
<div class="gwf3_bb_code_bar">
<div>
	<img src="{$root}img/{$iconset}/bb/b.png"
		alt="[b]"
		title="[b]{GWF_HTML::lang('bbhelp_b')}[/b]"
		onclick="return bbInsert('{$key}', '[b]', '[/b]')" />
		
	<img src="{$root}img/{$iconset}/bb/i.png"
		alt="[i]"
		title="[i]{GWF_HTML::lang('bbhelp_i')}[/i]"
		onclick="return bbInsert('{$key}', '[i]', '[/i]')" />
		
	<img src="{$root}img/{$iconset}/bb/u.png"
		alt="[u]"
		title="[u]{GWF_HTML::lang('bbhelp_u')}[/u]"
		onclick="return bbInsert('{$key}', '[u]', '[/u]')" />
	
	<img src="{$root}img/{$iconset}/bb/code.png"
		alt="[code]"
		title="[code=lang]{GWF_HTML::lang('bbhelp_code')}[/code]"
		onclick="return bbInsertCode('{$key}');" />
	
	<img src="{$root}img/{$iconset}/bb/quote.png" 
		alt="[quote]" 
		title="[quote=username]{GWF_HTML::lang('bbhelp_quote')}[/quote]" 
		onclick="return bbInsert('{$key}', '[quote=Unknown]', '[/quote]')" />

	<img src="{$root}img/{$iconset}/bb/url.png" 
		alt="[url]" 
		title="[url=url]{GWF_HTML::lang('bbhelp_url')}[/url] or [url]url[/url]" 
		onclick="return bbInsertURL('{$key}')" />

	<img src="{$root}img/{$iconset}/bb/email.png"
		alt="[email]" 
		title="[email=email@url]{GWF_HTML::lang('bbhelp_email')}[/email] or [email]email[/email]" 
		onclick="return bbInsert('{$key}', '[email]', '[/email]')" />
	
	<img src="{$root}img/{$iconset}/bb/noparse.png"
		alt="[noparse]"
		title="[noparse]{GWF_HTML::lang('bbhelp_noparse')}[/noparse]"
		onclick="return bbInsert('{$key}', '[noparse]', '[/noparse]')"
	/>
	
	<img src="{$root}img/{$iconset}/bb/score.png"
		alt="[score]"
		title="[score=5]{GWF_HTML::lang('bbhelp_level')}[/score]"
		onclick="return bbInsert('{$key}', '[score=5]', '[/score]')"
	/>
	
	<img src="{$root}img/{$iconset}/bb/spoiler.png" 
		alt="[spoiler]"
		title="[spoiler]{GWF_HTML::lang('bbhelp_spoiler')}[/spoiler]"
		onclick="return bbInsert('{$key}', '[spoiler]', '[/spoiler]')"
	/>
	
{*	<img src="{$root}img/{$iconset}/bb/img.png"
		alt="[img]"
		title="[img title= alt= w= h=]url {GWF_HTML::lang('bbhelp_img')}[/img]"
		onclick="return bbInsert('{$key}', '[img title\'\' alt=\'\']', '[/img]')"
	/>

	<img src="{$root}img/{$iconset}/bb/youtube.png"
		alt="[youtube]"
		title="[youtube]id {GWF_HTML::lang('bbhelp_youtube')}[/youtube]"
		onclick="return bbInsert('{$key}', '[youtube]', '[/youtube]')"
	/>
*}	
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
{*		<option value="">{GWF_HTML::lang('other', array('3', 2, 1))}</option> *} 
	</select>
	<input id="bb_url_href_{$key}" type="text" value="google.de" />
	<img src="{$root}img/{$iconset}/add.png" alt="Add" title="Add" onclick="return bbInsertURL('{$key}')" />
{*	<input type="submit" onclick="" value="Add" /> *}
</div>

<!-- /GWF3 BB CODE BAR  -->
</div>
