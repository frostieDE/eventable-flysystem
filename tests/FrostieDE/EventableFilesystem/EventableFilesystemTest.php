<?php

namespace FrostieDE\EventableFlysystem\Tests;

use FrostieDE\EventableFlysystem\CancelledException;
use FrostieDE\EventableFlysystem\Event\AfterAddPluginEvent;
use FrostieDE\EventableFlysystem\Event\AfterFilesystemEvent;
use FrostieDE\EventableFlysystem\Event\AfterPathChangedEvent;
use FrostieDE\EventableFlysystem\Event\AfterSetVisibilityEvent;
use FrostieDE\EventableFlysystem\Event\BeforeAddPluginEvent;
use FrostieDE\EventableFlysystem\Event\BeforeFilesystemEvent;
use FrostieDE\EventableFlysystem\Event\BeforePathChangedEvent;
use FrostieDE\EventableFlysystem\Event\BeforeSetVisibilityEvent;
use FrostieDE\EventableFlysystem\Event\FilesystemEvents;
use FrostieDE\EventableFlysystem\EventableFilesystem;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Plugin\ListFiles;
use League\Flysystem\PluginInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventableFilesystemTest extends TestCase {

    public function getMethodCalls() {
        return [
            ['read', ['path.txt'], ['contents' => 'contents'], 'contents', FilesystemEvents::BEFORE_READ, FilesystemEvents::AFTER_READ],
            ['write', ['path.txt', 'contents'], ['contents' => 'contents'], true, FilesystemEvents::BEFORE_WRITE, FilesystemEvents::AFTER_WRITE, false],
            ['update', ['path.txt', 'contents'], ['path' => 'path.txt'], true, FilesystemEvents::BEFORE_UPDATE, FilesystemEvents::AFTER_UPDATE],
            ['readStream', ['path.txt'], ['stream' => 'stream'], 'stream', FilesystemEvents::BEFORE_READ_STREAM, FilesystemEvents::AFTER_READ_STREAM],
            ['writeStream', ['path.txt', tmpfile()], ['stream' => tmpfile()], true, FilesystemEvents::BEFORE_WRITE_STREAM, FilesystemEvents::AFTER_WRITE_STREAM, false],
            ['updateStream', ['path.txt', tmpfile()], ['stream' => tmpfile()], true, FilesystemEvents::BEFORE_UPDATE_STREAM, FilesystemEvents::AFTER_UPDATE_STREAM],
            ['delete', ['path.txt'], true, true, FilesystemEvents::BEFORE_DELETE, FilesystemEvents::AFTER_DELETE ],
            ['deleteDir', ['path.txt'], true, true, FilesystemEvents::BEFORE_DELETE_DIR, FilesystemEvents::AFTER_DELETE_DIR],
            ['createDir', ['path'], ['path' => 'path'], true, FilesystemEvents::BEFORE_CREATE_DIR, FilesystemEvents::AFTER_CREATE_DIR],
            ['has', ['path'], true, true, FilesystemEvents::BEFORE_HAS, FilesystemEvents::AFTER_HAS ],
            ['getMetadata', ['path'], ['mimetype' => 'plain/text'], ['mimetype' => 'plain/text',], FilesystemEvents::BEFORE_GET_METADATA, FilesystemEvents::AFTER_GET_METADATA],
            ['getSize', ['path'], ['size' => 1], 1, FilesystemEvents::BEFORE_GET_SIZE, FilesystemEvents::AFTER_GET_SIZE],
            ['getTimestamp', ['path'], ['timestamp' => 1], 1, FilesystemEvents::BEFORE_GET_TIMESTAMP, FilesystemEvents::AFTER_GET_TIMESTAMP],
            ['getMimetype', ['path'], ['mimetype' => 'type'], 'type', FilesystemEvents::BEFORE_GET_MIMETYPE, FilesystemEvents::AFTER_GET_MIMETYPE],
            ['getVisibility', ['path'], ['visibility' => 'public'], 'public', FilesystemEvents::BEFORE_GET_VISIBILITY, FilesystemEvents::AFTER_GET_VISIBILITY],
            ['listContents', [''], [['path' => 'path', 'type' => 'file']], [[
                'path' => 'path',
                'type' => 'file',
                'dirname' => '',
                'basename' => 'path',
                'filename' => 'path'
            ]], FilesystemEvents::BEFORE_LIST_CONTENTS, FilesystemEvents::AFTER_LIST_CONTENTS],
        ];
    }

    /**
     * @dataProvider getMethodCalls
     */
    public function testMethodCalls($method, array $arguments, $response, $expected, $beforeEventName, $afterEventName, $has = true) {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();
        $adapter
            ->method('has')
            ->with($arguments[0])
            ->willReturn($has);
        $adapter
            ->method($method)
            //->with($arguments)
            ->willReturn($response);

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->setMethods(['dispatch'])
            ->getMock();

        $beforeEvent = new BeforeFilesystemEvent($arguments[0]);
        $afterEvent = new AfterFilesystemEvent($arguments[0], $expected);

        $dispatcher
            ->expects($this->atLeast(2))
            ->method('dispatch')
            ->willReturnMap(
                [
                    [ $beforeEventName, $beforeEvent, $beforeEvent ],
                    [ $afterEventName, $afterEvent, $afterEvent ]
                ]
            );

        $filesystem = new EventableFilesystem($dispatcher, $adapter);
        $result = call_user_func_array([ $filesystem, $method ], $arguments);

        $this->assertEquals($expected, $result);
    }

    public function testRename() {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();
        $adapter
            ->method('has')
            ->willReturnMap([
                [ 'path.txt', true ],
                [ 'newPath.txt', false ]
            ]);
        $adapter
            ->method('rename')
            ->willReturn(true);

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->setMethods(['dispatch'])
            ->getMock();

        $beforeEvent = new BeforePathChangedEvent('path.txt', 'newPath.txt');
        $afterEvent = new AfterPathChangedEvent('path.txt', 'newPath.txt', true);

        $dispatcher
            ->expects($this->atLeast(2))
            ->method('dispatch')
            ->willReturnMap(
                [
                    [ FilesystemEvents::BEFORE_RENAME, $beforeEvent, $beforeEvent ],
                    [ FilesystemEvents::AFTER_RENAME, $afterEvent, $afterEvent ]
                ]
            );

        $filesystem = new EventableFilesystem($dispatcher, $adapter);
        $result = call_user_func_array([ $filesystem, 'rename' ], [ 'path.txt', 'newPath.txt']);

        $this->assertTrue($result);
    }

    public function testCopy() {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();
        $adapter
            ->method('has')
            ->willReturnMap([
                [ 'path.txt', true ],
                [ 'newPath.txt', false ]
            ]);
        $adapter
            ->method('copy')
            ->willReturn(true);

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->setMethods(['dispatch'])
            ->getMock();

        $beforeEvent = new BeforePathChangedEvent('path.txt', 'newPath.txt');
        $afterEvent = new AfterPathChangedEvent('path.txt', 'newPath.txt', true);

        $dispatcher
            ->expects($this->atLeast(2))
            ->method('dispatch')
            ->willReturnMap(
                [
                    [ FilesystemEvents::BEFORE_COPY, $beforeEvent, $beforeEvent ],
                    [ FilesystemEvents::AFTER_COPY, $afterEvent, $afterEvent ]
                ]
            );

        $filesystem = new EventableFilesystem($dispatcher, $adapter);
        $result = call_user_func_array([ $filesystem, 'copy' ], [ 'path.txt', 'newPath.txt']);

        $this->assertTrue($result);
    }

    public function testSetVisibility() {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();
        $adapter
            ->method('has')
            ->with('path.txt')
            ->willReturn(true);
        $adapter
            ->method('setVisibility')
            ->willReturn(true);

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->setMethods(['dispatch'])
            ->getMock();

        $beforeEvent = new BeforeSetVisibilityEvent('path.txt', 'private');
        $afterEvent = new AfterSetVisibilityEvent('path.txt', 'private', true);

        $dispatcher
            ->expects($this->atLeast(2))
            ->method('dispatch')
            ->willReturnMap(
                [
                    [ FilesystemEvents::BEFORE_SET_VISIBILITY, $beforeEvent, $beforeEvent ],
                    [ FilesystemEvents::AFTER_SET_VISIBILITY, $afterEvent, $afterEvent ]
                ]
            );

        $filesystem = new EventableFilesystem($dispatcher, $adapter);
        $result = call_user_func_array([ $filesystem, 'setVisibility' ], [ 'path.txt', 'newPath.txt']);

        $this->assertTrue($result);
    }

    public function testAddPlugin() {
        $plugin = $this->getMockBuilder(PluginInterface::class)
            ->setMethods(['handle', 'getMethod', 'setFilesystem'])
            ->getMock();

        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();

        $dispatcher = $this->getMockBuilder(EventDispatcher::class)
            ->setMethods(['dispatch'])
            ->getMock();

        $beforeEvent = new BeforeAddPluginEvent($plugin);
        $afterEvent = new AfterAddPluginEvent($plugin);

        $dispatcher
            ->expects($this->atLeast(2))
            ->method('dispatch')
            ->willReturnMap(
                [
                    [ FilesystemEvents::BEFORE_ADD_PLUGIN, $beforeEvent, $beforeEvent ],
                    [ FilesystemEvents::AFTER_ADD_PLUGIN, $afterEvent, $afterEvent ]
                ]
            );

        $filesystem = new EventableFilesystem($dispatcher, $adapter);
        $result = call_user_func_array([ $filesystem, 'addPlugin' ], [ $plugin ]);
    }

    /**
     * @expectedException \FrostieDE\EventableFlysystem\CancelledException
     */
    public function testCancel() {
        $adapter = $this->getMockBuilder(AdapterInterface::class)
            ->getMock();
        $adapter
            ->method('has')
            ->with('path.txt')
            ->willReturn(true);
        $adapter
            ->method('setVisibility')
            ->willReturn(true);

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(FilesystemEvents::BEFORE_SET_VISIBILITY, function(BeforeSetVisibilityEvent $event) {
            $event->cancel();
        });

        $filesystem = new EventableFilesystem($dispatcher, $adapter);
        $result = call_user_func_array([ $filesystem, 'setVisibility' ], [ 'path.txt', 'newPath.txt']);
    }
}