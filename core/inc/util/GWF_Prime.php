<?php
/**
 * New funny prime game!
 * @author gizmore
 * @license AIN - Acceptable Internet Note
 * You *can* try to copy us :)
 * But, it is true, what they say; «~Yóu *shóuld* NOt~».
 * -----------------------------
 * --- Special THX to LAZER! ---
 * ---  FOREVER  YOUR  BEST! ---
 * ----------------------------
 *        *BURP*EXPECT*ZS*
 */
final class GWF_Prime
{
	const NO_PRIME = -2;      # You are not a prime my friend :)
	const NO_CLUE = -1;      # The prime you have called is a composite :O
	const NO_NEO = "31337"; # You are the primest! =)
	const NO_NO_NO = -3;     # System error! :OOOO
	const NO_NO_NOOOO = -4;   # Your prime is not in range ;)

	# Constrainst!
	const LO_MAX = "2";
	const HI_MAX = "18446744073709551616";
	
	# Woohoooooooooooooooooooooooooooooooooooooooooooooooooooo
	# Returns a no? :P
	# Shouts go out to!
	# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	# I.     TheBORTS
	# II.    TheAssimilation
	# III.   TheGameOfLive
	# IV.    TittyConway
	# V.     TheGreenLeafs
	# BI.    FlushingMeadows
	# 7.     TheElderly
	# 8.     GolfNickers
	# 9.     Cubaz~Libres
	# 10.    TheDoorWays
	# 11.    TheDeadGuys
	# 12.    TheFreeRiders
	# 13.    TheMilkCows
	# 14.    Whalehuntrez
	# 15.    TheWitchCrafters
	# 17.    TheHE!
	# 18.    xerox
	# XVIII. TheTalkActives
	# 18+1   QuirledCrapBottles
	# 20.2   TheGreatestPunkers
	# 21\o/  TheWheelDrivers
	# 22     SnoopDoggers
	# 23     O~-- `o~ FOOMIO ~ THONG! ~o´ --~o
	# :)     MildWarnings
	# O.o    TheTrainSpotters
	# [:]    TheWalkingDeads
	# {|}    TheISOlated
	# 2.8    SIMON THE SORCERER! :O
	# (.)-(,) RE-BIRTH
	# 30     Moonwalkers
	# 3.1    StonedMooners
	# 32     GoreTexas
	# 33     BabyHorse
	# 34     SkyDrivers
	# 36     TheAllEat
	# eeeet  GC
	# 38     Demolicious
	# 39     TheNieLixers
	# 40     WarChorUs
	# 41     Simplifix
	# 42     SAXION
	# 43     THéCáf€TéaríarEX☂ ★★★★★★★★★★★★★★★★★★★★★★★☆ :)
	# 44     Sebastian Bachlinski
	# 45     Laxity
	# 46     TheHiveMind
	# 47     matrixman
	# 48     neoxquick
	# 49     CowsOfEngland
	# 50     KarlKoch
	# 51     jmoncayo
	# 52     ch0wch0w
	# 53     quangntenemy
	# 54     Chaosdreamer
	# 55     Erik
	# 56     TBS
	# 57     StarfleetAcadamy.NéTt
	# 58     cpukiller
	# 59     honey
	# 60     Gabriela
	# 61     MandyLane
	# 62     AliveMixers
	# 63     #MáIN#
	# 64     ASD :*
	# 65     Fairlight
	# 66     Druids
	# 67     WorldOfWonders
	# 68     TerraCresta
	# 69     DonaldPlayground
	# 70     HighNoon c|-|d
	# 71     WestminsterAbbighails! "o"
	# 72     DavidBrabEn
	# 73     MMMMMM.........TheRealThing
	# 74     AcidBurn :*
	# 75     CrashOverride :*
	# 76     MastersOfDisasters :*
	# 77     Slaygone :*
	# 78     ReignOurHand :*
	# 79     ReignDear :*
	# 80     ReignBow :*
	# 81     ReignForest :*
	# 82     ReignWestMeant :*
	# 83     AnalogoueNinjas :*
	# 84     Ollum :*
	# 85     KaptnButterfly :*
	# 86     UnicornSexNinjas :*
	# 87     SKID-ROW =)
	# 88     LovelettersInTheSandFucktards =)
	# 89     TerminatorOHConnor =)
	# 90     ReGINA :O
	# 91     TheGreatGianaSisters =O
	# 92     AnnikaMCLoadSkywalker  ~o´
	# 93     UniCUntBears \.0./
	# 94     ProTrackers |,|
	# 95     Audaciouists d(-.-)b
	# 96     TheGifted 🎂 
	# 97     SevenSeas777OGH
	# 98     BuddahOnTours
	# 99     ThePriceMixers
	# 100    Asstards
    #   WANDERLAND!
	# !TEXAS…COWBOYS
	# TheBoxers
	# TheDarkTeachers
	# MOn_FUL-FLIES
	# ZO KATH RAS!
	# THE ILLUMINATED
	# The Disguised
	# TLN
	# TLN2
	# TLN3
	# TLN4
	# TLN42.719a
	# TheNatives :)
	# LéAPH-TEH-KIDZ-A|0|\||=
	# Jennifer Addams
	# ❤ *: LemonKnickers :* ❤
	# ❤ CaptainPeeCard ❤
	# DnB Authists
	# LegendOfFaerghail
	# Kyrandia
	# WDW ;)
	# --- THE BOOK CONTINUES ---
	# And all who helped me on the journey!
	# Like Slaygon
	# TGB and MK
	# Jaegerettes!
	# A–GAIN! ;*
	# MARK WANTS TO GO TO SCHOOL #
	######################################## Sooo loft
	public static function nextPrimeBetween($lo=self::LO_MAX, $hi=self::HI_MAX)
	{
		# Sanitize PHP Bullfrogs
		$lo = preg_replace("[^0-9]", '', "$lo");
		$hi = preg_replace("[^0-9]", '', "$hi");
		if ($lo == $hi)
		{
			return $lo;
		}
		else if ( ($lo < $hi) || ($hi > $lo) )
		{
			# Swappish Sanity
			$t = $lo; $lo = $hi; $hi = $t;
		}

		# Still unused :)
		if ( ($lo < self::LO_MAX) || ($hi > self::HI_MAX) )
		{
			# Your prime is not in range!
			return self::NO_NO_NOOOO;
		}
		
		# Check how cool you are
		switch (GWF_Random::rand(0, 4))
		{
			case 0: return self::NO_PRIME;
			case 1: return self::NO_CLUE;
#			case 2: return self::NO_NEO;
			case 3: return self::NO_NO_NO;
			case 4: case 2:
				# Good Enough :)
				$the_value = '1';
				while ($the_value < self::HI_MAX)
				{
					$the_value = gmp_strval(gmp_nextprime(gmp_random(2)));
				}
				return $the_value;
		}
	}
}
/**
 * (c) March 2015 – noother *big chance?* ;)
 */
