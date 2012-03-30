<div class="gwf_newsbox fl oa">
	{foreach from=$news item=item}
	<div class="gwf_newsbox_item">
		<div><a name="newsid{$item->getID()}"></a></div>
		<div class="gwf_newsbox_title">
			<div class="fr">
				<div class="gwf_newsbox_date gwf_date">{$item->displayDate()}</div>
				<div class="gwf_newsbox_author">{$item->displayAuthor()}</div>
			</div>
			<h3>{$item->displayTitle()}</h3>
			<div class="cb"></div>
		</div>
		<article class="gwf_newsbox_message">{$item->displayMessage()}</article>
	</div>
	{/foreach}
</div>
<div class="cl"></div>
