<?php

namespace Stop\Tests;

require_once __DIR__ . '/../../../src/Stop/Dumper/DumperInterface.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/AbstractDumper.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/Text.php';
require_once __DIR__ . '/../../../src/Stop/Model/Dump.php';

class TextTest extends \PHPUnit_Framework_TestCase
{

    public function testDumpReturn()
    {
        $Stop = new \Stop\Dumper\Text($hide = false,
                                      $continue = false,
                                      $return = true,
                                      $format = null);
        $output = $Stop->var_dump('String');
        $this->assertContains('string(6) "String"', $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/TextTest.php', $output, 'File is found');
        $this->assertContains('Line: 19', $output, 'Line is found');

        $Stop = new \Stop\Dumper\Text($hide = false,
                                      $continue = true,
                                      $return = true,
                                      $format = null);
        $output = $Stop->var_dump('String');
        $this->assertContains('Stop and Go!', $output, 'Go is found');
    }

    public function testPrintReturn()
    {
        $Stop = new \Stop\Dumper\Text($hide = false,
                                      $continue = false,
                                      $return = true,
                                      $format = null);
        $output = $Stop->print_r('String');
        $this->assertContains('String', $output, 'print_r');
        $this->assertContains('tests/Stop/Tests/TextTest.php', $output, 'File is found');
        $this->assertContains('Line: 38', $output, 'Line is found');
        $output = $Stop->print_r(false);
        $this->assertContains('bool(false)', $output, 'Boolean as var_dump');
        $output = $Stop->print_r(null);
        $this->assertContains('NULL', $output, 'null as var_dump');
    }

    public function testGetType()
    {
        $Stop = new \Stop\Dumper\Text($hide = false,
                                      $continue = false,
                                      $return = true,
                                      $format = null);
        $output = $Stop->get_type($Stop);
        $this->assertContains('StopType!', $output);
        $this->assertContains('Class: Stop\Dumper\Text', $output);
        $this->assertContains('Interfaces: Stop\Dumper\DumperInterface', $output);

        $output = $Stop->get_type(array(1,2,3,4));
        $this->assertContains('StopType!', $output);
        $this->assertContains('Type: array', $output);
        $this->assertContains('Count: 4', $output);

        $output = $Stop->get_type($str = "asdasdasd asdasdasd");
        $this->assertContains('StopType!', $output);
        $this->assertContains('Type: string', $output);
        $this->assertContains('Length: 19', $output);

    }

}
