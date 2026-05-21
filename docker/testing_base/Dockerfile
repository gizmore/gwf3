# at time of writing, this is debian:buster
FROM debian

RUN apt-get update

# some basic tools
RUN apt-get install -y less nano vim procps python3 && apt-get clean

# at time of writing, these are php-cli7.3 and mariadb-server-10.3
RUN apt-get install -y php-cli php-mbstring php-curl php-mysql mariadb-server && apt-get clean

# set up volumes and mariadb
RUN mkdir /db_data /gwf3_src /gwf3_run /var/run/mysqld && chown mysql:mysql /db_data /var/run/mysqld && mysql_install_db --datadir=/db_data
VOLUME /db_data
VOLUME /gwf3_src
VOLUME /gwf3_run

COPY testing_base_boot.sh /

# mysql
EXPOSE 3306

ENTRYPOINT [ "/testing_base_boot.sh" ]
CMD [ "/bin/bash" ]
