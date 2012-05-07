#!/bin/bash
/usr/sbin/groupadd -g $1 $2
/usr/sbin/useradd -m -u $1 -g $1 -d /home/user/$2 -p "$3" -k /etc/skel -s /usr/local/bin/sudosh $2
/bin/chmod 0604 /home/user/$2/.bash*
/usr/bin/touch /home/user/$2/.bash_history
/bin/chmod 0606 /home/user/$2/.bash_history
/bin/chown root:root /home/user/$2/.bash*
/bin/chown root:root /home/user/$2/WELCOME.txt
/bin/chmod 0444 /home/user/$2/WELCOME.txt
