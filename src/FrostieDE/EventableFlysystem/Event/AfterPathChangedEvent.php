<?php

namespace FrostieDE\EventableFlysystem\Event;

class AfterPathChangedEvent extends AfterFilesystemEvent {

    /** @var string */
    private $newPath;

    /**
     * @param string $path
     * @param string $newPath
     * @param mixed $result
     */
    public function __construct($path, $newPath, $result) {
        parent::__construct($path, $result);

        $this->newPath = $newPath;
    }

    /**
     * @return string
     */
    public function getNewPath() {
        return $this->newPath;
    }
}