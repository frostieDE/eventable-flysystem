<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\BeforePathChangedEvent;
use PHPUnit\Framework\TestCase;

class BeforePathChangedEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $event = new BeforePathChangedEvent('path.txt', 'newPath.txt');

        $this->assertEquals('path.txt', $event->getPath());
        $this->assertEquals('newPath.txt', $event->getNewPath());
        $this->assertFalse($event->isCancelled());
    }
}