<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\BeforeAddPluginEvent;
use League\Flysystem\PluginInterface;
use PHPUnit\Framework\TestCase;

class BeforeAddPluginEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $plugin = $this->getMockBuilder(PluginInterface::class)
            ->setMethods(['handle', 'getMethod', 'setFilesystem'])
            ->getMock();
        $event = new BeforeAddPluginEvent($plugin);

        $this->assertEquals($plugin, $event->getPlugin());
        $this->assertFalse($event->isCancelled());
    }
}