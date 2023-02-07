# CG#X: phpgdo core

Here we look into the 
[phpgdo core](https://github.com/gizmore/phpgdo)
and also dive into the code and compare it with older versions.

The core is dependency free and is recoded from scratch.

## phpgdo: core features
 - Util (rand, files, PP, debug)
 - Methods (parameters, inputs, processing, output)
 - Templates (php, cascading)
 - GDT (rendering, validation, serialization, re-use GDO vars)
 - Rendering (cli,www,json,xml,websocket,js?,gtk?)
 - GDO (table+entity, re-use columns)
 - DB (consistency, cache, migrations, transactions)
 - Language (i18n, js)
 - Cache (fs, memcached, processcache, tempcache)
 - User (system, guests, members, permissions, level)
 - UI (icons, panels, containers, menus)
 - Form (csrf, validations)
 - Table (queried/plain, lists,cards,tables)
 - Tests (unit tests, fuzzing)

## Bad
 - lots of half finished garbage.
 - php - a fractal of a bad design!
 - no flexible markup
 - Questions?
 
## Plans for v8
 - port to a better language
 