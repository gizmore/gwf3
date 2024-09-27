<?php

/**
 * Refresh Warbox IPs
 */
class WC_OTW_Cronjob
{
    public function run(Module_WeChall $module)
    {
        if ($this->shouldRun($module))
        {
            $this->runHourly($module);
        }
    }

    private function shouldRun(Module_WeChall $module)
    {
        $date = date('YmdH');
        $last = $module->cfgOTWCronjobDate();
        if ($last == $date)
        {
            return false;
        }
        $module->saveModuleVar('wc_warbox_ip_date', $date);
        return true;
    }

    private function runHourly(Module_WeChall $module)
    {
        $module->includeClass('WC_Warbox');
        $boxes = WC_Warbox::getAllBoxes();
        foreach ($boxes as $box)
        {
            /** @var WC_Warbox $box */
            $host = $box->getVar('wb_host');
            $oldIp = $box->getVar('wb_ip');
            $newIp = gethostbyname($host);
            if ( ($oldIp != $newIp) && ($newIp !== $host) )
            {
                $box->saveVar('wb_ip', $newIp);
                echo "[+] $host has new IP: $newIp\n";
            }
        }
    }

}