<body>

<!-->div class="sys_angel"></div><-->

<?php #echo GWF_TopMenu::display(); ?>

<?php if (!Module_Assessystem::$isApplet) { ?>
<div class="sys_wrap">
	<div class="sys_fl">
		<?php echo Module_Assessystem::getLangMenu(); ?>
		<?php echo Module_Assessystem::getSidemenu(); ?>
	</div>
	<div class="center"><a class="center sys_assess"><?php echo GWF_SITENAME; ?></a></div>
	<div>%PAGE%</div>
	<div class="sys_cl"></div>
</div>
<?php } ?>


<?php #echo GWF_Website::debugFooter(); ?>

</body>
