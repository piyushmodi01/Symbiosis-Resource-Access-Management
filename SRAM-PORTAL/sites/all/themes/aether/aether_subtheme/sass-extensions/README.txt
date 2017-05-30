You can unpack sass & compass extensions here, the benifit of this is
you do not have to ship the theme with requirements on compass projects,
your compass project will automatically check this folder when compiling.

No require statement is needed in your config.rb, just the following line:

  extensions_dir  = "sass-extensions"

To unpack an extension to this directory, install the extension locally via:

  sudo gem install EXTENSION_NAME

then navigate to the sass-extensions folder in terminal/shell and type: 

  compass unpack EXTENSION_NAME

Import it into your stylesheets as per extension documentation.

IMPORTANT: DO NOT MODIFY THE CONTENTS OF THESE PACKAGES
If you start modifying these packages, it will be impossible to update
without losing your changes, instead use the available mixins and variables
within your project.
