<div>
<?php echo SSYHTML::getBoxTitled($tLang->lang('soft_1_title'), $tLang->lang('soft_1_info')); ?>
</div>

<div class="le" style="margin: 30px 20% 10px 20px;">
<div style="font-size: 18px; margin-bottom: 20px; margin-left: 50px;"><?php echo GWF_String::toUpper($tLang->lang('soft_nachk1')); ?></div>
<?php 	echo '<div class="ssy1024h" style="height:2px; margin-top: 4px; margin-bottom:8px;" ></div>'; ?>

<div style="margin-left: 10px;">
<div style="margin-top: 10px;"><?php echo $tLang->lang('soft_nachk2'); ?></div>
<div><?php echo $tLang->lang('soft_nachk3'); ?></div>

<ul style="margin-top: 10px; margin-left: 40px;">
<?php
$data = $tLang->lang('soft_nachk3d');
foreach ($data as $txt)
{
	echo sprintf('<li>%s</li>', $txt);
}
?>
</ul>


<div style="margin-top: 10px;"><?php echo $tLang->lang('soft_nachk4'); ?></div>
<div style="margin-top: 10px;"><?php echo $tLang->lang('soft_nachk5'); ?></div>

</div>

</div>
