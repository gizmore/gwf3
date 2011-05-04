<div class="gwf_newsbox">
<?php foreach ($tVars['news'] as $newsid => $news) { $newsid = $news->getID(); ?>
<div class="gwf_newsbox_item">
	<div><a name="newsid<?php echo $news->getID(); ?>"></a></div>
	
	<div class="gwf_newsbox_title">
		<div class="fr">
			<div class="gwf_newsbox_date gwf_date"><?php echo $news->displayDate(); ?></div>
			<div class="gwf_newsbox_author"><?php echo $news->displayAuthor(); ?></div>
		</div>
		<h3><?php echo $news->displayTitle(); ?></h3>
		<div class="cb"></div>
	</div>

	<?php #if ($is_staff) { echo '<div class="gwf_newsbox_translate">'.$news->getTranslateSelect().'</div>'; } ?>

	<div class="gwf_newsbox_message"><?php echo $news->displayMessage(); ?></div>
	
</div>

<!--
<div class="gwf_newsbox_item">
	<div class="gwf_newsbox_head">
		<span class="gwf_newsbox_title"><?php echo $news->displayTitle(); ?></span>
		<span class="gwf_newsbox_date"><?php echo $news->displayDate(); ?></span>
		<span class="gwf_newsbox_author"><?php echo $news->displayAuthor(); ?></span>
	</div>
	<div id="news_msg_<?php echo $newsid; ?>">
		<div class="gwf_newsbox_message"><?php echo $news->displayMessage(); ?></div>
	</div>
</div>
  -->
<?php } ?>	
</div>
