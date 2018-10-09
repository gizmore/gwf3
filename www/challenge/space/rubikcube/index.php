<?php

# WeChall things
chdir('../../../');
define('GWF_PAGE_TITLE', "Rubik's Cube");
require_once('challenge/gwf_include.php');

GWF_Website::addCSS('rubik.css');
GWF_Website::addJavascript('yui/yui/yui-min.js');
GWF_Website::addJavascript('rubik.js');
GWF_Website::addJavascript('message-scroll.js');

require_once('challenge/html_head.php');
require_once 'challenge/space/rubikcube/cube.php';
require_once 'challenge/space/rubikcube/api.php';

if (false === ($chall = WC_Challenge::getByTitle(GWF_PAGE_TITLE)))
{
	$chall = WC_Challenge::dummyChallenge(GWF_PAGE_TITLE, 2, 'challenge/space/rubikcube/index.php', false);
}

$chall->showHeader();

$msg = CubeChallenge::onMove();
$cube = new CubeChallenge($chall);
$c = $cube->getCube();

$info = $chall->lang('info');
$info .= '<div id="answers">' . $msg . '<noscript id="cubestring">' . $c . '</noscript></div>
<div id="rotation" style="cursor: grab;">Press "R" once and drag the cursor to move the cube!</div>
<noscript>
Please enable javascript to see a 3D version!
<div class="rubiknoscript">
' . Cube::cube2Text($c, false, true) . '
</div>
Rotate:<br/>
<a href="?move=X">X</a> <a href="?move=Y">Y</a> <a href="?move=Z">Z</a> <a href="?move=F">Front</a>
<a href="?move=L">Left</a> <a href="?move=R">Right</a> <a href="?move=U">Up</a> <a href="?move=D">Down</a>
<a href="?move=B">Back</a> <a href="?move=M">Middle</a> <a href="?move=S">Standing</a> <a href="?move=E">Equatorial</a>
<br/>
<a href="?move=X\'">X\'</a> <a href="?move=Y\'">Y\'</a> <a href="?move=Z\'">Z\'</a> <a href="?move=F\'">Front\'</a>
<a href="?move=L\'">Left\'</a> <a href="?move=R\'">Right\'</a> <a href="?move=U\'">Up\'</a> <a href="?move=D\'">Down\'</a>
<a href="?move=B\'">Back\'</a> <a href="?move=M\'">Middle\'</a> <a href="?move=S\'">Standing\'</a> <a href="?move=E\'">Equatorial\'</a>
<br/>
<a href="?move=X2">X2</a> <a href="?move=Y2">Y2</a> <a href="?move=Z2">Z2</a> <a href="?move=F2">Front2</a>
<a href="?move=L2">Left2</a> <a href="?move=R2">Right2</a> <a href="?move=U2">Up2</a> <a href="?move=D2">Down2</a>
<a href="?move=B2">Back2</a> <a href="?move=M2">Middle2</a> <a href="?move=S2">Standing2</a> <a href="?move=E2">Equatorial2</a>
</noscript>
';

echo GWF_Box::box($info, $chall->lang('title'));
?>

<section id="messages">
<div class="wrapper">
	<ul class="active">
		<li class="prev"></li>
		<li class="current"></li>
		<li class="next"></li>
	</ul>

	<div class="populate">
	</div>
</div>
</section>

