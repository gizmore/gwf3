<?php
require 'config.php';
$files = scandir(dirname(__FILE__));
$title = 'Error';
if (false === ($file = Common::getGetString('f', false)))
{
	$content = '<p>No file via GET parameter &quot;f&quot; specified. You can use hl=1 for highlighting btw.</p>';
}
elseif (!in_array($file, $files, true))
{
	$content = '<p>Only the files in the challenge directory are allowed :)</p>';
}
else
{
	$title = $file;
	$content = trim(file_get_contents("{$dldc}$file"));
	if (isset($_GET['dl']))
	{
		header('Content-Type: text/plain');
		dldc_die($content);
	}
	elseif (isset($_GET['hl']))
	{
		$content = '<div class="code">'.GWF_Message::display('[P'.'HP]'.$content.'[/P'.'HP]').'</div>';
	}
	else
	{
		$content = "<code>\n".htmlspecialchars($content)."\n</code>";
	}
}
?>
<?php require 'header.php'; ?>
<h1><?= $title ?></h1>
<?= $content ?>
<?php require 'footer.php'; ?>
