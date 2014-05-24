<?php

namespace Stop\Tests;

use Stop\Dumper\AbstractDumper;
use Stop\Stop;

require_once __DIR__ . '/../../../src/Stop/Dumper/DumperInterface.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/AbstractDumper.php';
require_once __DIR__ . '/../../../src/Stop/Dumper/Text.php';
require_once __DIR__ . '/../../../src/Stop/Model/Dump.php';
require_once __DIR__ . '/../../../src/Stop/Stop.php';

class StopTest extends \PHPUnit_Framework_TestCase {

    public function testContextAware() {
        #if console it should render Text mode
        $output = Stop::it('String', AbstractDumper::VAR_DUMP, false, false, true);
        $this->assertContains('string(6) "String"', $output, 'var_dump the variable');
        $this->assertContains('------------------------', $output, 'Is Text Mode');
    }

}
