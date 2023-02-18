<?php
# CPU
#  arithmetic registers
# eax = 5 
# ecx = 0
# edx = 15
#  constrol flow registers
# eip = LOOP: # instruction pointer
# esp = 0x400000 # stack pointer
#  single bit flags
# C0 = CARRY flag - set to 1 on overflow or underflow ADD EAX 12 

# MOV EAX, 5
# CALL traditionalLoop == PUSH EIP on Stack, MOV EIP, &#memoy address
# PUSH EAX    # echo arg1 
# MOV  EAX, 1 # syscall 1 == echo
# INT  80     # do syscall
function traditionalLoop(int $n)
{
	$sum = 0; # 80004f: XOR EDX,EDX (start:)  0x8x: 
	# MOV ECX, EAX
	for ($i = $n; $i!=0; $i--)
	{
	    # LOOP:
		# JZ ECX + 16  # (20 00 0C)

	    # ADD:
		$sum += $i; # ADD EDX, ECX (04)
		            # DEC ECX
		# Jumper:   # JMP LOOP: # (7f f8)
	}
	
	# below16:
	
	
	# MOV EAX, EDX
	# RET
	return $sum;
}

echo traditionalLoop(0x80_00_00_00); # X: 5s
                                     # G: 9s


function traditionalMemcmp(string $a, string $b)
{
#    return $a === $b; # memcmp(a, b) == 0;
    
    # func in C:
    $len = strlen($a);
	for ($i = 0; $i < $len; $i++) # 2 if
	{
		if ($a[$i] != $b[$i]) # 1 if
		{
			return 1;
		}
	}
	return 0;
}

