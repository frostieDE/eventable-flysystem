<?php

namespace FrostieDE\EventableFlysystem\Event;

use Symfony\Component\EventDispatcher\Event;

abstract class FilesystemEvent extends Event {

    /** @var string */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path) {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }
}