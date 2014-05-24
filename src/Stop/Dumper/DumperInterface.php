<?php
/**
 * Created by PhpStorm.
 * User: ivo
 * Date: 03.11.13
 * Time: 17:36
 */

namespace Stop\Dumper;


interface DumperInterface {

    public function print_r($var);
    public function var_dump($var);
    public function get_type($var);


}
