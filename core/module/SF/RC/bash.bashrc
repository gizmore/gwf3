# If not running interactively, don't do anything
[[ $- != *i* ]] && return

export EDITOR='vim'
export LANG='de_DE.UTF-8'
#export LC_COLLATE='C'
export PAGER='less'
export PYTHONDONTWRITEBYTECODE=x

shopt -s cdspell
shopt -s checkwinsize
shopt -s cmdhist
shopt -s histappend
shopt -s hostcomplete
shopt -s nocaseglob

[ -d ~/bin ] && export PATH="~/bin:$PATH"

[ -r /etc/bash_aliases ] && . /etc/bash_aliases
[ -r ~/.bash_aliases ] && . ~/.bash_aliases

[ -r /etc/bash_completion ] && . /etc/bash_completion
[ -r /usr/share/bash-completion/bash_completion ] && . /usr/share/bash-completion/bash_completion
[ -x /usr/bin/lesspipe ] && eval "$(SHELL=/bin/sh lesspipe)"

#TODO
seed=$(hostname -f | md5sum | tr -dc '1234567')
hc1=${seed:1:1}
hc2=${seed:2:1}

PS1="\${debian_chroot:+\[\e[01;31m\](\$debian_chroot)}\[\e[01;3${hc1}m\]\u\[\e[00m\]@\[\e[01;3${hc2}m\]\h\[\e[00m\]: \[\e[01;34m\]\w\[\e[00m\]\n\[\e[00;33m\]\t\[\e[00;32m\](\$? J\j !\! #\#)\[\e[00m\]\\\$ "
PS2='> '
PS3='> '
PS4='+ '
