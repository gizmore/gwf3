<?php
$player = $tVars['player']; $player instanceof SR_Player;
$hp = $player->getHP(); $mp = $player->getMP();
$hpm = $player->getMaxHP(); $mpm = $player->getMaxMP();
?>
<table>
<tr><td>LVL</td><td>HP</td><td>MP</td><td>ATT</td><td>DEF</td><td>MARM</td><td>FARM</td><td>NY</td><td>XP</td><td>KARMA</td><td>Weight</td><td>Max</td></tr>
<tr>
	<td><?php echo $player->getBase('level'); ?></td>
	<td><?php echo sprintf('%s/%s', $hp, $hpm);?></td>
	<td><?php echo sprintf('%s/%s', $mp, $mpm);?></td>
	<td><?php echo $player->get('attack'); ?></td>
	<td><?php echo $player->get('defense'); ?></td>
	<td><?php echo $player->get('marm'); ?></td>
	<td><?php echo $player->get('farm'); ?></td>
	<td><?php echo $player->getNuyen(); ?></td>
	<td><?php echo $player->getBase('xp'); ?></td>
	<td><?php echo $player->getBase('karma'); ?></td>
	<td><?php echo Shadowfunc::displayWeight($player->get('weight')); ?></td>
	<td><?php echo Shadowfunc::displayWeight($player->get('max_weight')); ?></td>
</tr>
<tr><?php foreach (SR_Player::$ATTRIBUTE as $short => $long) { echo sprintf('<td>%s</td>', $short); } ?></tr>
<tr>
<?php foreach (SR_Player::$ATTRIBUTE as $short => $long)
{
	$base = $player->getBase($long);
	$curr = $player->get($long);
	$curr = $curr == $base ? '' : "($curr)";
	echo sprintf('<td>%s%s</td>', $base, $curr);
}
?>
</tr>

<?php
	$skills = array();
	foreach (SR_Player::$SKILL as $short => $long) {
		$base = $player->getBase($long);
		if ($base < 0) {
			continue;
		}
		$skills[$short] =  array($base, $player->get($long));
	}
	if (count($skills) > 0)
	{
		echo '<tr>';
		foreach ($skills as $text => $data)
		{
			echo sprintf('<td>%s</td>', $text);
		}
		echo '</tr>';
		echo '<tr>';
		foreach ($skills as $text => $data)
		{
			$c = $data[0] != $data[1] ? '('.$data[1].')' : '';
			echo sprintf('<td>%s%s</td>', $data[0], $c);
		}
		echo '</tr>';
	}
?>

</table>
