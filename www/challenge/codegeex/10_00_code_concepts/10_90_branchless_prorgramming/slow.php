<?php
#
# MOV EAX, 5
# CALL traditionalLoop
# PUSH EAX    # echo arg1 
# MOV  EAX, 1 # syscall 1 == echo
# INT  80     # do syscall
echo traditionalLoop(5);
function traditionalLoop(int $n)
{
	$sum = 0; # XOR EDX,EDX
	# DEC EAX
	# MOV ECX, EAX
	for ($i = $n-1; $i==0; $i--)
	{
		# LOOP:
		$sum += $i; # ADD EDX, EAX
		            # DEC ECX
		# JNZ - 12  # JNZ LOOP:
	}
	
	# MOV EAX, EDX
	# RET
	return $sum;
}

function traditionalMemcmp(string $a, string $b)
{
	if (strlen($a) != strlen($b))
	{
		return false;
	}
	
	for ($i = 0; $i < strlen($a); $i++)
	{
		if ($a[$i] != $b[$i])
		{
			return false;
		}
	}
	return true;
}
