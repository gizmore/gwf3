<?php
chdir("../../../");
define('GWF_PAGE_TITLE', 'Training: Get Sourced');
require_once("challenge/html_head.php");
require(GWF_CORE_PATH.'module/WeChall/solutionbox.php');
if (false === ($chall = WC_Challenge::getByTitle('Training: Get Sourced'))) {
	$chall = WC_Challenge::dummyChallenge('Training: Get Sourced');
}
$chall->showHeader();
$chall->onCheckSolution();
?>
<div class="box box_c">
	<p><?php echo $chall->lang('info'); ?></p>
	<p style="color:#e5e5e5;"><?php echo $chall->lang('info2'); ?></p>
</div>
<!-- <?php echo $chall->lang('comment'); ?> -->
<?php
formSolutionbox($chall);
require_once("challenge/html_foot.php");
?>
<!-- <?php echo $chall->lang('comment'); ?> -->




































                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                          
                                                                                                                                                                                                                                                       <!-- <?php echo $chall->lang('solution'); ?> -->                                                                                                                                                                                                                                                                                                            
