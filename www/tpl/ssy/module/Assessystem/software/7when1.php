<?php echo SSYHTML::getBoxTitled($tLang->lang('when1_title'), $tLang->lang('when1_info')); ?>

<span class="t" style="">
<span class="ssy800v_R ssy_st_out3">
	<?php echo SSYHTML::smallSoftwareBox($tLang, array('#', '#', '#', '#')); ?>
	<span class="ssy_st_out3_t ssy800h">TEXT_MISSING</span>
	<span class="ssy800v ssy_st_out2">
	<span class="ssy_st_out2_t">SEKTORSTUDIE</span> 
		<span class="ssy800v_R ssy_st_out1">
		</span>
	</span>
</span>
</span>

<?php /*


<table>
  <tr>
    <th>Rezeptname</th>
    <th>Sparte</th>
    <th>Hergestellte Stückzahl</th>
    <th>Brutto Preis</th>
    <th>Netto Preis</th>
    <th>EK Netto</th>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td>3522</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>Durchschnittswerte</td>
    <td></td>
    <td></td>
    <td></td>
    <td>5,29 €</td>
    <td>1,23 €</td>
  </tr>
  <tr>
    <td>Gewichtete Werte</td>
    <td></td>
    <td></td>
    <td></td>
    <td>0,00 €</td>
    <td>0,00 €</td>
  </tr>
   -->
<?php
/*
$data = array(
'Pizza Klein Margherita bis 31.08.2003	Pizza Klein bis 31.08.2003	2550	2,10 €	1,96 €	0,58 €',
'Pizza Groß Marinara ab 31.08.2003	Pizza Groß ab 01.09.2003	14	6,20 €	5,79 €	0,79 €',
'Pizza Groß Mista ab 31.08.2003	Pizza Groß ab 01.09.2003	12	7,70 €	7,20 €	2,28 €',
'Pizza Groß Napoletana ab 31.08.2003	Pizza Groß ab 01.09.2003	16	5,20 €	4,86 €	1,11 €',
'Pizza Groß Peperoni ab 31.08.2003	Pizza Groß ab 01.09.2003	16	5,00 €	4,67 €	0,93 €',
'Pizza Groß Primavera ab 31.08.2003	Pizza Groß ab 01.09.2003	15	7,00 €	6,54 €	1,20 €',
'Pizza Groß Quattro Staggioni ab 31.08.2003	Pizza Groß ab 01.09.2003	12	7,30 €	6,82 €	2,56 €',
'Pizza Groß Salamino ab 31.08.2003	Pizza Groß ab 01.09.2003	20	6,70 €	6,26 €	1,02 €',
'Pizza Klein Venezia bis 31.08.2003	Pizza Klein bis 31.08.2003	261	4,30 €	4,02 €	0,76 €',
'Pizza Groß Veneziana bis 31.08.2003	Pizza Groß bis 31.08.2003	176	7,00 €	6,54 €	1,18 €',
'Pizza Klein Spinat bis 31.08.2003	Pizza Klein bis 31.08.2003	93	4,30 €	4,02 €	0,63 €',
'Pizza Klein Salami ab 31.08.2003	Pizza Klein ab 01.09.2003	73	3,30 €	3,08 €	0,63 €',
'Pizza Groß Spinat bis 31.08.2003	Pizza Groß bis 31.08.2003	57	6,70 €	6,26 €	0,92 €',
'Pizza Klein Quattro Staggioni bis 31.08.2003	Pizza Klein bis 31.08.2003	128	4,80 €	4,49 €	1,36 €',
'Pizza Groß Quattro Staggioni bis 31.08.2003	Pizza Groß bis 31.08.2003	79	7,30 €	6,82 €	2,56 €',
);
foreach ($data as $line)
{
	$line = explode("\t", $line);
	echo '<tr>';
	foreach ($line as $col)
	{
		echo sprintf('<td>%s</td>', $col);
	}
	echo '</tr>';
}
?>
</table>


<!-- TABLE 2 -->
<table>
  <tr>
    <th>Rezeptname</th>
    <th>Warenverbrauch in Euro</th>
    <th>RG %</th>
    <th colspan="2">ERLÖSE</th>
    <th colspan="2">Deckungsbeitrag</th>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th>Brutto Gesamt</th>
    <th>Netto Gesamt</th>
    <th>Betrag</th>
    <th>Prozent</th>
  </tr>
  <tr>
    <th>Durchschnittswerte</th>						
  </tr>
  <tr>
    <td>Gewichtete Werte</td>
    <td>22.785,42 €</td>
    <td>317,25%</td>
    <td>104.247,60 €</td>
    <td>95.071,42 €</td>
    <td>22.286,00 €</td>
    <td>23,44%</td>
  </tr>
  
<?php
$data = array(
'Pizza Klein Margherita bis 31.08.2003	1.484,10 €	236,77	5.355,00 €	4.998,00 €	-218,75 	-4,38%',
'Pizza Groß Marinara ab 31.08.2003	11,07 €	632,36	86,80 €	81,06 €	49,50 	61,06%',
'Pizza Groß Mista ab 31.08.2003	27,35 €	215,90	92,40 €	86,40 €	41,48 	48,01%',
'Pizza Groß Napoletana ab 31.08.2003	17,82 €	336,38	83,20 €	77,76 €	36,52 	46,97%',
'Pizza Groß Peperoni ab 31.08.2003	14,89 €	401,72	80,00 €	74,72 €	36,41 	48,72%',
'Pizza Groß Primavera ab 31.08.2003	18,07 €	442,96	105,00 €	98,10 €	58,08 	59,20%',
'Pizza Groß Quattro Staggioni ab 31.08.2003	30,70 €	166,57	87,60 €	81,84 €	33,57 	41,02%',
'Pizza Groß Salamino ab 31.08.2003	20,38 €	514,27	134,00 €	125,20 €	75,54 	60,34%',
'Pizza Klein Venezia bis 31.08.2003	198,46 €	428,67	1.122,30 €	1.049,22 €	468,71 	44,67%',
'Pizza Groß Veneziana bis 31.08.2003	207,40 €	454,99	1.232,00 €	1.151,04 €	686,02 	59,60%',
'Pizza Klein Spinat bis 31.08.2003	58,71 €	536,78	399,90 €	373,86 €	179,02 	47,88%',
'Pizza Klein Salami ab 31.08.2003	46,32 €	385,42	240,90 €	224,84 €	71,67 	31,87%',
'Pizza Groß Spinat bis 31.08.2003	52,43 €	580,51	381,90 €	356,82 €	220,95 	61,92%',
'Pizza Klein Quattro Staggioni bis 31.08.2003	173,66 €	230,95	614,40 €	574,72 €	213,70 	37,18%',
'Pizza Groß Quattro Staggioni bis 31.08.2003	202,06 €	166,65	576,70 €	538,78 €	221,08 	41,03%',
);
foreach ($data as $line)
{
	$line = explode("\t", $line);
	echo '<tr>';
	foreach ($line as $col)
	{
		echo sprintf('<td>%s</td>', $col);
	}
	echo '</tr>';
}
?>
</table>

<!-- Tabelle 3 -->

<table>
  <tr>
    <th>Rezeptname</th>
    <th colspan="3">Variable Kosten</th>
    <th colspan="3">Fixe Kosten</th>
  </tr>
  <tr>
    <th></th>
    <th>Betrag</th>
    <th>Prozent Kosten intern</th>
    <th>Prozent Kosten extern</th>
    <th>Betrag</th>
    <th>Prozent Kosten intern</th>
    <th>Prozent Kosten extern</th>
  </tr>
  <tr>
  	<td>Durchschnittswerte</td>
  </tr>
  <tr>
    <td>Gewichtete Werte</td>
    <td>22.785,42 €</td>
    <td>0,31 €</td>
    <td>0,24 €</td>
    <td>50.000,00 €</td>
    <td>0,69 €</td>
    <td>0,53 €</td>
  </tr>
<?php
$data = array(
'Pizza Klein Margherita bis 31.08.2003	1.484,10 €	28,45%	29,69%	3.732,65 €	71,55%	74,68%',
'Pizza Groß Marinara ab 31.08.2003	11,07 €	35,07%	13,65%	20,49 €	64,93%	25,28%',
'Pizza Groß Mista ab 31.08.2003	27,35 €	60,89%	31,66%	17,57 €	39,11%	20,33%',
'Pizza Groß Napoletana ab 31.08.2003	17,82 €	43,21%	22,92%	23,42 €	56,79%	30,12%',
'Pizza Groß Peperoni ab 31.08.2003	14,89 €	38,87%	19,93%	23,42 €	61,13%	31,34%',
'Pizza Groß Primavera ab 31.08.2003	18,07 €	45,14%	18,42%	21,96 €	54,86%	22,38%',
'Pizza Groß Quattro Staggioni ab 31.08.2003	30,70 €	63,61%	37,51%	17,57 €	36,39%	21,46%',
'Pizza Groß Salamino ab 31.08.2003	20,38 €	41,04%	16,28%	29,28 €	58,96%	23,38%',
'Pizza Klein Venezia bis 31.08.2003	198,46 €	34,19%	18,92%	382,05 €	65,81%	36,41%',
'Pizza Groß Veneziana bis 31.08.2003	207,40 €	44,60%	18,02%	257,63 €	55,40%	22,38%',
'Pizza Klein Spinat bis 31.08.2003	58,71 €	30,13%	15,70%	136,13 €	69,87%	36,41%',
'Pizza Klein Salami ab 31.08.2003	46,32 €	30,24%	20,60%	106,86 €	69,76%	47,53%',
'Pizza Groß Spinat bis 31.08.2003	52,43 €	38,59%	14,69%	83,44 €	61,41%	23,38%',
'Pizza Klein Quattro Staggioni bis 31.08.2003	173,66 €	48,10%	30,22%	187,36 €	51,90%	32,60%',
'Pizza Groß Quattro Staggioni bis 31.08.2003	202,06 €	63,60%	37,50%	115,64 €	36,40%	21,46%',
);
foreach ($data as $line)
{
	$line = explode("\t", $line);
	echo '<tr>';
	foreach ($line as $col)
	{
		echo sprintf('<td>%s</td>', $col);
	}
	echo '</tr>';
}
?>
</table>

<!-- Tabelle 4 -->

<table>
  <tr>
    <th>Rezeptname</th>
  </tr>
  <tr>
    <th></th>
    <th>Kosten Gesamt</th>
    <th></th>
    <th>Handelsspanne</th>
    <th>Kalkulationsfaktor</th>
    <th>Kalkulationszuschlag</th>
  </tr>
  <tr>
    <td>Durchschnittswerte</td>
  </tr>				
  <tr>
    <td>Gewichtete Werte</td>
    <td>72.785,42 €</td>
    <td></td>
    <td>23,44%</td>
    <td>130,62%</td>
    <td>30,62%</td>
  </tr>
<?php
$data = array(
'Pizza Klein Margherita bis 31.08.2003	5.216,75 €		-4,38%	95,81%	-4,19%',
'Pizza Groß Marinara ab 31.08.2003	31,56 €		61,06%	256,83%	156,83%',
'Pizza Groß Mista ab 31.08.2003	44,92 €		48,01%	192,36%	92,36%',
'Pizza Groß Napoletana ab 31.08.2003	41,24 €		46,97%	188,56%	88,56%',
'Pizza Groß Peperoni ab 31.08.2003	38,31 €		48,72%	195,02%	95,02%',
'Pizza Groß Primavera ab 31.08.2003	40,02 €		59,20%	245,10%	145,10%',
'Pizza Groß Quattro Staggioni ab 31.08.2003	48,27 €		41,02%	169,56%	69,56%',
'Pizza Groß Salamino ab 31.08.2003	49,66 €		60,34%	252,13%	152,13%',
'Pizza Klein Venezia bis 31.08.2003	580,51 €		44,67%	180,74%	80,74%',
'Pizza Groß Veneziana bis 31.08.2003	465,02 €		59,60%	247,52%	147,52%',
'Pizza Klein Spinat bis 31.08.2003	194,84 €		47,88%	191,88%	91,88%',
'Pizza Klein Salami ab 31.08.2003	153,17 €		31,87%	146,79%	46,79%',
'Pizza Groß Spinat bis 31.08.2003	135,87 €		61,92%	262,62%	162,62%',
'Pizza Klein Quattro Staggioni bis 31.08.2003	361,02 €		37,18%	159,19%	59,19%',
'Pizza Groß Quattro Staggioni bis 31.08.2003	317,70 €		41,03%	169,59%	69,59%',
);
foreach ($data as $line)
{
	$line = explode("\t", $line);
	echo '<tr>';
	foreach ($line as $col)
	{
		echo sprintf('<td>%s</td>', $col);
	}
	echo '</tr>';
}
?>
</table>
*/
?>