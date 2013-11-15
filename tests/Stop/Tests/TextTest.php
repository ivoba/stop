<?php

namespace Stop\Tests;

require_once __DIR__ . '/../../../src/Stop/Dumper/DumperInterface.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/AbstractDumper.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/Text.php';
require_once __DIR__ . '/../../../src/Stop/Model/Dump.php';

class TextTest extends \PHPUnit_Framework_TestCase {

    public function testDumpReturn() {
        $Stop = new \Stop\Dumper\Text(false, false, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('string(6) "String"', $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/TextTest.php', $output, 'File is found');
        $this->assertContains('Line: 14', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Text(false, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('Stop and Go!', $output, 'Go is found');
    }

    public function testPrintReturn() {
        $Stop = new \Stop\Dumper\Text(false, false, true);
        $output = $Stop->print_r('String');
        $this->assertContains('String', $output, 'print_r');
        $this->assertContains('tests/Stop/Tests/TextTest.php', $output, 'File is found');
        $this->assertContains('Line: 26', $output, 'Line is found');
        $output = $Stop->print_r(false);
        $this->assertContains('bool(false)', $output, 'Boolean as var_dump');
        $output = $Stop->print_r(null);
        $this->assertContains('NULL', $output, 'null as var_dump');
    }

}
