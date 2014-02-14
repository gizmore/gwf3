#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>

#define PYTHON "/usr/bin/python"
#define CHALLENGE "/home/level/12/pytong.py"

int main(int argc, char **argv)
{
	if (argc < 2) {
		printf("usage: %s file\n", *argv);
		return 2;
	}
//	setgid(getegid());
//	setuid(geteuid());

	execle(PYTHON, PYTHON, CHALLENGE, argv[1], (char *)0, (char *)0);
	return 1;
}
