<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\AfterPathChangedEvent;
use PHPUnit\Framework\TestCase;

class AfterPathChangedEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $event = new AfterPathChangedEvent('path.txt', 'newPath.txt', false);

        $this->assertEquals('path.txt', $event->getPath());
        $this->assertEquals('newPath.txt', $event->getNewPath());
        $this->assertFalse($event->getResult());
    }
}