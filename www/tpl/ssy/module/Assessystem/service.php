<?php SSYHTML::$menuID = SSY_MENU_SERVICE2; ?>

<?php echo SSYHTML::getBoxTitled($tLang->lang('service_title'), $tLang->lang('service_info')); ?>

<?php $data = $tLang->lang('service_data'); ?>

<table id="ssy_service_table" cellspacing="1">

<?php
$i = 0;
foreach ($data as $txt)
{ 
	$mod = $i % 4;
	
	if ($mod === 0) {
		echo '<tr>';
	}
	echo sprintf('<td>%s</td>', $txt);

	if ($mod === 3) {
		echo '</tr>';
	}
	
	$i++;
}

?>

</table>
