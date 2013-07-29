<?php

/**
 * The MIT License (MIT)
 * Copyright (c) 2013 Ivo Bathke
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @package   org.ivoba.stop
 */

namespace Stop;

class Stop {

    const PRINT_R = 'print_r';
    const VAR_DUMP = 'var_dump';
    const ENV_DEV = 'dev';

    protected $env;

    public function __construct($env = self::ENV_DEV) {
        $this->env = $env;
    }

    public function printr($var, $continue = false) {
        if ($this->env) {
            $hide = true;
        }
        self::it($var, $continue, $hide, self::PRINT_R);
    }

    public function dump($var, $continue = false) {
        if ($this->env) {
            $hide = true;
        }
        self::it($var, $continue, $hide, self::VAR_DUMP);
    }

    public static function it($var, $continue = false, $hide = false, $method = self::PRINT_R) {
        if ($hide) {
            echo '<!--';
        }
        self::renderInfoBar($method, $continue);
        echo '<pre>';
        if ($method == self::VAR_DUMP) {
            var_dump($var);
        } else {
            print_r($var);
        }
        echo '</pre>';
        if ($hide) {
            echo '-->';
        }
        if ($continue === false) {
            exit;
        }
    }

    protected static function renderInfoBar($source, $continue) {
        $bt = debug_backtrace();
        //get backtrace index
        $function = 'stop';
        if($source == self::VAR_DUMP){
            $function = 'stop_dump';
        }
        foreach ($bt as $key => $value) {
            if($value['function'] == $function){
                $index = $key;
                break;
            }
        }
        if($continue === false){
            echo '<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">';
        }
        echo '<div class="container">';
        echo '<div class="row">';
        echo '<div class="col-lg-3"><h5>'.($continue?'Don`t ':'').'Stop!</h5></div>';
        echo '<div class="col-lg-3">File: '. $bt[$index]['file'] . '</div>';
        echo '<div class="col-lg-3">Line: '. $bt[$index]['line'] .'</div>';
        echo '<div class="col-lg-3">Memory: '.round((memory_get_usage()/1024/1024), 3).' MB</div>';
        echo '</div>';
        echo '</div><hr/>';
    }

}