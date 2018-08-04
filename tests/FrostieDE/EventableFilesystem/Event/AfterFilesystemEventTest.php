<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\AfterFilesystemEvent;
use PHPUnit\Framework\TestCase;

class AfterFilesystemEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $event = new AfterFilesystemEvent('path.txt', 'result');

        $this->assertEquals('path.txt', $event->getPath());
        $this->assertEquals('result', $event->getResult());
    }
}