<?php

function trying()
{
    $secrets = require __DIR__ . '/secret.php';
    foreach ($secrets as $n => $fib)
    {
        $url = $_POST['host'] . $n;
        echo "Trying $url<br/>\n";
        flush();
        $a = microtime(true);
        $result = trim(GWF_HTTP::getFromURL($url));
        echo "Got $result<br/>\n";
        $b = microtime(true);
        if (strlen($result) != 32)
        {
            echo "Not an MD5 Hash!<br/>\n";
            return false;
        }
        if (strtolower($result) !== strtolower($fib))
        {
            echo "MD5 does not match!<br/>\n";
            return false;
        }
        if ( ($b - $a) > 2.618)
        {
            echo "Too slow!<br/>\n";
            return false;
        }
        echo "Correct!<br/>\n";
    }
    return true;
}
