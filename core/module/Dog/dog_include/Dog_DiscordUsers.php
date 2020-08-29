<?php

final class Dog_DiscordUsers extends GDO
{
    public function getClassName() { return __CLASS__; }
    public function getTableName() { return GWF_TABLE_PREFIX.'dog_discord_users'; }
    public function getColumnDefines()
    {
        return array(
            'du_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
            'du_guid' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 24),
        );
    }
    
    public function getGUID() { return $this->getVar('du_guid'); }
    
    public static function getOrCreateEntry($username, $guid)
    {
        $eusername = GDO::escape($username);
        if ($user = self::table(__CLASS__)->selectFirstObject('*', "du_name='$eusername'"))
        {
            return $user;
        }
        $user = new self(array(
            'du_name' => $username,
            'du_guid' => $guid,
        ));
        $user->insert();
        return $user;
    }
    
    public static function getGUIDFor($username)
    {
        $eusername = GDO::escape($username);
        if ($entry = self::table(__CLASS__)->selectFirst('*', "du_name='$eusername'"))
        {
            return $entry['du_guid'];
        }
    }
    
}
