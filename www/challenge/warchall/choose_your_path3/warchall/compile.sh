#!/bin/bash
rm charp3
gcc charp3.c -o charp3
chown cyp:level22 charp3
chmod 2755 charp3
chown level22:level22 solution.nf0
