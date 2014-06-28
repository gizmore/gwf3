<?php
require 'config.php';
dldc_session_start();
require 'header.php';
?>
<?php
$CORRECT = 35346366;
function encrypt($input)
{
	return eval("return (('0x'.unpack('H*', '$input')) * 37 + 13);");
}
if (isset($_GET['encrypt']))
{
	$encrypt = encrypt(addslashes(Common::getGetString('input')));
	dldc_output("After encryption: $encrypt");
	if ($encrypt === $CORRECT)
	{
		dldc_challenge_solved('crypto101');
	}
}
?>
<h1>Crypto 101</h1>

<p>In this challenge you have to enter a plaintext that will match this output: <?=$CORRECT?>.</p>
<p>good luck!</p>

<div class="encrypt_input">
<form>
<div><input type="text" name="input" autocomplete="off" /><input type="submit" name="encrypt" value="go!" /></div>
</form>
</div>

<?php
require 'footer.php';
