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

        $box_data = GWF_HTTP::getFromURL('http://status.labs.overthewire.org/wechall.json');
        $box_data = json_decode($box_data, true);
        foreach ($box_data as $data)
        {
            list($name, $hostname, $newIp) = $data;
            $box = WC_Warbox::getByName($name);
            if ($box)
            {
                $oldIp = $box->getVar('wb_ip');
                $oldIp2 = $box->getVar('wb_ip2');
                if ($newIp != $oldIp && $newIp != $oldIp2)
                {
                    if($oldIp2)
                    {
                        echo "[+] Box $name has a new First IP: $newIp\n";
                        $box->saveVars([
                            'wb_ip' => $newIp,
                            'wb_ip2' => '',
                        ]);
                    }
                    else
                    {
                        echo "[+] Box $name has a new Second IP: $newIp\n";
                        $box->saveVars([
                            'wb_ip2' => $newIp,
                        ]);
                    }
                }
            }
            else
            {
                echo "[-] Cannot find box $name\n";
            }
        }
    }
}
