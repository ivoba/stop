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

use Stop\Dumper\AbstractDumper;

final class Stop
{

    const DEFAULT_DUMPER = '\Stop\Dumper\Bootstrap';
    const CONSOLE_DUMPER = '\Stop\Dumper\Text';
    const AJAX_DUMPER = '\Stop\Dumper\Json';

    protected static $DumperClass = self::DEFAULT_DUMPER;
    protected static $Enabled = true;

    /**
     * Dump it!
     *
     * @param type $var
     * @param type $method
     * @param type $continue
     * @param type $hide
     * @param type $return
     * @return type
     */
    public static function it($var,
                              $method = AbstractDumper::PRINT_R,
                              $continue = false,
                              $hide = false,
                              $return = false)
    {

        if (self::$Enabled === false) {
            return null;
        }
        //detect console or ajax
        if (php_sapi_name() == 'cli') {
            //no custom dumper?
            if (self::$DumperClass == self::DEFAULT_DUMPER) {
                self::$DumperClass = self::CONSOLE_DUMPER;
            }
        } elseif (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if (self::$DumperClass == self::DEFAULT_DUMPER) {
                self::$DumperClass = self::AJAX_DUMPER;
            }
        }

        try {
            $Stop = new self::$DumperClass($hide, $continue, $return);
        } catch (\Exception $exc) {
            error_log($exc->getMessage());
            //fallback
            $default = self::DEFAULT_DUMPER;
            $Stop = new $default($hide, $continue, $return);
        }

        if ($method == AbstractDumper::PRINT_R) {
            return $Stop->print_r($var);
        }
        if ($method == AbstractDumper::GET_TYPE) {
            return $Stop->get_type($var);
        }
        return $Stop->var_dump($var);
    }

    /**
     * var_dump it!
     *
     * @param type $var
     * @param type $continue
     * @param type $hide
     * @param type $return
     * @return type
     */
    public static function dump($var, $continue = false, $hide = false, $return = false)
    {
        return self::it($var, AbstractDumper::VAR_DUMP, $continue, $hide, $return);
    }

    /**
     * print_r it!
     *
     * @param type $var
     * @param boolean $continue
     * @param boolean $hide
     * @param boolean $return
     * @return type
     */
    public static function print_r($var, $continue = false, $hide = false, $return = false)
    {
        return self::it($var, AbstractDumper::PRINT_R, $continue, $hide, $return);
    }

    /**
     * dump a variable as json
     *
     * @param $var
     * @param bool $continue
     * @param bool $hide
     * @param bool $return
     */
    public static function json($var, $continue = false, $hide = false, $return = false){
        $Stop = new \Stop\Dumper\Json($hide, $continue, $return, Dumper\AbstractDumper::FORMAT_JSON);
        $Stop->var_dump($var);
    }

    /**
     * @param $var
     * @param bool $continue
     * @param bool $hide
     * @param bool $return
     * @return type
     */
    public static function type($var, $continue = false, $hide = false, $return = false){
        return self::it($var, AbstractDumper::GET_TYPE, $continue, $hide, $return);
    }

    /**
     * set the dumper class yourself
     *
     * @param $class
     */
    public static function setDumperClass($class)
    {
        self::$DumperClass = $class;
    }

}
