<?php
$item = $tVars['item']; $item instanceof SR_Item;
$player = $tVars['player']; $player instanceof SR_Player;
$name = $item->getItemName();
?>
<div>
	<div><img src="<?php echo $tVars['img']; ?>" width="32" height="32" alt="<?php echo $name; ?>" title="<?php echo $name; ?>" /></div>
	<div><?php echo $name; ?></div>
	<div><?php echo $item->getItemInfo($player); ?></div>
	<div>
	<?php
		echo Module_Lamb::buyButton($item, $player);
	?>
	</div>
</div>
