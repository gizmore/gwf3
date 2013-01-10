<?php echo SSYHTML::getBoxTitled($tLang->lang('soft_3_title_1'), $tLang->lang('soft_3_info_1')); ?>

<span class="t" style="">
<span class="ssy800v_R ssy_st_out3">
	<span class="ssy_small_softbox">
	<?php 
	$keys = $tLang->lang('neuzrv_key');
	$index = (int)Common::getGet('index', 0);
	$index = Common::clamp($index, 0, count($keys)-1);
	$body = $tLang->lang('neuzrv_body');
	
	foreach ($keys as $i => $txt)
	{
		$href = GWF_WEB_ROOT.'zeitreihenvergleich/gastronomie/'.$i;
		echo sprintf('<a href="%s">%s</a>', $href, $txt);
	}
		?>
	</span>
	<span class="ssy_st_out3_t ssy800h"><?php echo GWF_String::toUpper($keys[$index]); ?></span>
	<span class="ssy800v ssy_st_out2">
		<span class="ssy800v_R ssy_st_out1"><?php echo $body[$index]; ?></span>
	</span>
</span>
</span>
