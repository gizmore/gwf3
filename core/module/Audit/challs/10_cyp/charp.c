#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <unistd.h>

#define BUFSIZE 256

int main(int argc, char *argv[])
{
  FILE *fp;
  char buf[BUFSIZE];
  char *filename;
  int lines, chars, cpl;

  setregid(1011,1011); // set real and effective GID to level10

  if (argc != 2)
  {
    fprintf(stderr, "Usage: %s filename\n", argv[0]);
    exit(EXIT_FAILURE);
  }
  
  filename= argv[1];
  printf("Counting %s ... \n", filename);

  if (snprintf(buf, BUFSIZE, "/usr/bin/wc -l %s", filename)>=BUFSIZE)
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

  snprintf(buf, BUFSIZE, "/usr/bin/wc -c %s", filename);
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

