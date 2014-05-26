<?php

namespace Stop\Dumper;

abstract class AbstractDumper implements DumperInterface {

    const PRINT_R = 'print_r';
    const VAR_DUMP = 'var_dump';
    const GET_TYPE = 'get_type';

    const FORMAT_JSON = 'json';

    public static $functions = array(
        '_S', '_SD', '_SG', '_SDG', '_SDGH', '_SDGH', '_SJ', 'stop', 'stop_dump', 'stop_type', '_ST', '_STG'
    );
    protected $hide;
    protected $return;
    protected $continue;
    protected $format;

    /**
     * @param bool $hide
     * @param bool $continue
     * @param bool $return
     * @param null|string $format
     */
    public function __construct($hide = false,
                                $continue = false,
                                $return = false,
                                $format = null) {
        $this->hide = $hide;
        $this->continue = $continue;
        $this->return = $return;
        $this->format = $format;
    }

    public function print_r($var) {
        $dump = $this->createDump($var, self::PRINT_R);
        return $this->render($dump);
    }

    public function var_dump($var) {
        $dump = $this->createDump($var, self::VAR_DUMP);
        return $this->render($dump);
    }

    public function get_type($var){
        $dump = $this->createDump($var, self::GET_TYPE);
        return $this->render($dump);
    }

    abstract protected function render(\Stop\Model\Dump $dump);
    abstract protected function createDump($var, $method);

    protected function resolveClaim($method = null){
        if($method == self::GET_TYPE){
            return 'StopType' . ($this->continue ? ' and Go' : '') . ($this->hide ? ' and Hide' : '') . '!';
        }
        return 'Stop' . ($this->continue ? ' and Go' : '') . ($this->hide ? ' and Hide' : '') . '!';
    }

    protected function resolveMemory(){
        return round((memory_get_usage() / 1024 / 1024), 3) . ' MB';
    }

    protected function resolveFileLine(){
        $bt = debug_backtrace();
        $index = $this->resolveCallOccurence($bt);
        if ($index) {
            return $bt[$index];
        }
        return false;
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
                if ($value['function'] == 'print_r' || $value['function'] == 'var_dump' || $value['function'] == 'get_type') {
                    $index = $key;
                    break;
                }
            }
        }
        return $index;
    }

    protected function resolveType($var){
        $dumpArr = array();
        if (is_object($var)) {
            $dumpArr['Class'] = get_class($var);
            if ($parents = class_parents($var)) {
                $dumpArr['Extends'] = implode("\n", $parents);
            }
            if ($interfaces = class_implements($var)) {
                $dumpArr['Interfaces'] = implode("\n", $interfaces);
            }
            if (function_exists('class_uses')) {
                if ($traits = class_uses($var)) {
                    $dumpArr['Traits'] = implode("\n", $traits);
                }
            }
        } else {
            $dumpArr['Type'] = gettype($var);
            if (is_array($var)) {
                $dumpArr['Count'] = count($var);
            }
            if (is_string($var)) {
                $dumpArr['Length'] = strlen($var);
            }
        }
        return $dumpArr;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }
}
