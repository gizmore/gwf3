<applet id="ssy_applet2" code="com.assessystem.SSYMain" archive="<?php echo GWF_WEB_ROOT; ?>applet/surveystudios5i.jar">
	<param name="width" value="640" />
	<param name="height" value="480" />
<!-- 	<param name="locale" value="<?php echo $tVars['locale']; ?>" />  -->
	<param name="host" value="<?php echo rtrim(sprintf("%s://%s%s", Common::getProtocol(), Common::getHost(), GWF_WEB_ROOT), '/').'/'; ?>" />
	<param name="uid" value="<?php echo $tVars['uid']; ?>" />
	<param name="sid" value="<?php echo $tVars['cookie']; ?>" />
	<param name="quit" value="<?php echo 'account'; ?>" />
	<?php echo $tVars['module']->error('err_no_java'); ?>
</applet>
<script type="text/javascript">
window.onresize = ssyResize;
window.onload = ssyResize;
ssyResize();
</script>
