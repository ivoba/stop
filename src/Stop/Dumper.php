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

class Dumper {

    const PRINT_R = 'print_r';
    const VAR_DUMP = 'var_dump';

    public static $functions = array(
        '_S', '_SD', '_SG', '_SDG', '_SDGH', '_SDGH', 'stop', 'stop_dump'
    );
    protected $hide;
    protected $return;
    protected $continue;
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

    public function __construct($hide = false, $continue = false, $return = false) {
        $this->hide = $hide;
        $this->continue = $continue;
        $this->return = $return;
    }

    public function print_r($var) {
        $dump = $this->createDump($var, self::PRINT_R);
        return $this->render($dump);
    }

    public function var_dump($var) {
        $dump = $this->createDump($var, self::VAR_DUMP);
        return $this->render($dump);
    }

    protected function render(\Stop\Model\Dump $dump) {
        $out = str_replace(array('{claim}', '{file}', '{line}', '{memory}', '{dump}'), array($dump->claim, $dump->file, $dump->line, $dump->memory, $dump->dump), $this->getTheme());
        if ($this->hide) {
            $out_temp = "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}";
            $output = explode("\n", $dump->dump);
            $out_temp .= "console.log(\"$dump->claim\");";
            $out_temp .= "console.log(\"File: $dump->file\");";
            $out_temp .= "console.log(\"Line: $dump->line\");";
            $out_temp .= "console.log(\"Memory: $dump->memory\");";
            foreach ($output as $line) {
                if (trim($line)) {
                    $line = addslashes($line);
                    $out_temp .= "console.log(\"{$line}\");";
                }
            }
            $out_temp .= "\r\n//]]>\r\n</script>";
            $out = $out_temp;
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

    protected function createDump($var, $method) {
        $claim = 'Stop' . ($this->continue ? ' and Go' : '') . ($this->hide ? ' and Hide' : '') .'!';
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
//       avoid print_r stays silent when false or null
        if (is_bool($var) or is_null($var)) {
            $method = self::VAR_DUMP;
        }
        if ($method == self::PRINT_R) {
            $dump = print_r($var, true);
        } else {
            //TODO if xdebug is enabled and hide is active use var_export or ini_set('html_errors', 0);
            ob_start();
            if (function_exists('xdebug_disable') && $this->hide) {
                var_export($var);
            } else {
                var_dump($var);
            }
            $dump = ob_get_clean();
        }

        return new \Stop\Model\Dump($claim, $file, $line, $memory, $dump);
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
                if ($value['function'] == '::' && ($value['function'] == 'it' || $value['function'] == 'dump' || $value['function'] == 'print_r')) {
                    $index = $key;
                    break;
                }
            }
        }
        if (!$index) {
            //from object?
            foreach ($bt as $key => $value) {
                if ($value['function'] == 'print_r' || $value['function'] == 'var_dump') {
                    $index = $key;
                    break;
                }
            }
        }
        return $index;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

}
