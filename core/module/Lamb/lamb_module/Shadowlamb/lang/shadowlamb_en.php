<?php
$c = "#";
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
'mount' => 'Mount',
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
'from_brewing' => 'brewing magic potions',

# Options
'opt_help' => 'Help',
'opt_lock' => 'Equipment Lock',
'opt_bot' => 'Player Botflag',
'opt_norl' => 'Permleader',
'enabled' => 'enabled',
'disabled' => 'disabled',


# PrintF-Formats
'fmt_list' => ', %s', # item
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
'fmt_giveitems' => ", {$b}%s x %s{$b}", # amt, itemname

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
'hlp_clan_enter' => "Join clans with {$c}abandon, {$c}request and {$c}accept. Create a clan with {$c}create. Purchase more size and motto with {$c}manage. Set options with {$c}toggle. Access clan bank with {$c}push, {$c}pop and {$c}view, clan money with {$c}pushy and {$c}popy.",

# Knowledge
'ks_words' => 'Word',
'ks_spells' => 'Spell',
'ks_places' => 'Place',
'kp_words' => 'Words',
'kp_spells' => 'Spells',
'kp_places' => 'Places',

# Party loot
'pl_unknown' => 'Unknown',
'pl_cycle' => 'Cycle',
'pl_random' => 'Random',
'pl_killer' => 'Killer',

##########################
#   0000-4999   = Errors #
##########################
'0000' => 'You did not #start the game yet. Type #start race gender to begin playing.',
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
'1018' => 'This playername is ambigous. Try the {server} version.',
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
'1033' => 'Your party is moving. Try this command when idle.',
'1034' => 'You cannot switch to running mode when you passed level 2.',
'1035' => 'In dungeons you don\'t have mounts.',
'1036' => 'This command does not work in combat.',
'1037' => 'You cannot store items in that mount.',
'1038' => 'Please specify a positive amount of items.',
'1039' => 'You cannot put mounts in your %s.', # mount name
'1040' => 'You have not that much %s.',
'1041' => 'Your %s(%s/%s) has no room for %d of your %s (%s).', # mountname, stored, storage, amt, itemname, weight
'1042' => 'You don`t have that item in your mount.',
'1043' => 'You don\'t have that much %s in your %s.', # itemname, mountname
'1044' => 'Please wait %s before you shout again.',  # duration
'1045' => 'Multiple players whispered you, so I quit with this message.',
'1046' => 'Nobody whispered you in the last %s.', # duration
'1047' => 'You need to learn alchemy first.',
'1048' => 'You don\'t have this spell.',
'1049' => 'You don\'t have the %s spell on that high level.', # spellname
'1050' => 'You do not have a WaterBottle.',
'1051' => 'Brewing the potion failed and the bottle is lost.',
'1052' => 'The "%s" spell works in combat only.', # spellname
'1053' => 'You cannot cast a spell with a level smaller than 0.',
'1054' => 'You cannot cast %s level %s because your spell level is only %s.', # spellname, levelneed, levelhave 
'1055' => 'You need %s MP to cast %s level %s, but you only have %s.', # needmp, spellname, level, #havemp
'1056' => 'You failed to cast %s. %s MP wasted.%s',
'1057' => 'The %s from %s failed.', # spellname, player
'1058' => 'You should not drop that item.',
'1059' => 'You cannot change your equipment in combat when it\'s locked.',
'1060' => 'You cannot attack this party again. Please wait %s.', # duration
'1061' => 'Funny. You give something to yourself. Problem?',
'1062' => 'Please specify a positive amount of nuyen.',
'1063' => 'You only have %s.', # nuyen
'1064' => 'This player is not in your party.',
'1065' => 'You can only remote control NPC',
'1066' => 'Only the following remote commands are allowed: %s.', # rawlist
'1067' => 'You don`t have a %s equipped.', # type
'1068' => 'You are already exploring %s. ETA: %s.',
'1069' => 'This location is unknown or ambigious.',
'1070' => 'This location does not exist in %s.',
'1071' => 'You are already in %s.',
'1072' => 'Please specify a target to teleport to.',
'1073' => 'This city is unknown.',
'1074' => 'You cannot cast teleport inside this lcoation.',
'1075' => 'You cannot teleport to %s because %s do(es) not have the min level of %s.',
'1076' => 'You need at least %s level %s to teleport %s party members.',
'1077' => 'You need %s MP to brew this potion, but you got only %s.',
'1078' => 'You cannot cast this spell inside a dungeon.',
'1079' => 'You cannot teleport into dungeons.',
'1080' => 'You cannot move because %s is dead.',
'1081' => 'You cannot move because %s is overladed.',
'1082' => 'You cannot move because %s has no #aslset.',
'1083' => 'You cannot hunt own party members.',
'1084' => 'You cannot hunt %s because you are in %s and %s is in %s.',
'1085' => 'You cannot join NPC parties.',
'1086' => 'You cannot join your own party.',
'1087' => 'The party does not want you to join.',
'1088' => 'The party has reached the maximum membercount of %d.',
'1089' => 'This player is not in your party.',
'1090' => 'You cannot kick yourself.',
'1091' => '%s is already the party leader.',
'1092' => 'You cannot give leadership to NPCs.',
'1093' => 'You are not in a party.',
'1094' => 'You should not use this command to swap leader position. Please use the #(le)ader command.',
'1095' => 'You are already leader of your party.',
'1096' => 'Your leader does not allow to takeover the leadership.',
'1097' => 'Please wait %s and try again.',
'1098' => '',
'1099' => '',
'1100' => '',
'1101' => '',
'1102' => '',
'1103' => '',
'1104' => '',
'1105' => '',
'1106' => '',
'1107' => '',
'1108' => '',
'1109' => '',
'1110' => '',

