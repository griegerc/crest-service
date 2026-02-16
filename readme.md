# Crest service

Microservice to create and deliver customized crests assembled from a specified amount of layers.

## Setup custom crest

Follow theses steps to setup and create your own customized crest service:
 - Adapt MariaDB and Logging settings in *Config.php* to your needs.
 - Adapt crest settings in *Config.php*:   
    > $crestWidth is the width in pixel of your crest image and layers.
      $crestHeight is the height in pixel of your crest image and layers.
      $crestLayerAmount is a list of the amount of each crest layer (see *Crest layers*)
                                                   
### Crest layers
Please all crest-layer-files (only PNG) in the folder *htdocs/public/data/* with the naming convention: 
   > l[LAYER]-[ID].png 

where *LAYER* is a number from 0 (bottom) to n (top) representing the layer
and *ID* the current number within the layer.

You have to configure also this in $crestLayerAmount in the file *Config.php* where the index is the *LAYER* and the number is the *ID*.
Initial there is -as an example- a crest configuration with 3 layers.

## DEV-Environment with docker
Setup:
 - Execute: 
    > docker-compose up -d
 - Go to PHPMyAdmin-Page and create a database "csrv"
 - Import database structure from **htdocs/database/init.sql**

## Links
    http://localhost:8080/            Public Crest-API  
    http://localhost:8080/index.php   Public Crest-API (alternative URL)
    http://localhost:8080/test.php    Crest testing page (delete in productive use)
    http://localhost:8080/edit.php    Editor sample page (delete in productive use)       
    http://localhost:8081/            PHPMyAdmin
    
## Notes & Limits
 - userId has to be in between 1 and 4.294.967.295
 - ~85 layers possible (if max. amount per layer is <=99)
 - 1.000.000 entries will consume ~300MB of HDD size.