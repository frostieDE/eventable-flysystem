<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\BeforeFilesystemEvent;
use PHPUnit\Framework\TestCase;

class BeforeFilesystemEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $event = new BeforeFilesystemEvent('path.txt');

        $this->assertEquals('path.txt', $event->getPath());
        $this->assertFalse($event->isCancelled());
    }

    public function testCancel() {
        $event = new BeforeFilesystemEvent('path.txt');

        $this->assertFalse($event->isCancelled());

        $event->cancel();
        
        $this->assertTrue($event->isCancelled());
    }
}