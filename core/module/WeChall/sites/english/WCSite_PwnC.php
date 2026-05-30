<?php
class WCSite_PwnC extends WC_Site
{
    public function parseStats($result)
    {
        $resp = json_decode($result, true);
        if (isset($resp['error']))
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($resp['error']), $this->displayName())));
        }

        list($onsitesrank, $onsitescore, $maxscore, $challssolved, $challcount, $usercount) = explode(':', trim($result, '"'));
        if ($maxscore == 0)
        {
            return htmlDisplayError(WC_HTML::lang('err_response', array(GWF_HTML::display($result), $this->displayName())));
        }
        return array($onsitescore, $onsitesrank, $challssolved, $maxscore, $usercount, $challcount);
    }
}
