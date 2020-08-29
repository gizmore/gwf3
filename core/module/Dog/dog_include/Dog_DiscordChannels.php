<?php
final class Dog_DiscordChannels extends GDO
{
    public function getClassName() { return __CLASS__; }
    public function getTableName() { return GWF_TABLE_PREFIX.'dog_discord_channels'; }
    public function getColumnDefines()
    {
        return array(
            'dc_name' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S|GDO::PRIMARY_KEY, GDO::NOT_NULL, 63),
            'dc_guild' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 24),
            'dc_channel' => array(GDO::VARCHAR|GDO::ASCII|GDO::CASE_S, GDO::NOT_NULL, 24),
        );
    }
    
    public function getGuild() { return $this->getVar('dc_guild'); }
    public function getChannel() { return $this->getVar('dc_channel'); }
    
    public static function getOrCreateEntry($channelname, $guild, $channel)
    {
        $echannelname = GDO::escape($channelname);
        if ($chan = self::table(__CLASS__)->selectFirstObject('*', "dc_name='$echannelname'"))
        {
            return $chan;
        }
        $chan = new self(array(
            'dc_name' => $channelname,
            'dc_guild' => $guild,
            'dc_channel' => $channel,
        ));
        $chan->insert();
        return $chan;
    }
    
    public static function getEntry($channel_name)
    {
        $ename = ltrim(GDO::escape($channel_name), '#');
        return self::table(__CLASS__)->selectFirstObject('*', "dc_name='$ename'");
    }

}
