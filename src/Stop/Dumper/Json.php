<?php

namespace Stop\Dumper;
/**
 * Class Json
 * Continue & Hide are not working here
 *
 * @todo for nicer object rendering use this: http://code.google.com/p/prado3/source/browse/tags/3.1.9/framework/Util/TVarDumper.php
 * @todo for continue mode implement singleton store
 * @package Stop\Dumper
 */
class Json extends AbstractDumper
{

    protected function render(\Stop\Model\Dump $dump)
    {
        if ($this->return) {
            return json_encode($dump);
        } elseif ($this->continue) {
            //TODO implement
        }
        header('Content-type: application/json');
        //@Todo if php >= 5.4 use JSON_PRETTY_PRINT
        echo json_encode($dump);
        exit;

    }

    protected function createDump($var, $method)
    {
        $claim = $this->resolveClaim();
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
        } else {
            $type = gettype($var);
            if ($type == 'string') {
                $type .= '(' . strlen($var) . ')';
                if($this->format == self::FORMAT_JSON){
                    $value = json_decode($var);
                    $type = 'json/'.$type;
                }
                else{
                    $value = $var;
                }
            } elseif ($type == 'object') {
                $type .= '(' . get_class($var) . ')';
                $value = print_r($var, true);

            } elseif ($type == 'array') {
                $value = $var;
            } else {
                $value = $var;
            }
            $dump = array('type' => $type,
                'value' => $value);

        }
        return new \Stop\Model\Dump($claim, $file, $line, $memory, $dump);
    }


}
