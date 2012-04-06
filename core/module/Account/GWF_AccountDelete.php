<?php
/**
 * An account deletion note.
 * @author gizmore
 */
final class GWF_AccountDelete extends GDO
{
	###########
	### GDO ###
	###########
	public function getClassName() { return __CLASS__; }
	public function getTableName() { return GWF_TABLE_PREFIX.'acc_rm'; }
	public function getColumnDefines()
	{
		return array(
			'accrm_uid' => array(GDO::OBJECT|GDO::PRIMARY_KEY, GDO::NOT_NULL, array('GWF_User', 'accrm_uid')),
			'accrm_note' => array(GDO::MESSAGE),
		);
	}
	
	public static function insertNote(GWF_User $user, $note)
	{
		# no empty notes
		if ($note === '') {
			return false;
		}
		
		# insert it
		$entry = new self(array(
			'accrm_uid' => $user->getVar('user_id'),
			'accrm_note' => $note,
		));
		if (false === $entry->replace()) {
			return false;
		}
		return $note;
	}
}
?>