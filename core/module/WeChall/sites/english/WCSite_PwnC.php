<?php
class WCSite_PwnC extends WC_Site
{
    public function parseStats($url)
    {
        if (false === ($result = GWF_HTTP::getFromURL($url, false)))
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }
        list($onsitescore, $maxscore) = explode(':', trim($result, '"'));
        $onsitesrank = -1;
        $challssolved = -1;
        $usercount = -1;
        $challcount = -1;
        if ($maxscore == 0)
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }
        return array($onsitescore, $onsitesrank, $challssolved, $maxscore, $usercount, $challcount);
    }
}
