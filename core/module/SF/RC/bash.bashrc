# If not running interactively, don't do anything
[[ $- != *i* ]] && return

export EDITOR='vim'
export LANG='de_DE.UTF-8'
export LC_COLLATE='C'
export PAGER='less'

shopt -s cdspell
shopt -s checkwinsize
shopt -s cmdhist
shopt -s histappend
shopt -s hostcomplete
shopt -s nocaseglob

if [ -d ~/bin ]; then
	export PATH="$PATH":~/bin
fi

if [ -f /etc/bash_aliases ]; then
	. /etc/bash_aliases
fi

if [ -f ~/.bash_aliases ]; then
	. ~/.bash_aliases
fi

if [ -f /etc/bash_completion ]; then
	. /etc/bash_completion
fi

[ -x /usr/bin/lesspipe ] && eval "$(SHELL=/bin/sh lesspipe)"

#TODO
seed=$(hostname -f | md5sum | tr -dc '1234567')
hc1=${seed:1:1}
hc2=${seed:2:1}

PS1="\${debian_chroot:+\[\e[01;31m\](\$debian_chroot)}\[\e[01;3${hc1}m\]\u\[\e[00m\]@\[\e[01;3${hc2}m\]\h\[\e[00m\]: \[\e[01;34m\]\w\[\e[00m\]\n\[\e[00;33m\]\t\[\e[00;32m\](\$? J\j !\! #\#)\[\e[00m\]\\\$ "
PS2='> '
PS3='> '
PS4='+ '

return
## OLD...
NCC='\[\033[0m\]'      # no color
txtblk='\[\e[0;30m\]' # Black - Regular
txtred='\[\e[0;31m\]' # Red
txtgrn='\[\e[0;32m\]' # Green
NC='\[\e[0;32m\]' # Green
txtylw='\[\e[0;33m\]' # Yellow
txtblu='\[\e[0;34m\]' # Blue
txtpur='\[\e[0;35m\]' # Purple

#PS1="\n${NC}[${txtgrn}\t${NC}] ${txtred}\w\n${NC}[${txtred}\u${NC}@${txtblu}\H${NC}]#\#\n${txtred}\$${NCC} "
#PS1='\[\e[m\n\e[1;30m\][$$:$PPID \j:\!\[\e[1;30m\]]\[\e[0;36m\] \T \d \[\e[1;30m\][\[\e[1;34m\]\u@\H\[\e[1;30m\]:\[\e[0;37m\]${SSH_TTY} \[\e[0;32m\]+${SHLVL}\[\e[1;30m\]] \[\e[1;37m\]\w\[\e[0;37m\] \n($SHLVL:\!)\$ '

