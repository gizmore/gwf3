// gcc -shared -fPIC -Wl,-z,defs -Wl,--as-needed -o ssl_wrapper.so ssl_wrapper.c -ldl -lssl -lcrypto
// LD_PRELOAD=ssl_wrapper.so WARSOLVE_CERT=<path> WARSOLVE_PKEY=<path> WARSOLVE_PASS=<path> php warserver.php <args>

#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <dlfcn.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <openssl/bio.h> 
#include <openssl/ssl.h> 
#include <openssl/err.h> 

static int (*real_accept)(int, struct sockaddr *, socklen_t *) = NULL;
static int (*real_fork)() = NULL;
static int (*real_close)(int) = NULL;
static ssize_t (*real_recv)(int s, void *buf, size_t len, int flags);
static ssize_t (*real_send)(int s, const void *buf, size_t len, int flags);

int accept(int s, struct sockaddr *addr, socklen_t *addrlen);
int fork();
int close(int);
ssize_t recv(int s, void *buf, size_t len, int flags);
ssize_t send(int s, const void *buf, size_t len, int flags);

static int ssl_socket = -93; // initialize to invalid fd to avoid breaking forked sendmail's reads and writes
static SSL *ssl_ssl = NULL;
static SSL_CTX *ssl_ctx = NULL;
static int forked = 0;

#define MAX_PASS_SIZE (128)

static void init()
{
  if ( real_accept == NULL )
  {
    char *cert_path, *pkey_path, *pass_path;

    real_accept = (int (*)(int, struct sockaddr *, socklen_t *)) dlsym(RTLD_NEXT,"accept");
    real_fork = (int (*)()) dlsym(RTLD_NEXT,"fork");
    real_close = (int (*)(int)) dlsym(RTLD_NEXT,"close");
    real_recv = (ssize_t (*)(int s, void *buf, size_t len, int flags)) dlsym(RTLD_NEXT,"recv");
    real_send = (ssize_t (*)(int s, const void *buf, size_t len, int flags)) dlsym(RTLD_NEXT,"send");
    if ( (real_accept == NULL) || (real_accept == accept)
      || (real_fork == NULL) || (real_fork == fork)
      || (real_close == NULL) || (real_close == close)
      || (real_recv == NULL) || (real_recv == recv)
      || (real_send == NULL) || (real_send == send) )
    {
      fprintf(stderr,"could not load real functions!\n");
      real_accept = NULL;
      real_fork = NULL;
      real_close = NULL;
      real_recv = NULL;
      real_send = NULL;
      exit(1);
    }

    SSL_load_error_strings();
    SSL_library_init();
    OpenSSL_add_all_algorithms();

    cert_path = getenv("WARSOLVE_CERT");
    pkey_path = getenv("WARSOLVE_PKEY");
    pass_path = getenv("WARSOLVE_PASS");

    ssl_ctx = SSL_CTX_new(SSLv23_server_method());
    SSL_CTX_set_options(ssl_ctx, SSL_OP_SINGLE_DH_USE);

    if (cert_path != NULL)
    {
      if (!SSL_CTX_use_certificate_chain_file(ssl_ctx, cert_path))
      {
        ERR_print_errors_fp(stdout);
        SSL_CTX_free(ssl_ctx);
        exit(1);
      }
    }

    if (pass_path != NULL)
    {
      char pass[MAX_PASS_SIZE];
      int i;

      FILE *pass_fd = fopen(pass_path,"r");
      if (!pass_fd || !fgets(pass, MAX_PASS_SIZE, pass_fd))
      {
        perror("WARSOLVE_PASS");
        fprintf(stderr,"error: could not read password file\n");
        SSL_CTX_free(ssl_ctx);
        exit(1);
      }
      fclose(pass_fd);

      pass[MAX_PASS_SIZE-1] = '\0';
      for (i=strlen(pass)-1; (i>=0) && (pass[i] == '\n'); i--)
      {
        pass[i] = '\0';
      }

      SSL_CTX_set_default_passwd_cb_userdata(ssl_ctx, pass);
    }

    if (pkey_path != NULL)
    {
      if (!SSL_CTX_use_PrivateKey_file(ssl_ctx, pkey_path, SSL_FILETYPE_PEM))
      {
        ERR_print_errors_fp(stdout);
        SSL_CTX_free(ssl_ctx);
        exit(1);
      }
    }
  }
}

int accept(int s, struct sockaddr *addr, socklen_t *addrlen)
{
  int socket, ssl_err;
  SSL *ssl;

  init();

  socket = real_accept(s,addr,addrlen);

  if (socket < 0) // error, no actual socket
  {
    return socket;
  }

  ssl = SSL_new(ssl_ctx);
  SSL_set_fd(ssl, socket);
  ssl_err = SSL_accept(ssl);
  if(ssl_err <= 0)
  {
    ERR_print_errors_fp(stdout);
    SSL_shutdown(ssl);
    SSL_free(ssl);
    real_close(socket);
    return -1; // XXX set errno?
  }

  ssl_socket = socket;
  ssl_ssl = ssl;

  return socket;
}

int fork()
{
  int pid;


  init();

  if (forked)
  {
    return real_fork();
  }


  pid = real_fork();

  if (pid == 0)
  {
    forked = 1;
  } else if (pid > 0)
  {
    // no SSL_shutdown(ssl_ssl) as it also terminates connection in fork!
    SSL_free(ssl_ssl);
    real_close(ssl_socket);
  }

  return pid;
}

int close(int fd)
{

  init();

  if (forked && fd == ssl_socket)
  {
    forked = 0;
    SSL_shutdown(ssl_ssl);
    SSL_free(ssl_ssl);
    return real_close(ssl_socket);
  }

  return real_close(fd);
}

ssize_t recv(int s, void *buf, size_t len, int flags)
{

  init();

  if (!forked || (s != ssl_socket))
  {
    return real_recv(s,buf,len,flags);
  }
  
  // XXX what about flags
  return SSL_read(ssl_ssl,buf,len);
}

ssize_t send(int s, const void *buf, size_t len, int flags)
{

  init();

  if (!forked || (s != ssl_socket))
  {
    return real_send(s,buf,len,flags);
  }

  // XXX what about flags
  return SSL_write(ssl_ssl,buf,len);
}
