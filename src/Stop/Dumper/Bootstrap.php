<?php
/**
 * Created by PhpStorm.
 * User: ivo
 * Date: 03.11.13
 * Time: 15:36
 */

namespace Stop\Dumper;


class Bootstrap extends AbstractDumper
{

    protected $theme = '<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
                        <div class="ivoba_stop container">
                        <div class="page-header">
                            <h4>{claim} <small>
                            <strong>File:</strong> {file}
                            <strong>Line:</strong> {line}
                            <div class="pull-right"><strong>Memory:</strong> {memory}</div></small></h1>
                        </div>
                        <div class="row"><div class="span12"><pre>{dump}</pre></div></div></div>';

    protected function render(\Stop\Model\Dump $dump)
    {
        $out = str_replace(array('{claim}', '{file}', '{line}', '{memory}', '{dump}'), array($dump->claim, $dump->file, $dump->line, $dump->memory, $dump->dump), $this->getTheme());
        if ($this->hide) {
            $out_temp = "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}";
            $output = explode("\n", $dump->dump);
            $out_temp .= "console.log(\"$dump->claim\");";
            $out_temp .= "console.log(\"File: $dump->file\");";
            $out_temp .= "console.log(\"Line: $dump->line\");";
            $out_temp .= "console.log(\"Memory: $dump->memory\");";
            foreach ($output as $line) {
                if (trim($line)) {
                    $line = addslashes($line);
                    $out_temp .= "console.log(\"{$line}\");";
                }
            }
            $out_temp .= "\r\n//]]>\r\n</script>";
            $out = $out_temp;
        }

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
            $delimiter = '<br/>';
            $func = function(&$value, $key) { $value = '<strong>'.$key.':</strong> ' .$value; };
            if($this->hide){
                $func = function(&$value, $key) { $value = $key.':' .$value; };
                $delimiter = "\n";
            }
            array_walk($dumpArr, $func);
            $dump = implode($delimiter, $dumpArr);
        }
        else {
            //TODO if xdebug is enabled and hide is active use var_export or ini_set('html_errors', 0);
            ob_start();
            if (function_exists('xdebug_disable') && $this->hide) {
                var_export($var);
            } else {
                var_dump($var);
            }
            $dump = ob_get_clean();
            if (function_exists('xdebug_disable')) {
                if (strpos($dump, "<pre class='xdebug-var-dump' dir='ltr'>") !== false) {
                    //strip xdebug rendered pre's
                    $dump = substr($dump, strlen("<pre class='xdebug-var-dump' dir='ltr'>"));
                    $dump = substr($dump, 0, strlen($dump) - strlen('</pre>'));
                }
            }
        }
        return new \Stop\Model\Dump($claim, $file, $line, $memory, $dump);
    }
} 