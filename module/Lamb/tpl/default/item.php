<?php
$player = $tVars['player']; $player instanceof SR_Player;
$item = $tVars['item']; $item instanceof SR_Item;
$location = $player->getParty()->getLocationClass('inside');
$name = $item->getItemName();
?>
<div>
	<div><img src="<?php echo $tVars['img']; ?>" width="32" height="32" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" /></div>
	<div><?php echo $item->getItemInfo($player); ?></div>
	<div><?php echo $name.' - '.$item->getItemDescription(); ?></div>
	<table>
		<?php
		foreach ($item->getItemModifiers($player) as $k => $v)
		{
			echo sprintf('<tr><td>%s</td><td>%s</td></tr>', $k, $v);
		}
		if (NULL !== ($mods = $item->getItemModifiersB()))
		{
			foreach ($mods as $k => $v)
			{
				echo sprintf('<tr><td>%s</td><td>%s</td></tr>', $k, $v);
			}
		}
		?>
	</table>


	<?php # buttons
	if ($item instanceof SR_Equipment) {
		if ($item->isEquipped($player)) {
			echo Module_Lamb::unequipButton($item, $player);
		}
		else {
			echo Module_Lamb::equipButton($item, $player);
			echo Module_Lamb::dropButton($item, $player);
		}
		
		if ($location !== false && $location instanceof SR_Store) {
			echo Module_Lamb::sellButton($item, $player);
		}
	}
	echo Module_Lamb::useButton($item, $player);
	?>
	
</div>