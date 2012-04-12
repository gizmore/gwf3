#!/bin/bash
gcc wrap.c -o pytong
chown spaceone:level12 pytong pytong.py
chmod 2755 pytong pytong.py
