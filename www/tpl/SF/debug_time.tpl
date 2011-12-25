{assign var="timings" value=GWF_DebugInfo::getTimings()}
SQL: {$timings['t_sql']|string_format:"%.03f"}s ({$timings['queries']} Queries);
PHP: {$timings['t_php']|string_format:"%.03f"}s;
TOTAL: {$timings['t_total']|string_format:"%.03f"}s;<br/>
MEM PHP: {$timings['mem_php']|filesize:"2":"1024"};
MEM USER: {$timings['mem_user']|filesize:"2":"1024"};
MEM TOTAL: {$timings['mem_total']|filesize:"2":"1024"};<br/>
SPACE FREE: {$timings['space_free']|filesize:"2":"1024"}
SPACE USED: {$timings['space_used']|filesize:"2":"1024"}
SPACE TOTAL: {$timings['space_total']|filesize:"2":"1024"}<br/>
MODULES LOADED: {$SF->getLoadedModules('%count% (%mods%)')};