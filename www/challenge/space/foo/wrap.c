#include <stdio.h>
#include <stdlib.h>
#define BUFSIZE 256

int escape_single_quotes(char *to, char *from, int max)
{
	int l= 0;

	for (;*from;from++)
	{
		switch (*from)
		{
			case '\'':
				if (l>=max-4) return 0;	// not enough space for escaped chars!
// replace ' with '\''
				*(to++)= '\'';
				*(to++)= '\\';
				*(to++)= '\'';
				l += 3;
			default:
				if (l>=max-1) return 0;	// not enough space for this char!
				*(to++)= *from;
				l++;
		}
	}

	*to= 0;

	return 1;
}

int main(int argc, char *argv[])
{
	FILE *fp;
	char buf[BUFSIZE];
	char escaped_name[BUFSIZE];
	char *filename;
	int returncode;

	setregid(1013,1013); // gid of level12

	if (argc != 2)
	{
		fprintf(stderr, "Usage: %s filename\n", argv[0]);
		exit(EXIT_FAILURE);
	}

	filename= argv[1];

	if (!escape_single_quotes(escaped_name, filename, BUFSIZE))
	{
		fprintf(stderr, "Escaped filename is too long!\n");
		exit(EXIT_FAILURE);
	}

	if (snprintf(buf, BUFSIZE, "/usr/bin/python /home/level/12/space/foo.py %s", escaped_name)>=BUFSIZE)
	{
		fprintf(stderr, "Filename %s is too long!\n", filename);
		exit(EXIT_FAILURE);
	}

	fp = popen(buf, "r");
	if (!fp)
	{
		fprintf(stderr, "Command execution failed! Sorry!\n");
		exit(EXIT_FAILURE);
	}
	returncode = pclose(fp);
	if (0 == returncode)
	{
		//TODO: printf solution or cat solution.txt
	}

	return EXIT_SUCCESS;
}
