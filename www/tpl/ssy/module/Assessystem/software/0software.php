<?php echo SSYHTML::getBoxTitled($tLang->lang('soft_title'), $tLang->lang('soft_info')); ?>

<div class="le" style="margin: 30px 10px 10px 20px;">

<div style="font-size: 18px; margin-bottom: 20px; margin-left: 50px;"><?php echo GWF_String::toUpper($tLang->lang('all_soft_1')); ?></div>

<?php
for ($i = 2; $i <= 4; $i++)
{
	echo sprintf('<div style="font-size:16px; margin-top:20px;">%s</div>', $tLang->lang('all_soft_'.$i));
	echo '<div class="ssy1024h" style="height:2px; margin-right: 20%; margin-top: 4px; margin-bottom:8px;" ></div>';
	
	$data = $tLang->lang('all_soft_'.$i.'d');
	foreach ($data as $txt)
	{
		echo sprintf('<div style="font-size: 14px; margin-left: 40px; margin-right: 20%%;">%s</div>', $txt);
	}
}

?>
</div>
