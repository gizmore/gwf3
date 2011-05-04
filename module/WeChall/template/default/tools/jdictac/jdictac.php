<?php $path = GWF_WEB_ROOT.'applet/JDicTac.jar';
echo GWF_Box::box($tVars['lang']->lang('page_info', $path));
?>
<applet code="org.gizmore.jdictac.JDicTac" archive="<?php echo $path; ?>" width="800" height="600" align="middle">
</applet>
