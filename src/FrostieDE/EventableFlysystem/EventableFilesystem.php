<?php

namespace FrostieDE\EventableFlysystem;

use FrostieDE\EventableFlysystem\Event\AfterFilesystemEvent;
use FrostieDE\EventableFlysystem\Event\AfterPathChangedEvent;
use FrostieDE\EventableFlysystem\Event\AfterSetVisibilityEvent;
use FrostieDE\EventableFlysystem\Event\BeforeFilesystemEvent;
use FrostieDE\EventableFlysystem\Event\BeforePathChangedEvent;
use FrostieDE\EventableFlysystem\Event\BeforeSetVisibilityEvent;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Handler;
use League\Flysystem\PluginInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventableFilesystem extends Filesystem {

    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher, AdapterInterface $adapter, $config = null) {
        parent::__construct($adapter, $config);

        $this->dispatcher = $eventDispatcher;
    }

    /**
     * @param string $method
     * @return string
     */
    private function getEventForMethod($method) {
        $eventName = preg_replace_callback('~(?<=[a-z])[A-Z]~', function($matches) {
            return strtolower(sprintf('_%s', $matches[0]));
        }, $method);

        return $eventName;
    }

    /**
     * @param string $method
     * @return string
     */
    private function getBeforeEventName($method) {
        return sprintf('flysystem.filesystem.before.%s', $this->getEventForMethod($method));
    }

    /**
     * @param string $method
     * @return string
     */
    private function getAfterEventName($method) {
        return sprintf('flysystem.filesystem.after.%s', $this->getEventForMethod($method));
    }

    /**
     * @param string $method
     * @param array $arguments
     * @param callable $beforeEventFactory
     * @param callable $afterEventFactory
     * @return mixed
     * @throws CancelledException
     */
    protected function call($method, array $arguments, callable $beforeEventFactory, callable $afterEventFactory) {
        /** @var BeforeFilesystemEvent $beforeEvent */
        $beforeEvent = $beforeEventFactory($arguments);
        $this->dispatcher->dispatch($this->getBeforeEventName($method), $beforeEvent);

        if($beforeEvent->isCancelled()) {
            throw new CancelledException();
        }

        $methodName = 'parent::' . $method;
        $result = call_user_func_array($methodName, $arguments);

        /** @var AfterFilesystemEvent $afterEvent */
        $afterEvent = $afterEventFactory($arguments, $result);
        $this->dispatcher->dispatch($this->getAfterEventName($method), $afterEvent);

        return $result;
    }

    /**
     * @param string $path
     * @return bool|mixed
     * @throws CancelledException
     */
    public function has($path) {
        return $this->call('has', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return false|mixed|string
     * @throws CancelledException
     */
    public function read($path) {
        return $this->call('read', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return false|mixed|resource
     * @throws CancelledException
     */
    public function readStream($path) {
        return $this->call('readStream', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], null);
        });
    }

    /**
     * @param string $directory
     * @param bool $recursive
     * @return array|mixed
     * @throws CancelledException
     */
    public function listContents($directory = '', $recursive = false) {
        return $this->call('listContents', [ $directory, $recursive ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return array|false|mixed
     * @throws CancelledException
     */
    public function getMetadata($path) {
        return $this->call('getMetadata', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return false|int|mixed
     * @throws CancelledException
     */
    public function getSize($path) {
        return $this->call('getSize', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return false|mixed|string
     * @throws CancelledException
     */
    public function getMimetype($path) {
        return $this->call('getMimetype', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return false|mixed|string
     * @throws CancelledException
     */
    public function getTimestamp($path) {
        return $this->call('getTimestamp', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @return false|mixed|string
     * @throws CancelledException
     */
    public function getVisibility($path) {
        return $this->call('getVisibility', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @param string $contents
     * @param array $config
     * @return bool|mixed
     * @throws CancelledException
     */
    public function write($path, $contents, array $config = []) {
        return $this->call('write', [ $path, $contents, $config ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @param resource $resource
     * @param array $config
     * @return bool|mixed
     * @throws CancelledException
     */
    public function writeStream($path, $resource, array $config = []) {
        return $this->call('writeStream', [ $path, $resource, $config ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @param string $contents
     * @param array $config
     * @return bool|mixed
     * @throws CancelledException
     */
    public function update($path, $contents, array $config = []) {
        return $this->call('update', [ $path, $contents, $config ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @param resource $resource
     * @param array $config
     * @return bool|mixed
     * @throws CancelledException
     */
    public function updateStream($path, $resource, array $config = []) {
        return $this->call('updateStream', [ $path, $resource, $config], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @param string $newpath
     * @return bool|mixed
     * @throws CancelledException
     */
    public function rename($path, $newpath) {
        return $this->call('rename', [ $path, $newpath ], function(array $arguments) {
            return new BeforePathChangedEvent($arguments[0], $arguments[1]);
        }, function(array $arguments, $result) {
            return new AfterPathChangedEvent($arguments[0], $arguments[1], $result);
        });
    }

    /**
     * @param string $path
     * @param string $newpath
     * @return bool|mixed
     * @throws CancelledException
     */
    public function copy($path, $newpath) {
        return $this->call('copy', [ $path, $newpath ], function(array $arguments) {
            return new BeforePathChangedEvent($arguments[0], $arguments[1]);
        }, function(array $arguments, $result) {
            return new AfterPathChangedEvent($arguments[0], $arguments[1], $result);
        });
    }

    /**
     * @param string $path
     * @return bool|mixed
     * @throws CancelledException
     */
    public function delete($path) {
        return $this->call('delete', [ $path ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $dirname
     * @return bool|mixed
     * @throws CancelledException
     */
    public function deleteDir($dirname) {
        return $this->call('deleteDir', [ $dirname ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $dirname
     * @param array $config
     * @return bool|mixed
     * @throws CancelledException
     */
    public function createDir($dirname, array $config = []) {
        return $this->call('createDir', [ $dirname, $config ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }

    /**
     * @param string $path
     * @param string $visibility
     * @return bool|mixed
     * @throws CancelledException
     */
    public function setVisibility($path, $visibility) {
        return $this->call('setVisibility', [ $path, $visibility ], function(array $arguments) {
            return new BeforeSetVisibilityEvent($arguments[0], $arguments[1]);
        }, function(array $arguments, $result) {
            return new AfterSetVisibilityEvent($arguments[0], $arguments[1], $result);
        });
    }

    /**
     * @param string $path
     * @param string $contents
     * @param array $config
     * @return bool
     * @codeCoverageIgnore
     */
    public function put($path, $contents, array $config = []) {
        return parent::put($path, $contents, $config);
    }

    /**
     * @param string $path
     * @param resource $resource
     * @param array $config
     * @return bool|mixed
     * @codeCoverageIgnore
     */
    public function putStream($path, $resource, array $config = []) {
        return parent::putStream($path, $resource, $config);
    }


    /**
     * @param string $path
     * @return bool|false|string
     * @throws \League\Flysystem\FileNotFoundException
     * @codeCoverageIgnore
     */
    public function readAndDelete($path) {
        return parent::readAndDelete($path);
    }

    /**
     * @param string $path
     * @param Handler|null $handler
     * @return \League\Flysystem\Directory|\League\Flysystem\File|Handler
     * @codeCoverageIgnore
     */
    public function get($path, Handler $handler = null) {
        return parent::get($path, $handler);
    }

    /**
     * @param PluginInterface $plugin
     * @return FilesystemInterface|mixed
     * @throws CancelledException
     */
    public function addPlugin(PluginInterface $plugin) {
        return $this->call('addPlugin', [ $plugin ], function(array $arguments) {
            return new BeforeFilesystemEvent($arguments[0]);
        }, function(array $arguments, $result) {
            return new AfterFilesystemEvent($arguments[0], $result);
        });
    }
}