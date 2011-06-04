SQL: {$timings['t_sql']|string_format:"%.03f"}s ({$timings['queries']} Queries);
PHP: {$timings['t_php']|string_format:"%.03f"}s;
TOTAL: {$timings['t_total']|string_format:"%.03f"}s;<br>
MEM PHP: {$timings['mem_php']|filesize:"2":"1024"};
MEM USER: {$timings['mem_user']|filesize:"2":"1024"};
MEM TOTAL: {$timings['mem_total']|filesize:"2":"1024"};<br>
SPACE FREE: {GWF_SF_Utils::umrechnung($timings['space_free'])}
SPACE USED: {GWF_SF_Utils::umrechnung($timings['space_used'])}
SPACE TOTAL: {GWF_SF_Utils::umrechnung($timings['space_total'])}<br>
MODULES LOADED: {$gwf->Module()->getModulesLoaded('%count% (%mods%)')};