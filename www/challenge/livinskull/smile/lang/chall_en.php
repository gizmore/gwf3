<?php
$lang = array(
	'title' => 'Smile!',
	'info' =>
		'We are working hard on a better WeChall, and ask for your help.<br/>'.
		'In particular we want new smileys beeing added to the bb_decoder.<br/>'.
		'To add cool smileys, we have coded up a <a href="%5$s">small form</a> to submit them.<br/>'.
		'<br/>'.
		'Would be cool if you could add a few smileys and replacing rules for us!<br/>'.
		'<br/>'.
		'Oh ... again you are given the sourcecode.<br/>'.
		'There are two files: <a href="%1$s">smile.php</a> (<a href="%2$s">highlighted</a>)<br/>'.
		'And: <a href="%3$s">Livin_Smile.php</a> (<a href="%4$s">highlighted</a>)',

	# Form
	'ft_add' => 'Add a smiley',
	'btn_add' => 'Add rule',
	'th_pattern' => 'Smiley pattern',
	'tt_pattern' => 'Example patterns: /:\\\\)/ or /:o/i',
	'th_filename' => 'Smiley image',
	'tt_filename' => 'Example filename: challenge/livinskull/smile/smiles/lol.jpg',
	'th_upload' => 'Upload smiley',
	'btn_upload' => 'Upload',
	
	'test_input' => 'Smiley sample input',
	'test_output' => 'Smiley sample output',
	'test_input_msg' => 'This is a test',

	'all_smileys_input' => 'All smileys sample input',
	'all_smileys_output' => 'All smileys sample output',

	'err_test' => 'Your smiley rule did not pass the test :(',
	'err_pattern' => 'Your pattern looks invalid. Please wrap then into // delimiters.',
	'err_no_image' => 'Please upload images only.',
	'err_path' => 'Your rule has no valid smiley image, and thus did not get added.',
	'err_xss' => 'Your smiley path seems to contain dangerous input.',

	'msg_rule_added' => 'Thank you for adding another smiley rule!',
	'msg_uploaded' => 'Thank you for uploading a smiley. Use this as replacement for your patterns: %1$s',
);
?>