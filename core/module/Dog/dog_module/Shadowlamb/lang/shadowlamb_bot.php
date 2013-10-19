<?php
$lang = array(
'ny' => '%s',
'lvl' => '%s',
'name' => 'NAME',
'none' => 'none',
'over' => 'over',
'bank' => '',
'items' => '',
'mount' => '',
'inventory' => '',
'unknown' => '?',
'unknown_contr' => '?',
'modifiers' => '%s',
'm' => '', # metres
'g' => '%d', # gram
'kg' => '%.02f', # kilogram
'busy' => '%s', # duration
'eta' => '%s', # duration
'hits1' => '; %s:%s', # player, damage
'hits2' => '; %s:%s:%s:%s', # player, damage, hp left, max hp
'kills' => '; %s:%s', # player, damage
'loot_nyxp' => ',%s,%.02f',
'page' => '%d,%d,%s',
'from_brewing' => 'FRBRW',
'members' => '%d',
'of' => '_of_',
'range' => '%s',
'atk_time' => '%s',
'worth' => '%s',
'weight' => '%s',
'forwards' => 'forwards',
'backwards' => 'backwards',
		
'fmt_exx' => '%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
'fmt_examine' => '%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',
'fmt_list' => ',%s', # item
'fmt_gain' => '%5$s,%1$s%2$.02f,%3$.02f,%4$.02f', # sign, gain, now, max, unit
'fmt_asl' => '%d,%d,%s', # age, height, weight
'fmt_requires' => '%s', # statted list
'fmt_mods' => ';%s:%s', # stat, value
'fmt_stats' => ',%4$s:%2$s:%5$s', # stat-long, base, (now), stat, now
'fmt_sumlist' => ',%2$s:%3$s', # enum, playername, summand
'fmt_cityquests' => ', %s,%.01f', # cityname, percent
'fmt_quests' => ',%2$s-%3$s', # boldy, id, name
'fmt_rawitems' => ', %s:%s', # id, itemname
'fmt_items' => ', %1$s:%2$s:%4$s', # id, itemname, (amt), amt
'fmt_itemmods' => ';%s:%s', # stat, value
'fmt_itemindex' => ', %1$s|%2$s|%5$s|%6$s', # id, itemname, dcount, dprice, count, price 
'fmt_effect' => ',%s:%s:%s', # stat, gain, duration
'fmt_equip' => ',%3$s:%2$s', # long type, item, short type
'fmt_hp_mp' => ',%6$s:%1$s:%2$s:%3$s:%4$s', #  need, enum, name, hp, maxhp
'fmt_spells' => ',%1$s:%2$s:%3$s:%5$s', # id, spellname, base, (adjusted), adjusted
'fmt_lvlup' => ',%1$s:%6$s:%2$s:%3$s', # field, tobase, karma, bold, K, couldbit
'fmt_giveitems' => ',%dx%s', # amt, itemname
'fmt_bazar_shop' => ', %d,%s,%s', # itemcount, itemname, price
'fmt_bazar_shops' => ', %s,%d', # player, itemcount
'fmt_bazar_search' => ', %s,%s,%s,%s', # player, itemname, amount, price
'fmt_xp' => ',%s|%s|%s|%s|%s|%s|%s', # enum, player, level, level xp, xp per level, karma xp, xp per karma

'pa_delete' => 'delete',
'pa_talk' => 'talk,%s,%s', # enemy party, duration,
'pa_fight' => 'fight,%s', # enemy party
'pa_inside' => 'inside,%s', # location
'pa_outside1' => 'outside,%s', # location
'pa_outside2' => 'outside,%s', # location
'pa_sleep' => 'sleep,%s', # location
'pa_travel' => 'travel,%s,%s', # location, duration
'pa_explore' => 'explore,%s,%s', # location, duration
'pa_goto' => 'goto,%s,%s', # location, duration
'pa_hunt' => 'hunt,%s,%s', # location, duration
'pa_hijack' => 'hijack,%s,%s,%s', # playername, location, duration

// # Stubs
// 'stub_found' => 'You found the %s. There is no description yet.', # location
// 'stub_enter' => 'You enter the %s. There is no text yet.', # location
// 'stub_shop_slogan' => 'Welcome to %s\'s shop.', # player
// 'stub_found_bazar' => 'You found the local bazar, a place where you can offer your items and purchase them.',
// 'stub_enter_bazar' => 'You enter the bazar. You see %d shops with a total of %d items.', # shopcount, itemcount
// 'stub_found_clanhq' => 'You found the clan headquarters.',
// 'stub_enter_clanhq' => 'You enter the clan headquarters.',
// 'stub_found_elevator' => 'You found the %s. A sign reads: "MAX %s KG".',
// 'stub_enter_elevator' => 'You enter the %s. A sign reads: "MAX %s KG".',
// 'stub_found_bank' => 'You found the Bank of %s. All transactions are done with slot machines.',
// 'stub_enter_bank' => 'You enter the Bank of %s. You see some customers at the counters and also some security officers.',
// 'stub_found_blacksmith' => 'You find a small store, "The Blacksmith". It seems like they can upgrade your equipment here.',
// 'stub_enter_blacksmith' => 'You enter the %s blacksmith. You see two dwarfs at the counter.',
// 'stub_found_hospital' => 'You found the local hospital. The sign reads: "Renraku Cyberware 20% off".',
// 'stub_enter_hospital' => 'You enter the huge building and are guided to a doctor.',
// 'stub_found_store' => 'You find a small Store. There are no employees as all transactions are done by slot machines.',
// 'stub_enter_store' => 'You enter the %s Store. No people or employees are around.',
// 'stub_found_subway' => 'You found the %s subway. You can travel to other cities from here.',
// 'stub_enter_subway' => 'You enter the subway and walk to the tracks.',

// # Ingame help
// 'hlp_in_outside' => 'When you find locations, you are outside of them. Use #goto or #enter to enter them. You can #(exp)lore again to find more locations.',
// 'hlp_clan_enter' => "Join clans with #abandon, #request and #accept. Create a clan with #create. Purchase more size and motto with #manage. Set options with #toggle. Access clan bank with #push, #pop and #view, clan money with #pushy and #popy.",
// 'hlp_bank' => "In a bank you can use #push and #pop to bank items, and #pushy and #popy to store nuyen. Use #view to list or search your banked items. Every transaction costs %s for you.",
// 'hlp_bazar' => "In the bazar you can sell your items. You can use #push, #pop, #view, #search, #buy, #bestbuy, #buyslot, #slogan and #price here.",
// 'hlp_elevator' => 'In elevators you can use #up, #down and #floor.',
// 'hlp_exit' => 'You can return to this location to #leave the building.',
// 'hlp_hotel' => 'You can pay %s to #sleep here and restore your party`s HP/MP.',
// 'hlp_hack' => ' You can use a Cyberdeck here to hack into a computer.',
// 'hlp_search' => ' You can use #search here to search the room for items.',
// 'hlp_second_hand' => 'You can sell statted items to higher prices here. The statted items that get sold here will stay in the shop.',
// 'hlp_store' => 'In this store you can use %s.',
// 'hlp_cyberdeck' => 'This item only works inside locations with computers.',
// 'hlp_cyberdeck_targets' => 'You don\'t see any Computers with a Headcomputer interface here.',
// 'hlp_start' => "{$b}Known races{$b}: %s. {$b}Known genders{$b}: %s.",
// 'hlp_blacksmith' => "At a blacksmith you can #upgrade equipment with runes. You can also #break items into runes or #clean them. It is also possible to #split runes. Also #view, #buy and #sell works here.",
// 'hlp_hospital' => 'Use #talk <topic> to talk to the doctor. Use #view, #implant and #unplant to manage your cyberware. Use #heal to pay some nuyen and get healed. Use #surgery to revert lvlup into karma.',
// 'hlp_talking1' => 'Use %s to talk to %s.',
// 'hlp_talking2' => 'Use %s to talk to the NPCs.',
// 'hlp_school' => 'In schools you can use #learn and #courses.',
		
############
### OOPS ###
############
# Workaround for Shadowclients #
'5275' => '5275: %2$s,%1$s', # entertext, location
);
?>
