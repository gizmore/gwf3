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
  char *filename = "*-solution.txt";
  int lines, chars, cpl;

  setregid(1645,1645); // set real and effective GID to levelxx

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
  while (1==fscanf(fp, "%d", &lines))
  {
    fgets(buf, BUFSIZE, fp);
  }
  pclose(fp);

  snprintf(buf, BUFSIZE, "/usr/bin/wc -c %s", filename);
  fp= popen(buf, "r");
  if (!fp)
  {
    fprintf(stderr, "Command execution failed! Bummer!\n");
    exit(EXIT_FAILURE);
  }
  while (1==fscanf(fp, "%d", &chars))
  {
    fgets(buf, BUFSIZE, fp);
  }
  pclose(fp);

  cpl= (chars*lines) ? chars/lines : 0;

  printf("Chars per line is %d.\n", cpl);

  return EXIT_SUCCESS;
}
