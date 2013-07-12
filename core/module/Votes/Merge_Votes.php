<?php
final class Merge_Votes
{
	public static function onMerge(GDO_Database $db_from, GDO_Database $db_to, array &$db_offsets, $prefix, $prevar)
	{
		merge_calc_offset($db_from, $db_to, $db_offsets, 'GWF_VoteMulti');
		merge_calc_offset($db_from, $db_to, $db_offsets, 'GWF_VoteScore');
		
		// VoteMulti
		merge_add_offset($db_from, $db_to, 'GWF_VoteMulti', 'vm_id', $db_offsets['GWF_VoteMulti']);
		merge_add_offset($db_from, $db_to, 'GWF_VoteMulti', 'vm_uid', $db_offsets['GWF_User']);
		merge_use_mapping($db_from, $db_to, 'GWF_VoteMulti', 'vm_gid', $db_offsets['GWF_Group']);
		merge_table($db_from, $db_to, 'GWF_VoteMulti');
		
		// VoteMultiOpt
		merge_add_offset($db_from, $db_to, 'GWF_VoteMultiOpt', 'vmo_vmid', $db_offsets['GWF_VoteMulti']);
		merge_table($db_from, $db_to, 'GWF_VoteMultiOpt');
		
		// VoteMultiRow
		merge_add_offset($db_from, $db_to, 'GWF_VoteMultiRow', 'vmr_vmid', $db_offsets['GWF_VoteMulti']);
		merge_add_offset($db_from, $db_to, 'GWF_VoteMultiRow', 'vmr_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'GWF_VoteMultiRow');
		
		// VoteScore
		merge_add_offset($db_from, $db_to, 'GWF_VoteScore', 'vs_id', $db_offsets['GWF_VoteScore']);
		merge_table($db_from, $db_to, 'GWF_VoteScore');
		
		// VoteScoreRow
		merge_add_offset($db_from, $db_to, 'GWF_VoteScoreRow', 'vsr_vsid', $db_offsets['GWF_VoteScore']);
		merge_add_offset($db_from, $db_to, 'GWF_VoteScoreRow', 'vsr_uid', $db_offsets['GWF_User']);
		merge_table($db_from, $db_to, 'GWF_VoteScoreRow');
	}
}
