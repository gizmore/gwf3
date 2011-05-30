SQL: {$timings['t_sql']|string_format:"%.03f"}s ({$timings['queries']} Queries);
PHP: {$timings['t_php']|string_format:"%.03f"}s;
TOTAL: {$timings['t_total']|string_format:"%.03f"}s;
MEM PHP: {$timings['mem_php']|filesize:"2":"1024"};
MEM USER: {$timings['mem_user']|filesize:"2":"1024"};
MEM TOTAL: {$timings['mem_total']|filesize:"2":"1024"};<br>
MODULES LOADED: {$gwf->Module()->getModulesLoaded('%count% (%mods%)')};