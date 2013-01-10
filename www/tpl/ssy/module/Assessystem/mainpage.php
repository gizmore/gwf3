<div><?php echo SSYHTML::getRosePlain(); ?></div>
<!-- 
<div class="ssy_logotext"></div>
-->

<h1 class="ssy_sitename" style="margin: 20px auto;">
	<?php if (strpos($_SERVER['HTTP_HOST'], 'essey.de') !== false) {
		echo 'Essey.de';
	} else {
		echo GWF_SITENAME;
	}
	?>
</h1>


<div style="margin-top: 18px;"><?php echo $tLang->lang('home_info'); ?></div>

<?php # var_dump(GWF_Language::getBrowserLang()); ?>

<div id="ssy_mainmenu"><span class="ssy_border"><?php echo SSYHTML::getMenuS(); ?></span></div>
