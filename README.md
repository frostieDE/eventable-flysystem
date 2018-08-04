# Eventable Flysystem

[![Build Status](https://travis-ci.org/frostieDE/eventable-flysystem.svg?branch=master)](https://travis-ci.org/frostieDE/eventable-flysystem)

This is a Filesystem implementation which dispatches events on any call to the underlying filesystem.

In contrast to [flysystem-eventable-filesystem](https://github.com/thephpleague/flysystem-eventable-filesystem) this
implementation can be used with Symfonys EventDispatcher.

# Composer

    $ composer require frostiede/eventable-flysystem
    
# Usage

    $adapter = new Local('./uploads'); # use League\Flysystem\Adapter\Local
    $dispatcher = new EventDispatcher(); # use Symfony\Component\EventDispatcher\EventDispatcher
    $filesystem = new EventableFilesystem($dispatcher, $adapter);
    
Of course, your `$adapter` can be any adapter :wink:
    
# Contribution

Feel free to contribute :-)

# License

MIT