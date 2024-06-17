FROM mcr.microsoft.com/devcontainers/php:1-8.2-bookworm

# Install MariaDB client
RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client vim libfreetype6-dev libjpeg62-turbo-dev libpng-dev  \ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*

# Install php-mysql driver
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install mysqli pdo pdo_mysql gd 
RUN docker-php-ext-enable mysqli pdo pdo_mysql xdebug gd


RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN service apache2 restart

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

