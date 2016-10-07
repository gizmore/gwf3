#!/bin/bash
BASE=`pwd`
cd $BASE
cd ../../../../www
google-chrome-stable --disable-web-security  "tpl/wanda/farbrat.html"
