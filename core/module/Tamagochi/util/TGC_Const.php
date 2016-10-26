<?php
final class TGC_Const
{
	const GPS_INACCURACY = 100;
	
	const NONE = 'none';
	const NO_SKILL = -1;
	const NO_AVATAR = -1;
	
	const MALE = 'male';
	const FEMALE = 'female';
	public static $GENDERS = array(self::MALE, self::FEMALE);
	
	const ATTACK = 'attack';
	const DEFEND = 'defend';
	const EXPLORE = 'explore';
	public static $MODES = array(self::ATTACK, self::DEFEND, self::EXPLORE);
	
	const FIGHTER = 'fighter';
	const NINJA = 'ninja';
	const PRIEST = 'priest';
	const WIZARD = 'wizard';
	public static $SKILLS = array(self::FIGHTER, self::NINJA, self::PRIEST, self::WIZARD);
	
	const BLACK = 'black';
	const RED = 'red';
	const GREEN = 'green';
	const BLUE = 'blue';
	public static $COLORS = array(self::BLACK, self::RED, self::GREEN, self::BLUE);
	
	const STEPPE = 'steppe';
	const FOREST = 'forest';
	const HILLS = 'hills';
	const MOUNTAINS = 'mountains';
	public static $TERRAINS = array(self::STEPPE, self::FOREST, self::HILLS, self::MOUNTAINS);
	
	const FIRE = 'fire';
	const WATER = 'water';
	const WIND = 'wind';
	const EARTH = 'earth';
	public static $ELEMENTS = array(self::FIRE, self::WATER, self::WIND, self::EARTH);
	
	const NEOPHYTE = 'neophyte';
	const NOVICE = 'novice';
	const AMATEUR = 'amateur';
	const APPRENTICE = 'apprentice';
	const ADEPT = 'adept';
	const EXPERT = 'expert';
	const LO_MASTER = 'lo_master';
	const UM_MASTER = 'um_master';
	const ON_MASTER = 'on_master';
	const EE_MASTER = 'ee_master';
	const PA_MASTER = 'pa_master';
	const MON_MASTER = 'mon_master';
	public static $LEVELS = array(self::NEOPHYTE, self::NOVICE, self::AMATEUR, self::APPRENTICE, self::ADEPT, self::EXPERT, self::LO_MASTER, self::UM_MASTER, self::ON_MASTER, self::EE_MASTER, self::PA_MASTER, self::MON_MASTER);
	
}