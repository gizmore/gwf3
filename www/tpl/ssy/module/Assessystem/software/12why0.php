<div>
<?php echo SSYHTML::getBoxTitled($tLang->lang('why0_title'), $tLang->lang('why0_info')); ?>
<span class="t" style="">
<span class="ssy800v_R ssy_st_out3">
	<span class="ssy_small_softbox">
	<?php
	
	$index = Common::clamp(intval(Common::getGet('index')), 1, 5);
	
	for ($i = 1; $i <= 5; $i++)
	{
		$href = GWF_WEB_ROOT.$tLang->lang('menu_U222').'/'.$i;
		echo sprintf('<a href="%s">%s</a>', $href, $tLang->lang('why'.$i.'_title'));
	}
//	foreach ($tLang->lang('soft_1_3') as $txt)
//	{
//		echo sprintf('<a href="#">%s</a>', $txt);
//	}
	?>
	</span>
	<span class="ssy_st_out3_t ssy800h"><?php #echo GWF_String::toUpper($tLang->lang('soft_1_title_2')); ?><?php echo GWF_String::toUpper($tLang->lang(sprintf('why%d_title', $index))); ?></span>
	<span class="ssy800v ssy_st_out2">
		<span class="ssy800v_R ssy_st_out1">
			<?php echo $tLang->lang(sprintf('why%d_info', $index)); ?>
			<?php #echo $tLang->lang('when1_info'); ?>
			<?php #echo $tLang->lang('when2_info'); ?>
			<?php #echo $tLang->lang('when3_info'); ?>
			<?php #echo $tLang->lang('when4_info'); ?>
			<?php #echo $tLang->lang('when5_info'); ?>
		</span>
	</span>
</span>
</span>
</div>
