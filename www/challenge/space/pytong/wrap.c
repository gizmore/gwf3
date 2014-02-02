#include <stdio.h>
#include <stdlib.h>
#define BUFSIZE 256

int escape_single_quotes(char *to, char *from, int max)
{
	int l = 0;

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

	*to = 0;

	return 1;
}

int main(int argc, char *argv[])
{
	FILE *fp;
	FILE *solution;
	char buf[BUFSIZE];
	char escaped_name[BUFSIZE];
	char *filename;

	setregid(1013, 1013); // gid of level12

	if (argc != 2)
	{
		fprintf(stderr, "Usage: %s filename\n", argv[0]);
		exit(EXIT_FAILURE);
	}

	filename = argv[1];

	if (!escape_single_quotes(escaped_name, filename, BUFSIZE))
	{
		fprintf(stderr, "Escaped filename is too long!\n");
		exit(EXIT_FAILURE);
	}

	if (snprintf(buf, BUFSIZE, "/usr/bin/python /home/level/12/pytong.py '%s'", escaped_name) >= BUFSIZE)
	{
		fprintf(stderr, "Filename %s is too long!\n", filename);
		exit(EXIT_FAILURE);
	}

	unsetenv("PYTHONPATH");

	if (!(fp = popen(buf, "r")))
	{
		fprintf(stderr, "Command execution failed! Sorry!\n");
		exit(EXIT_FAILURE);
	}
	while(fgets(buf, sizeof(buf), fp)!=NULL)
	{
		printf("%s", buf);
	}
	if (0 == pclose(fp))
	{
		if(!(solution = fopen("/home/level/12/solution.txt", "r")))
		{
			fprintf(stderr, "Sorry! Solution is right but an error occured, please try again!\n");
			exit(EXIT_FAILURE);
		}
		while(fgets(buf, sizeof(buf), solution)!=NULL)
		{
			printf("%s", buf);
		}
		fclose(solution);

	}

	return EXIT_SUCCESS;
}
