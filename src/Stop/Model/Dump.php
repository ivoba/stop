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

namespace Stop\Model;

class Dump {

    public $claim;
    public $file;
    public $line;
    public $memory;
    public $dump;
    
    /**
     * 
     * @param string $claim
     * @param string $file
     * @param string $line
     * @param string $memory
     * @param string $dump
     */
    function __construct($claim, $file, $line, $memory, $dump) {
        $this->claim = $claim;
        $this->file = $file;
        $this->line = $line;
        $this->memory = $memory;
        $this->dump = $dump;
    }


}
