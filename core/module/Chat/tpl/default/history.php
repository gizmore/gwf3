<h1><?php echo $tLang->lang('pt_history'); ?></h1>
<p><?php echo $tLang->lang('pi_history'); ?></p>
<p><a href="/chat/history/page-1"><?php echo $tLang->lang('btn_history')?></a></p>

<div class="fl">
<?php foreach ($tVars['friends'] as $friend) { ?>
	<div><a href="/chat/history/for/<?php echo Common::urlencodeSEO(($friend)); ?>/page-1"><?php echo GWF_HTML::display($friend); ?></a></div>
<?php } ?>
</div>

<?php echo $tVars['pagemenu']; ?>

<div><?php echo $tVars['prevpage']; ?> | <?php echo $tVars['nextpage']?></div>

<?php
echo GWF_Table::start();
foreach ($tVars['history'] as $msg)
{
	echo GWF_Table::rowStart();
	echo GWF_Table::column($msg->displayFrom());
	echo GWF_Table::column($msg->displayTo());
	echo GWF_Table::column($msg->displayMessage());
	echo GWF_Table::rowEnd();
}
echo GWF_Table::end();
?>
<div><?php echo $tVars['prevpage']; ?> | <?php echo $tVars['nextpage']?></div>
