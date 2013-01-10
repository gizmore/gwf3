<?php $faux = SSYHTML::$wantRightPanel === true ? ' class="ssy_fauxed"' : ''; ?>
<body>
<div id="ssy_wrap"<?php if (SSYHTML::$wantFooter) { echo ' style="margin-bottom: -30px;"'; }?> class="ssy1600h<?php if (SSYHTML::$wantRightPanel) echo '_faux'; ?>">
<?php if (SSYHTML::$wantRightPanel) { ?>
	<div id="ssy_right">
		<?php echo SSYHTML::getRosePlain(); ?>
		<br/>
		<?php echo SSYHTML::getMenuS(); ?>
	</div>
<?php } ?>
	<div id="ssy_main"<?php echo $faux; ?>>
		%PAGE%
		<?php if (SSYHTML::$wantFooter) {
			echo '<div id="ssy_footersp"></div>'; 
		}?>
	</div>
	<div class="cl"></div>
	
</div>
<?php echo SSYHTML::getFooter(); ?>
<?php #echo SSYHTML::getLangMenu(); ?>
<?php echo SSYHTML::getAngel(); ?>
</body>
