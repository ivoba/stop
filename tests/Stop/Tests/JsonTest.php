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

}
