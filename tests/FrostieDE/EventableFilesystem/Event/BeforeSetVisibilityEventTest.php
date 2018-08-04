<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\BeforeSetVisibilityEvent;
use PHPUnit\Framework\TestCase;

class BeforeSetVisibilityEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $event = new BeforeSetVisibilityEvent('path.txt', 'public');

        $this->assertEquals('path.txt', $event->getPath());
        $this->assertEquals('public', $event->getVisibility());
        $this->assertFalse($event->isCancelled());
    }
}