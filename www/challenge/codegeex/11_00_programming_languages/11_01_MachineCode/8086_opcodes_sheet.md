# p0ü

#### demo code

000000000 : 0xC1E002A3
000000000 : 0x0040101A

##


   MC/OP     Assembly        Size     ;)   (ISA) (x64)
 - 0x90   == NOP            (1 bytes)       8086  yes
 - 0xA1   == MOV EAX, DSPTR (5 bytes)       x586  no
 - 0xC1E0 == SHL EAX, NUM   (3 bytes)
 - 0xA3   == MOV DSPTR, EDX (5 bytes)
 - 0x52   == PUSH EDX       (1 bytes)
 - 0x33C0 == XOR EAX, EAX   (2 bytes)
 - 0xe9   == jmp PTR        (5 bytes)
 - 0xeb   == jmp NUM        (2 bytes)
 
 