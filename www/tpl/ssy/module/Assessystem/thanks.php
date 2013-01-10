<?php echo SSYHTML::getBox($tLang->lang('thanks_info')); ?>
<!-- 
<span class="ssy_bg800R" style="padding: 2px; margin-top: 40px;">
<span class="ssy_bg800" style="padding: 2px;"> -->
<span class="ib" style="margin-top: 40px;">
	<span class="fl ssy_leftlinks ssy_bgMenu">
<?php 
$i = 0;
foreach ($tVars['thanks'] as $t)
{ 
	$i++;
	$href = sprintf('/wir_danken/%d/%s', $i, $t);
	$text = $t;
	echo sprintf('<a href="%s">%s</a>', $href, $text);
}
?>
	</span>
	<span class="ssy_bgMenu ssy_rightcontainer" style="min-width: 320px; max-width: 400px;">
		<span class="ib" style="padding: 10px;"><?php echo $tVars['current']?></span>
	</span>
	<span class="cl"></span>
<!-- 
</span>
</span>
-->
</span>