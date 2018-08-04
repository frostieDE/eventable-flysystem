<?php

namespace FrostieDE\EventableFlysystem\Event;

class BeforePathChangedEvent extends BeforeFilesystemEvent {

    /** @var string */
    private $newPath;

    /**
     * @param string $path
     * @param string $newPath
     */
    public function __construct($path, $newPath) {
        parent::__construct($path);

        $this->newPath = $newPath;
    }

    /**
     * @return string
     */
    public function getNewPath() {
        return $this->newPath;
    }
}