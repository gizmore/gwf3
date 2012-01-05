<?php
final class Konzert_Install
{
	public static function onInstall(Module_Konzert $module, $dropTables)
	{
		return GWF_ModuleLoader::installVars($module, array(
		)).
		self::installDefaultTermine($module);
	}
	
	private static function installDefaultTermine()
	{
		$table = GDO::table('Konzert_Termin');
		if ($table->countRows() > 0)
		{
			return '';
		}
		
		$defaults = array(
			
			array(
				"20111112", # date
				"2000", # time
				"„Sternstunden der UFA-Filmmusik“<br/>Eine „Show“ unvergänglicher Melodien<br/>Melanie Gobbo und ihr Orchester", #prog
				"Aachen <span class=\"red\">Premiere!</span>", # city
				"Altes Kurhaus Aachen<br/>Kurhausstr. 2<br/>52062 Aachen<br/>Eingang: Klangbrücke", # loc
				'', #tickets
			),
			
			array(
				"20120121",
				"2000",
				"„Sternstunden der UFA-Filmmusik“<br/>Eine „Show“ unvergänglicher Melodien<br/>Melanie Gobbo und ihr Orchester", #prog
				"Rees",
				"Bürgerhaus Rees<br/>Markt 1<br/>46459 Rees", # loc
				'', # tickets
			),
			
			array(
				"20120204",
				"2000",
				"„Sternstunden der UFA-Filmmusik“<br/>Eine „Show“ unvergänglicher Melodien<br/>Melanie Gobbo und ihr Orchester", #prog
				"Meerbusch",
				"Forum Wasserturm<br/>Rheinstrasse 10<br/>Meerbusch-Lank",
				"", # tickets
			),
			
			array(
				"20120303",
				"1930",
				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
				"Remscheid",
				"Veranstaltungszentrum<br/>Vaßbendersaal,Schützenhaus<br/>Schützenplatz 1<br/>42853 Remscheid",
				"", # tickets
			),
			
			array(
				"20120317",
				"",
				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
				"Bedburg-Hau",
				"Rathaussaal<br/>Rathausplatz 1<br/>47551 Bedburg-Hau",
				"", # tickets
			),
			
			array(
				"20120324",
				"",
				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
				"Bedburg-Hau",
				"Rathaussaal<br/>Rathausplatz 1<br/>47551 Bedburg-Hau",
				"", # tickets
			),
			
			array(
				"20120421",
				"1930",
				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
				"Schwelm",
				"Rittergut Haus Martfeld<br/>Haus Martfeld 1<br/>58332 Schwelm",
				"", # tickets
			),
			
			array(
				"20120428",
				"2000",
				"„Sternstunden der UFA-Filmmusik“<br/>Eine „Show“ unvergänglicher Melodien<br/>Melanie Gobbo und ihr Orchester", #prog
				"Moers",
				"Kulturzentrum Rheinkamp<br/>Kopernikusstraße 11<br/>47445 Moers",
				"", # tickets
			),
			
			array(
				"20120518",
				"",
				"<span class=\"red\">Exklusiv-Event</span>",
				"Tegernsee",
				"Hotel &amp; Spa<br/>Das Tegernsee",
				"", # tickets 
			),
			array(
				"20120519",
				"",
				"<span class=\"red\">Exklusiv-Event</span>",
				"Tegernsee",
				"Hotel &amp; Spa<br/>Das Tegernsee",
				"", # tickets 
			),
			
//			array(
//				"20120517",
//				"1600",
//				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
//				"Eifel",
//				"Restaurant im Nationalpark Eifel<br/>im großen Kursaal<br/>Kurhausstraße 5<br/>53937 Schleiden",
//				"", # tickets
//			),
			
			array(
				"20120714",
				"",
				"„That`s Glamour!“<br/><span class=\"red\">Exklusiv-Event</span><br/>Präsentiert von<br/>Melanie Gobbo und Band",
				"Hargimont, Belgien",
				"<a href=\"http://www.chateaujemeppe.eu\">Chateau Jemeppe</a><br/>Rue Felix Lefevre 24<br/>6900 Hargimont Belgique<br/>Tel. 084 22 59 01",
				"", # tickets
			),
			
			array(
				"20120922",
				"1930",
				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
				"Bad Oeynhausen",
				"Wandelhalle",
				"", # tickets
			),
	
			array(
				"20121003",
				"1600",
				"„Operetten-Rendevous mit dem Charme Wiener Melodien“<br/>Melanie Gobbo mit Melissa u. Baptiste Pawlik",
				"Schleiden",
				"Gemündner Park<br/>im großen Kursaal<br/>Kurhausstraße 5<br/>53937 Schleiden",
				"", # tickets
			),
		);

		$back = '';
		
		foreach ($defaults as $data)
		{
			list($date, $time, $prog, $city, $loc, $tic) = $data;
			
			if (false === $table->insertAssoc(array(
				'kt_id' => 0,
				'kt_date' => $date,
				'kt_time' => $time,
				'kt_city' => $city,
				'kt_prog' => $prog,
				'kt_tickets' => $tic,
				'kt_location' => $loc,
				'kt_options' => Konzert_Termin::ENABLED,
			), false))
			{
				$back .= GWF_HTML::err('ERR_DATABASE', array(__FILE__, __LINE__));
			}
		}
		
		return $back;
	}
}
?>