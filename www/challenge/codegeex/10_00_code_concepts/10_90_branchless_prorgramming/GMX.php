<?php
namespace gizmore;

/**
 * Proof of concept that a complete branchless strcasecmp is possible.
 * 
 * @author gizmore
 * @since 7.0.2
 */
final class GMX
{
	/**
	 * PoC
	 * 
	 * @param int $a8u 
	 * @param int $b8u
	 */
	public static function GMXCMPb8(int $a8, int $b8)
	{
		$jumptable = [
			'jmpToFail',
			'jmpToLoop',
		];
		
		# Loop: (here would be the loop)
		
		$a8 &= 0xff; # clear all bits but low 8
		$b8 &= 0xff; # clear all bits but low 8
		
		$na = $a8 ^ 0xff; # The one's complement, or "negative"
		$xb = $b8 ^ $na; # XOR `b` with `a`s negative.
		# If `a==b`, then all bits are 1.
		$xb++; # If `a==b`, we now have byte overflow in carry/bit9.
		$xb >> 8; # Emulate carry read.
		$carry = $xb; # Only looking at the carry, we can know if `a==b`.
		
		return $carry;
		
		# JMP without conditional branch.
		$jumptable[$carry]($carry);
	}
}

$eax = \gizmore\GMX::GMXCMPb8(ord('G'), ord('X'));
echo $eax ? 'DIFF' : 'SAME';
