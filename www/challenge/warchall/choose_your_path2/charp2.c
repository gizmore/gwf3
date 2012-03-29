#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <unistd.h>

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
  int lines, chars, cpl;

  setregid(1012, 1012); // set real and effective GID to level11

  if (argc != 2)
  {
    fprintf(stderr, "Usage: %s filename\n", argv[0]);
    exit(EXIT_FAILURE);
  }
  
  filename= argv[1];
  printf("Counting %s ... \n", filename);

  if (!escape_single_quotes(escaped_name, filename, BUFSIZE))
  {
    fprintf(stderr, "Escaped filename is too long!\n");
    exit(EXIT_FAILURE);
  }

  if (snprintf(buf, BUFSIZE, "wc -l '%s'", escaped_name)>=BUFSIZE)
  {
    fprintf(stderr, "Filename %s is too long!\n", filename);
    exit(EXIT_FAILURE);
  }

  fp= popen(buf, "r");
  if (!fp)
  {
    fprintf(stderr, "Command execution failed! Sorry!\n");
    exit(EXIT_FAILURE);
  }
  if (1!=fscanf(fp, "%d", &lines))
  {
    fprintf(stderr, "Cannot scan! Sorry!\n");
  }
  pclose(fp);

  snprintf(buf, BUFSIZE, "wc -c '%s'", escaped_name);
  fp= popen(buf, "r");
  if (!fp)
  {
    fprintf(stderr, "Command execution failed! Bummer!\n");
    exit(EXIT_FAILURE);
  }
  if (1!=fscanf(fp, "%d", &chars))
  {
    fprintf(stderr, "Cannot scan! Sorry!\n");
  }
  pclose(fp);

  cpl= chars/lines;

  printf("Chars per line is %d.\n", cpl);

  return EXIT_SUCCESS;
}

