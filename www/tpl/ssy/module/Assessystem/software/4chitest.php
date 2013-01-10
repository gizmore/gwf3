<div>
<?php echo SSYHTML::getBoxTitled($tLang->lang('soft_4_title'), $tLang->lang('soft_4_info1').'<br/>'.$tLang->lang('soft_4_info2')); ?>
<?php #echo SSYHTML::softwareBoxFromID($tLang, 4) ?>


<span class="t" style="">
<span class="ssy800v_R ssy_st_out3">
	<span class="ssy_small_softbox">
	<?php 
	foreach ($tLang->lang('soft_4_3') as $txt)
	{
		echo sprintf('<a href="#">%s</a>', $txt);
	}
	?>
	</span>
	<span class="ssy_st_out3_t ssy800h"><?php echo GWF_String::toUpper($tLang->lang('soft_4_title')); ?></span>
	<span class="ssy800v ssy_st_out2">
		<span class="ssy800v_R ssy_st_out1">
		</span>
	</span>
</span>
</span>

</div>