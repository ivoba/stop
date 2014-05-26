Stop
====

Stop is a lightweight Dumper for PHP 5.3+ , thus a replacement for ```echo '<pre>';print_r($var);exit;```

[![Build Status](https://secure.travis-ci.org/ivoba/stop.png?branch=master)](http://travis-ci.org/ivoba/stop)
[![Total Downloads](https://poser.pugx.org/ivoba/stop/downloads.png)](https://packagist.org/packages/ivoba/stop)
[![Dependency Status](https://www.versioneye.com/php/ivoba:stop/master/badge.png)](https://www.versioneye.com/php/ivoba:stop/master)

During developing pretty often i found myself typing: ```echo '<pre>';print_r($var);exit;``` or ```var_dump($var);exit;```

So this lib provides:

- shortcut functions
- some more infos as File, Line & Memory
- some nicer rendering with Twitter Bootstrap,
- options for return or continue & hide which will print to javascript console
- disable Stop for prod env
- autoloading
- extensibility, if youd like to use jqueryUI f.e just subclass the Dumper and set the class
- context awareness: if you are in console it will render in text mode,
  if in ajax mode it will render in json mode
- dumper for json strings
- stop_type as a better version of ```var_dump(get_class($var));exit;```

Its pretty lightweight since it basically just uses PHP functions plus some sugar.
If you need more power have a look at: https://github.com/raulfraile/ladybug or http://raveren.github.io/kint/  


Install
----------
via composer, put this in your require block:  

    "ivoba/stop": "dev-master"

then  

    composer update ivoba/stop



Using Stop
----------

###Functions:
By default, resp. via composer install, Stop will include global functions to ease access to the debug methods

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

- ```_SG($var);``` Stop and Go! (resp. print_r)
- ```_SGH($var);``` Stop and Go and Hide! (resp. print_r)
- ```_SDG($var);``` Stop Dump and Go! (resp. var_dump)
- ```_SDGH($var);``` Stop Dump and Go and Hide! (resp. var_dump)
- ```_SJ($json);``` Stop Dump as Json! (decodes a json string and send it inside the dump object as json to the browser.
Use browser addons like JSONovich for pretty rendering.)
- ```_ST($var);``` StopType! (resp. get_type | get_class & class_uses & class_implements & class_parents)
- ```_STG($var);``` StopType and Go! (resp. get_type | get_class & class_uses & class_implements & class_parents)

###Static Class Methods:

```
   use \Stop\Stop;
   Stop::it($var, \Stop\Dumper::PRINT_R, $continue, $hide, $return);
   Stop::dump($var, $continue, $hide, $return);
   Stop::print_r($var, $continue, $hide, $return);
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

