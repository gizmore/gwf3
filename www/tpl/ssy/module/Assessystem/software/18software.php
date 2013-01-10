<?php echo SSYHTML::getBoxTitled($tLang->lang('soft2_title'), $tLang->lang('soft2_info')); ?>

<div class="le" style="margin: 30px 10px 10px 20px;">

<?php
for ($i = 1; $i <= 3; $i++)
{
	$head = GWF_String::toUpper($tLang->lang('soft_busi_'.$i.'a'));
	$sub = $tLang->lang('soft_busi_'.$i.'b');
	$txt = $tLang->lang('soft_busi_'.$i.'c');
	
	echo sprintf('<div style="font-size: 18px; margin-bottom: 20px; margin-top: 40px; margin-left: 50px;">%s</div>', $head);
	
	echo sprintf('<div style="font-size:16px; margin-top:20px;">%s</div>', $sub);

	echo '<div class="ssy1024h" style="height:2px; margin-right: 20%; margin-top: 4px; margin-bottom:8px;" ></div>';
	
	echo sprintf('<div style="font-size: 14px; margin-left: 40px; margin-right: 20%%;">%s</div>', $txt);

}

?>

</div>