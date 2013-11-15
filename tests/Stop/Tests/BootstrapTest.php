<?php

namespace Stop\Tests;

require_once __DIR__ . '/../../../src/Stop/Dumper/DumperInterface.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/AbstractDumper.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/Bootstrap.php';
require_once __DIR__ . '/../../../src/Stop/Model/Dump.php';

class BootstrapTest extends \PHPUnit_Framework_TestCase {

    public function testDumpReturn() {
        $Stop = new \Stop\Dumper\Bootstrap(false, false, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('string(6) "String"', $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/BootstrapTest.php', $output, 'File is found');
        $this->assertContains('<strong>Line:</strong> 14', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Bootstrap(false, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('Stop and Go!', $output, 'Go is found');
    }

    public function testPrintReturn() {
        $Stop = new \Stop\Dumper\Bootstrap(false, false, true);
        $output = $Stop->print_r('String');
        $this->assertContains('<pre>
                        String
                        </pre>', $output, 'print_r');
        $this->assertContains('tests/Stop/Tests/BootstrapTest.php', $output, 'File is found');
        $this->assertContains('<strong>Line:</strong> 26', $output, 'Line is found');
        $output = $Stop->print_r(false);
        $this->assertContains('bool(false)', $output, 'Boolean as var_dump');
        $output = $Stop->print_r(null);
        $this->assertContains('NULL', $output, 'null as var_dump');
    }

    public function testDumpHide() {
        $Stop = new \Stop\Dumper\Bootstrap(true, false, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Hide!")', $output, 'Hide is found');
        $this->assertContains("console.log(\"\'String\'\")", $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/BootstrapTest.php', $output, 'File is found');
        $this->assertContains('console.log("Line: 40")', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Bootstrap(true, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Go and Hide!")', $output, 'Hide and Go is found');
    }

    public function testPrintHide() {
        $Stop = new \Stop\Dumper\Bootstrap(true, false, true);
        $output = $Stop->print_r('String');
        $this->assertContains('console.log("Stop and Hide!")', $output, 'Hide is found');
        $this->assertContains('console.log("String")', $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/BootstrapTest.php', $output, 'File is found');
        $this->assertContains('console.log("Line: 53")', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Bootstrap(true, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Go and Hide!")', $output, 'Hide and Go is found');
    }

}
