<?php

namespace Stop\Tests;

require_once __DIR__ . '/../../../src/Stop/Dumper.php';
require_once __DIR__ . '/../../../src/Stop/Model/Dump.php';

class DumperTest extends \PHPUnit_Framework_TestCase {

    public function testDumpReturn() {
        $Stop = new \Stop\Dumper(false, false, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('string(6) "String"', $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/DumperTest.php', $output, 'File is found');
        $this->assertContains('<strong>Line:</strong> 12', $output, 'Line is found');

        $Stop = new \Stop\Dumper(false, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('Stop and Go!', $output, 'Go is found');
    }

    public function testPrintReturn() {
        $Stop = new \Stop\Dumper(false, false, true);
        $output = $Stop->print_r('String');
        $this->assertContains('<pre>
                        String
                        </pre>', $output, 'print_r');
        $this->assertContains('tests/Stop/Tests/DumperTest.php', $output, 'File is found');
        $this->assertContains('<strong>Line:</strong> 24', $output, 'Line is found');
        $output = $Stop->print_r(false);
        $this->assertContains('bool(false)', $output, 'Boolean as var_dump');
        $output = $Stop->print_r(null);
        $this->assertContains('NULL', $output, 'null as var_dump');
    }

    public function testDumpHide() {
        $Stop = new \Stop\Dumper(true, false, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Hide!")', $output, 'Hide is found');
        $this->assertContains("console.log(\"\'String\'\")", $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/DumperTest.php', $output, 'File is found');
        $this->assertContains('console.log("Line: 38")', $output, 'Line is found');

        $Stop = new \Stop\Dumper(true, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Go and Hide!")', $output, 'Hide and Go is found');
    }

    public function testPrintHide() {
        $Stop = new \Stop\Dumper(true, false, true);
        $output = $Stop->print_r('String');
        $this->assertContains('console.log("Stop and Hide!")', $output, 'Hide is found');
        $this->assertContains('console.log("String")', $output, 'var_dump the variable');
        $this->assertContains('tests/Stop/Tests/DumperTest.php', $output, 'File is found');
        $this->assertContains('console.log("Line: 51")', $output, 'Line is found');

        $Stop = new \Stop\Dumper(true, true, true);
        $output = $Stop->var_dump('String');
        $this->assertContains('console.log("Stop and Go and Hide!")', $output, 'Hide and Go is found');
    }
    
    /**
     * if you have ext/test_helpers
     * 
     * @see https://github.com/php-test-helpers/php-test-helpers/blob/master/README.markdown#intercepting-the-exit-statement
     * @return type
     */
//    public function testPrintExit() {
//        set_exit_overload(function() { return FALSE; });
//        $Stop = new \Stop\Dumper(false, false, false);
//        ob_start();
//        $Stop->print_r('String');
//        $output = ob_flush();
//        $this->assertContains('console.log("Stop and Hide!")', $output, 'Hide is found');
//        $this->assertContains('console.log("String")', $output, 'var_dump the variable');
//        $this->assertContains('tests/Stop/Tests/DumperTest.php', $output, 'File is found');
//        $this->assertContains('console.log("Line: 51")', $output, 'Line is found');
//
//        $Stop = new \Stop\Dumper(true, true, true);
//        $output = $Stop->var_dump('String');
//        $this->assertContains('console.log("Stop and Go and Hide!")', $output, 'Hide and Go is found');
//        unset_exit_overload();
//    }

}