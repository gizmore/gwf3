<body>
	<?php echo Module_Assessystem::getLangMenu(); ?>
	<div id="ssy_wrap">
		%PAGE%
		<?php if (Module_Assessystem::wantFooter()) { ?>
		<div id="ssy_footsp"></div>
		<?php } ?>
	</div>
	<?php if (Module_Assessystem::wantFooter()) { ?>
		<?php echo Module_Assessystem::getFooter(); ?>
	<?php } ?>
	<?php echo Module_Assessystem::getAngel(); ?>
</body>
