<?php
$lang = array(
	
	# Menu
	'menu_dl' => 'Download',
	'menu_about' => 'About',
	'menu_tut' => 'Tutorial',
	'menu_contact' => 'Contact',
	'menu_gb' => 'Guestbook',
	'menu_links' => 'Links',
	'menu_login' => 'Login',
	'menu_logout' => 'Logout',
	'menu_register' => 'Register',
	'menu_admin' => 'Admin',
	'menu_pm' => 'PM',
	'menu_forum' => 'Forum',
	'menu_chat' => 'Chat',
	'menu_account' => 'Account',
	'menu_news' => 'News',
	'menu_helpdesk' => 'Helpdesk',
	'menu_profile' => 'Edit your profile',

	# About&FaQ
	'pt_about' => 'About PoolTool',
	'mt_about' => 'PoolTool, About, PoolTool, Playray, Billard, Pool, Cheating, Aiming, Tool, Toss, Calculation, Toss calculation, Java',
	'md_about' => 'PoolTool is a toss calculation tool, for playray; Open-Source and in Java, it is a trusted tool for the curious.',

	'about' => 
		'PoolTool is an Billard cheating/helper program, coded by <em>theAnswer</em> and <em>Gizmore</em>, to aid you at Pool on <a href="http://playray.com">PlayRay</a>. It is written in plain <a href="http://www.java.com/en/download/manual.jsp">Java</a> and should run with Java version 5 and above. We created this program for educational purposes only, and <b>we do *not* use it against other human players</b>.<br/>'.
		'<br/>'.
		'<a href="http://en.wikipedia.org/wiki/Cheating_in_online_games">Cheating</a> spoils the fun of gaming and in the long run for <b>both</b> players. So please use it only for demonstrative or educational purposes.<br/>'.
		'<br/>'.
		'By the way: <b>PoolTool is no help for the experienced player.</b><br/>'.
		'Currently, PoolTool is only able to aid on PlayRay. Thus, other similar billard games would only need some code tweaking.<br/>'.
		'If you like to try out PootTool, take a look at the tutorial page.<br/>',
	'faq_info' => 'Here are some answers to frequently asked questions:',
	'faqq_1' => 'If you do not like cheating, why did you put it online?',
	'faqa_1' => 'I think there are several ways and programs to cheat. This is only of them, and fairly good, but I like to show it anyway. Also I invested time and work into this project and it would be sad if it only gets dusty on my harddisk. Last but not least I am a bit proud of it :)',
	'faqq_2' => 'Do you think there are people cheating on PlayRay?',
	'faqa_2' => 'I think a small minority of players doesn`t shrink away from cheating. However, proving that is a very difficult up to impossible task. You can`t prove the use of PoolTool or most other cheating programs, but you can guess it. If you hear from other programs that allow you to cheat on PlayRay, please let me know.',
	'faqq_3' => 'How can I <b>guess</b> if someone is cheating?',
	'faqa_3' => 'As I said, you can only guess, and some players are really, really good, but when a medium-strength player suddenly makes very difficult tosses without any aiming it seems very weird to me. Keep in mind, you can only guess, and some people are just lucky. A good way to guess is maybe watch the players queue movements. Also you should play with a low timelimit, to make cheating more difficult.',
	'faqq_4' => 'Can you code me a similar program for XYZ?',
	'faqa_4' => 'This depends on the program.',
	'faqq_5' => 'Do you like writing me similar programs?',
	'faqa_5' => 'This depends, beside the program, on my motivation.',
	'faqq_6' => 'Would you please remove this website?',
	'faqa_6' => 'No I won`t. The software would be available from people that already got it, so it would make no sense to remove it now.',
	'faqq_7' => 'You are such a cheater! Why the heck do you cheat?!?!',
	'faqa_7' => 'Please read the page attentive and in order. Wut? You are here again? So please repeat your question a) backwards, b) in another language, c) in rot26',

	# Tutorial
	'start_pr' => 'Start Playray',
	'start_pt' => 'Start Pooltool',
	'load_table' => 'Make a screenshot of the pool table',
	'select_ball' => 'Select a ball by clicking it in PoolTool',
	'select_pocket' => 'Select a pocket by clicking it in PoolTool',
	'aim_or_shoot' => 'Press Aim or Shoot to toss',

	'pt_tut' => 'PoolTool Tutorial and Documenation',
	'mt_tut' => 'PootTool, Tutorial, Documentation, PlayRay, Pool, Billard, Cheat, Help, Calculation, Toss, Toss calculation',
	'md_tut' => 'PoolTool tutorial and documentation.',

	'tut_1' => 'You have to set some settings, to make pooltool work correctly:<br/><b>Disable shadows in playray.</b>',
	'tut_2' => 'First you have to start a billard or pool game on PlayRay.',
	'tut_3' =>
		'Of course you have to start PoolTool too. There are several ways for it on windows, which might work, but that depends on your configuration.<br/><br/>'.
		'1. Try to open PoolTool*.jar with a double click. <b>or</b><br/>'.
		'2. Rightclick PoolTool and select open with->Java. <b>or</b><br/>'.
		'3. Open a cmd shell. (For that press Start->execute, and type in "cmd")<br/>'.
		'&nbsp;&nbsp;&nbsp;Change the current working directory to PoolTool\'s location.<br/>'.
		'&nbsp;&nbsp;&nbsp;Execute this command: <b>java -jar PoolTool*</b><br/>',
	'tut_4' => 
		'Now lets focus on the usage:<br/><br/>'.
		'PoolTool works by creating <b>screenshots</b>. It scans the Balls positions, and can calculate tosses with this information. To take a screenshot you have to press <b>Load Table</b>. Some things have to be visible, to make PoolTool recognize the table and balls. <b>The upper left corner of the Applet has to be visible, as well as the balls to scan</b>.',
	'tut_5' =>
	"After the balls have been scanned, you can select a ball and a pocket. The selecting order doesn't matter. The program is kinda intuitive and aims over bounds or N balls, to get the selected ball into the selected pocket. The algorithm can be improved, though.<br/><br/>'.".
	'<b>To select a pocket or a ball, simply click it in PoolTool.</b><br/>'.
		'I am gonna click the green,full Ball in PoolTool. It changes its color to cyan when selected.<br/>',
	'tut_6' => 'Now I select the target pocket. Simply click it like the ball. Also the pocket changes color to cyan when selected.',
	'tut_7' =>
		'As you might have noticed, PoolTool immediately calculates its toss and outputs it in a graphical way. If a ball changes its color to red, it is blocking the toss, lying between selected ball and pocket. Impossible tosses are marked as impossible in the program. The white lines show the direction after a collision. (This is currently calculated completely wrong.)<br/><br/>'.
		'Now you can press <b>Aim</b> or <b>Shoot</b>. Aim sets the mouse to the calculated best shot. You can then hold the mouse button to specify the tosses strength. Shoot executes a rightclick at that position, a toss with full power. This may be more accurate, depending on your ability to handle a mouse.',

	# Matcher
	'matches' => '%s IPs have a positive match!',
	'ft_matcher' => 'Match IPs',
	'btn_match' => 'Match',
	'err_pass' => 'The password you provided is not correct.',
	'err_hour_a' => 'Beginning hour is invalid.',
	'err_hour_b' => 'Ending hour is invalid.',
	'th_pass' => 'Password',
	'th_day' => 'Day',
	'th_hour_a' => 'From Hour',
	'th_hour_b' => 'To Hour',
	'th_ips' => 'IPs',
		
	# monnino fixes
	'cfg_ptmpw' => 'PoolTool Password',
);
?>
