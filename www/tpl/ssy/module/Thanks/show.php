<?php SSYHTML::$menuID = SSY_MENU_THANKS; ?>
<?php echo SSYHTML::getBoxTitled($tLang->lang('thx_title'), $tLang->lang('thx_info')); ?>
<!-- 
<span class="ssy_bg800R" style="padding: 2px; margin-top: 40px;">
<span class="ssy_bg800" style="padding: 2px;"> -->
<span class="ib" style="margin-top: 40px;">
	<span class="fl ssy_leftlinks">
<?php 
$i = 0;
foreach ($tVars['thanks'] as $t)
{ 
	$href = $t->getShowHREF();
	echo sprintf('<a href="%s">%s<br/>%s</a>', $href, $t->displayCat(), $t->display('thx_businame'));
}
?>
	</span>
	<span class="ssy480h ssy_rightcontainer" style="min-width: 320px; max-width: 400px;">
		<span class="ib" style="padding: 10px;">
			<?php if (false !== ($c = $tVars['current'])) { ?>
			<span class="b"><?php echo $c->displayCat(); ?></span>
			<span class="b"><?php echo $c->display('thx_businame'); ?></span>
			<br/>
			<span class="b"><?php echo $c->displayFullName(); ?></span>
			<span class="b"><?php echo $c->displayPosition(); ?></span>
			<br/>
			<span class="b"><?php echo $c->display('thx_busistreet'); ?></span>
			<span class="b"><?php echo $c->displayPLZCity(); ?></span>
			<span class="b"><?php echo $c->displayCountry(); ?></span>
			<br/>
			<span class="b"><?php echo $c->display('thx_tel1'); ?></span>
			<span class="b"><?php echo $c->display('thx_tel2'); ?></span>
			<span class="b"><?php echo $c->display('thx_fax'); ?></span>
			<br/>
			<span class="b"><?php echo $c->display('thx_email'); ?></span>
			<span class="b"><?php echo $c->display('thx_homepage'); ?></span>
			<?php } ?>
		</span>
	</span>
	<span class="cl"></span>
<!-- 
</span>
</span>
-->
</span>