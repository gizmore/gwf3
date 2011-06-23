<?php
$lang = array(
	'err_create_config' => 'Bitter erstellen Sie &quot;protected/config.php&quot; und geben Sie Schreibrechte für den Web-Server.',
	'err_no_config' => 'Die &quot;protected/config.php&quot; Datei wurde nicht gefunden.',
	'err_no_db' => 'Es konnte keine Verbindung zur Datenbank aufgebaut werden.',
	'err_config_value' => 'In deiner config.php, der definierte Wert für &quot;%1%&quot; ist ungültig. Der Standardwert wurde wiederhergestellt.',
	'err_unknown_type' => 'Unbekannter vartype für config var: %1%.',
	'err_unknown_var' => 'Unbekannte Konfigurations variable: %1%.',
	'err_text' => 'Die var \'%1%\' muss ein String sein.',
	'err_int8' => 'Die var \'%1%\' muss eine Oktalzahl sein.',
	'err_int10' => 'Die var \'%1%\' muss eine Dezimalzahl sein.',
	'err_bool' => 'Die var \'%1%\' muss eon booleascher Wert sein (entweder true oder false).',
	'err_script' => 'Die var \'%1%\' hat einen ungültigen Standartwert.',
	'err_no_smarty' => 'Konnte Smarty library nicht finden.',

	'pt_wizard' => 'GWF - Installations-Assistent',
	
	'wizard' => 'Installations-Assistent',
	'step' => 'Schritt %1%',
	'yes' => 'ja',
	'no' => 'nein',
	'ok' => 'OK.',
	'error' => 'FEHLER: ',
	'no_cfg_file' => 'Konfiguration existiert nicht',

	'step_0'    => 'Prüfe Abhängigkeiten',
	'step_0_0'  => 'Willkommen zum GWF Installations-Assistent.<br/>Bitte erstellen Sie zuerst eine Datenbank für Ihre installation.<br/>MySQL befehle um eine Datenbank zu erstellen:',
	'step_0_0a' => 'Dann überprüfe, ob alle mit (*) markierten Felder grün sind.',
	'step_0_1'  => 'Ist der Ordner &quot;protected/&quot; .htaccess geschützt?',
	'step_0_2'  => 'Ist die root .htaccess schreibgeschützt?(*)',
	'step_0_3'  => 'Kann &quot;protected/config.php&quot; schreiben?(*)',
	'step_0_4'  => 'existiert config.php?',
	'step_0_5'  => 'Kann in Ordner &quot;dbimg/&quot; schreiben?(*)',
	'step_0_6'  => 'Kann in Ordner &quot;temp/&quot; geschrieben werden?(*)',
	'step_0_7'  => 'Kann in Ordner &quot;protected/logs/&quot; geschrieben werden?(*)',
	'step_0_8'  => 'Kann in Ordner &quot;protected/rawlog/&quot; geschrieben werden?(*)',
	'step_0_9'  => 'Kann zur Datenbank verbinden?',
	'step_0_10' => 'Ist PHP hash library installiert?(*)',
	'step_0_11' => 'Ist PHP ZipArchive installiert?',
	'step_0_12' => 'Ist PHP curl library installiert?',
	'step_0_13' => 'Ist PHP Fileinfo or mime_content_type verfügbar?',
	'step_0_14' => 'Sind gefährliche Funktionen (exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen) deaktiviert?',
	'step_0_15' => 'Sind GnuPG Funktionen verfügbar?',

	'step_1' => 'Erstelle &quot;protected/config.php&quot;',

	'step_1a' => 'Teste Datenbankverbindung',
	'step_1a_0' => 'Suche nach protected/config.php Konfigurationsdatei... %1%.',
	'step_1a_1' => 'Versuche zur Datenbank zu verbinden... %1%.',

	'step_1b' => 'Schreibe &quot;protected/config.php&quot;',
	'step_1b_0' => 'Konfigurationsdatei schreiben... %1%.',

	'step_2' => 'Teste &quot;protected/config.php&quot;',
	'step_2_0' => 'Ihre Konfiguration scheint stabil. Versuchen Sie nun die core Tabellen einzurichten.',

	'step_3' => 'Installiere core Tabellen',
	'create_table' => 'Erstelle Tabelle für class %1%... ',
	'step_3_0' => 'Wir werden jetzt die Tabellen für die core-Klassen erstellen.<br/>Sie finden diese im &quot;inc/&quot; Ordner.<br/>Jede Klasse besitzt eine Datenbanktabelle.',
	'step_3_1' => 'Sie können jetzt entweder versuchen die Land/Sprach Tabellen mit oder ohne ip2country Mapping zu installieren.<br/>IP2country Mapping kann mehrere Minuten zum installieren benötigen.',

	'step_4' => 'Installiere Land+Sprach Tabellen',
	'step_4_0' => 'Sie können jetzt installieren oder die UserAgent Datenbank auslassen.<br/>Es wird empfohlen diesen Schritt auszulassen, da die UserAgent Datenbank zurzeit komplett unbenutzt ist.',

	'step_5' => 'Installiere Land+Sprach+ip2Land Tabellen',
	'step_5_0' => 'Sie können jetzt installieren oder die UserAgent Datenbank auslassen.<br/>Es wird empfohlen diesen Schritt auszulassen, da die UserAgent Datenbank zurzeit komplett unbenutzt ist.',

	'step_6' => 'Installiere useragent map',
	'step_6_0' => 'Sie sollten jetzt alle Module installieren, die in GWF3 mitgeliefert werden.',

	'step_7' => 'Installiere alle Module',
	'step_7_0' => 'Sie sollten jetzt mindestens ein Admin Account erstellen.',
	'step_7a' => 'Installierte Module',
	
	'step_8' => 'Eestelle ein Administrator Konto',

	'step_9' => 'Installation abschließen',

	'step_10' => 'Schütze den &quot;protected/&quot; Ordner',
);
?>