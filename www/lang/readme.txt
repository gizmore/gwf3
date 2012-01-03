You can have your own module language files here:

Please remind:
At the moment GWF3 checks only if the www/lang/module/$MODULE/$path directory exists. If it exists but no language files are in there it will drop a fatal error. In this directory must be the GWF_DEFAULT_LANG language file.
You cannot have core/ languages (not implemented yet)

TODO: moving the Path detection from GWF_Module to another file?
