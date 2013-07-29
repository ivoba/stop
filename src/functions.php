<?php

if (!function_exists('_s')) {
    /**
     * print_r variable and exit
     * shortcut function
     * 
     * @param mixed $var 
     * @param boolean $continue dont exit the script
     * @param boolean $hide put output in html comment
     */
    function _s($var, $continue = false, $hide = false) {
        stop($var, $continue, $hide);
    }

}
if (!function_exists('_sc')) {
    /**
     * print_r variable and continue
     * shortcut function
     * 
     * @param mixed $var 
     */
    function _sc($var) {
        stop($var, true);
    }

}
if (!function_exists('_sch')) {
    /**
     * print_r variable, continue and hide
     * shortcut function
     * 
     * @param mixed $var 
     */
    function _sch($var) {
        stop($var, true, true);
    }

}
if (!function_exists('_sd')) {
    /**
     * var_dump variable and exit 
     * shortcut function
     * 
     * @param mixed $var
     * @param boolean $continue dont exit the script
     * @param boolean $hide put output in html comment
     */
    function _sd($var, $continue = false, $hide = false) {
        stop_dump($var, $continue, $hide);
    }

}
if (!function_exists('_sdc')) {
    /**
     * var_dump variable and continue 
     * shortcut function
     */
    function _sdc($var) {
        stop_dump($var, true);
    }

}
if (!function_exists('_sdch')) {
    /**
     * var_dump variable, continue and hide 
     * shortcut function
     */
    function _sdch($var) {
        stop_dump($var, true, true);
    }

}

/**
 * print_r variable and exit
 * 
 * @param mixed $var 
 * @param boolean $continue dont exit the script
 * @param boolean $hide put output in html comment
 */
function stop($var, $continue = false, $hide = false) {
    \Stop\Stop::it($var, $continue, $hide);
}

/**
 * var_dump variable and exit
 * 
 * @param mixed $var
 * @param boolean $continue dont exit the script
 * @param boolean $hide put output in html comment
 */
function stop_dump($var, $continue = false, $hide = false) {
    \Stop\Stop::it($var, $continue, $hide, \Stop\Stop::VAR_DUMP);
}
