disable_modules		.*
disable_triggers	.*

# module translate
enable_module		Translate             # module translate
enable_triggers		[a-z]{2}\-[a-z]{2}    # module translate
# module translate

enable_module		Slaylert
enable_modules		GWF.*
enable_trigger		help
enable_trigger		login
enable_trigger		register
