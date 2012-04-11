#!/bin/bash
gcc wrap.c -o pytong
chown spaceone:level13 pytong
chown spaceone:level13 pytong.py
chmod 2755 pytong pytong.py
