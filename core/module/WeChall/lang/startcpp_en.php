<?php
$lang = array(
	'page_title' => 'Get Started with C++',
	'meta_tags' => 'Gizmore Tutorial, Get started with C++, Beginners, Beginner Tutorial',

	'box_1_t' => 'Get Started with C++',
	'box_1_b' =>
		'This tutorial is about how to get started with coding C++ on a windows computer, using open source tools.<br/>'.
		'Before you start reading: I am not a senior coder; this tutorial is for beginners.<br/>'.
		'<br/>'.
		'C++ is a compiled programming language, that means the sourcecode gets compiled into an executeable.<br/>'.
		'Thus, to code in C++, you will need a <i>compiler</i>, that generates programs out of C/++ sourcecode.<br/>'.
		'<br/>'.
		'In this tutorial we will setup the mingw compiler, and use Code::Blocks as an IDE (Integrated Developement Environment).<br/>'.
		'<br/>'.
		'So folks, what do we need to get started?<br/>'.
		'<br/>'.
		'<ul style="margin-left: 20px;"><li><a href="%s">MinGW Compiler</a></li><li><a href="%s">Code::Blocks</a></li></ul>',

	'box_2_t' => 'Installing MinGW',
	'box_2_b' =>
		'I have chosen to download the automatic MinGW installer.<br/>'.
		'Thats a small application that will download and install MinGW for you.<br/>'.
		'While choosing components, I also activated <b>make for MinGW</b> and <b>g++</b>. I am not quite sure, but I think we might need that.',

	'box_3_t' => 'Installing Code::Blocks',
	'box_3_b' =>
		'Installing Code::Blocks is easy as well.<br/>'.
		'I chose the binary windows package without MinGw. It seems possible to just use the package that includes MinGW, and skip installing MinGW yourself.<br/>'.
		'When running Code::Blocks first time, it will prompt you about the default compiler to use. Here you choose Gnu-GCC-Compiler (which should be autodetected).<br/>'.
		'If MinGW gets not detected, you have to set it up manually, which is easy, so dont worry. Go to the menu, <i>Settings->Compiler and Debugger</i>, select the gcc compiler and edit the toolchain executables (make it point to your MinGW directory).',

	'box_4_t' => 'Compiling hello world',
	'box_4_b' =>
		'Ok. lets try out if we can compile a program, to check if we set things up properly.<br/>'.
		'For that you create a new project, a <b>Console Application</b>. A console application will pop up a dos box.<br/>'.
		'Check out the <b>build</b> menu. there you can clean up compiled stuff, as well as compile new.<br/>'.
		'I suggest you to select <i>Build->Clean</i>, and afterwards <i>Build->Build and Run</i>. The sourcecode should compile without error, and display the string &quot;Hello World!&quot; in a black dos box.',
	
	'box_5_t' => 'Learning C/++',
	'box_5_b' =>
		'If you want to learn C++, it is a good start to begin with reading a book.<br/>'.
		'<br/>'.
		'Check out the following link for online books: <a href="%s">A list of free C++ books in english</a>.<br/>'.
		'For beginners I recommend these: <a href="%s">C++ in Action</a> and <a href="%s">Thinking in C++</a>.<br/>'.
		'Also recommended for very beginners is "Accelerated C++" which might be available in your local library.<br/>'.
		'<br/>'.
		'Recommended C/++ references: <a href="%s">dinkumware.com</a> and <a href="%s">cprogramming.com</a><br/>'.
		'<br/>'.
		'[A Book I found in german: <a href="%s">highscore.de</a>]<br/>'.
		'[Introduction to C++ in german: <a href="%s">Volkards C++ Kurs</a>]',
);
?>