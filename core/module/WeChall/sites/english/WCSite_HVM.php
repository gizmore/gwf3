<?php
/**
 * https://hackmyvm.eu/userscore.php?username=sml
 * Response: 4:3420:363:0:14135
 * Format: score:maxscore:chall_count:challs_solved:usercount
 */
class WCSite_HVM extends WC_Site
{
    public function parseStats($url)
    {
        if (false === ($result = GWF_HTTP::getFromURL($url, false)))
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }

        $stats = explode(':', $result);
        if (count($stats) < 5)
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }

        $onsitescore = intval($stats[0]);
        $maxscore = intval($stats[1]);
        $challcount = intval($stats[2]);
        $challsolved = intval($stats[3]);
        $usercount = intval($stats[4]);

        if ($challcount === 0 || $usercount === 0)
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }

        return array($onsitescore, -1, $challsolved, $maxscore, $usercount, $challcount);
    }
}
