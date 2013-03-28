#include <stdlib.h>
#include <stdio.h>
#include <sys/file.h>
#include <sys/types.h>
#include <fcntl.h>
#include <string.h>

#define RLOG_ID_FILE_PATH		"/var/lib/sudosh_rlog/"
#define RLOG_ID_FILE 			RLOG_ID_FILE_PATH "rlogid"



int main (int argc, char *argv[], char *environ[]) {
	FILE *idFile;
	int fd;
	char buff[32];
	unsigned long id = 1;

	
	fd = open(RLOG_ID_FILE, O_RDWR);	
	if (fd != -1) {	
		flock(fd, LOCK_EX);
		idFile = fdopen(fd, "r+");
		
	
		if (fgets(buff, sizeof(buff), idFile)) 
			id = strtoul(buff, NULL, 10);
	} else {
		idFile = fopen(RLOG_ID_FILE, "w+");
	}

	printf("%lu", id);

	if (idFile) {
		snprintf(buff, sizeof(buff), "%lu", ++id);
		rewind(idFile);
		fprintf(idFile, "%s", buff);
		if (fd != -1)
			flock(fd, LOCK_UN);
		fclose(idFile);
		close(fd);
		truncate(RLOG_ID_FILE, strlen(buff));
	}


	return 0;
}

