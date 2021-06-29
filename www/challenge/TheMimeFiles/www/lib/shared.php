<?php
session_start();

###############
### Utility ###
###############
function html($s)
{
    return htmlspecialchars($s, ENT_HTML5, 'utf8');
}

function quote($s)
{
    return sprintf("'%s'", escape($s));
}

function escape($s)
{
    return str_replace(['"', "'"], ['\\"', '\\\''], $s);
}
