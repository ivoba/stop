Stop
====

Stop provides nice output for debug functions PHP 5.3+

During developing pretty often i find myself typing:

    print_r($var);exit;

or

    var_dump($var);exit; 

So this lib provides a shortcut plus some more infos, some nice rendering, plenty of options and autoloading to that.

Install
----------
via composer, put this in your require block:  

    "ivoba/stop": "dev-master"

then  

    composer update ivoba/stop



Using Stop
----------

By default, resp. via composer install, Stop will include global functions to ease access to the debug methods

* Functions:
this is probably the fastest way with or without IDE Autocompletion.  
If you also have functions named **stop** or **stop_dump** or **_s** or **_sd** in your project: **rename them, dude! No mercy!** or use the class ;)  

this will output print_r($var) in a code block and will exit the script:  

    stop($var);

or even shorter

    _s($var);

this will output var_dump($var) in a code block and will exit the script:

    stop_dump($var);

or even shorter

    _sd($var);


* Static Class Methods:

   ```\Stop\Stop::it($var, $continue, $hide, \Stop\Stop::VAR_DUMP);```

* OO Style:

```
    $Stop = new \Stop\Stop(\Stop\Stop::ENV_DEV);  
    $Stop->printr($var);
    $Stop->dump($var);
```    


###TODO

- FirePHP
- more config
- render backtrace?
- render code context 

any ideas? contribute!

