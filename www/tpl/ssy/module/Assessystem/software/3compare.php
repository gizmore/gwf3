<div>
<?php
//$html = 
//	sprintf('%s<br/>%s<br/><ul><li>%s</li><li>%s</li><li>%s</li></ul>', 
//		$tLang->lang('soft_3_info'),
//		$tLang->lang('soft_3_infoH'),
//		$tLang->lang('soft_3_info1'),
//		$tLang->lang('soft_3_info2'),
//		$tLang->lang('soft_3_info3')
//	);  
$html = $tLang->lang('soft_3_info');
?>

<?php echo SSYHTML::getBoxTitled($tLang->lang('soft_3_title'), $html); ?>
<?php #echo SSYHTML::softwareBoxFromID($tLang, 3) ?>

<div class="ce" style="margin-top: 40px;"><img src="<?php echo GWF_WEB_ROOT; ?>tpl/ssy/img/argh/en/Zeitreihenvergleich.jpg" style="width: 95%; height: 95%;" alt="grafik" title="grafik" /></div>

</div>