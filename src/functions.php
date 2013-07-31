<?php

use \Stop\Stop;
use \Stop\Dumper;

/*
 * @todo use below to give possibility to override functionality of global functions
 * global $ivoba_stop_go_hide = create_function($var, 'Stop::it($var, true, true)');
 */

//@todo multiple $args = func_get_args(); in shortcuts 

if (!function_exists('_s')) {

    /**
     * print_r variable and exit
     * shortcut function
     * 
     * @param mixed $var 
     */
    function _s($var) {
        Stop::it($var);
    }

}
if (!function_exists('_sg')) {

    /**
     * print_r variable and go on
     * shortcut function
     * 
     * @param mixed $var 
     */
    function _sg($var) {
        Stop::it($var, true);
    }

}
if (!function_exists('_sgh')) {

    /**
     * print_r variable, go on and hide
     * shortcut function
     * 
     * @param mixed $var 
     */
    function _sgh($var) {
        Stop::it($var, true, true);
    }

}
if (!function_exists('_sd')) {

    /**
     * var_dump variable and exit 
     * shortcut function
     * 
     * @param mixed $var
     */
    function _sd($var) {
        Stop::it($var, Dumper::VAR_DUMP);
    }

}
if (!function_exists('_sdg')) {

    /**
     * var_dump variable and go on 
     * shortcut function
     */
    function _sdc($var) {
        Stop::it($var, Dumper::VAR_DUMP, true, false);
    }

}
if (!function_exists('_sdgh')) {

    /**
     * var_dump variable, go on and hide 
     * shortcut function
     */
    function _sdgh($var) {
        Stop::it($var, Dumper::VAR_DUMP, true, true);
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
    Stop::it($var, $continue, $hide);
}

/**
 * var_dump variable and exit
 * 
 * @param mixed $var
 * @param boolean $continue dont exit the script
 * @param boolean $hide put output in html comment
 */
function stop_dump($var, $continue = false, $hide = false) {
    Stop::it($var, $continue, $hide, Dumper::VAR_DUMP);
}