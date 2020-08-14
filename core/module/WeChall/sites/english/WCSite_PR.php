<?php
class WCSite_PR extends WC_Site
{
    public function parseStats($url)
    {
        if (false === ($result = GWF_HTTP::getFromURL($url, false)))
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }
        
        $stats = json_decode($result, JSON_OBJECT_AS_ARRAY);
        
        $username = null;
        $onsitesrank = $stats['userRank'] ? $stats['userRank'] : -1;;
        $onsitescore = $stats['score'];
        $maxscore = $stats['maxScore'];
        $usercount = $stats['userCount'] ? $stats['userCount'] : -1;
        $challssolved = $onsitescore;
        $challcount = $maxscore-1;
        
        if ($maxscore === 0 || $challcount === 0)
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }
        
        return array($onsitescore, $onsitesrank, $challssolved, $maxscore, $usercount, $challcount);
    }
}
