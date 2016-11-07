<?php
$lang = array(
	'err_create_config' => 'Bitter erstellen Sie &quot;protected/config.php&quot; und geben Sie Schreibrechte für den Web-Server.',
	'err_no_config' => 'Die &quot;protected/config.php&quot; Datei wurde nicht gefunden.',
	'err_no_db' => 'Es konnte keine Verbindung zur Datenbank aufgebaut werden.',
	'err_config_value' => 'In deiner config.php, der definierte Wert für &quot;%s&quot; ist ungültig. Der Standardwert wurde wiederhergestellt.',
	'err_unknown_type' => 'Unbekannter vartype für config var: %s.',
	'err_unknown_var' => 'Unbekannte Konfigurations variable: %s.',
	'err_text' => 'Die var \'%s\' muss ein String sein.',
	'err_int8' => 'Die var \'%s\' muss eine Oktalzahl sein.',
	'err_int10' => 'Die var \'%s\' muss eine Dezimalzahl sein.',
	'err_bool' => 'Die var \'%s\' muss eon booleascher Wert sein (entweder true oder false).',
	'err_script' => 'Die var \'%s\' hat einen ungültigen Standartwert.',
	'err_no_smarty' => 'Konnte Smarty library nicht finden.',
	'err_no_mods_selected' => 'Bitte wählen sie einige Module aus.',
	'err_htaccess' => 'Die Wurzel-&quot;.htaccess&quot; Datei konnte nicht beschrieben werden.',
	'err_copy' => 'Cannot copy to file %s.',
	'err_clear_smarty' => 'Der Smarty Template Cache konnte nicht geleert werden.',

	'msg_copy' => 'Succesfully made a copy of %s.',
	'msg_copy_untouched' => 'Ihre Kopie von %s wurde nicht verändert.',
	'msg_htaccess' => 'Die Wurzel &quot;.htaccess&quot; Datei wurde erfolgreich beschrieben.',

	'pt_wizard' => 'GWF - Installations-Assistent',
	'mt_wizard' => 'GWF,Install,Wizard',
	'md_wizard' => 'GWFv3  Installations-Assistent. You should not see me ;)',

	'foot_progress' => 'Installationsfortschritt: %0.02f%%',
	'license' => 'GWF3 is &copy; by gizmore.<br/>GWF3 ist zur Zeit unlizensiert. Eine MIT-Kompatible Lizenz ist geplant.<br/>GWF3 soll Frei sein!',
	'pagegen' => 'Seite erzeugt in in %.03fs.',

	'menu_0' => 'Status',
	'menu_1' => 'ConfigErzeugen',
	'menu_2' => 'ConfigTesten',
	'menu_3' => 'KernTabellen',
	'menu_4' => 'Sprachen',
	'menu_5' => 'WebRoboter',
	'menu_6' => 'Module',
	'menu_7' => 'Beispiele',
	'menu_8' => 'HTAccess',
	'menu_9' => 'Admins',
	'menu_10' => 'Backup',
	'menu_11' => 'Cache',
	'menu_12' => 'Protect',
		
	'title_long' => 'Space &amp; Gizmore Website Framework',
	'title_step' => 'Installations-Assistent - Schritt %d',

	'wizard' => 'Installations-Assistent',
	'step' => 'Schritt %s',
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
	'step_0_6'  => 'Kann in Ordner &quot;extra/temp/&quot; geschrieben werden?(*)',
	'step_0_7'  => 'Kann in Ordner &quot;protected/logs/&quot; geschrieben werden?(*)',
	'step_0_8'  => 'Kann in Ordner &quot;protected/rawlog/&quot; geschrieben werden?(*)',
	'step_0_9'  => 'Kann zur Datenbank verbinden?',
	'step_0_10' => 'Ist PHP hash library installiert?(*)',
	'step_0_11' => 'Ist PHP ZipArchive installiert?',
	'step_0_12' => 'Ist PHP curl library installiert?',
	'step_0_13' => 'Ist PHP Fileinfo or mime_content_type verfügbar?',
	'step_0_14' => 'Sind gefährliche Funktionen (exec,system,passthru,pcntl_exec,proc_open,shell_exec,popen,link) deaktiviert?',
	'step_0_15' => 'Sind GnuPG Funktionen verfügbar?',

	'step_1' => 'Erstelle &quot;protected/config.php&quot;',

	'step_1a' => 'Teste Datenbankverbindung',
	'step_1a_0' => 'Suche nach protected/config.php Konfigurationsdatei... %s.',
	'step_1a_1' => 'Versuche zur Datenbank zu verbinden... %s.',

	'step_1b' => 'Schreibe &quot;protected/config.php&quot;',
	'step_1b_0' => 'Konfigurationsdatei schreiben... %s.',

	'step_2' => 'Teste &quot;protected/config.php&quot;',
	'step_2_0' => 'Ihre Konfiguration scheint stabil. Versuchen Sie nun die core Tabellen einzurichten.',

	'step_3' => 'Kerntabellen installieren',
	'create_table' => 'Erstelle Tabelle für class %s... ',
	'step_3_0' => 'Wir werden jetzt die Tabellen für die core-Klassen erstellen.<br/>Sie finden diese im &quot;core/inc/&quot; Ordner.<br/>Jede dieser Klassen besitzt eine Datenbanktabelle.',

	'step_4' => 'Länder und Sprachen installieren',
	'step_4_0' => 'Sie können jetzt entweder versuchen die Land/Sprach Tabellen mit oder ohne ip2country Mapping zu installieren.<br/>IP2country Mapping kann mehrere Minuten zum installieren benötigen.',
	'step_4_1' => 'Installiere Land- und Sprachtabellen',
	'step_4_2' => 'Installiere Land+Sprach+ip2Land Tabellen',

	'step_5' => 'Useragents installieren',
	'step_5_0' => 'Sie können jetzt die UserAgent Datenbank installieren oder dies überspringen.<br/>Es wird empfohlen diesen Schritt auszulassen, da die UserAgent Datenbank zurzeit komplett unbenutzt ist.',
	'step_5_1' => 'Installiere useragent map',

	'step_6' => 'Module installieren',
	'step_6_0' => 'Wählen Sie die Module die sie installieren möchten',
	'step_6_1' => 'Module installieren',

	'step_7' => 'Beispieldateien kopieren',

	'step_8' => 'HTAccess erzeugen',

	'step_9' => 'Administratoren erzeugen',

	'step_10' => 'Create Backup Folders',
	'step_10_0' => 'You should add the following to your crontab:<br/><br/>%s<br/>%s<br/><br/>You will find data here: %s.<br/><br/>Backup strategy is important!',
	
	'step_11' => 'Clear Caches',
	'step_11_0' => 'Install has been finished.<br/>All caches have been cleared.<br/>You can login now or enhance the protection of your install folder.',
	
	'step_12' => 'Protect the install folder',
	'step_12_0' => 'Your install folder should now be protected by throwing 404 errors.',
	
	'msg_all_done' => 'Glückwunsch, Ihre Installation ist abgeschlossen!<br/>Vielen Dank das Sie sich für GWF3 entschieden haben.<br/>Wir wünschen viel Spass damit.<br/><br/>gizmore und spaceone',
);
?>