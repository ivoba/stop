<?php

namespace Stop\Dumper;

/**
 * Class Text
 * Caution: hide is not implemented here because it doesnt make sense
 *
 * @package Stop\Dumper
 */
class Text extends AbstractDumper
{

    protected $theme = "------------------------
{claim}
File: {file}
Line: {line}
Memory: {memory}

Output:
------------------------
{dump}
------------------------
";

    protected function render(\Stop\Model\Dump $dump)
    {
        $out = str_replace(array('{claim}', '{file}', '{line}', '{memory}', '{dump}'), array($dump->claim, $dump->file, $dump->line, $dump->memory, $dump->dump), $this->getTheme());
        if ($this->return) {
            return $out;
        } elseif ($this->continue) {
            echo $out;
            return;
        }
        echo $out;
        exit;
    }

    protected function createDump($var, $method)
    {
        $claim = $this->resolveClaim($method);
        $file = '';
        $line = '';
        if ($fileLine = $this->resolveFileLine()) {
            $file = $fileLine['file'];
            $line = $fileLine['line'];
        }
        $memory = $this->resolveMemory();

//       avoid print_r stays silent when false or null
        if (is_bool($var) or is_null($var)) {
            $method = self::VAR_DUMP;
        }
        if ($method == self::PRINT_R) {
            $dump = print_r($var, true);
        }
        elseif($method == self::GET_TYPE){
            $dumpArr = $this->resolveType($var);
            $func = function(&$value, $key) { $value = $key . ': ' .$value; };
            array_walk($dumpArr, $func);
            $dump = implode("\n", $dumpArr);
        }
        else {
            ob_start();
            var_dump($var);
            $dump = ob_get_clean();
        }

        return new \Stop\Model\Dump($claim, $file, $line, $memory, $dump);
    }

}
