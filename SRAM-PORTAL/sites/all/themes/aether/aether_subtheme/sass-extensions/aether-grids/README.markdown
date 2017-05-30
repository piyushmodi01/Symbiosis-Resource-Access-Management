## Requirements
  Compass 12.1  
  Sass 3.2  

## Install

```
# Get the compass extension:
  $ git clone git://github.com/krisbulman/aether-grids.git  

# Add the following lines to your compass configuration file:
  require 'aether-grids'  

# You can import all the stylesheets you'll need by typing: 
  $ compass install -r aether-grids aether-grids  

# You can import just the variables sass file by typing: 
  $ compass install -r aether-grids aether-grids/variables  
```

## Usage
```
// Import the aether-grids utilities you need:

// These will compile CSS and should be included in their own stylesheets.
// NOTE: If you used the import all stylesheet step above,
// there is no need to import these again.
  @import "aether-grids/default-layout";  
  @import "aether-grids/mediaquery-layout";  
  @import "aether-grids/visibility";  
  @import "aether-grids/debug";  

// If you want access (and you do) the grid utilities or mediaquery mixins
// in other non grid related stylesheets, use these: 
  @import "aether-grids/layout/grid-utilities";
  @import "aether-grids/layout/grid-mediaqueries";
```

## License

   See LICENSE.txt
