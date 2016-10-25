<?php
final class TGC_AvatarNames
{
	public static function randomPlayerName(GWF_User $user)
	{
		return self::randomName($user->getGender());
	}
	
	public static function randomName($gender=TGC_Const::MALE)
	{
		$syllables = self::syllables($gender);
	}
	
	public static function syllables($gender)
	{
		return $gender === 'male' ? self::maleSyllables() : self::femaleSyllables();
		
	}
	
	private static function maleSyllables()
	{
		return array(
				'he',
				'ro',
				'din',
				'lor',
				'man',
				'to',
				'rin',
				
		);
	}
	
	private static function femaleSyllables()
	{
		return array(
				'la',
				'ra',
				'lei',
				'si',
				'sa',
				'li',
				'la',
				'le',
				're',
				'me',
				'mi',
		);
	}
}
