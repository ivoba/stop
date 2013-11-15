<?php

namespace Stop\Dumper;

abstract class AbstractDumper implements DumperInterface {

    const PRINT_R = 'print_r';
    const VAR_DUMP = 'var_dump';

    public static $functions = array(
        '_S', '_SD', '_SG', '_SDG', '_SDGH', '_SDGH', 'stop', 'stop_dump'
    );
    protected $hide;
    protected $return;
    protected $continue;

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

    abstract protected function render(\Stop\Model\Dump $dump);
    abstract protected function createDump($var, $method);

    protected function resolveClaim(){
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
