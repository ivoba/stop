<?php

namespace Stop\Tests;

require_once __DIR__ . '/../../../src/Stop/Dumper/DumperInterface.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/AbstractDumper.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/Json.php';
require_once __DIR__ . '/../../../src/Stop/Model/Dump.php';

class JsonTest extends \PHPUnit_Framework_TestCase {

    public function testDumpReturn() {
        $Stop = new \Stop\Dumper\Json(false, false, true);
        $output = $Stop->var_dump('String');
        $obj = json_decode($output);
        $this->assertObjectHasAttribute('claim', $obj);
        $this->assertEquals('14', $obj->line);
        $this->assertContains('type":"string(6)","value":"String"', $output, 'var_dump the variable');
        $this->assertContains('Stop\/Tests\/JsonTest.php', $output, 'File is found');
        $this->assertContains('"line":14', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Json(false, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('Stop and Go!', $output, 'Go is found');
    }

    public function testPrintReturn() {
        $Stop = new \Stop\Dumper\Json(false, false, true);
        $output = $Stop->print_r('String');
        $obj = json_decode($output);
        $this->assertObjectHasAttribute('claim', $obj);
        $this->assertContains('String', $output, 'print_r');
        $this->assertContains('Stop\/Tests\/JsonTest.php', $output, 'File is found');
        $this->assertEquals('29', $obj->line);
        $output = $Stop->print_r(false);
        $this->assertContains('boolean","value":false', $output, 'Boolean as var_dump');
        $output = $Stop->print_r(null);
        $this->assertContains('NULL', $output, 'null as var_dump');
    }

    public function testJsonFormat(){
        $Stop = new \Stop\Dumper\Json(false, false, true, \Stop\Dumper\AbstractDumper::FORMAT_JSON);
        $jsonFixture = file_get_contents(__DIR__ . '/../Fixtures/test.json');
        $output = $Stop->var_dump($jsonFixture);
        $obj = json_decode($output);
        $this->assertObjectHasAttribute('claim', $obj);
        $this->assertContains('json\/string', $output, 'json/string');
        $this->assertContains('Stop\/Tests\/JsonTest.php', $output, 'File is found');
        $this->assertEquals('44', $obj->line);
        $this->assertEquals('pa1', $obj->dump->value->pa1->name);
    }

    public function testGetType()
    {
        $Stop = new \Stop\Dumper\Json($hide = false,
                                    $continue = false,
                                    $return = true,
                                    \Stop\Dumper\AbstractDumper::FORMAT_JSON);
        $output = $Stop->get_type($Stop);
        $this->assertContains('StopType!', $output);
        $this->assertContains('"Class":"Stop\\\Dumper\\\Json', $output);
        $this->assertContains('Stop\\\Dumper\\\DumperInterface', $output);
        $this->assertContains('Stop\/Tests\/JsonTest.php', $output, 'File is found');
        $output = $Stop->get_type(array(1,2,3,4));
        $this->assertContains('StopType!', $output);
        $this->assertContains('"Type":"array"', $output);
        $this->assertContains('"Count":4', $output);
        $output = $Stop->get_type($str = "asdasdasd asdasdasd");
        $this->assertContains('StopType!', $output);
        $this->assertContains('"Type":"string"', $output);
        $this->assertContains('"Length":19', $output);
    }

}
