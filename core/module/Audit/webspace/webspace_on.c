#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <pwd.h>
#include <unistd.h>
#include <string.h>

#define BUFFER_SIZE 256
int main()
{
    struct passwd *passwd;
    passwd = getpwuid ( getuid());
    
    setuid(0); // THX dloser! ;)

    char command[BUFFER_SIZE];
    strncpy(command, "/usr/bin/php /opt/php/gwf3/core/module/Audit/webspace/webspace_on.php ", BUFFER_SIZE - 1);
    command[BUFFER_SIZE - 1] = '\0';
    strncat(command, passwd->pw_name, BUFFER_SIZE - strlen(command) - 1);

    return system(command);
}
