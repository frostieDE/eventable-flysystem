<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\AfterSetVisibilityEvent;
use PHPUnit\Framework\TestCase;

class AfterSetVisibilityEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $event = new AfterSetVisibilityEvent('path.txt', 'public', true);

        $this->assertEquals('path.txt', $event->getPath());
        $this->assertEquals('public', $event->getVisibility());
        $this->assertTrue($event->getResult());
    }
}