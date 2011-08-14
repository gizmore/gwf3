<div class="gwf_pagemenu">
<span>
<?php
foreach ($tVars["pagelinks"] as $id => $link)
{
	if ($link === false) {
		echo "...";
	}
	elseif ($link === '') {
		echo "<a class=\"gwf_pagemenu_sel\" $link>[$id]</a>";
	}
	else {
		echo "<a $link>[$id]</a>";
	}
}
?>
</span>
</div>
