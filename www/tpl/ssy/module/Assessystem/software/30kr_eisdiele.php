<?php
$html = 
	sprintf('%s<br/>%s<br/><ul><li>%s</li><li>%s</li><li>%s</li></ul>', 
		$tLang->lang('soft_3_info'),
		$tLang->lang('soft_3_infoH'),
		$tLang->lang('soft_3_info1'),
		$tLang->lang('soft_3_info2'),
		$tLang->lang('soft_3_info3')
	);  

?>
<?php echo SSYHTML::getBoxTitled($tLang->lang('soft_5_title_2'), $html); ?>

<span class="t" style="">
<span class="ssy800v_R ssy_st_out3">
	<span class="ssy_small_softbox">
	<?php 
	foreach ($tLang->lang('soft_1_3') as $txt)
	{
		echo sprintf('<a href="#">%s</a>', $txt);
	}
	?>
	</span>
	<span class="ssy_st_out3_t ssy800h"><?php echo GWF_String::toUpper($tLang->lang('soft_5_title_2')); ?></span>
	<span class="ssy800v ssy_st_out2">
		<span class="ssy800v_R ssy_st_out1">
		</span>
	</span>
</span>
</span>
