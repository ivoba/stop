Stop
====

Stop is a lightweight Dumper for PHP 5.3+ , thus a replacement for ```echo '<pre>';print_r($var);exit;```

During developing pretty often i find myself typing: ```echo '<pre>';print_r($var);exit;``` or ```var_dump($var);exit;```

So this lib provides:  
 - shortcuts 
 - some more infos as File, Line & Memory 
 - some nicer rendering with Twitter Bootstrap, 
 - options for return or continue & hide which will print to javascript console 
 - disable Stop for prod env
 - autoloading  
 - extensibility, if youd like to use jqueryUI f.e just subclass the Dumper and set the class
 

Its pretty lightweight since it just prints the PHP functions. 
If you need more power have a look at: https://github.com/raulfraile/ladybug or http://raveren.github.io/kint/  


Install
----------
via composer, put this in your require block:  

    "ivoba/stop": "dev-master"

then  

    composer update ivoba/stop



Using Stop
----------

By default, resp. via composer install, Stop will include global functions to ease access to the debug methods

###Functions:
this is probably the fastest way with or without IDE Autocompletion.  
If you also have functions named **stop** or **stop_dump** in your project: **rename them, dude! No mercy!** or use the class ;)  

this will output print_r($var) in a code block and will exit the script:  

```stop($var);``` or the shortcut ```_S($var);```


this will output var_dump($var) in a code block and will exit the script:

```stop_dump($var);``` or the shortcut ```_SD($var);```

####Options
There are 3 options that can be passed as parameters:

- $continue: if this is true the script will not exit, default is false 
- $hide: if this is true it will print to javascript console, default is false
- $return: if this is true the script will return the output, default is false

Shortcut functions for options:

- ```_SG($var);``` Stop and Go!
- ```_SGH($var);``` Stop and Go and Hide!
- ```_SDG($var);``` Stop Dump and Go!
- ```_SDGH($var);``` Stop Dump and Go and Hide!


###Static Class Methods:

```
   use \Stop\Stop;
   Stop::it($var, \Stop\Dumper::PRINT_R, $continue, $hide, $return);
```

###OO Style:

```
    $Stop = new \Stop\Dumper($hide, $continue, $return);  
    $Stop->printr($var);
    $Stop->dump($var);
```    

Requirements
----------

PHP > 5.3  nothing more  
I recommend however to install XDebug for nicer var_dump rendering.

