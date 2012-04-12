#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void hint()
{
	printf("Need to bypass aslr\n");
	exit(0);
}
void vulnfunc(char *input)
{
	char vulnbuf[300];
	memcpy(vulnbuf, input, strlen(input));
}
int main(int argc, char *argv[])
{
	if(argc > 1)
	{
		vulnfunc(argv[1]);
	}
	else
	{
		printf("%s <input>\n", argv[0]);
		return 1;
	}
	return 0;
}
