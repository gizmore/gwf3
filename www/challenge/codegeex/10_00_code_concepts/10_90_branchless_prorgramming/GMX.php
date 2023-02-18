<?php
namespace gizmore;

/**
 * Proof of concept that a complete branchless strcasecmp is possible.
 * 
 * 2nd catch
 * 
 * @author gizmore
 * @since 7.0.2
 */
final class GMX
{
    
    /**
     * This does not work :)
     * @param int $a
     * @param int $b
     * @return int
     */
    public static function divThyself(int $a, int $b): int
    {
        $result = $a - $b;
        return $result / $result; # only 1 or 0 ?
    }
    
    
	/**
	 * PoC
	 * 
	 * @param int $a8u 
	 * @param int $b8u
	 */
	public static function GMXCMPb8(int $a8, int $b8)
	{
		$jumptable = [
		    'jmpToDiff',
		    'jmpToSame',
		];
		# MOV eax, result * 16 # only 1 or 0
		# JMP eax
		# 11 / 11 == 1
		# Loop: (here would be the loop)
		
		$a8 &= 0x0000_00ff; # clear all bits but low 8  # 71 0x47 0b0100_0111 (A)
		#                                               #         0b0101_1000 (b)
		
		#                                               # na      0b1011_1000 # 1's complement
		#                                                         0b1111_1111 # INC++
		
		#                                               #       1 0b0000_0000 # CARRY
		#                                               #         0b0000_0001 # shift right 8
		$b8 &= 0x0000_00ff; # clear all bits but low 8  # 88 0x58 0b0101_1000
		
		$na = $a8 ^ 0xff; # The one's complement, or "negative"
		$xb = $b8 ^ $na; # XOR `b` with `a`s negative.
		# If `a==b`, then all bits are 1.
		$xb++; # If `a==b`, we now have byte overflow in carry/bit9.
		$xb >>= 8; # Emulate carry read.
		$carry = $xb; # Only looking at the carry, we can know if `a==b`.
		
		return $carry;
		
		# JMP without conditional branch.
		$jumptable[$eax]($carry);
	}
}

error_reporting(E_ALL);

$eax = \gizmore\GMX::GMXCMPb8(ord('G'), ord('G'));
echo $eax == 0 ? 'DIFF' : 'SAME';
// if ($eax)
// {
//     'DIF';
// }
// else
// {
//     'SAM',
// }
