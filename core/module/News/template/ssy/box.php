<div class="gwf_newsbox">
<?php foreach ($tVars['news'] as $newsid => $news) { ?>
<div class="gwf_newsbox_item">
	<div class="gwf_newsbox_date"><?php echo $news->displayDate(); ?></div>
	<div class="gwf_newsbox_title"><?php echo $news->displayTitle(); ?></div>
	<div class="gwf_newsbox_author"><?php echo $news->displayAuthor(); ?></div>
	<div class="gwf_newsbox_message"><?php echo $news->displayMessage(); ?></div>
</div>
<?php } ?>	
</div>
