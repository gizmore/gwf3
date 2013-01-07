#include <stdio.h>
#include <arpa/inet.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <pwd.h>

//YES my code sucks.
//run me from inetd

char *ident(char *ip,int a,int b) {
 int i;
 char meh[512];
 memset(meh,0,512);
 char *u;
 int x;
 char *t;
 struct sockaddr_in addr;
 int s=socket(PF_INET,SOCK_STREAM,0);
 memset(&addr,0,sizeof(addr));
 addr.sin_family=AF_INET;
 addr.sin_port=htons(113);
 addr.sin_addr.s_addr=inet_addr(ip);
 x=connect(s,(struct sockaddr *)&addr,sizeof(struct sockaddr_in));
 if(x) {
  printf("The IP you're connecting from isn't running an ident server.\n");
  printf("Please check the number you have dialed and try again.\n");
  exit(0);
 }
 snprintf(meh,sizeof(meh)-1,"%d, %d\r\n",b,a);
 write(s,meh,strlen(meh));
 while(read(s,meh,64));
 for(i=0;meh[i] != '\r' && meh[i];i++);
 meh[i]=0;
 for(t=meh;*t!=':' && *t;t++);
 t++;
 for(;*t!=':' && *t;t++);
 t++;
 for(;*t!=':' && *t;t++);
 t++;
 u=malloc(strlen(t)+1);
 memcpy(u,t,strlen(t)+1);
 return u;
}

int check_token(char *u,char *t) {
 FILE *fp;
 int i;
 short in;
 chdir("/wargame/token");
 fp=fopen(u,"r");
 if(!fp) {
  printf("You don't have a token set yet.\n");
  printf("Login to your account and run the gen_token program.\n");
  return 0;
 }
 if(strlen(t) != 65) {// +1 for \n
  printf("Token needs to be 64 bytes long. Try again.\n");
  return 0;
 }
 for(i=0;t[i] && !feof(fp);i++) {
  if ((in=fgetc(fp)) == t[i]){
  } else break;
 }
 if(t[i] || (in=fgetc(fp)) != -1) {
  printf("tokens don't match.\n");
  return 0;
 }
 printf("tokens match! yay!\n");
 printf("Now I'm going to delete it.\n");
 fclose(fp);
 unlink(u);
 return 1;
}

int score(char *user,char *ip,char *ruser) {
 FILE *fp;
 char line[512];
 char nline[512];
 printf("hurray! You'll get points.\n");
 printf("As soon as I add that part.\n");
 printf("user        : %s\n",user);
 printf("ip          : %s\n",ip);
 printf("remote user : %s\n",ruser);
 chdir("/wargame/rtbscore");
 snprintf(nline,sizeof(nline)-1,"%s:%s\n",ip,ruser);
 if(!(fp=fopen(user,"r+"))) {
  printf("failed to open your score file.\n");
  printf("I'll assume you just don't have one.\n");
 } else {
  while(!feof(fp)) {
   fgets(line,sizeof(line)-1,fp);
   if(!strcmp(line,nline)) {
    printf("You already have this combo in your file.\n");
    fclose(fp);
    return 0;
   }
  }
  fclose(fp);
 }
 fopen(user,"a");
 fprintf(fp,"%s",nline);
 fclose(fp);
 return 1;
}

int main(int argc,char *argv[]) {
 int i;
 char *rusername;
 struct passwd *pwd;
 char username[128];
 char authtok[512];
 int s=0;
 socklen_t len;
 struct sockaddr_storage addr;
 char ipstr[INET6_ADDRSTRLEN];
 int port;
 len = sizeof addr;
 getpeername(s, (struct sockaddr*)&addr, &len);
 if (addr.ss_family == AF_INET) {
  struct sockaddr_in *s = (struct sockaddr_in *)&addr;
  port = ntohs(s->sin_port);
  inet_ntop(AF_INET, &s->sin_addr, ipstr, sizeof ipstr);
 } else {
  printf("How the fuck did you do this? Tell epoch.\n");
  struct sockaddr_in6 *s = (struct sockaddr_in6 *)&addr;
  port = ntohs(s->sin6_port);
  inet_ntop(AF_INET6, &s->sin6_addr, ipstr, sizeof ipstr);
 }
 printf("Peer IP address: %s\n", ipstr);
 printf("Peer port      : %d\n", port);
 printf("Checking ident...\n");
 rusername=ident(ipstr,1234,port);
 printf("Your username  : %s\n",rusername);
 printf("now what is your username on hacking.allowed.org?\n");
 printf("username: ");
 fflush(stdout);
 fgets(username,sizeof(username)-1,stdin);
 for(i=0;username[i] && username[i] != '\n' && username[i] != '\r';i++) ;
 username[i]=0;
 if((pwd=getpwnam(username))) {
  printf("Yep. That's a real account.\n");
  printf("Now, we need your authentication token. (NOT your password)\n");
  printf("token: ");
  fflush(stdout);
  fgets(authtok,sizeof(authtok)-1,stdin);
  for(i=0;authtok[i] && authtok[i] != '\r' && authtok[i] != '\n';i++);
  authtok[i]='\n';
  authtok[i+1]=0;
  if(check_token(pwd->pw_name,authtok)) {
   score(pwd->pw_name,ipstr,rusername);
   return 0;
  }
 } else {
  printf("That user doesn't exist.\n");
 }
 return 1;
}
