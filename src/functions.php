<?php

use \Stop\Stop;
use \Stop\Dumper;

/*
 * @todo use below to give possibility to override functionality of global functions
 * global $ivoba_stop_go_hide = create_function($var, 'Stop::it($var, true, true)');
 */

//@todo multiple $args = func_get_args(); in shortcuts 

if (!function_exists('_S')) {

    /**
     * Stop!
     * print_r variable and exit
     * shortcut function
     *
     * @param mixed $var
     */
    function _S($var)
    {
        Stop::print_r($var);
    }

}
if (!function_exists('_SG')) {

    /**
     * Stop and Go!
     * print_r variable and dont exit
     * shortcut function
     *
     * @param mixed $var
     */
    function _SG($var)
    {
        Stop::print_r($var, true);
    }

}
if (!function_exists('_SGH')) {

    /**
     * Stop and Go and Hide!
     * print_r variable, dont exit and print to console
     * shortcut function
     *
     * @param mixed $var
     */
    function _SGH($var)
    {
        Stop::print_r($var, true, true);
    }

}
if (!function_exists('_SD')) {

    /**
     * Stop Dump!
     * var_dump variable and exit
     * shortcut function
     *
     * @param mixed $var
     */
    function _SD($var)
    {
        Stop::dump($var);
    }

}
if (!function_exists('_SDG')) {

    /**
     * Stop Dump and Go!
     * var_dump variable and dont exit
     * shortcut function
     */
    function _SDG($var)
    {
        Stop::dump($var, true, false);
    }

}
if (!function_exists('_SDGH')) {

    /**
     * Stop Dump and Go and Hide!
     * var_dump variable, dont exit and print to console
     * shortcut function
     */
    function _SDGH($var)
    {
        Stop::dump($var, true, true);
    }

}

if (!function_exists('_SJ')) {
    /**
     * Stop Dump as Json!
     * if you want to dump a json string with json header, use this function!
     *
     * @param $var
     */
    function _SJ($var)
    {
        Stop::json($var, $continue = false, $hide = false, $return = false);
    }
}

if (!function_exists('_ST')) {
    /**
     * Stop Type!
     * just show the type of a variable, use this function!
     *
     * @param $var
     */
    function _ST($var)
    {
        Stop::type($var, $continue = false, $hide = false, $return = false);
    }
}

if (!function_exists('_STG')) {
    /**
     * Stop Type!
     * just show the type of a variable, use this function!
     *
     * @param $var
     */
    function _STG($var)
    {
        Stop::type($var, $continue = true, $hide = false, $return = false);
    }
}

/**
 * print_r variable and exit
 *
 * @param mixed $var
 * @param boolean $continue dont exit the script
 * @param boolean $hide put output in html comment
 */
function stop($var, $continue = false, $hide = false, $return = false)
{
    return Stop::it($var, Dumper\AbstractDumper::PRINT_R, $continue, $hide, $return);
}

/**
 * var_dump variable and exit
 *
 * @param mixed $var
 * @param boolean $continue dont exit the script
 * @param boolean $hide put output in html comment
 */
function stop_dump($var, $continue = false, $hide = false, $return = false)
{
    return Stop::it($var, Dumper\AbstractDumper::VAR_DUMP, $continue, $hide, $return);
}

/**
 * show variable type without content
 *
 * @param $var
 * @param bool $continue
 * @param bool $hide
 * @param bool $return
 * @return mixed
 */
function stop_type($var, $continue = false, $hide = false, $return = false)
{
    return Stop::it($var, Dumper\AbstractDumper::GET_TYPE, $continue, $hide, $return);
}