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
        $this->assertContains('<pre>String</pre>', $output, 'print_r');
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
        $this->assertContains('console.log("Line: 38")', $output, 'Line is found');

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
        $this->assertContains('console.log("Line: 51")', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Bootstrap(true, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Go and Hide!")', $output, 'Hide and Go is found');
    }

    public function testGetType()
    {
        $Stop = new \Stop\Dumper\Bootstrap($hide = false,
            $continue = false,
            $return = true,
            $format = null);
        $output = $Stop->get_type($Stop);
        $this->assertContains('StopType!', $output);
        $this->assertContains('<strong>Class:</strong> Stop\Dumper\Bootstrap', $output);
        $this->assertContains('<strong>Interfaces:</strong> Stop\Dumper\DumperInterface', $output);

        $output = $Stop->get_type(array(1,2,3,4));
        $this->assertContains('StopType!', $output);
        $this->assertContains('<strong>Type:</strong> array', $output);
        $this->assertContains('<strong>Count:</strong> 4', $output);

        $output = $Stop->get_type($str = "asdasdasd asdasdasd");
        $this->assertContains('StopType!', $output);
        $this->assertContains('<strong>Type:</strong> string', $output);
        $this->assertContains('<strong>Length:</strong> 19', $output);

    }

}