<section id="rubik">
<div id="cube-container">
	<div id="cube-viewport">
		<div id="cube">
		<!-- UP FACE -->
			<!-- LEFT COLUMN (L)  -->
			<div class="utl cubie up LM UE BS U1"><div><span>U1</span></div></div>
			<div class="ucl cubie up LM UE CS U2"><div><span>U2</span></div></div>
			<div class="ubl cubie up LM UE FS U3"><div><span>U3</span></div></div>
			<!-- CENTER COLUMN (C)  -->
			<div class="utc cubie up CM UE BS U4"><div><span>U4</span></div></div>
			<div class="ucc cubie up CM UE CS U5"><div><span>U5</span></div></div>
			<div class="ubc cubie up CM UE FS U6"><div><span>U6</span></div></div>
			<!-- RIGHT COLUMN (R)  -->
			<div class="utr cubie up RM UE BS U7"><div><span>U7</span></div></div>
			<div class="ucr cubie up RM UE CS U8"><div><span>U8</span></div></div>
			<div class="ubr cubie up RM UE FS U9"><div><span>U9</span></div></div>
		<!-- END UP FACE -->

		<!-- FRONT FACE -->
			<!-- LEFT COLUMN (L)  -->
			<div class="ftl cubie front LM UE FS F1"><div><span>F1</span></div></div>
			<div class="fcl cubie front LM CE FS F2"><div><span>F2</span></div></div>
			<div class="fbl cubie front LM DE FS F3"><div><span>F3</span></div></div>
			<!-- CENTER COLUMN (C)  -->
			<div class="ftc cubie front CM UE FS F4"><div><span>F4</span></div></div>
			<div class="fcc cubie front CM CE FS F5"><div><span>F5</span></div></div>
			<div class="fbc cubie front CM DE FS F6"><div><span>F6</span></div></div>
			<!-- RIGHT COLUMN (R)  -->
			<div class="ftr cubie front RM UE FS F7"><div><span>F7</span></div></div>
			<div class="fcr cubie front RM CE FS F8"><div><span>F8</span></div></div>
			<div class="fbr cubie front RM DE FS F9"><div><span>F9</span></div></div>
		<!-- END FRONT FACE -->

		<!--DOWN FACE -->
			<!-- LEFT COLUMN (L)  -->
			<div class="dtl cubie down LM DE FS D1"><div><span>D1</span></div></div>
			<div class="dcl cubie down LM DE CS D2"><div><span>D2</span></div></div>
			<div class="dbl cubie down LM DE BS D3"><div><span>D3</span></div></div>
			<!-- CENTER COLUMN (C)  -->
			<div class="dtc cubie down CM DE FS D4"><div><span>D4</span></div></div>
			<div class="dcc cubie down CM DE CS D5"><div><span>D5</span></div></div>
			<div class="dbc cubie down CM DE BS D6"><div><span>D6</span></div></div>
			<!-- RIGHT COLUMN (R)  -->
			<div class="dtr cubie down RM DE FS D7"><div><span>D7</span></div></div>
			<div class="dcr cubie down RM DE CS D8"><div><span>D8</span></div></div>
			<div class="dbr cubie down RM DE BS D9"><div><span>D9</span></div></div>
		<!-- END DOWN FACE -->

		<!--BACK FACE -->
			<!-- LEFT COLUMN (L)  -->
			<div class="btl cubie back LM DE BS B1"><div><span>B1</span></div></div>
			<div class="bcl cubie back LM CE BS B2"><div><span>B2</span></div></div>
			<div class="bbl cubie back LM UE BS B3"><div><span>B3</span></div></div>
			<!-- CENTER COLUMN (C)  -->
			<div class="btc cubie back CM DE BS B4"><div><span>B4</span></div></div>
			<div class="bcc cubie back CM CE BS B5"><div><span>B5</span></div></div>
			<div class="bbc cubie back CM UE BS B6"><div><span>B6</span></div></div>
			<!-- RIGHT COLUMN (R)  -->
			<div class="btr cubie back RM DE BS B7"><div><span>B7</span></div></div>
			<div class="bcr cubie back RM CE BS B8"><div><span>B8</span></div></div>
			<div class="bbr cubie back RM UE BS B9"><div><span>B9</span></div></div>
		<!--END BOTTOM FACE -->

		<!--LEFT FACE -->
			<!-- LEFT COLUMN (L)  -->
			<div class="ltl cubie left LM UE BS L1"><div><span>L1</span></div></div>
			<div class="lcl cubie left LM CE BS L2"><div><span>L2</span></div></div>
			<div class="lbl cubie left LM DE BS L3"><div><span>L3</span></div></div>
			<!-- CENTER COLUMN (C)  -->
			<div class="ltc cubie left LM UE CS L4"><div><span>L4</span></div></div>
			<div class="lcc cubie left LM CE CS L5"><div><span>L5</span></div></div>
			<div class="lbc cubie left LM DE CS L6"><div><span>L6</span></div></div>
			<!-- RIGHT COLUMN (R)  -->
			<div class="ltr cubie left LM UE FS L7"><div><span>L7</span></div></div>
			<div class="lcr cubie left LM CE FS L8"><div><span>L8</span></div></div>
			<div class="lbr cubie left LM DE FS L9"><div><span>L9</span></div></div>
		<!--END LEFT FACE -->

		<!--RIGHT FACE -->
			<!-- LEFT COLUMN (L)  -->
			<div class="rtl cubie right RM UE FS R1"><div><span>R1</span></div></div>
			<div class="rcl cubie right RM CE FS R2"><div><span>R2</span></div></div>
			<div class="rbl cubie right RM DE FS R3"><div><span>R3</span></div></div>
			<!-- CENTER COLUMN (C)  -->
			<div class="rtc cubie right RM UE CS R4"><div><span>R4</span></div></div>
			<div class="rcc cubie right RM CE CS R5"><div><span>R5</span></div></div>
			<div class="rbc cubie right RM DE CS R6"><div><span>R6</span></div></div>
			<!-- RIGHT COLUMN (R)  -->
			<div class="rtr cubie right RM UE BS R7"><div><span>R7</span></div></div>
			<div class="rcr cubie right RM CE BS R8"><div><span>R8</span></div></div>
			<div class="rbr cubie right RM DE BS R9"><div><span>R9</span></div></div>
		<!--END LEFT FACE -->

		 </div>
	</div>
</div>
</section>

<script>
YUI().use('node','rubik','message-scroll', function(Y) {
	var scrollpanel = new Y.MessageScroll();
	var cube = window.cube = new Y.Rubik({
		cube: <?php print(json_encode($c)); ?>
	});
	cube.run();
});
</script>

<?php
echo $chall->copyrightFooter();
require_once('challenge/html_foot.php');
