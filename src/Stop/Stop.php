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

final class Stop {

    protected static $DumperClass = '\Stop\Dumper';
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
    public static function it($var, $method = \Stop\Dumper::PRINT_R, $continue = false, $hide = false, $return = false) {
        if(self::$Enabled === false){
            return null;
        }
        try {
            $Stop = new self::$DumperClass($hide, $continue, $return);
        } catch (\Exception $exc) {
            error_log($exc->getMessage());
            //fallback
            $Stop = new \Stop\Dumper($hide, $continue, $return);
        }

        if ($method == \Stop\Dumper::PRINT_R) {
            return $Stop->print_r($var);
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
    public static function dump($var, $continue = false, $hide = false, $return = false) {
        return self::it($var, \Stop\Dumper::VAR_DUMP, $continue, $hide, $return);
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
    public static function print_r($var, $continue = false, $hide = false, $return = false) {
        return self::it($var, \Stop\Dumper::PRINT_R, $continue, $hide, $return);
    }

    public static function setDumperClass($class) {
        self::$DumperClass = $class;
    }

}
