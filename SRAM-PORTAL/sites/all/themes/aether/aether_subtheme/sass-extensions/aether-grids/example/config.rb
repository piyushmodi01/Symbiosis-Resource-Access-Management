require '../lib/aether-grids'
# Require any additional compass plugins here.

#environment = :development
environment = :production
output_style =  :compact
project_type = :stand_alone
css_dir = "stylesheets"
sass_dir = "sass"
images_dir = "images"
relative_assets = true

sass_options = (environment == :development) ? {:debug_info => true} : {:always_update => true}

# Increased decimal precision.
# 33.33333% instead of 33.333%
Sass::Script::Number.precision = 5
