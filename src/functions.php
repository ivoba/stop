<?php

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
