<?php
$lang = array(
	'page_title' => 'Introducción a C++',
	'meta_tags' => 'Tutorial de Gizmore, Introducción a C++, Principiantes, Tutorial para principiantes',
	'box_1_t' => 'Introducción a C++',
	'box_1_b' =>
		'En este tutorial se trata de cómo empezar a programar en C++ dirigido a equipos con Windows, usando herramienta de código abierto.<br/>'.
		'Antes de empezar: no soy un programador senior, este tutorial va dirigido a principiantes.<br/>'.
		'<br/>'.
		'C++ es un lenguaje de programación compilado, esto significa que el código fuente es compilado en un ejecutable.<br/>'.
		'Por lo tanto, para programar en C++, necesitarás un <i>compilador</i>, el cual genera programas apartir de código fuente en C++.<br/>'.
		'<br/>'.
		'En este tutorial vamos a configurar el compilador MinGW, y usar Code::Blocks como IDE (entorno integrado de desarrollo).<br/>'.
		'<br/>'.
		'Así que amigos, ¿qué necesitamos para empezar?<br/>'.
		'<br/>'.
		'<ul style="margin-left: 20px;"><li><a href="%s">Compilador MinGW</a></li><li><a href="%s">Code::Blocks</a></li></ul>',
	'box_2_t' => 'Instalando MinGW',
	'box_2_b' =>
		'He elegido descargar el instalador automático de MinGW.<br/>'.
		'Es una pequeña aplicación que descargará e instalará MinGW por ti.<br/>'.
		'Mientras elegía componentes, activé también <b>make para MinWG</b> y <b>g++</b>. No estoy muy seguro, pero creo que lo podremos necesitar.',
	'box_3_t' => 'Instalando Code::Blocks',
	'box_3_b' =>
		'Instalar Code::Blocks es fácil también.<br/>'.
		'Elegí el paquete binario de Windows sin MinGW. Parece posible solo usar el paquete que incluye MinGW, y omitir la instalación anterior de MinGW.<br/>'.
		'Al ejecutar Code::Blocks por primera vez, te preguntará acerca del compilador por defecto para usar. En este punto eliges Gnu-GCC-Compiler (el cual debe ser auto detectado).<br/>'.
		'Si MinGW no es detectado, lo debes configurar manualmente, lo cual es fácil, no te preocupes. Ve al menú <i>Settings->Compiler and Debugger</i>, selecciona el compilador gcc y edita la cadena de ejecutables (hazla apuntar hacia tu directorio de MinGW).',
	'box_4_t' => 'Compilando hola mundo',
	'box_4_b' =>
		'Bien. Tratemos de compilar un programa, para verificar si la configuración fue correcta.<br/>'.
		'Para ello debes crear un nuevo proyecto, una <b>Console Application</b>. Una aplicación de consola mostrará una ventana de línea de comandos.<br/>'.
		'Revisa el menú <b>build</b>, allí puedes limpiar los proyectos compiladas, además de compilar nuevos.<br/>'.
		'Te sugiero que selecciones <i>Build->Clean</i>, y luego <i>Build->Build and Run</i>. El código fuente deberá compilar sin errores, y mostrar la cadena &quot;Hello World!&quot; en una línea de comandos.',
	
	'box_5_t' => 'Aprendiendo C/++',
	'box_5_b' =>
		'Si quieres aprender C++, un buen comienzo es empezar leyendo un libro.<br/>'.
		'<br/>'.
		'Revisa los siguientes enlaces de libros en línea:: <a href="%s">Lista de libros en inglés de C++ gratis</a>.<br/>'.
		'Para principiantes recomiendo estos: <a href="%s">C++ in Action</a> y <a href="%s">Thinking in C++</a>.<br/>'.
		'También recomendado para principiantes está "Accelerated C++" el cual debe estar disponible en tu librería local.<br/>'.
		'<br/>'.
		'Referencias recomendadas de C/++: <a href="%s">dinkumware.com</a> y <a href="%s">cprogramming.com</a><br/>'.
		'<br/>'.
		'[Un libro que encontré en alemán: <a href="%s">highscore.de</a>]<br/>'.
		'[Introducción a C++ en alemán: <a href="%s">Volkards C++ Kurs</a>]',
);
?>
