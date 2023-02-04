# CGX: phpgdo Core

A deeper look into the gdo core modules.


# phpgdo7: Core
 - Utilities (curl, files, cli, random, more)
 - GDT (know how to behave in all modes. know validation. know serialization)
 - GDO (table+entity, re-use column GDT)
 - DB (no raw queries, easier than sql, fast, small, cache)
 - I18n (cheap, reuse, fast)
 - Templates (php, cascading)
 - Methods (parameters, inputs, processing, output)
 - Cache (fs, memcached, processcache, tempcache)
 - Users (systems, guests, members)
 - Permissions (groups, level)
 - UI, Icons, Panels, Containers, Menus
 - Rendering (cli,www,json,xml,websocket,js?,gtk?)
 - Forms (csrf, validation)
 - Tables (queried/plain, lists,cards,tables)
 - Tests (unit tests, fuzzing, mail on error)
 
## Good
 - very few warnings
 - core has unit tests
 - performance ok
 - memory good
 - solid and secure
 
## Bad
 - lots of half finished garbage
 - php - a fractal of a bad design
 - very unflexible markup
 
## Plans
 - port to a better language
