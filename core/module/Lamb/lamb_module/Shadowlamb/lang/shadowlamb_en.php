<?php
$b = chr(2);
/**
 * Please respect weird punctuations when doing human readable translations
 * Examples: .leading dot. missing dots,  leading spaces Etc. 
 */
$lang = array(
############
### Bits ###
############
# Tiny bits
'name' => 'Name',
'none' => 'None',
'over' => 'Over',
'items' => 'Items',
'unknown' => 'Unknown',
'unknown_contr' => 'Unknown Contactors',
'modifiers' => " {$b}Modifiers{$b}: %s.", # statlist
'm' => 'm', # metres
'g' => '%dg', # gram
'kg' => '%.02fkg', # kilogram
'busy' => '%s busy.', # duration
'eta' => 'ETA: %s.', # duration
'hits1' => ', hits %s with %s damage', # player, damage
'hits2' => ', hits %s with %s(%s/%s)HP left', # player, damage, hp left, max hp
'kills' => ', kills %s with %s', # player, damage
'loot_nyxp' => '. You loot %s and %.02f XP',
'page' => 'page %d/%d: %s.',

# PrintF-Formats
'fmt_gain' => '%s%.02f(%.02f/%.02f)%s', # sign, gain, now, max, unit
'fmt_asl' => "{$b}Age{$b}:%d, %dcm %s", # age, height, weight
'fmt_requires' => " {$b}Requires{$b}: %s.", # statted list
'fmt_stats' => ", {$b}%s{$b}:%s%s", # stat-long, base, (now), stat, now
'fmt_cityquests' => ', %s(%.01f%%)', # cityname, percent
'fmt_sumlist' => ", {$b}%s{$b}-%s(%s)", # enum, playername, summand
'fmt_quests' => ", %1\$s%2\$d%1\$s-%3\$s", # boldy, id, name
'fmt_rawitems' => ", {$b}%s{$b}-%s", # id, itemname
'fmt_items' => ", {$b}%s{$b}-%s%s", # id, itemname, (amt), amt
'fmt_effect' => ", {$b}%s{$b}:%s(%s)", # stat, gain, duration
'fmt_equip' => ", {$b}%s{$b}:%s", # long type, item, short type
'fmt_hp_mp' => ", {$b}%1\$s{$b}-%2\$s%5\$s(%3\$s/%4\$s)%5\$s", # $member->getEnum(), $member->getName(), $hpmp, $hpmmpm, $b2, $b1
'fmt_spells' => ", {$b}%s{$b}-%s:%s%s", # id, spellname, base, (adjusted), adjusted
'fmt_lvlup' => ', %4$s%1$s%4$s:%2$s(%4$s%3$s%5$s%4$s)', # field, tobase, karma, bold, K, couldbit

# Party actions in "You are %s", "Your party is %s", (UGLY)
'empty_party' => 'an empty party',
'last_action' => ' Last action: %s %s. %s.', # last action, last target, last durcation
'pa_delete' => "{$b}beeing deleted{$b}.",
'pa_talk' => "{$b}talking{$b} to %s. %s remaining.%s", # enemy party, duration, last action
'pa_fight' => "{$b}fighting{$b} against %s.%s", # enemy party last action.
'pa_inside' => "{$b}inside{$b} %s.", # location
'pa_outside1' => "{$b}outside{$b} of %s.", # location
'pa_outside2' => "somewhere inside %s.", # location
'pa_sleep' => "{$b}sleeping{$b} inside %s.", # location
'pa_travel' => "{$b}travelling{$b} to %s. %s remaining.", # location, duration
'pa_explore' => "{$b}exploring{$b} %s. %s remaining.", # location, duration
'pa_goto' => "{$b}going{$b} to %s. %s remaining.", # location, duration
'pa_hunt' => "{$b}hunting{$b} %s. %s remaining.", # location, duration
'pa_hijack' => "{$b}hijacking{$b} %s at %s. %s remaining.", # playername, location, duration

# Quest states
'qu_open' => 'Open',
'qu_deny' => 'Denied',
'qu_done' => 'Done',
'qu_fail' => 'Failed',
'qu_abort' => 'Aborted',

# Sums
'sum_age' => 'ages',
'sum_bmi' => 'body masses',
'sum_height' => 'heights',

# Stubs
'stub_found' => 'You found the %s. There is no description yet.', # location
'stub_enter' => 'You enter the %s. There is no text yet.', # location
'stub_shop_slogan' => 'Welcome to %s\'s shop.', # player

# Clan history
'ch_0' => '%s created the clan %s.', # player, clanname
'ch_1' => '%s requested to join your clan as member #%s.', # player, membernum
'ch_2' => '%s has joined your clan as member #%s.', # player, membernum
'ch_3' => '%s has left your clan and it now holds %s members.', # player, amt
'ch_4' => "{$b}%s{$b}: \"%s\"", # player, message
'ch_5' => '%s has pushed %s into the clanbank.', # player, nuyen
'ch_6' => '%s has taken %s out of the clanbank.', # player, nuyen
'ch_7' => '%s has put %s %s into the clanbank.', # player, amt, item 
'ch_8' => '%s has taken %s %s out of the clanbank.', # player, amt, item
'ch_9' => '%s has purchased more member slots and the clan can now hold up to %s.', # player, memberslots
'ch_10' => '%s has purchased more nuyen capacity and the clan can now hold up to %s.', # player, maxnuyen
'ch_11' => '%s has purchased more storage room and the clan can now hold up to %s.', # player, maxstorage

# Bounty
'meet_bounty' => " There is a {$b}bounty{$b} on %s.", # sumlist
'no_bounty' => 'This player has no bounty.',
'total_bounty' => "There is a total {$b}bounty of %s{$b} for %s: %s.", # total, player, details
'no_bounties' => 'There are no bounties at the moment.',
'bounty_page' => 'Bounties page %s/%s: %s.',

# Bad karma
'info_bk' => ', %s has %d bad_karma', # player, badkarma

# Ingame help
'hlp_in_outside' => 'When you find locations, you are outside of them. Use #goto or #enter to enter them. You can #(exp)lore again to find more locations.',

# Knowledge
'ks_words' => 'Word',
'ks_spells' => 'Spell',
'ks_places' => 'Place',
'kp_words' => 'Words',
'kp_spells' => 'Spells',
'kp_places' => 'Places',


##########################
#   0000-4999   = Errors #
##########################
'0000' => 'You did not #start the game yet.',
'0001' => 'You need to login to play.',
		
'1002' => 'You need at least level %d to shout.', # level
'1003' => 'Please wait %s before you shout again.', # duration
'1004' => 'You have no %s quests.', # section
// '1005' => 'You don\'t know any word.',
'1006' => 'You do not meet the requirements: %s.', # statted-list
'1007' => 'No items found that match the search pattern.',
'1008' => 'There are no items here.',
'1009' => 'No such page!',
'1010' => 'There are no quests here.',
'1011' => 'You did not setup your asl with {$b}#aslset{$b} yet. You need to do this to start moving in the game.',
'1012' => 'The target is unknown.',
'1013' => 'You can not use this item.',
'1014' => 'You can not equip this item.',
'1015' => 'Your party (level sum %d) cannot attack a party with level sum %d because the level difference is larger than %d.',
'1016' => 'You already have your asl set to: %s.', # aslstring
'1017' => 'This player is unknown or not in memory.',
'1018' => 'This playername is ambigous.',
'1019' => 'You are not in a clan, chummer.',
'1020' => 'I don\'t know what item "%s" is.', # itemname
'1021' => 'You don`t have anything comparable to "%s" equipped.', # itemname
'1022' => 'You are not in a store.',
'1023' => 'You don\'t have this knowledge.',
'1024' => 'You can only levelup attributes, skills, knowledge and spells. Also you cannot levelup your essence.',
'1025' => 'You need to learn %s first.', # field
'1026' => 'You already have reached the max level of %d for %s.',
'1027' => 'You need %d karma to increase your base level for %s from %d to %d, but you only have %d karma.',
'1028' => '%s is not here or the name is ambigous.',
'1029' => 'You don\'t have this item.',
'1030' => 'You can\'t swap the same things.',
'1031' => 'You are not outside of a location.',
'1032' => 'You are not the party leader.',
'1033' => '',
'1034' => '',
'1035' => '',
'1036' => '',
'1037' => '',
'1038' => '',
'1039' => '',
'1040' => '',


############################
#   5000-9999   = Messages #
############################
'5000' => '%s just quit his irc server.', # username 
'5001' => 'You awake and have a delicious breakfast.',
'5002' => 'You are ready to go.',
'5003' => 'The party advanced to level %s.', # level
'5004' => 'Your attributes: %s.', # statlist
'5005' => 'Inventory',
'5006' => 'Your skills: %s.', # statlist
'5007' => 'Known Places in %s: %s.', # cityname, places
'5008' => 'Your party has %s: %s.', # nuyen sum, party sum list
'5009' => 'Quest stats per city: %s.', # questlist
'5010' => 'Quest stats: %d open, %d accomplished, %d rejected, %d failed, %d unknown from a total of %d.',
'5011' => '%d: %s - %s (%s)', # questid, questname, describtion, status
'5012' => 'Your asl: %s. Use #asl [<age|bmi|height>] for party sums.',
'5013' => 'Your party\'s %s(%s): %s.', # field, total, sumlist
# Gender Race L(LL), HP/HPP MP/MPP, ATK, DEF, DMG-DDMG, MARM/FARM, XP, Karma, NY, WEIGHT/WWEIGHT
# Status with magic
'5014' => "%s %s L%s(%s). {$b}HP{$b}:%s/%s, {$b}MP{$b}:%s/%s, {$b}Atk{$b}:%s, {$b}Def{$b}:%s, {$b}Dmg{$b}:%s-%s, {$b}Arm{$b}(M/F):%s/%s, {$b}XP{$b}:%.02f, {$b}Karma{$b}:%s, {$b}¥{$b}:%.02f, {$b}Weight{$b}:%s/%s.",
# Status without magic
'5015' => "%s %s L%s(%s). {$b}HP{$b}:%s/%s, {$b}Atk{$b}:%s, {$b}Def{$b}:%s, {$b}Dmg{$b}:%s-%s, {$b}Arm{$b}(M/F):%s/%s, {$b}XP{$b}:%.02f, {$b}Karma{$b}:%s, {$b}¥{$b}:%.02f, {$b}Weight{$b}:%s/%s.",
# Party status
'5016' => 'You are %s', # action
'5017' => 'You are leading %d members (%s) and you are %s', # membercount, memberlist, action
'5018' => 'Your party (%s) is %s', # memberlist, action
'5019' => 'Old message: %s', # message
'5020' => 'You exit the %s.', # location
'5021' => 'You hear the alarm sound!',
'5022' => 'Your hacking attempt failed.',
'5023' => 'Your join request has been sent to the clan leaders.',
'5024' => 'Your target for hijacking (%s) gone away.', # target
'5025' => '%s has left %s.', # target, location
'5026' => '%s is in your party now.', # target
'5027' => 'You explored %s again, but it seems you know every single corner of it.', # cityname
'5028' => 'You explored %s again, but could not find anything new.', # cityname
'5029' => '%s', # location found text
'5030' => '%s', # inngame help message
'5031' => 'You have lost your target and continue in the streets of %s.', # cityname
'5032' => 'You found %s at %s with a party of %s members.', # target, location, membercount
'5033' => 'You found %s in the streets of %s.', # target, cityname
'5034' => "You collected a {$b}bounty{$b}: %s.", # nuyen
'5035' => '%s have been booked to your bank account for selling %s %s to %s.', # nuyen, amt, item, player
'5036' => 'Your character has been punished with %.02f bad_karma.', # bad karma
'5037' => 'Hidden commands: %s.', # cmdlist
'5038' => 'Player %s does not belong to a clan yet.', # player
'5039' => '%s is in the "%s" clan with %s/%s members, %s/%s wealth and %s/%s in the bank. Their motto: %s',
'5040' => '%d ClanMembers page %d/%d: %s.', # membercount, page, npages, sumlist
'5041' => 'ClanHistory page %d/%d: %s.', # page, npages, weird msglist
'5042' => 'Cmds: %s.',
'5043' => '%s', # Compare table messages, 3 rows
'5044' => '%s', # Unknown table messages, multiple rows
'5045' => 'Your cyberware: %s.', # itemlist
'5046' => 'You surely forgot about the %s "%s".', # section, knowledge
'5047' => 'Your effects: %s.', # effectlist
'5048' => 'Your equipment: %s.', # equipstring
'5049' => '%s', # examine string
'5050' => 'Your parties HP: %s.', # HP/MP string
'5051' => 'Your parties MP: %s.', # HP/MP string
'5052' => 'Your party has %s karma: %s.', # total, sumlist
'5053' => 'Your knowledge: %s.', # statlist
'5054' => 'Known spells: %s.', # spellfmtlist
'5055' => 'Known Words: %s.', # #rawitemlist
'5056' => 'Your party has level %s(%s/%s): %s.', # total level, xp , need xp, sumlist
'5057' => 'Skills to upgrade: %s.', # lvlupstring
'5058' => 'Attributes to upgrade: %s.', # lvlupstring
'5059' => 'Knowledge to upgrade: %s.', # lvlupstring
'5060' => 'Spells to upgrade: %s.', # lvlupstring
'5061' => 'You used %d karma and leveled up your %s from %d to %d.', # karma, field, from, to
'5062' => "{$b}%s{$b} shows you: %s.", # player, examinestring
'5063' => 'Items %s and %s have been swapped.', # itemname, itemname
'5064' => 'Your party carries %s: %s.', # total weight, sumlist
'5065' => 'Your party does not accept new members anymore.',
'5066' => 'Your party does accept new members again.',
'5067' => '%s has been banned from the party.',
'5068' => '%s may now join your party again.',
'5069' => '%s quests, page %d/%d: %s.',
'5070' => '',
'5071' => '',
'5072' => '',
'5073' => '',
'5074' => '',
'5075' => '',
'5076' => '',
'5077' => '',
'5078' => '',
'5079' => '',
'5080' => '',


);
?>