########################
# 10000-14999 = Spells #
########################
# Generic
'10000' => '%s uses a level %s %s potion on %s.',
'10001' => '%s casts a level %s %s on %s.',
'10002' => '%s uses a level %s %s potion on %s.',
'10003' => '%s casts a level %s %s on %s.',
# Berzerk
'10010' => '%s uses a level %s %s potion on %s, +%s min_dmg / +%s max_dmg for %s.',
'10011' => '%s casts a level %s %s on %s, +%s min_dmg / +%s max_dmg for %s.',
'10012' => '%s uses a level %s %s potion on %s.',
'10013' => '%s casts a level %s %s on %s.',
# Blow
'10020' => '%s uses a level %s %s potion on %s who got blown away %s and is now on position %s.',
'10021' => '%s casts a level %s %s on %s who got blown away %s and is now on position %s.',
'10022' => '%s uses a level %s %s potion on %s who got blown away %s and is now on position %s.',
'10023' => '%s casts a level %s %s on %s who got blown away %s and is now on position %s.',
# Chameleon
'10030' => '%s uses a level %s %s potion on %s, +%s charisma for %s.',
'10031' => '%s casts a level %s %s on %s, +%s charisma for %s.',
'10032' => '%s uses a level %s %s potion on %s.',
'10033' => '%s casts a level %s %s on %s.',
# Firebolt
'10040' => '%s uses a level %s %s potion on %s and caused %s damage.',
'10041' => '%s casts a level %s %s on %s and caused %s damage.',
'10042' => '%s uses a level %s %s potion on %s and caused %s damage, %s/%s HP left.',
'10043' => '%s casts a level %s %s on %s and caused %s damage, %s/%s HP left.',
# Freeze
'10050' => '%s uses a level %s %s potion on %s. %s seconds frozen with power %01f.',
'10051' => '%s casts a level %s %s on %s. %s seconds frozen with power %01f.',
'10052' => '%s uses a level %s %s potion on %s. %s seconds frozen with power %01f.',
'10053' => '%s casts a level %s %s on %s. %s seconds frozen with power %01f.',
# Goliath
'10060' => '%s uses a level %s %s potion on %s, +%s strength for %s.',
'10061' => '%s casts a level %s %s on %s, +%s strength for %s.',
'10062' => '%s uses a level %s %s potion on %s.',
'10063' => '%s casts a level %s %s on %s.',
# Hawkeye
'10070' => '%s uses a level %s %s potion on %s, +%s firearms for %s.',
'10071' => '%s casts a level %s %s on %s, +%s firearms for %s.',
'10072' => '%s uses a level %s %s potion on %s.',
'10073' => '%s casts a level %s %s on %s.',
# Hummingbird
'10080' => '%s uses a level %s %s potion on %s, +%s quickness for %s.',
'10081' => '%s casts a level %s %s on %s, +%s quickness for %s.',
'10082' => '%s uses a level %s %s potion on %s.',
'10083' => '%s casts a level %s %s on %s.',
# Magicarp
'10090' => '%s uses a level %s %s potion on %s and they lost %s MP.',
'10091' => '%s casts a level %s %s on %s, +%s and they lost %s MP.',
'10092' => '%s uses a level %s %s potion on %s and they lost %s MP.',
'10093' => '%s casts a level %s %s on %s and they lost %s MP.',
# Turtle
'10100' => '%s uses a level %s %s potion on %s, +%s marm/farm for %s.',
'10101' => '%s casts a level %s %s on %s, +%s marm/farm for %s.',
'10102' => '%s uses a level %s %s potion on %s.',
'10103' => '%s casts a level %s %s on %s.',
# Heal
'10110' => '%s uses a level %s %s potion on %s, %s.',
'10111' => '%s casts a level %s %s on %s, %s.',
'10112' => '%s uses a level %s %s potion on %s.',
'10113' => '%s casts a level %s %s on %s.',

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
'5070' => '%s has been already %s.', # option, en/disabled
'5071' => '%s has been %s for your character.', # option, en/disabled
'5072' => 'Your Shadowlamb message type was already set to %s.', # notice|privmsg
'5073' => 'Your Shadowlamb message type has been set to %s.', # notice|privmsg
'5074' => 'This is a test.',
'5075' => 'You are already playing running mode. Nice!',
'5076' => 'Type "#rm %s" to confirm.',
'5077' => 'You are now playing running mode. This means unlimited stats but instant death. Good luck!',
'5078' => 'It is advised you #enable norl now too, to prevent your char from beeing kidnapped with the #rl command!',
'5079' => 'Your mount page %s/%s: %s.', # page, pages, itemlist
'5080' => 'You stored %d of your %s in your %s.', # amt, itemname, mountname
'5081' => 'You collect %d %s from your %s and put it into your inventory (ID: %d).', # amt, itemname, mountname, invid
'5082' => 'You have cleaned your mount.',
'5083' => 'Party Mounts(%s/%s): %s.', # storage, max storage, sumlist
'5084' => "{$b}%s{$b} pm: \"%s\"", # player, message
'5085' => "{$b}%s{$b} says: \"%s\"", # player, message
'5086' => "{$b}%s{$b} whispers: \"%s\"", # player, message
'5087' => '%s', # bounties
'5088' => '%s', # own bounty
'5089' => '%s', # other bounty
'5090' => '%s moves %.01f meters %s and is now on position %.01f meters%s', # player, fw/bw, metres, busy (OWN)
'5091' => '%s moves %.01f meters %s and is now on position %.01f meters%s', # player, fw/bw, metres, busy (ENEMY)
'5092' => 'The enemy party said "bye".',
'5093' => 'You continue %s.', # action
'5094' => '%s thanked you and left the party.', # player
'5095' => 'You encounter %s.',
'5096' => 'You meet %s.%s%s',
'5097' => '%s moves %.01f meters towards %s and is now on position %.01f meters. %ds busy.',
'5098' => '%s moves %.01f meters towards %s and is now on position %.01f meters.',
'5105' => 'You loot %s and %s XP.', # nuyen, XP
'5110' => 'You are about to drop %d %s. Retype to confirm.', # amt itemname
'5111' => 'You got rid of %d %s.',
'5112' => '%s tried to flee from the combat. %s busy.', #player, duration
'5113' => '%s has fled from the enemy.', # player
'5114' => '%s has fled from combat.', # player
'5115' => 'You gave %d %s to %s.%s', # amt, item, player, busytime
'5116' => '%s received %s from %s.', # player, itemlist, source
'5117' => '%s told %s about %s.', # player, player, knowledge
'5118' => 'You received %s from %s.',
'5119' => 'You gave %s to %s.',
'5120' => 'You see no other players.',
'5121' => 'You see these players: %s.',
'5122' => 'Your default combat distance has been set to %.01f meters.',
'5123' => 'Distances: %s.', # sumlist
'5124' => 'Distances: %s.', # sumlist
'5125' => 'You get a reward of %s for killing the enemy.',
'5126' => 'You start to explore %s. ETA: %s.',
'5127' => 'You are going to %s. ETA: %s.',
'5128' => 'You see no mounts from other players to rob.',
'5129' => '%s', # Mount page
'5130' => 'Mounts to hijack: %s.',
'5133' => '%s used %s MP to cast %s and your party is now outside of %s.',
'5134' => 'You start to hunt %s. ETA: %s.',
'5135' => '%s left the party.',
'5136' => '%s joined the party.',
'5137' => '%s has been kicked off the party.',
'5138' => '%s is the new party leader.',
'5139' => "Your party has set it's loot mode to: {$b}%s{$b}.",
'5140' => '%s and %s have swapped their party position.',
'5141' => '',
'5142' => '',
'5143' => '',
'5144' => '',
'5145' => '',
'5146' => '',
'5147' => '',
'5148' => '',
'5149' => '',
'5150' => '',


);
?>
