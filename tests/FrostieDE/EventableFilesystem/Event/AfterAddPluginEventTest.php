<?php

namespace FrostieDE\EventableFlysystem\Tests\Event;

use FrostieDE\EventableFlysystem\Event\AfterAddPluginEvent;
use League\Flysystem\PluginInterface;
use PHPUnit\Framework\TestCase;

class AfterAddPluginEventTest extends TestCase {
    public function testConstructorAndGetters() {
        $plugin = $this->getMockBuilder(PluginInterface::class)
            ->setMethods(['handle', 'getMethod', 'setFilesystem'])
            ->getMock();
        $event = new AfterAddPluginEvent($plugin);

        $this->assertEquals($plugin, $event->getPlugin());
    }
}