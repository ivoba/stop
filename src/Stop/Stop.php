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

    protected $hide;
    protected $return;
    protected $continue;
    protected static $class = false;
    protected static $functions = array(
        '_s', '_sd', '_sg', '_sdg', '_sdgh', '_sgh', 'stop', 'stop_dump'
    );
    protected $theme = '<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
                        <div class="ivoba_stop container">
                        <div class="page-header">
                            <h4>{claim} <small>
                            <strong>File:</strong> {file}
                            <strong>Line:</strong> {line}
                            <div class="pull-right"><strong>Memory:</strong> {memory}</div></small></h1>
                        </div>
                        <div class="row"><div class="span12"><pre>
                        {dump}
                        </pre></div></div></div>';

    public function __construct($hide, $continue, $return) {
        $this->hide = $hide;
        $this->continue = $continue;
        $this->return = $return;
    }

    public function printr($var) {
        return $this->render($var, self::PRINT_R);
    }

    public function dump($var) {
        return $this->render($var, self::VAR_DUMP);
    }

    /**
     * 
     * @param type $var
     * @param type $method
     * @param type $continue
     * @param type $hide
     * @param type $return
     * @return type
     */
    public static function it($var, $method = self::PRINT_R, $continue = false, $hide = false, $return = false) {

        if (self::$class === false) {
            $Stop = new self($hide, $continue, $return);
        } else {
            $Stop = new self::$class($hide, $continue, $return);
        }
        return $Stop->render($var, $method);
    }

    protected function resolveCallOccurence(&$bt) {
        $index = false;
        //from helper?
        foreach ($bt as $key => $value) {
            if (in_array($value['function'], self::$functions)) {
                $index = $key;
                break;
            }
        }
        if (!$index) {
            //from static?
            foreach ($bt as $key => $value) {
                if ($value['function'] == 'it') {
                    $index = $key;
                    break;
                }
            }
        }
        if (!$index) {
            //from object?
            foreach ($bt as $key => $value) {
                if ($value['function'] == 'printr' || $value['function'] == 'dump') {
                    $index = $key;
                    break;
                }
            }
        }
        return $index;
    }

    protected function render($var, $method) {
        $claim = 'Stop'.($this->continue ? ' and Go': '') .'!';
        $bt = debug_backtrace();
        $index = $this->resolveCallOccurence($bt);
        if ($index) {
            $file = $bt[$index]['file'];
            $line = $bt[$index]['line'];
        } else {
            $file = '';
            $line = '';
        }
        $memory = round((memory_get_usage() / 1024 / 1024), 3) . ' MB';
        if ($method == self::PRINT_R) {
            $dump = print_r($var, true);
        } else {
            ob_start();
            var_dump($var);
            $dump = ob_get_clean();
        }
        $out = str_replace(array('{claim}', '{file}', '{line}', '{memory}', '{dump}'), array($claim, $file, $line, $memory, $dump), $this->theme);
        if ($this->hide) {
            $out = "<!-- 
                    " . $out .
                    " -->";
        }
        if ($this->return) {
            return $out;
        } elseif ($this->continue) {
            echo $out;
            return;
        }
        echo $out;
        exit;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

}
