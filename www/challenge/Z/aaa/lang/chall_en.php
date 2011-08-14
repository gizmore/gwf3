<?php
$lang = array(
	'thanks' => 'Thanks go out to %1% and %2% for beta-testing the challenge.',
	'index_info' =>
		'You are in the role of a secret hacker. As always.<br/>'.
		'Your next job is the following:<br/>'.
		'<br/>'.
		'VSA (Very Secret Agency) has followed very strict security policies for years, it is almost impossible to break into their network.<br/>'.
		'Unfortunately, that\'s what your boss wants from you.<br/>'.
		'After some social engineering you gathered, that VSA wants to order some simple programs from SoftMicro software development corporation.<br/>'.
		'SoftMicro is the old partner for VSA, and he has implemented lots of backdoors for a commercial operating system named "Doors" for VSA.<br/>'.
		'SoftMicro\'s software is usually crappy, but their network is very well defended - thanks to the very often attacks against SoftMicro\'s network.<br/>'.
		'But VSA doesn\'t accept any code from SoftMicro directly, because they hired a well known company named Anderson to audit every piece of code that are used at VSA.<br/>'.
		'Your plan is to hijack the communication between Andersen and SoftMicro, so you can analyse the program, and after Andersen audited the program, you will hijack the traffic between Andersen and VSA, exchange the program with your evil one, and the job is done.<br/>'.
		'<br/>'.
		'The plan is great, but maybe not everything goes as planned...<br/>'.
		'<br/><br/>'.
		'Your first task is to hijack the communication between Anderson\'s and SoftMicro\'s network.<br/>'.   
		'<br/>'.
		'Here is the information you have already gathered:<br/>'.
		'The SoftMicro\'s network is 207.46.197.0  <br/>'.
		'Your public IP is 17.149.160.49 <br/>'.
		'<br/>'.
		'Anderson\'s main page is <a href="%1%">Anderson</a><br/>'.
		'<br/>'.
		'As you make progress on the challenge, you will get six pieces of a secret code, which is the proof that you have solved the challenge.<br/>'.
		'So, don\'t forget to write down those secret code pieces.<br/>',

	# router.php
	'err_router' => 'Invalid username/password.',
	'cfg_cmd' => 'Config command',
	'router_info' =>
		'Login successful.<br/>'.
		'You can configure your router here, the syntax is the same as on all *NIX boxes.<br/><br/>'.
		'Example: route add -net x.x.x.x netmask 255.255.255.0 gw x.x.x.x<br/><br/>',

	# upload_md5.php
	'upload_info' =>
		'Your next task is to create two different binaries, whose md5sum is the same.<br/>'.
		'The first binary must be sent to Anderson for software analysis, and the second has to be sent to VSA in the next part of your mission.<br/>'.
		'<br/>'.
		'The first good program has to print<br/>'. 
		'<i>"Hello VSA employee"</i><br/>'.
		'and your second, evil one has to print<br/>'. 
		'<i>"I am a super VIRUS, game over."</i><br/>'.
		'<br/><br/>'.
		'This script verifies if the two different binaries are doing as specified, and if the md5sum is equal for them.<br/>'.
		'<br/>'.
		'As SoftMicro\'s developers are in late to finish their job, maybe you can find the collision before they want it to send to Anderson.<br/>'.
		'<br/>'.
		'Note: The script only checks if the good file contains the good string, the evil contains the evil string, and md5sum differs from the sha1 sum.<br/>'.
		'On my average PC it took 8 hours to find a collision, but there is a quicker and smarter way...<br/>',
	'hidden_hint' => 'Hidden hint: search for md5 collision.',

	# upload_md5_file.php
	'err_file_size' => 'Your file is too large.<br/>',
	'err_upload_fail' => 'File could not be uploaded!<br/>',
	'err_wrong' => 'Error: The files are not different.<br/>',
	'err_md5' => 'Error: The md5sums are not equal.<br/>',
	'err_upload_grbge' => 'Error: The files are not doing what they should do.<br/>',
	'msg_uploaded_collision' =>
		'Good job.<br/>'.
		'2nd part of the secret string: %1%<br/>'.
		'<br/>'.
		'Your journey continues here:<br/>'.
		'<a href="%2%">Fingerprinting</a>',
);
?>
