<?php echo SSYHTML::getBox($tLang->lang('thanks_info')); ?>
<div id="ssy_soft_table">
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
	
</div>
<div class="ssy_bg800R">
<div class="ssy_bg800">
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
</div>
<div class="ssy_bg800"><?php echo $tVars['current']; ?></div>
</div>
<div class="ssy_inmain_wrap">
	<span class="ssy_border2"><span class="ssy_box">WIR DANKEN...</span></span>

	<span class="ssy_back800">
		<span class="ssy_halfboxl">
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
		<span class="ssy_halfboxr"><?php echo $tVars['current']; ?></span>
	</span>
</div>
