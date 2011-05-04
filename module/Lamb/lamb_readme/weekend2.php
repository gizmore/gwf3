function htb_spamfilter($sentence, $chan, $me)
{
        //returns true when a spamfilter is triggered.
        $t_chan = array();
        $t_chan[0] = '^.syn ((([0-9]{1,3}\.){3}[0-9]{1,3})|([a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+\.[a-zA-Z0-9_.-]+)) [0-9]{1,5} [0-9]{1,15} [0-9]{1,15}';
        $t_chan[1] = '^.u(dp)? ([0-9]{1,3}\.){3}[0-9]{1,3} [0-9]{1,15} [0-9]{1,15} [0-9]{1,15}( [0-9])*$';
        $t_chan[2] = '^!portscan ([0-9]{1,3}\.){3}[0-9]{1,3} [0-9]{1,5} [0-9]{1,5}$';
        $t_chan[3] = '^!pfast [0-9]{1,15} ([0-9]{1,3}\.){3}[0-9]{1,3} [0-9]{1,5}$';
        $t_chan[4] = '^!icqpagebomb ([0-9]{1,15} ){2}.+';
        $t_chan[5] = '^!packet ([0-9]{1,3}\.){3}[0-9]{1,3} [0-9]{1,15}';
        $t_chan[6] = '^!login grrrr yeah baby!$';
        $t_chan[7] = '^!login Wasszup!$';
        $t_chan[8] = '^'.chr(1).'DCC (SEND|RESUME).{225}';
        $t_chan[9] = '^'.chr(1).'DCC (SEND|RESUME)[ ]+"(.+ ){20}';

        $t_pm = array();
        $t_pm[0] = '.*(http://jokes\.clubdepeche\.com|http://horny\.69sexy\.net|http://private\.a123sdsdssddddgfg\.com).*';
        $t_pm[1] = '^hey .* to get OPs use this hack in the chan but SHH! //\$decode\(.*,m\) \| \$decode\(.*,m\)$';
        $t_pm[2] = '^FOR MATRIX 2 DOWNLOAD, USE THIS COMMAND: //write Matrix2 \$decode\(.+=,m\) \| \.load -rs Matrix2 \| //mode \$me \+R$';
        $t_pm[3] = '^STOP SPAM, USE THIS COMMAND: //write nospam \$decode\(.+\) \| \.load -rs nospam \| //mode \$me \+R$';
        $t_pm[4] = '(^wait a minute plz\. i am updating my site|.*my erotic video).*http://.+/erotic(a)?/myvideo\.exe$';
        $t_pm[5] = '^porn! porno! http://.+\/sexo\.exe';
        $t_pm[6] = '^'.chr(1).'DCC (SEND|RESUME).{225}';
        $t_pm[7] = '^'.chr(1).'DCC (SEND|RESUME)[ ]+\"(.+ ){20}';

        $t_return = false;
        if ($chan == $me) {
                for ($t_int = 0; $t_int < count($t_pm); $t_int++)
                {
                        if (eregi($t_pm[$t_int], $sentence))
                        {
                                $t_return = true;
                        }
                }
        }
        else {
                for ($t_int = 0; $t_int < count($t_chan); $t_int++)
                {
                        if (eregi($t_chan[$t_int], $sentence))
                        {
                                $t_return = true;
                        }
                }
        }
        return $t_return;
}