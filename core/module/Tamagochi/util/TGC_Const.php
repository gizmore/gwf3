<?php
final class TGC_Const
{
	const NONE = 'none';
	const NO_SKILL = -1;
	const NO_AVATAR = -1;
	
	const GPS_INACCURACY = 100;
	
	const MALE = 'male';
	const FEMALE = 'female';
	public static $GENDERS = array(MALE, FEMALE);
	
	const ATTACK = 'attack';
	const DEFEND = 'defend';
	const EXPLORE = 'explore';
	public static $MODES = array(ATTACK, DEFEND, EXPLORE);
	
	const WIZARD = 'fighter';
	const NINJA = 'ninja';
	const PRIEST = 'priest';
	const WIZARD = 'wizard';
	public static $SKILLS = array(WIZARD, NINJA, PRIEST, WIZARD);
	
	const BLACK = 'black';
	const RED = 'red';
	const GREEN = 'green';
	const BLUE = 'blue';
	public static $COLORS = array(BLACK, RED, GREEN, BLUE);
	
	const STEPPE = 'steppe';
	const FOREST = 'forest';
	const HILLS = 'hills';
	const MOUNTAINS = 'mountains';
	
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
	
	public static $LEVELS = array(NEOPHYTE, NOVICE, AMATEUR, APPRENTICE, ADEPT, EXPERT, LO_MASTER, UM_MASTER, ON_MASTER, EE_MASTER, PA_MASTER, MON_MASTER);
}