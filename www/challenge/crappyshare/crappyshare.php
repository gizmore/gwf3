<?php require_once 'solution.php'; # <-- Look closer to this file! ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
			<style type="text/css">
			* {
				margin: 0;
				padding: 0;
			}
			html {
				height: 100%;
				font-family: Arial;
			}
			body {
				min-height: 100%;
				height: auto;
				background: url(img/bg.png) repeat-x #9BC9E5;
			}
			.error {
				font-weight: bolder;
				background: url(../../img/cross_shield_2.png) center left no-repeat;
				padding-left: 18px;
				color: #f00;
				padding: 5px 20px;
				font-size: 17px;
			}
			h1 {
			}
			#title {
				padding-top: 4px;
				font-size: 22px;
			}
			#subtitle {
				font-size: 16px;
			}
			#main {
				width: 800px;
				margin: 0 auto;
			}
			#logo {
				margin-top: 20px;
				background: url(img/logo.png) no-repeat;
				float: left;
				padding-left: 78px;
				height: 80px;
			}
			.thin {
				height: 2px;
				background: url(img/thin.png) no-repeat;
			}
			.cl {
				height: 0px;
				clear: both;
			}
			#box {
				margin-top: -9px;
				width: 790px;
			}
			#box_top {
				height: 149px;
				background: url(img/bbox_top.png);
				width: 790px;
			}
			#box_mid {
				background: url(img/bbox_middle.png) repeat-y;
				padding: 0 30px;
				width: 790px;
			}
			#box_content {
				position: relative;
				top: -55px;
				padding: 20px;
			}
			#box_bot {
				height: 30px;
				background: url(img/bbox_bottom.png);
				width: 790px;
			}
			
			#header {
				margin-left: 50px;
				height: 100px;
			}
			form div div {
				float: left;
				font-size: 17px;
				width: 120px;
			}
			.thin2 {
				background: url(img/thin2.png) repeat-x;
				width: 700px;
				height: 2px;
				margin: 5px 0;
				
			}
			#copy {
				color: #005;
				padding: 2px;
				font-size: 12px;
				font-weight: bold;
				margin-bottom: -5px;
				text-align: right;
				margin-right: 70px;
			}
			.thx_result {
				width: 675px;
				border: 2px groove #aaf;
				padding: 5px;
				margin: 5px 2px;
			}
			#partners {
				padding: 5px 12px;
			}
			#images_hack {
				background: url(img/birdy.png) no-repeat center left;
				height: 32px;
				line-height: 32px;
				padding-left: 36px;
			}
		</style>
		<title>CrappyShare</title>
	</head>
	<body>
		<div id="main">
			<div id="header">
				<div id="logo">
					<div id="title">Crappy<b>Share</b></div>
					<div class="thin"></div>
					<div id="subtitle">Share your files with everyone</div>
				</div>
				<div class="cl"></div>
			</div>
			<div id="box">
				<div id="box_top"></div>
				<div id="box_mid">
					<div id="box_content">
					<?php 
					# File Upload
					if (isset($_FILES['file']) && is_array($_FILES['file']) && $_FILES['file']['size'] > 0)
					{
						upload_please_by_file($_FILES['file']);
					}
					# URL Upload
					$url = isset($_POST['url']) && is_string($_POST['url']) ? $_POST['url'] : '';
					$url = trim($url);
					if ($url !== '')
					{
						upload_please_by_url($url);
					}
					?>
					<div>
						<form enctype="multipart/form-data" action="crappyshare.php" method="post">
							<div><div>Upload File:</div><input type="file" name="file" /></div>
							<div class="thin2"></div>
							<div><div>Or By URL:</div><input type="text" name="url" value=""/></div>
							<div style="height: 10px;"></div>
							<div><input type="image" name="upload" src="img/upload.png" value="Upload Please!"/></div>
						</form>
					</div>
					</div>
					<div id="partners"><div id="images_hack">Powered by <a href="http://www.happy-security.de/utilities/hz/images-hack/">Images-Hack</a>.</div></div>
				</div>
				<div id="box_bot"></div>
			</div>
		</div>
	</body>
</html>
<?php
function htmlDisplayError($error)
{
	echo '<div class="error">'.$error.'</div>';
	return false;
}

function htmlTitleBox($title, $text)
{
	echo '<div class="box">';
	echo '<div class="title">'.$title.'</div>';
	echo '<p>'.$text.'</p>';
	echo '</div>';
}

/**
 * Upload received by file, call thx. Delete temp file if neccessary.
 * @param array $file
 * @return NULL
 */
function upload_please_by_file(array $file)
{
	if ($file['error'] === 0 || $file['size'] > 0) # Is File?
	{
		// Thanks
		upload_please_thx(file_get_contents($file['tmp_name']));
		
		// Delete temp file
		if (false === @unlink($file['tmp_name']))
		{
			htmlDisplayError('Can not delete file. (should not see me)');
		}
	}
	else
	{
		htmlDisplayError('File is errorneous');
	}
}

/**
 * Retrieve uploaded file from url and call thx.
 * @param string $url
 * @return NULL
 */
function upload_please_by_url($url)
{
	if (1 === preg_match('#^[a-z]{3,5}://#', $url)) # Is URL?
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		if (false === ($file_data = curl_exec($ch)))
		{
			htmlDisplayError('cURL failed.');
		}
		else
		{
			// Thanks
			upload_please_thx($file_data);
		}
	}
	else
	{
		htmlDisplayError('Your URL looks errorneous.');
	}
}

/**
 * Thank you for upload. we might store the file and earn money.
 * Thank you again :)
 * @param string $file_data
 * @return NULL
 */
function upload_please_thx($file_data)
{
	htmlTitleBox('Thank You For Uploading:', '<div class="thx_result">'.nl2br(htmlspecialchars(substr($file_data,0, 1024)).'</div>'));
}
?>
