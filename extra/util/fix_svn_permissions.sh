#!/bin/bash
find -name '*.php' -perm /u=x,g=x,o=x -exec svn propdel svn:executable {} \;
